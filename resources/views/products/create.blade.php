<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .error-message { color: red; margin-top: 5px; font-size: 0.9em; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
    </style>
</head>
<body>
    
    <h1>Tambah Produk Baru</h1>
    <a href="{{ route('products.index') }}">Kembali ke Daftar Produk</a>
    <hr>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name') }}" 
                   required>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="code">Kode Produk:</label>
            <input type="text" id="code" name="code" 
                   value="{{ old('code') }}" 
                   required>
            @error('code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp):</label>
            <input type="number" id="price" name="price" 
                   value="{{ old('price') }}" 
                   required step="any" min="0">
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok:</label>
            <input type="number" id="stock" name="stock" 
                   value="{{ old('stock') }}" 
                   required min="0">
            @error('stock')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit">Simpan Produk</button>
    </form>
</body>
</html>