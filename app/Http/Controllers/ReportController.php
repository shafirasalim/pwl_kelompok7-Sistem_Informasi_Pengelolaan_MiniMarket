<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Laporan Penjualan
     */
    public function salesReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $user = auth()->user();
        
        $query = Sale::with(['cashier', 'branch', 'details.product'])
            ->whereBetween('sale_date', [$request->start_date, $request->end_date]);

        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($user->role === 'owner' && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();
        
        $totalRevenue = $sales->sum('total_price');
        $totalTransactions = $sales->count();

        $productSales = DB::table('sale_details')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->whereBetween('sales.sale_date', [$request->start_date, $request->end_date])
            ->select(
                'products.name as product_name',
                DB::raw('SUM(sale_details.quantity) as total_quantity'),
                DB::raw('SUM(sale_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $branches = Branch::all();

        return view('reports.sales', compact(
            'sales', 
            'totalRevenue', 
            'totalTransactions',
            'productSales',
            'branches',
            'request'
        ));
    }

    /**
     * Laporan Stok
     */
    public function stockReport(Request $request)
    {
        $user = auth()->user();
        
        $query = Stock::with(['branch', 'product'])
            ->where('stock', '<=', $request->low_stock_threshold ?? 10); // Default stok < 10

        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($user->role === 'owner' && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        $stocks = $query->orderBy('stock', 'asc')->get();

        $branches = Branch::all();

        return view('reports.stock', compact('stocks', 'branches', 'request'));
    }

    /**
     * Laporan Transaksi per Cabang (untuk Owner)
     */
    public function branchReport(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa melihat laporan semua cabang');
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $branches = Branch::withCount([
            'sales as total_sales' => function ($query) use ($request) {
                $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
            },
        ])
        ->with([
            'sales' => function ($query) use ($request) {
                $query->whereBetween('sale_date', [$request->start_date, $request->end_date])
                      ->select(DB::raw('branch_id'), DB::raw('SUM(total_price) as total_revenue'));
            }
        ])
        ->get();

        return view('reports.branch', compact('branches', 'request'));
    }
}