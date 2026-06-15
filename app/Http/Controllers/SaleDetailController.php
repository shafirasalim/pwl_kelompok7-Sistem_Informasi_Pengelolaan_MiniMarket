<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    public function index()
    {
        $saleDetails = SaleDetail::with(['sale', 'product'])->get();
        return view('sale_details.index', compact('saleDetails'));
    }

    public function create()
    {
        $sales = Sale::all();
        $products = Product::all();

        return view('sale_details.create', compact('sales', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        SaleDetail::create($request->only([
            'sale_id',
            'product_id',
            'quantity',
            'price',
            'subtotal',
        ]));

        return redirect()->route('sale-details.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(SaleDetail $saleDetail)
    {
        $sales = Sale::all();
        $products = Product::all();

        return view('sale_details.edit', compact('saleDetail', 'sales', 'products'));
    }

    public function update(Request $request, SaleDetail $saleDetail)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $saleDetail->update($request->only([
            'sale_id',
            'product_id',
            'quantity',
            'price',
            'subtotal',
        ]));

        return redirect()->route('sale-details.index');
    }

    public function destroy(SaleDetail $saleDetail)
    {
        $saleDetail->delete();

        return redirect()->route('sale-details.index');
    }
}