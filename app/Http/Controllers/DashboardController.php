<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Mechanic;
use App\Models\ServiceTransaction;
use App\Models\Order;

class DashboardController extends Controller {
    public function index() {
        $totalCustomers = Customer::count();
        $totalVehicles = Vehicle::count();
        $totalMechanics = Mechanic::count();
        
        $serviceRevenue = ServiceTransaction::whereMonth('transaction_date', date('m'))->sum('cost');
        $orderRevenue = Order::whereMonth('created_at', date('m'))->where('status', 'selesai')->sum('total');
        $totalRevenue = $serviceRevenue + $orderRevenue;

        $latestTransactions = ServiceTransaction::with(['vehicle.customer', 'mechanic'])
            ->latest()
            ->take(5)
            ->get();

        // Calculate revenue trend for the last 7 days (Service + Online Sparepart Orders)
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyServiceRevenue = ServiceTransaction::whereDate('transaction_date', $date)
                                ->where('status', 'selesai')
                                ->sum('cost');
            $dailyOrderRevenue = Order::whereDate('created_at', $date)
                                ->where('status', 'selesai')
                                ->sum('total');
            $revenueTrend['labels'][] = \Carbon\Carbon::parse($date)->translatedFormat('D');
            $revenueTrend['data'][] = $dailyServiceRevenue + $dailyOrderRevenue;
        }

        return view('dashboard', compact(
            'totalCustomers', 'totalVehicles', 'totalMechanics', 'totalRevenue', 'latestTransactions', 'revenueTrend'
        ));
    }
}
