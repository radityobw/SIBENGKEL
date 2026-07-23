<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Mechanic;
use App\Models\ServiceTransaction;

class DashboardController extends Controller {
    public function index() {
        $totalCustomers = Customer::count();
        $totalVehicles = Vehicle::count();
        $totalMechanics = Mechanic::count();
        $totalRevenue = ServiceTransaction::whereMonth('transaction_date', date('m'))->sum('cost');

        $latestTransactions = ServiceTransaction::with(['vehicle.customer', 'mechanic'])
            ->latest()
            ->take(5)
            ->get();

        // Calculate revenue trend for the last 7 days
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyRevenue = ServiceTransaction::whereDate('transaction_date', $date)
                                ->where('status', 'selesai')
                                ->sum('cost');
            $revenueTrend['labels'][] = \Carbon\Carbon::parse($date)->translatedFormat('D');
            $revenueTrend['data'][] = $dailyRevenue;
        }

        return view('dashboard', compact(
            'totalCustomers', 'totalVehicles', 'totalMechanics', 'totalRevenue', 'latestTransactions', 'revenueTrend'
        ));
    }
}
