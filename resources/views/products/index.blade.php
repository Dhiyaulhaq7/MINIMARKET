<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk Minimarket</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success-message { color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px; background-color: #e6ffe6; }
        .action-cell { white-space: nowrap; }
    </style>
</head>
<body>
    
    <h1>Daftar Produk Minimarket 🛒</h1>
    
    <p><a href="{{ route('products.create') }}">**+ Tambah Produk Baru**</a></p>
    
    <hr>
    
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($products->isEmpty())
        <p>Belum ada produk yang tersedia. Silakan tambahkan produk baru.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Kode</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th class="action-cell">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="action-cell">
                        <a href="{{ route('products.edit', $product->id) }}">Edit</a> 
                        
                        | 
                        
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }} (Kode: {{ $product->code }})?')"
                                    style="border: none; background: none; color: red; cursor: pointer; padding: 0;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>