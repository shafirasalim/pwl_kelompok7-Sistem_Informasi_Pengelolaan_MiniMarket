<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['branch', 'cashier'])->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $branches = Branch::all();
        $cashiers = User::all();

        return view('sales.create', compact('branches', 'cashiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'cashier_id' => 'required|exists:users,id',
            'sale_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
        ]);

        Sale::create($request->only([
            'branch_id',
            'cashier_id',
            'sale_date',
            'total_price',
        ]));

        return redirect()->route('sales.index');
    }

    public function show(Sale $sale)
    {
        $sale->load(['branch', 'cashier', 'saleDetails.product']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $branches = Branch::all();
        $cashiers = User::all();

        return view('sales.edit', compact('sale', 'branches', 'cashiers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'cashier_id' => 'required|exists:users,id',
            'sale_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
        ]);

        $sale->update($request->only([
            'branch_id',
            'cashier_id',
            'sale_date',
            'total_price',
        ]));

        return redirect()->route('sales.index');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index');
    }
}