<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::all();
        return view('inventory')->with('products', $products);
    }

    // Store a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'selling_price' => 'required|numeric|min:0',
            'amount_sold' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return redirect()->route('inventory')->with('success', 'Product added successfully.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'selling_price' => 'required|numeric|min:0',
            'amount_sold' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('inventory')->with('success', 'Product updated successfully.');
    }
}
