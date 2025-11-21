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
        #expiry_fields { border-left: 3px solid #007bff; padding-left: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    
    <h1>Tambah Produk Baru</h1>
    <a href="{{ route('products.index') }}">Kembali ke Daftar Produk</a>
    <hr>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf 
        
        <div class="form-group">
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

        <!-- TAMBAHAN: FORM EXPIRED DATE -->
        <div class="form-group">
            <label for="has_expiry">Produk memiliki Expired Date?</label>
            <select name="has_expiry" id="has_expiry" class="form-control" onchange="toggleExpiryFields()">
                <option value="0">Tidak</option>
                <option value="1" {{ old('has_expiry') ? 'selected' : '' }}>Ya</option>
            </select>
        </div>

        <div id="expiry_fields" style="display: none;">
            <div class="form-group">
                <label for="manufacture_date">Tanggal Produksi</label>
                <input type="date" name="manufacture_date" class="form-control" 
                       value="{{ old('manufacture_date') }}">
                @error('manufacture_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="expired_date">Tanggal Kadaluarsa *</label>
                <input type="date" name="expired_date" class="form-control" 
                       value="{{ old('expired_date') }}">
                @error('expired_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="batch_number">Nomor Batch</label>
                <input type="text" name="batch_number" class="form-control" 
                       value="{{ old('batch_number') }}" 
                       placeholder="Contoh: BATCH-001">
                @error('batch_number')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <button type="submit">Simpan Produk</button>
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