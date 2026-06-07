<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Http\Requests\StorePlotRequest;
use Illuminate\Http\Request;

class PlotController extends Controller
{
    public function index()
    {
        $plots = Plot::withCount('burials')->orderBy('plot_number')->get();
        $plotData = $plots->map(fn($p) => [
            'id' => $p->id,
            'plot_number' => $p->plot_number,
            'section' => $p->section,
            'lat' => $p->lat,
            'lng' => $p->lng,
            'status' => $p->status,
            'burials_count' => $p->burials_count,
            'capacity' => $p->capacity,
        ]);
        return view('plots.index', compact('plots', 'plotData'));
    }

    public function create()
    {
        return view('plots.create');
    }

    public function store(StorePlotRequest $request)
    {
        $plot = Plot::create($request->validated());
        if ($request->isJson()) {
            return response()->json(['id' => $plot->id, 'plot_number' => $plot->plot_number], 201);
        }
        return redirect()->route('plots.index')->with('success', 'Plot created.');
    }

    public function show(Plot $plot)
    {
        $plot->load('burials', 'contracts.client');
        return view('plots.show', compact('plot'));
    }

    public function edit(Plot $plot)
    {
        return view('plots.edit', compact('plot'));
    }

    public function update(StorePlotRequest $request, Plot $plot)
    {
        $plot->update($request->validated());
        return redirect()->route('plots.index')->with('success', 'Plot updated.');
    }

    public function destroy(Plot $plot)
    {
        if ($plot->burials()->exists()) {
            return back()->with('error', 'Cannot delete plot with existing burials.');
        }
        $plot->delete();
        return redirect()->route('plots.index')->with('success', 'Plot deleted.');
    }

    public function updatePosition(Request $request, Plot $plot)
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        $plot->update(['lat' => $request->lat, 'lng' => $request->lng]);
        return response()->json(['success' => true]);
    }
}
