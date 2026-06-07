<?php

namespace App\Http\Controllers;

use App\Models\PreNeedPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PreNeedPlanController extends Controller
{
    public function index()
    {
        $plans = PreNeedPlan::orderBy('type')->orderBy('name')->get();
        return view('pre-need-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('pre-need-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:burial,funeral,memorial',
            'description' => 'nullable|string',
            'features'    => 'nullable|array',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        PreNeedPlan::create($validated);

        return redirect()->route('pre-need-plans.index')->with('success', 'Plan created.');
    }

    public function show(PreNeedPlan $preNeedPlan)
    {
        return view('pre-need-plans.show', ['plan' => $preNeedPlan]);
    }

    public function edit(PreNeedPlan $preNeedPlan)
    {
        return view('pre-need-plans.edit', ['plan' => $preNeedPlan]);
    }

    public function update(Request $request, PreNeedPlan $preNeedPlan)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:burial,funeral,memorial',
            'description' => 'nullable|string',
            'features'    => 'nullable|array',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $preNeedPlan->update($validated);

        return redirect()->route('pre-need-plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(PreNeedPlan $preNeedPlan)
    {
        if ($preNeedPlan->contracts()->exists()) {
            return back()->with('error', 'Cannot delete a plan with existing contracts.');
        }
        $preNeedPlan->delete();
        return redirect()->route('pre-need-plans.index')->with('success', 'Plan deleted.');
    }
}
