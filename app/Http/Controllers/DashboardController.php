<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $salesQuery = Sale::query();
        $stockQuery = Stock::with(['product', 'branch'])->where('stock', '<=', 10);

        if ($user->role !== 'owner') {
            $salesQuery->where('branch_id', $user->branch_id);
            $stockQuery->where('branch_id', $user->branch_id);
        }

        $totalBranches = $user->role === 'owner' ? Branch::count() : 1;
        $totalUsers = $user->role === 'owner' ? User::count() : User::where('branch_id', $user->branch_id)->count();
        $totalSales = $salesQuery->count();
        $totalRevenue = $salesQuery->sum('total_price');
        $todaySales = (clone $salesQuery)->whereDate('sale_date', today())->sum('total_price');
        
        $lowStock = $stockQuery->take(5)->get();

        $salesChart = (clone $salesQuery)
            ->select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereBetween('sale_date', [now()->subDays(6), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $salesChart->pluck('date')->toArray();
        $chartData = $salesChart->pluck('total')->toArray();

        $topProductsQuery = DB::table('sale_details')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->select('products.name', DB::raw('SUM(sale_details.quantity) as total_qty'))
            ->groupBy('products.id', 'products.name');

        if ($user->role !== 'owner') {
            $topProductsQuery->where('sales.branch_id', $user->branch_id);
        }

        $topProducts = $topProductsQuery->orderByDesc('total_qty')->limit(5)->get();

        $branchPerformance = collect();
        if ($user->role === 'owner') {
            $branchPerformance = DB::table('branches')
                ->leftJoin('sales', 'branches.id', '=', 'sales.branch_id')
                ->select(
                    'branches.name', 
                    DB::raw('COUNT(sales.id) as total_trx'), 
                    DB::raw('COALESCE(SUM(sales.total_price), 0) as total_revenue')
                )
                ->groupBy('branches.id', 'branches.name')
                ->orderByDesc('total_revenue')
                ->get();
        }

        return view('dashboard', compact(
            'totalBranches', 'totalUsers', 'totalSales', 'totalRevenue', 
            'todaySales', 'lowStock', 'chartLabels', 'chartData', 
            'topProducts', 'branchPerformance'
        ));
    }
}