<?php

namespace App\Http\Controllers;

use App\Models\ColumbaryNiche;
use Illuminate\Http\Request;

class ColumbaryNicheController extends Controller
{
    public function index()
    {
        $niches = ColumbaryNiche::withCount('contracts')->orderBy('section')->orderBy('row')->orderBy('tier')->get();
        return view('columbary-niches.index', compact('niches'));
    }

    public function create()
    {
        return view('columbary-niches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'niche_number' => 'required|string|max:50|unique:columbary_niches',
            'section'      => 'nullable|string|max:100',
            'row'          => 'nullable|string|max:50',
            'tier'         => 'nullable|integer|min:1|max:20',
            'status'       => 'nullable|in:available,reserved,occupied',
            'price'        => 'required|numeric|min:0',
            'map_x'        => 'nullable|numeric',
            'map_y'        => 'nullable|numeric',
            'notes'        => 'nullable|string',
        ]);

        ColumbaryNiche::create($validated);

        return redirect()->route('columbary-niches.index')->with('success', 'Niche created.');
    }

    public function show(ColumbaryNiche $columbaryNiche)
    {
        $columbaryNiche->load('contracts.client');
        return view('columbary-niches.show', ['niche' => $columbaryNiche]);
    }

    public function edit(ColumbaryNiche $columbaryNiche)
    {
        return view('columbary-niches.edit', ['niche' => $columbaryNiche]);
    }

    public function update(Request $request, ColumbaryNiche $columbaryNiche)
    {
        $validated = $request->validate([
            'niche_number' => 'required|string|max:50|unique:columbary_niches,niche_number,' . $columbaryNiche->id,
            'section'      => 'nullable|string|max:100',
            'row'          => 'nullable|string|max:50',
            'tier'         => 'nullable|integer|min:1|max:20',
            'status'       => 'nullable|in:available,reserved,occupied',
            'price'        => 'required|numeric|min:0',
            'map_x'        => 'nullable|numeric',
            'map_y'        => 'nullable|numeric',
            'notes'        => 'nullable|string',
        ]);

        $columbaryNiche->update($validated);

        return redirect()->route('columbary-niches.index')->with('success', 'Niche updated.');
    }

    public function destroy(ColumbaryNiche $columbaryNiche)
    {
        if ($columbaryNiche->contracts()->exists()) {
            return back()->with('error', 'Cannot delete a niche with existing contracts.');
        }
        $columbaryNiche->delete();
        return redirect()->route('columbary-niches.index')->with('success', 'Niche deleted.');
    }

    public function updatePosition(Request $request, ColumbaryNiche $columbaryNiche)
    {
        $request->validate([
            'map_x' => 'required|numeric',
            'map_y' => 'required|numeric',
        ]);

        $columbaryNiche->update(['map_x' => $request->map_x, 'map_y' => $request->map_y]);
        return response()->json(['success' => true]);
    }
}
