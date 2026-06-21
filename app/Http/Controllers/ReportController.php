<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Semua role yang boleh lihat laporan
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('reports.index');
    }

    public function salesReport(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();

        $startDate = $request->start_date ?? now()->subDays(7)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $query = Sale::with(['cashier', 'branch', 'details.product'])
            ->whereBetween('sale_date', [$startDate, $endDate]);

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
            ->whereBetween('sales.sale_date', [$startDate, $endDate]);

        if ($user->role !== 'owner') {
            $productSales->where('sales.branch_id', $user->branch_id);
        }

        if ($user->role === 'owner' && $request->branch_id) {
            $productSales->where('sales.branch_id', $request->branch_id);
        }

        $productSales = $productSales
            ->select(
                'products.name as product_name',
                DB::raw('SUM(sale_details.quantity) as total_quantity'),
                DB::raw('SUM(sale_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $branches = ($user->role === 'owner') ? Branch::all() : collect();

        return view('reports.sales', compact(
            'sales',
            'totalRevenue',
            'totalTransactions',
            'productSales',
            'branches',
            'request'
        ));
    }

    public function stockReport(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $showAll = $request->boolean('show_all', false); 
        $threshold = $request->low_stock_threshold ?? 10;

        $query = Stock::with(['branch', 'product'])
            ->whereHas('product');

        if (!$showAll) {
            $query->where('stock', '<=', $threshold);
        }

        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($user->role === 'owner' && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        $stocks = $query->orderBy('branch_id')->orderBy('stock', 'asc')->get();
        $branches = ($user->role === 'owner') ? Branch::all() : collect();

        return view('reports.stock', compact('stocks', 'branches', 'request', 'threshold', 'showAll'));
    }

    public function exportSalesPdf(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();

        $startDate = $request->start_date ?? now()->subDays(7)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $query = Sale::with(['cashier', 'branch', 'details.product'])
            ->whereBetween('sale_date', [$startDate, $endDate]);

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
            ->whereBetween('sales.sale_date', [$startDate, $endDate])
            ->select(
                'products.name as product_name',
                DB::raw('SUM(sale_details.quantity) as total_quantity'),
                DB::raw('SUM(sale_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $filename = 'laporan-penjualan-' . $startDate . '-to-' . $endDate . '.pdf';

        $pdf = Pdf::loadView('reports.pdf.sales', compact(
            'sales',
            'totalRevenue',
            'totalTransactions',
            'productSales',
            'request'
        ));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }

    public function exportStockPdf(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $showAll = $request->boolean('show_all', false);
        $threshold = $request->low_stock_threshold ?? 10;

        $query = Stock::with(['branch', 'product'])
            ->whereHas('product');

        if (!$showAll) {
            $query->where('stock', '<=', $threshold);
        }

        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($user->role === 'owner' && $request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        $stocks = $query->orderBy('branch_id')->orderBy('stock', 'asc')->get();

        $filename = $showAll 
            ? 'laporan-semua-stok-' . now()->format('Y-m-d') . '.pdf'
            : 'laporan-stok-menipis-' . now()->format('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('reports.pdf.stock', compact('stocks', 'threshold', 'showAll'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}