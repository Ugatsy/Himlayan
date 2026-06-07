<?php

namespace App\Http\Controllers;

use App\Models\Burial;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    public function index()
    {
        return view('public.find');
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Burial::with('plot')
            ->where(function ($query) use ($q) {
                $query->whereRaw('MATCH(deceased_name) AGAINST(? IN BOOLEAN MODE)', [$q . '*'])
                      ->orWhere('deceased_name', 'like', '%' . $q . '%')
                      ->orWhereHas('plot', function ($q2) use ($q) {
                          $q2->where('plot_number', 'like', '%' . $q . '%');
                      });
            })
            ->where('burial_status', 'completed')
            ->select('id', 'deceased_name', 'date_of_birth', 'date_of_death', 'plot_id')
            ->get()
            ->map(fn($b) => [
                'name'        => $b->deceased_name,
                'dates'       => ($b->date_of_birth?->format('Y-m-d') ?? '?') . ' – ' . $b->date_of_death->format('Y-m-d'),
                'plot_number' => $b->plot->plot_number,
                'section'     => $b->plot->section,
                'lat'         => $b->plot->lat,
                'lng'         => $b->plot->lng,
            ]);

        return response()->json($results);
    }
}
