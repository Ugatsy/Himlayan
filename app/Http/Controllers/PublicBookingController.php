<?php

namespace App\Http\Controllers;

use App\Models\PreNeedPlan;
use App\Models\ColumbaryNiche;
use App\Models\Plot;
use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;

class PublicBookingController extends Controller
{
    public function plans()
    {
        $plans = PreNeedPlan::where('is_active', true)->orderBy('type')->orderBy('name')->get()->groupBy('type');
        return view('public.plans', compact('plans'));
    }

    public function planDetail(PreNeedPlan $preNeedPlan)
    {
        abort_if(!$preNeedPlan->is_active, 404);
        return view('public.plan-detail', ['plan' => $preNeedPlan]);
    }

    public function columbarium()
    {
        $niches = ColumbaryNiche::orderBy('section')->orderBy('row')->orderBy('tier')->get();
        return view('public.columbarium', compact('niches'));
    }

    public function lots()
    {
        $plots = Plot::withCount('burials')->where('status', 'available')->orderBy('plot_number')->get();
        $plotData = $plots->map(fn($p) => [
            'id' => $p->id,
            'plot_number' => $p->plot_number,
            'section' => $p->section,
            'lat' => $p->lat,
            'lng' => $p->lng,
            'status' => $p->status,
            'burials_count' => $p->burials_count,
            'capacity' => $p->capacity,
            'price' => $p->price,
        ]);
        return view('public.lots', compact('plots', 'plotData'));
    }

    public function reserveForm($type)
    {
        if (!in_array($type, ['lot', 'columbary', 'plan'])) {
            abort(404);
        }
        $plots = $type === 'lot' ? Plot::where('status', 'available')->orderBy('plot_number')->get() : collect();
        $niches = $type === 'columbary' ? ColumbaryNiche::where('status', 'available')->orderBy('niche_number')->get() : collect();
        $plans = $type === 'plan' ? PreNeedPlan::where('is_active', true)->orderBy('name')->get() : collect();
        $plotData = $type === 'lot' ? $plots->map(fn($p) => [
            'id' => $p->id, 'plot_number' => $p->plot_number, 'section' => $p->section,
            'lat' => $p->lat, 'lng' => $p->lng, 'price' => $p->price,
        ]) : collect();
        $nicheData = $type === 'columbary' ? $niches->map(fn($n) => [
            'id' => $n->id, 'niche_number' => $n->niche_number, 'section' => $n->section,
            'row' => $n->row, 'tier' => $n->tier, 'price' => $n->price,
        ]) : collect();
        return view('public.reserve-form', compact('type', 'plots', 'niches', 'plans', 'plotData', 'nicheData'));
    }

    public function reserveStore(Request $request)
    {
        $validated = $request->validate([
            'type'                  => 'required|in:lot,columbary,plan',
            'full_name'             => 'required|string|max:255',
            'contact_number'        => 'required|string|max:50',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string',
            'plot_id'               => 'required_if:type,lot|nullable|exists:plots,id',
            'columbary_niche_id'    => 'required_if:type,columbary|nullable|exists:columbary_niches,id',
            'pre_need_plan_id'      => 'required_if:type,plan|nullable|exists:pre_need_plans,id',
            'message'               => 'nullable|string',
        ]);

        $client = Client::firstOrCreate(
            ['contact_number' => $validated['contact_number']],
            [
                'full_name'  => $validated['full_name'],
                'email'      => $validated['email'] ?? null,
                'address'    => $validated['address'] ?? null,
                'id_number'  => 'PENDING',
                'id_type'    => 'Others',
            ]
        );

        $plotId = $validated['type'] === 'lot' ? $validated['plot_id'] : null;
        $nicheId = $validated['type'] === 'columbary' ? $validated['columbary_niche_id'] : null;
        $planId = $validated['type'] === 'plan' ? $validated['pre_need_plan_id'] : null;

        $price = 0;
        if ($plotId) $price = Plot::find($plotId)->price;
        elseif ($nicheId) $price = ColumbaryNiche::find($nicheId)->price;
        elseif ($planId) $price = PreNeedPlan::find($planId)->price;

        Contract::create([
            'client_id'          => $client->id,
            'plot_id'            => $plotId,
            'pre_need_plan_id'   => $planId,
            'columbary_niche_id' => $nicheId,
            'contract_date'      => now(),
            'total_amount'       => $price,
            'payment_type'       => 'installment',
            'status'             => 'active',
        ]);

        if ($plotId) Plot::where('id', $plotId)->update(['status' => 'reserved']);
        if ($nicheId) ColumbaryNiche::where('id', $nicheId)->update(['status' => 'reserved']);

        return redirect()->route('public.reserve.confirmation')->with('success', 'Your reservation has been submitted successfully. Our team will contact you within 24 hours.');
    }

    public function confirmation()
    {
        return view('public.confirmation');
    }
}
