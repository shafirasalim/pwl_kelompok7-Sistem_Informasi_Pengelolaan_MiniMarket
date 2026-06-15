<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['branch', 'product'])->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $branches = Branch::all();
        $products = Product::all();

        return view('stocks.create', compact('branches', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0',
        ]);

        Stock::create($request->only(['branch_id', 'product_id', 'stock']));

        return redirect()->route('stocks.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Stock $stock)
    {
        $branches = Branch::all();
        $products = Product::all();

        return view('stocks.edit', compact('stock', 'branches', 'products'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0',
        ]);

        $stock->update($request->only(['branch_id', 'product_id', 'stock']));

        return redirect()->route('stocks.index');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index');
    }
}