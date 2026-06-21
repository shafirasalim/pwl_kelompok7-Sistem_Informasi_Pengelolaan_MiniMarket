<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        
        $query = Sale::with(['cashier', 'branch', 'details.product']);
        
        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }
        
        $sales = $query->orderBy('sale_date', 'desc')->paginate(15);
        
        return view('sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        // Supervisor bisa buat transaksi
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        
        $activeBranchId = null;
        
        if ($user->role === 'owner') {
            $activeBranchId = $request->query('branch');
            
            if (!$activeBranchId) {
                $activeBranchId = Branch::first()->id;
            }
        } else {
            $activeBranchId = $user->branch_id;
        }
        $stocks = Stock::with(['product', 'branch'])
            ->whereHas('product')
            ->where('branch_id', $activeBranchId)
            ->where('stock', '>', 0)
            ->get();

        $productsData = $stocks->map(function($s) {
            return [
                'id' => $s->product_id,
                'name' => $s->product->name,
                'price' => $s->product->price,
                'stock_id' => $s->id,
                'stock' => $s->stock,
            ];
        });
        $branches = ($user->role === 'owner') ? Branch::all() : collect();

        return view('sales.create', compact('stocks', 'productsData', 'activeBranchId', 'branches'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
        ]);

        $user = auth()->user();
        $branchId = $request->branch_id;
        
        DB::transaction(function () use ($request, $user, $branchId) {
            $totalPrice = 0;
            $items = [];
            
            foreach ($request->items as $item) {
                $stock = Stock::where('branch_id', $branchId)
                    ->where('product_id', $item['product_id'])
                    ->lockForUpdate() 
                    ->first();

                if (!$stock) {
                    throw new \Exception('Produk tidak tersedia di cabang ini');
                }

                if ($stock->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk produk " . $stock->product->name . ". Stok tersedia: " . $stock->stock);
                }

                $subtotal = $stock->product->price * $item['quantity'];
                $totalPrice += $subtotal;

                $items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $stock->product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $sale = Sale::create([
                'branch_id' => $branchId,
                'cashier_id' => $user->id,
                'sale_date' => $request->sale_date,
                'total_price' => $totalPrice,
            ]);

            foreach ($items as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                Stock::where('branch_id', $branchId)
                    ->where('product_id', $item['product_id'])
                    ->decrement('stock', $item['quantity']);

                \App\Models\StockMovement::create([
                    'user_id' => $user->id,
                    'stock_id' => Stock::where('branch_id', $branchId)
                        ->where('product_id', $item['product_id'])
                        ->first()->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'movement_date' => $request->sale_date,
                ]);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Transaksi berhasil disimpan');
    }

    public function show(Sale $sale)
    {
        $user = auth()->user();
        
        if ($user->role !== 'owner' && $sale->branch_id !== $user->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $sale->load(['cashier', 'branch', 'details.product']);
        
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        if ($user->role !== 'owner' && $sale->branch_id !== $user->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->details as $detail) {
                Stock::where('branch_id', $sale->branch_id)
                    ->where('product_id', $detail->product_id)
                    ->increment('stock', $detail->quantity);

                \App\Models\StockMovement::create([
                    'user_id' => auth()->id(),
                    'stock_id' => Stock::where('branch_id', $sale->branch_id)
                        ->where('product_id', $detail->product_id)
                        ->first()->id,
                    'type' => 'in',
                    'quantity' => $detail->quantity,
                    'movement_date' => now(),
                ]);
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Transaksi berhasil dihapus');
    }
}