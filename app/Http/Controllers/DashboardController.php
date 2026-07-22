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

        return view('dashboard', compact(
            'totalCustomers', 'totalVehicles', 'totalMechanics', 'totalRevenue', 'latestTransactions'
        ));
    }
}
