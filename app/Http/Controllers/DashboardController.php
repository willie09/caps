<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\WalkInLog;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate total sales from members
        $membershipPrices = [
            'basic' => 500,
            'premium' => 700,
            'vip' => 1000,
        ];
        $members = Member::all();
        $totalMemberSales = 0;
        foreach ($members as $member) {
            $type = $member->membership_type;
            if (isset($membershipPrices[$type])) {
                $totalMemberSales += $membershipPrices[$type];
            }
        }

        // Calculate total sales from walk-ins
        $walkInSales = WalkInLog::sum('amount');

        $totalSales = $totalMemberSales + $walkInSales;

        // Calculate total expenses
        $totalExpenses = Expense::sum('amount');

        // Calculate net worth
        $netWorth = $totalSales - $totalExpenses;

        // Calculate monthly income (members + walk-ins)
        $monthlyIncomeMembers = Member::selectRaw("DATE_FORMAT(join_date, '%Y-%m') as month, membership_type")
            ->get()
            ->groupBy('month')
            ->map(function ($group) use ($membershipPrices) {
                return $group->sum(function ($member) use ($membershipPrices) {
                    return $membershipPrices[$member->membership_type] ?? 0;
                });
            });

        $monthlyIncomeWalkIns = WalkInLog::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyIncome = $monthlyIncomeMembers->merge($monthlyIncomeWalkIns)->map(function ($value, $key) use ($monthlyIncomeMembers, $monthlyIncomeWalkIns) {
            return ($monthlyIncomeMembers->get($key, 0) ?? 0) + ($monthlyIncomeWalkIns->get($key, 0) ?? 0);
        });

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

        return view('dashboard', [
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netWorth' => $netWorth,
            'chartMonths' => $months,
            'chartIncomeData' => $incomeData,
            'chartExpensesData' => $expensesData,
            'inventories' => \App\Models\Inventory::all(),
        ]);
    }
}
