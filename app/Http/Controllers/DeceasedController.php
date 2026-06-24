<?php

namespace App\Http\Controllers;

use App\Models\Burial;
use App\Models\BurialPermit;

class DeceasedController extends Controller
{
    public function index()
    {
        $burialDeceased = Burial::with('plot', 'contract.client')
            ->where('burial_status', 'completed')
            ->orderBy('date_of_death', 'desc')
            ->get()
            ->map(fn($b) => [
                'name' => $b->deceased_name,
                'date_of_birth' => $b->date_of_birth,
                'date_of_death' => $b->date_of_death,
                'plot' => $b->plot?->plot_number,
                'section' => $b->plot?->section,
                'client' => $b->contract?->client?->full_name,
                'burial_date' => $b->burial_date,
                'source' => 'Burial Record',
            ]);

        $permitDeceased = BurialPermit::with('contract.client', 'contract.plot')
            ->where('status', '!=', 'cancelled')
            ->orderBy('date_of_death', 'desc')
            ->get()
            ->map(fn($p) => [
                'name' => $p->deceased_name,
                'date_of_birth' => $p->date_of_birth,
                'date_of_death' => $p->date_of_death,
                'plot' => $p->contract?->plot?->plot_number,
                'section' => $p->contract?->plot?->section,
                'client' => $p->contract?->client?->full_name,
                'burial_date' => null,
                'source' => 'Burial Permit (AF 58)',
            ]);

        $allDeceased = $burialDeceased->concat($permitDeceased)
            ->sortByDesc('date_of_death')
            ->values();

        return view('deceased.index', ['deceasedList' => $allDeceased]);
    }
}
