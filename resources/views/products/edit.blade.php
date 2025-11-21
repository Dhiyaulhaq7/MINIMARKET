<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk: {{ $product->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"], input[type="date"], select { 
            width: 100%; max-width: 400px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; 
        }
        .error-message { color: red; font-size: 0.9em; margin-top: 5px; }
        #expiry_fields { border-left: 3px solid #007bff; padding-left: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Edit Produk: {{ $product->name }}</h1>
    <a href="{{ route('products.index') }}">← Kembali ke Daftar Produk</a>
    <hr>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf 
        @method('PUT') 
        
        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="code">Kode Produk:</label>
            <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}" required>
            @error('code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp):</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required step="any" min="0">
            @error('price')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stok:</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
            @error('stock')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <!-- FORM EXPIRED DATE -->
        <div class="form-group">
            <label for="has_expiry">Produk memiliki Expired Date?</label>
            <select name="has_expiry" id="has_expiry" onchange="toggleExpiryFields()">
                <option value="0" {{ old('has_expiry', $product->has_expiry) == 0 ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ old('has_expiry', $product->has_expiry) == 1 ? 'selected' : '' }}>Ya</option>
            </select>
        </div>

        <div id="expiry_fields" style="display: {{ old('has_expiry', $product->has_expiry) ? 'block' : 'none' }};">
            <div class="form-group">
                <label for="manufacture_date">Tanggal Produksi</label>
                <input type="date" name="manufacture_date" 
                       value="{{ old('manufacture_date', $product->manufacture_date ? (\Carbon\Carbon::parse($product->manufacture_date)->format('Y-m-d')) : '') }}">
                @error('manufacture_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="expired_date">Tanggal Kadaluarsa *</label>
                <input type="date" name="expired_date" 
                       value="{{ old('expired_date', $product->expired_date ? (\Carbon\Carbon::parse($product->expired_date)->format('Y-m-d')) : '') }}">
                @error('expired_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="batch_number">Nomor Batch</label>
                <input type="text" name="batch_number" 
                       value="{{ old('batch_number', $product->batch_number) }}" 
                       placeholder="Contoh: BATCH-001">
                @error('batch_number')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Simpan Perubahan</button>
    </form>

    <script>
    function toggleExpiryFields() {
        const hasExpiry = document.getElementById('has_expiry').value;
        const expiryFields = document.getElementById('expiry_fields');
        
        if (hasExpiry === '1') {
            expiryFields.style.display = 'block';
        } else {
            expiryFields.style.display = 'none';
        }
    }

    // Jalankan saat page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleExpiryFields();
    });
    </script>
</body>
</html>