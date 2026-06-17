<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $query = StockMovement::with(['user', 'stock.product', 'stock.branch']);
        
        if ($user->role !== 'owner') {
            $query->whereHas('stock', function($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            });
        }
        
        $stockMovements = $query->orderBy('movement_date', 'desc')->get();

        return view('stock_movements.index', compact('stockMovements'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $stocks = Stock::with(['product', 'branch']);
        
        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        }
        
        $stocks = $stocks->get();

        return view('stock_movements.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $stock = Stock::findOrFail($request->stock_id);
            
            StockMovement::create([
                'user_id' => auth()->id(),
                'stock_id' => $request->stock_id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'movement_date' => $request->movement_date,
            ]);

            if ($request->type === 'in') {
                $stock->increment('stock', $request->quantity);
            } elseif ($request->type === 'out') {
                if ($stock->stock < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi! Stok tersedia: ' . $stock->stock);
                }
                $stock->decrement('stock', $request->quantity);
            } elseif ($request->type === 'adjustment') {
                $stock->update(['stock' => $request->quantity]);
            }
        });

        return redirect()->route('stock-movements.index')->with('success', 'Mutasi stok berhasil dicatat');
    }

    public function edit(StockMovement $stockMovement)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $stocks = Stock::with(['product', 'branch']);
        
        if ($user->role !== 'owner') {
            $stocks->where('branch_id', $user->branch_id);
        }
        
        $stocks = $stocks->get();

        return view('stock_movements.edit', compact('stockMovement', 'stocks'));
    }

    public function update(Request $request, StockMovement $stockMovement)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
        ]);

        $oldStock = Stock::find($stockMovement->stock_id);
        if ($stockMovement->type === 'in') {
            $oldStock->decrement('stock', $stockMovement->quantity);
        } elseif ($stockMovement->type === 'out') {
            $oldStock->increment('stock', $stockMovement->quantity);
        }

        $stockMovement->update($request->only(['stock_id', 'type', 'quantity', 'movement_date']));

        $newStock = Stock::find($request->stock_id);
        if ($request->type === 'in') {
            $newStock->increment('stock', $request->quantity);
        } elseif ($request->type === 'out') {
            if ($newStock->stock < $request->quantity) {
                return back()->withErrors(['error' => 'Stok tidak mencukupi!']);
            }
            $newStock->decrement('stock', $request->quantity);
        } elseif ($request->type === 'adjustment') {
            $newStock->update(['stock' => $request->quantity]);
        }

        return redirect()->route('stock-movements.index')->with('success', 'Mutasi stok berhasil diupdate');
    }

    public function destroy(StockMovement $stockMovement)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $stock = Stock::find($stockMovement->stock_id);
        if ($stockMovement->type === 'in') {
            $stock->decrement('stock', $stockMovement->quantity);
        } elseif ($stockMovement->type === 'out') {
            $stock->increment('stock', $stockMovement->quantity);
        }

        $stockMovement->delete();

        return redirect()->route('stock-movements.index')->with('success', 'Mutasi stok berhasil dihapus');
    }
}
