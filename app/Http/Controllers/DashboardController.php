<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\WalkInLog;
use App\Models\Expense;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate total sales from Sale model (includes memberships, renewals, walk-ins)
        $totalSales = Sale::sum('amount');

        // Calculate total expenses
        $totalExpenses = Expense::sum('amount');

        // Calculate net worth
        $netWorth = $totalSales - $totalExpenses;

        // Additional metrics
        $totalMembers = \App\Models\Member::count();
        $totalTrainors = \App\Models\Trainor::count();
        $totalProducts = \App\Models\Product::count();
        $salesThisMonth = Sale::whereMonth('sale_date', now()->month)->whereYear('sale_date', now()->year)->count();
        $recentSales = Sale::latest('sale_date')->take(5)->get();

        // Calculate monthly income from Sale model
        $monthlyIncome = Sale::selectRaw("DATE_FORMAT(sale_date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        // Calculate monthly expenses
        $monthlyExpenses = Expense::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        // Prepare data for chart
        $months = collect(range(0, 11))->map(function ($i) {
            return now()->subMonths(11 - $i)->format('Y-m');
        });

        $incomeData = $months->map(function ($month) use ($monthlyIncome) {
            return $monthlyIncome->get($month, 0);
        });

        $expensesData = $months->map(function ($month) use ($monthlyExpenses) {
            return $monthlyExpenses->get($month, 0);
        });

        return view('admin.dashboard', [
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netWorth' => $netWorth,
            'totalMembers' => $totalMembers,
            'totalTrainors' => $totalTrainors,
            'totalProducts' => $totalProducts,
            'salesThisMonth' => $salesThisMonth,
            'recentSales' => $recentSales,
            'chartMonths' => $months,
            'chartIncomeData' => $incomeData,
            'chartExpensesData' => $expensesData,
            'inventories' => \App\Models\Inventory::all(),
        ]);
    }
}
