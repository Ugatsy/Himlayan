<?php

namespace App\Console\Commands;

use App\Models\Plot;
use Illuminate\Console\Command;

class DetectGravesFromTiles extends Command
{
    protected $signature = 'plots:detect-from-tiles
        {--zoom=20 : Zoom level to scan}
        {--dry-run : Only output detections, do not update DB}
        {--threshold=180 : Brightness threshold (0-255)}
        {--min-area=40 : Minimum pixel area for a grave}
        {--max-area=600 : Maximum pixel area for a grave}';

    protected $description = 'Scan satellite tiles to detect grave markers and calculate lat/lng coordinates for plots';

    private int $n;
    private array $detections = [];

    public function handle(): int
    {
        $zoom = (int) $this->option('zoom');
        $this->n = 1 << $zoom;

        $tilesDir = public_path("tiles/{$zoom}");
        if (!is_dir($tilesDir)) {
            $this->error("Tiles directory not found: {$tilesDir}");
            return Command::FAILURE;
        }

        $this->info("Scanning tiles at zoom {$zoom} from {$tilesDir}");

        $xDirs = scandir($tilesDir);
        $xDirs = array_filter($xDirs, fn($d) => is_dir("{$tilesDir}/{$d}") && ctype_digit($d));
        sort($xDirs);

        $totalTiles = 0;
        foreach ($xDirs as $x) {
            $totalTiles += count(glob("{$tilesDir}/{$x}/*.png"));
        }
        $this->info("Found {$totalTiles} tiles across " . count($xDirs) . " x-columns");
        $this->newLine();

        $bar = $this->output->createProgressBar($totalTiles);
        $bar->start();

        foreach ($xDirs as $x) {
            $files = glob("{$tilesDir}/{$x}/*.png");
            foreach ($files as $file) {
                preg_match('/(\d+)\.png$/', $file, $m);
                $this->processTile((int) $x, (int) $m[1], $file);
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Found " . count($this->detections) . " raw features");
        $this->newLine();

        if (count($this->detections) === 0) {
            $this->warn("No features detected. Try adjusting parameters.");
            return Command::SUCCESS;
        }

        $this->clusterAndNumber();
        $this->outputResults();

        if ($this->option('dry-run')) {
            $this->info("Dry-run complete. Pass --dry-run to actually update the database.");
        } else {
            $this->updateDatabase();
        }

        return Command::SUCCESS;
    }

    private function processTile(int $tileX, int $tileY, string $filePath): void
    {
        $data = file_get_contents($filePath);
        $img = @imagecreatefromstring($data);
        if (!$img) return;

        imagefilter($img, IMG_FILTER_GRAYSCALE);

        $w = 256;
        $h = 256;
        $threshold = (int) $this->option('threshold');
        $minArea = (int) $this->option('min-area');
        $maxArea = (int) $this->option('max-area');

        $gray = [];
        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                $gray[$y][$x] = imagecolorat($img, $x, $y) & 0xFF;
            }
        }
        imagedestroy($img);

        $edge = [];
        for ($y = 1; $y < $h - 1; $y++) {
            for ($x = 1; $x < $w - 1; $x++) {
                $gx = -1 * $gray[$y-1][$x-1] + 1 * $gray[$y-1][$x+1]
                    + -2 * $gray[$y][$x-1]   + 2 * $gray[$y][$x+1]
                    + -1 * $gray[$y+1][$x-1] + 1 * $gray[$y+1][$x+1];
                $gy = -1 * $gray[$y-1][$x-1] + -2 * $gray[$y-1][$x] + -1 * $gray[$y-1][$x+1]
                    + 1 * $gray[$y+1][$x-1]  + 2 * $gray[$y+1][$x]  + 1 * $gray[$y+1][$x+1];
                $mag = abs($gx) + abs($gy);
                $edge[$y][$x] = ($mag > 60 && $gray[$y][$x] > $threshold * 0.85) ? 1 : 0;
            }
        }

        $visited = [];
        $components = [];

        for ($y = 1; $y < $h - 1; $y++) {
            for ($x = 1; $x < $w - 1; $x++) {
                if (!($edge[$y][$x] ?? 0)) continue;
                if ($visited[$y][$x] ?? false) continue;

                $stack = [[$x, $y]];
                $pixels = [];
                $visited[$y][$x] = true;

                while (!empty($stack)) {
                    [$cx, $cy] = array_pop($stack);
                    $pixels[] = [$cx, $cy];

                    foreach ([[-1,0],[1,0],[0,-1],[0,1]] as [$dx, $dy]) {
                        $nx = $cx + $dx;
                        $ny = $cy + $dy;
                        if ($nx > 0 && $nx < $w - 1 && $ny > 0 && $ny < $h - 1) {
                            if (($edge[$ny][$nx] ?? 0) && !($visited[$ny][$nx] ?? false)) {
                                $visited[$ny][$nx] = true;
                                $stack[] = [$nx, $ny];
                            }
                        }
                    }
                }

                $count = count($pixels);
                if ($count < $minArea || $count > $maxArea) continue;

                $minX = $w; $maxX = 0; $minY = $h; $maxY = 0;
                foreach ($pixels as [$px, $py]) {
                    $minX = min($minX, $px);
                    $maxX = max($maxX, $px);
                    $minY = min($minY, $py);
                    $maxY = max($maxY, $py);
                }

                $bbW = $maxX - $minX + 1;
                $bbH = $maxY - $minY + 1;
                $fillRatio = $count / ($bbW * $bbH);
                $aspect = max($bbW, $bbH) / max(min($bbW, $bbH), 1);

                if ($fillRatio < 0.35) continue;
                if ($aspect > 4) continue;
                if ($bbW < 4 || $bbH < 4) continue;
                if ($bbW > 50 || $bbH > 50) continue;

                $centroidX = ($minX + $maxX) / 2;
                $centroidY = ($minY + $maxY) / 2;

                $avgBright = 0;
                $samplePixels = min(count($pixels), 20);
                for ($i = 0; $i < $samplePixels; $i++) {
                    $avgBright += $gray[$pixels[$i][1]][$pixels[$i][0]];
                }
                $avgBright /= $samplePixels;

                if ($avgBright < $threshold * 0.7) continue;

                $this->detections[] = [
                    'lat' => $this->tileYToLat($tileY, $centroidY / 256),
                    'lng' => $this->tileXToLng($tileX, $centroidX / 256),
                    'area' => $count,
                    'brightness' => $avgBright,
                    'width' => $bbW,
                    'height' => $bbH,
                ];
            }
        }
    }

    private function tileXToLng(int $tileX, float $fraction): float
    {
        return ($tileX + $fraction) / $this->n * 360 - 180;
    }

    private function tileYToLat(int $tileY, float $fraction): float
    {
        return rad2deg(atan(sinh(M_PI * (1 - 2 * ($tileY + $fraction) / $this->n))));
    }

    private function clusterAndNumber(): void
    {
        if (empty($this->detections)) return;

        $used = array_fill(0, count($this->detections), false);
        $clusters = [];
        $distThreshold = 0.00004;

        for ($i = 0; $i < count($this->detections); $i++) {
            if ($used[$i]) continue;
            $cluster = [$i];
            $used[$i] = true;

            for ($j = $i + 1; $j < count($this->detections); $j++) {
                if ($used[$j]) continue;
                $dLat = $this->detections[$i]['lat'] - $this->detections[$j]['lat'];
                $dLng = $this->detections[$i]['lng'] - $this->detections[$j]['lng'];
                if (sqrt($dLat * $dLat + $dLng * $dLng) < $distThreshold) {
                    $cluster[] = $j;
                    $used[$j] = true;
                }
            }
            $clusters[] = $cluster;
        }

        $plots = [];
        foreach ($clusters as $cluster) {
            $sumLat = 0; $sumLng = 0; $totalW = 0;
            foreach ($cluster as $idx) {
                $w = $this->detections[$idx]['area'];
                $sumLat += $this->detections[$idx]['lat'] * $w;
                $sumLng += $this->detections[$idx]['lng'] * $w;
                $totalW += $w;
            }
            if ($totalW > 0) {
                $plots[] = [
                    'lat' => $sumLat / $totalW,
                    'lng' => $sumLng / $totalW,
                ];
            }
        }

        if (empty($plots)) return;

        usort($plots, function ($a, $b) {
            $latDiff = abs($a['lat'] - $b['lat']);
            if ($latDiff > 0.00002) return $b['lat'] <=> $a['lat'];
            return $a['lng'] <=> $b['lng'];
        });

        $this->detections = [];
        $rowThreshold = 0.00003;
        $currentRowLat = null;
        $rowPlots = [];
        $rows = [];

        foreach ($plots as $p) {
            if ($currentRowLat === null || abs($p['lat'] - $currentRowLat) > $rowThreshold) {
                if (!empty($rowPlots)) {
                    $rows[] = $rowPlots;
                }
                $currentRowLat = $p['lat'];
                $rowPlots = [];
            }
            $rowPlots[] = $p;
        }
        if (!empty($rowPlots)) $rows[] = $rowPlots;

        $rows = array_slice($rows, 0, 26);

        foreach ($rows as $ri => $row) {
            $row = array_slice($row, 0, 50);

            foreach ($row as $ci => $plot) {
                $letter = $this->numberToLetters($ri);
                $num = str_pad($ci + 1, 2, '0', STR_PAD_LEFT);
                $pn = strtoupper($letter) . '-' . $num;

                $this->detections[] = [
                    'plot_number' => $pn,
                    'lat' => round($plot['lat'], 7),
                    'lng' => round($plot['lng'], 7),
                ];
            }
        }
    }

    private function numberToLetters(int $n): string
    {
        $result = '';
        while ($n >= 0) {
            $result = chr(ord('A') + ($n % 26)) . $result;
            $n = (int)($n / 26) - 1;
        }
        return $result;
    }

    private function outputResults(): void
    {
        $rows = array_map(fn($d) => [$d['plot_number'], $d['lat'], $d['lng']], $this->detections);

        if (!empty($rows)) {
            foreach (array_chunk($rows, 40) as $chunk) {
                $this->table(['Plot #', 'Latitude', 'Longitude'], $chunk);
            }
        }

        $this->newLine();
        $this->info("Total plots detected: " . count($this->detections));

        $latMin = min(array_column($this->detections, 'lat'));
        $latMax = max(array_column($this->detections, 'lat'));
        $lngMin = min(array_column($this->detections, 'lng'));
        $lngMax = max(array_column($this->detections, 'lng'));
        $this->line("Coverage: {$latMin},{$lngMin} to {$latMax},{$lngMax}");
    }

    private function updateDatabase(): void
    {
        $created = 0;
        $updated = 0;

        foreach ($this->detections as $detection) {
            $existing = Plot::where('plot_number', $detection['plot_number'])->first();
            if ($existing) {
                $existing->update([
                    'lat' => $detection['lat'],
                    'lng' => $detection['lng'],
                    'section' => 'Auto-detected',
                ]);
                $updated++;
            } else {
                Plot::create([
                    'plot_number' => $detection['plot_number'],
                    'section' => 'Auto-detected',
                    'lat' => $detection['lat'],
                    'lng' => $detection['lng'],
                    'capacity' => 1,
                    'status' => 'available',
                ]);
                $created++;
            }
        }

        $this->info("Created {$created} new plots, updated {$updated} existing.");
    }
}
