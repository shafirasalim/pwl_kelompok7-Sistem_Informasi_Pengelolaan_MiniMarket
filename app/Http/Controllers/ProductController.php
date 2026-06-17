<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa mengelola produk');
        }
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa mengelola produk');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);
        Product::create($request->only(['name', 'price']));
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa mengelola produk');
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa mengelola produk');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Hanya Owner yang bisa mengelola produk');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
