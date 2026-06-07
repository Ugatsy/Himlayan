<?php

namespace App\Http\Controllers;

use App\Models\BurialSpot;
use App\Http\Requests\StoreBurialSpotRequest;
use Illuminate\Http\Request;

class BurialSpotController extends Controller
{
    public function index()
    {
        $spots = BurialSpot::orderBy('plot_number')->get();
        return view('burial.index', compact('spots'));
    }

    public function store(StoreBurialSpotRequest $request)
    {
        BurialSpot::create($request->validated());
        return back()->with('success', 'Burial spot added.');
    }

    public function update(StoreBurialSpotRequest $request, BurialSpot $burialSpot)
    {
        $burialSpot->update($request->validated());
        return back()->with('success', 'Burial spot updated.');
    }

    public function destroy(BurialSpot $burialSpot)
    {
        $burialSpot->delete();
        return back()->with('success', 'Burial spot deleted.');
    }

    public function updatePosition(Request $request, BurialSpot $burialSpot)
    {
        $request->validate([
            'x' => 'required|numeric|min:0|max:520',
            'y' => 'required|numeric|min:0|max:380',
        ]);

        $burialSpot->update([
            'map_x' => $request->x,
            'map_y' => $request->y,
        ]);

        return response()->json(['success' => true, 'x' => $burialSpot->map_x, 'y' => $burialSpot->map_y]);
    }
}
