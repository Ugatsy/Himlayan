<?php

namespace App\Http\Controllers;

use App\Models\Burial;
use App\Models\Plot;
use App\Models\Contract;
use Illuminate\Http\Request;

class BurialController extends Controller
{
    public function index()
    {
        $burials = Burial::with('plot', 'contract.client', 'scheduledBy')
            ->orderBy('burial_date', 'desc')
            ->get();
        return view('burials.index', compact('burials'));
    }

    public function create()
    {
        $plots = Plot::whereIn('status', ['available', 'reserved', 'occupied'])
            ->whereColumn('current_occupants', '<', 'capacity')
            ->orderBy('plot_number')
            ->get();
        $contracts = Contract::with('client')->where('status', 'active')->get();
        return view('burials.create', compact('plots', 'contracts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plot_id'       => 'required|exists:plots,id',
            'contract_id'   => 'required|exists:contracts,id',
            'deceased_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'date_of_death' => 'required|date',
            'burial_date'   => 'required|date',
            'burial_status' => 'nullable|in:scheduled,completed,cancelled',
            'notes'         => 'nullable|string|max:1000',
        ]);

        $validated['scheduled_by'] = auth()->id();
        $validated['burial_status'] = $validated['burial_status'] ?? 'scheduled';

        $burial = Burial::create($validated);

        $plot = Plot::find($validated['plot_id']);
        $plot->increment('current_occupants');

        if ($plot->current_occupants >= $plot->capacity) {
            $plot->update(['status' => 'full']);
        } elseif ($plot->status === 'available') {
            $plot->update(['status' => 'occupied']);
        }

        return redirect()->route('burials.index')->with('success', 'Burial scheduled.');
    }

    public function show(Burial $burial)
    {
        $burial->load('plot', 'contract.client', 'scheduledBy');
        return view('burials.show', compact('burial'));
    }

    public function edit(Burial $burial)
    {
        $plots = Plot::orderBy('plot_number')->get();
        $contracts = Contract::with('client')->where('status', 'active')->get();
        return view('burials.edit', compact('burial', 'plots', 'contracts'));
    }

    public function update(Request $request, Burial $burial)
    {
        $validated = $request->validate([
            'plot_id'       => 'required|exists:plots,id',
            'contract_id'   => 'required|exists:contracts,id',
            'deceased_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'date_of_death' => 'required|date',
            'burial_date'   => 'required|date',
            'burial_status' => 'nullable|in:scheduled,completed,cancelled',
            'notes'         => 'nullable|string|max:1000',
        ]);

        $burial->update($validated);
        return redirect()->route('burials.index')->with('success', 'Burial updated.');
    }

    public function destroy(Burial $burial)
    {
        $plot = $burial->plot;
        $burial->delete();

        if ($plot->current_occupants > 0) {
            $plot->decrement('current_occupants');
            if ($plot->current_occupants < $plot->capacity) {
                $plot->update(['status' => 'occupied']);
            }
        }

        return redirect()->route('burials.index')->with('success', 'Burial deleted.');
    }

    public function approve(Burial $burial)
    {
        $burial->update([
            'burial_status' => 'completed',
            'approved_at'   => now(),
        ]);

        return back()->with('success', 'Burial approved.');
    }
}
