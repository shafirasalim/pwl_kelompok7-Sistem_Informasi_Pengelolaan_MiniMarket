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
        $user = auth()->user();

        $query = Stock::with(['branch', 'product']);

        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }

        $stocks = $query->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $branches = ($user->role === 'owner') ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        $products = Product::all();

        return view('stocks.create', compact('branches', 'products'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0',
        ]);

        $existingStock = Stock::where('branch_id', $request->branch_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingStock) {
            return back()->withErrors(['error' => 'Stok untuk produk ini di cabang tersebut sudah ada. Silakan edit stok yang sudah ada.']);
        }

        Stock::create($request->only(['branch_id', 'product_id', 'stock']));

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Stock $stock)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $branches = ($user->role === 'owner') ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        $products = Product::all();

        return view('stocks.edit', compact('stock', 'branches', 'products'));
    }

    public function update(Request $request, Stock $stock)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0',
        ]);

        $stock->update($request->only(['branch_id', 'product_id', 'stock']));

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil diupdate');
    }

    public function destroy(Stock $stock)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil dihapus');
    }
}