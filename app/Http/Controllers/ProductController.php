<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // WAJIB: Import model Product
use Illuminate\Validation\Rule; // Diperlukan untuk validasi 'unique' saat update

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk. (READ: Index)
     */
    public function index()
    {
        // Mengambil semua data produk, diurutkan berdasarkan ID terbaru
        $products = Product::orderBy('id', 'desc')->get();
        
        // Mengirim data ke view 'products.index'
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru. (CREATE: Form)
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru yang dibuat dari form ke database. (CREATE: Store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|unique:products|max:50', // Harus unik di tabel products
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 2. Simpan Data ke Database
        Product::create($request->all());

        // 3. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk **'.$request->name.'** berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk tertentu. (READ: Show)
     */
    public function show(Product $product)
    {
        // Karena menggunakan Route Model Binding (Product $product), 
        // produk sudah otomatis diambil.
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk tertentu. (UPDATE: Form)
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui produk yang sudah ada di database. (UPDATE: Update)
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:100',
            // Rule::unique di sini memastikan kode produk unik, 
            // tetapi MENGECUALIKAN produk yang sedang di-edit.
            'code' => ['required', 'string', 'max:50', Rule::unique('products')->ignore($product->id)],
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 2. Update Data di Database
        $product->update($request->all());

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk **'.$product->name.'** berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database. (DELETE: Destroy)
     */
    public function destroy(Product $product)
    {
        $productName = $product->name; // Simpan nama sebelum dihapus
        
        // Hapus produk
        $product->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk **'.$productName.'** berhasil dihapus!');
    }
}