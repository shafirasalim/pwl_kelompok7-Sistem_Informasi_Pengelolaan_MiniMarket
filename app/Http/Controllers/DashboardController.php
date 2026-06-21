<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            $totalBranches = Branch::count();
            $totalUsers = User::count();
            $totalSales = Sale::count();
            $totalRevenue = Sale::sum('total_price');
            
            $lowStock = Stock::with(['product', 'branch'])
                ->where('stock', '<=', 10)
                ->take(10)
                ->get();
            
            $todaySales = Sale::whereDate('sale_date', today())->sum('total_price');
            
            $salesChart = Sale::select(
                    DB::raw('DATE(sale_date) as date'),
                    DB::raw('SUM(total_price) as total'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('sale_date', [now()->subDays(7), now()])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        } else {
            $branchId = $user->branch_id;
            
            $totalBranches = 1;
            $totalUsers = User::where('branch_id', $branchId)->count();
            $totalSales = Sale::where('branch_id', $branchId)->count();
            $totalRevenue = Sale::where('branch_id', $branchId)->sum('total_price');
            
            $lowStock = Stock::with(['product'])
                ->where('branch_id', $branchId)
                ->where('stock', '<=', 10)
                ->take(10)
                ->get();
            
            $todaySales = Sale::where('branch_id', $branchId)
                ->whereDate('sale_date', today())
                ->sum('total_price');

            $salesChart = Sale::where('branch_id', $branchId)
                ->select(
                    DB::raw('DATE(sale_date) as date'),
                    DB::raw('SUM(total_price) as total'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('sale_date', [now()->subDays(7), now()])
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return view('dashboard', compact(
            'totalBranches',
            'totalUsers',
            'totalSales',
            'totalRevenue',
            'lowStock',
            'todaySales',
            'salesChart'
        ));
    }
}