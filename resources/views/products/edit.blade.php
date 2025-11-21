<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk: {{ $product->name }}</title>
</head>
<body>
    <h1>Edit Produk: {{ $product->name }}</h1>
    <a href="{{ route('products.index') }}">Kembali ke Daftar Produk</a>
    <hr>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf 
        @method('PUT') <div>
            <label for="name">Nama Produk:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <br>
        <div>
            <label for="code">Kode Produk:</label><br>
            <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}" required>
        </div>
        <br>
        <div>
            <label for="price">Harga (Rp):</label><br>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required step="any">
        </div>
        <br>
        <div>
            <label for="stock">Stok:</label><br>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <br>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>