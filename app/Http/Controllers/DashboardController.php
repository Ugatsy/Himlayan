<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Burial;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\PreNeedPlan;
use App\Models\ColumbaryNiche;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPlots = Plot::count();
        $occupiedPlots = Plot::whereIn('status', ['occupied', 'full'])->count();
        $availablePlots = Plot::where('status', 'available')->count();
        $occupancyRate = $totalPlots > 0 ? round(($occupiedPlots / $totalPlots) * 100) : 0;

        $totalRevenue = Payment::sum('amount_paid');
        $activeContracts = Contract::where('status', 'active')->count();
        $upcomingBurials = Burial::where('burial_status', 'scheduled')
            ->whereDate('burial_date', '>=', now())
            ->count();
        $unreadNotifications = Notification::where('is_read', false)->count();
        $newInquiries = Inquiry::where('status', 'new')->count();
        $activePlans = PreNeedPlan::where('is_active', true)->count();
        $availableNiches = ColumbaryNiche::where('status', 'available')->count();

        $recentBurials = Burial::with('plot', 'scheduledBy')
            ->orderBy('burial_date', 'desc')
            ->take(5)
            ->get();

        $recentPayments = Payment::with('contract.client')
            ->orderBy('paid_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPlots', 'occupiedPlots', 'availablePlots', 'occupancyRate',
            'totalRevenue', 'activeContracts', 'upcomingBurials', 'unreadNotifications',
            'recentBurials', 'recentPayments', 'newInquiries',
            'activePlans', 'availableNiches'
        ));
    }
}
