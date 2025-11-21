<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validasi Data - TAMBAH VALIDASI EXPIRED
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|unique:products|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'has_expiry' => 'boolean',
            'manufacture_date' => 'nullable|date',
            'expired_date' => 'nullable|date|after:manufacture_date',
            'batch_number' => 'nullable|string|max:100'
        ]);

        // Jika tidak ada expired date, set null
        $productData = $request->all();
        if (!$request->has_expiry) {
            $productData['manufacture_date'] = null;
            $productData['expired_date'] = null;
            $productData['batch_number'] = null;
        }

        Product::create($productData);

        return redirect()->route('products.index')->with('success', 'Produk **'.$request->name.'** berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi Data - TAMBAH VALIDASI EXPIRED
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:50', Rule::unique('products')->ignore($product->id)],
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'has_expiry' => 'boolean',
            'manufacture_date' => 'nullable|date',
            'expired_date' => 'nullable|date|after:manufacture_date',
            'batch_number' => 'nullable|string|max:100'
        ]);

        // Jika tidak ada expired date, set null
        $updateData = $request->all();
        if (!$request->has_expiry) {
            $updateData['manufacture_date'] = null;
            $updateData['expired_date'] = null;
            $updateData['batch_number'] = null;
        }

        $product->update($updateData);

        return redirect()->route('products.index')->with('success', 'Produk **'.$product->name.'** berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $productName = $product->name;
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk **'.$productName.'** berhasil dihapus!');
    }
}