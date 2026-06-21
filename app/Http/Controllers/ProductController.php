<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }
        
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Hanya Owner dan Manager yang bisa mengelola produk');
        }
        return view('products.create');
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Hanya Owner dan Manager yang bisa mengelola produk');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);
        Product::create($request->only(['name', 'price']));
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(string $id)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse'])) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function edit(Product $product)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Hanya Owner dan Manager yang bisa mengelola produk');
        }
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Hanya Owner dan Manager yang bisa mengelola produk');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa menghapus produk');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}