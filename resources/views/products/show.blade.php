<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk: {{ $product->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .detail-box { border: 1px solid #ccc; padding: 15px; max-width: 400px; }
        .detail-box p { margin: 5px 0; }
        .detail-box strong { display: inline-block; width: 100px; }
    </style>
</head>
<body>
    
    <h1>Detail Produk: {{ $product->name }}</h1>
    <a href="{{ route('products.index') }}">Kembali ke Daftar Produk</a>
    <hr>

    <div class="detail-box">
        <p><strong>Nama:</strong> {{ $product->name }}</p>
        <p><strong>Kode:</strong> {{ $product->code }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $product->stock }}</p>
        <p><strong>Dibuat Pada:</strong> {{ $product->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Diperbarui Pada:</strong> {{ $product->updated_at->format('d M Y, H:i') }}</p>
    </div>

    <p style="margin-top: 20px;">
        <a href="{{ route('products.edit', $product->id) }}">Edit Produk Ini</a>
    </p>

</body>
</html>