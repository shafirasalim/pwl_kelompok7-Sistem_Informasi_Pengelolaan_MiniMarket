<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $stockMovements = StockMovement::with(['user', 'stock.product'])->get();

        return view('stock_movements.index', compact('stockMovements'));
    }

    public function create()
    {
        $users = User::all();
        $stocks = Stock::with('product')->get();

        return view('stock_movements.create', compact('users', 'stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'stock_id' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required',
        ]);

        StockMovement::create($request->all());

        return redirect()->route('stock-movements.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(StockMovement $stockMovement)
    {
        $users = User::all();
        $stocks = Stock::with('product')->get();

        return view('stock_movements.edit',
            compact('stockMovement', 'users', 'stocks'));
    }

    public function update(Request $request, StockMovement $stockMovement)
    {
        $request->validate([
            'user_id' => 'required',
            'stock_id' => 'required',
            'type' => 'required',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required',
        ]);

        $stockMovement->update($request->all());

        return redirect()->route('stock-movements.index');
    }

    public function destroy(StockMovement $stockMovement)
    {
        $stockMovement->delete();

        return redirect()->route('stock-movements.index');
    }
}