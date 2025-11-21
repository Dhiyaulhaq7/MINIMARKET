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
        .expired-row { background-color: #ffcccc; }
        .critical-row { background-color: #fff3cd; }
        .warning-row { background-color: #d1ecf1; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 0.8em; color: white; display: inline-block; margin: 2px 0; }
        .badge-expired { background-color: #dc3545; }
        .badge-critical { background-color: #fd7e14; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-safe { background-color: #28a745; }
        .badge-none { background-color: #6c757d; }
        .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 4px; margin: 15px 0; }
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

    <!-- ALERT EXPIRED SUMMARY -->
    @php
        $expiredCount = 0;
        $criticalCount = 0;
        $warningCount = 0;
        
        foreach($products as $product) {
            $status = $product->expiry_status;
            if ($status == 'expired') $expiredCount++;
            if ($status == 'critical') $criticalCount++;
            if ($status == 'warning') $warningCount++;
        }
    @endphp
    
    @if($expiredCount > 0 || $criticalCount > 0)
    <div class="alert-warning">
        <h3>⚠️ Peringatan Stok Expired:</h3>
        <p><strong>{{ $expiredCount }}</strong> produk sudah EXPIRED</p>
        <p><strong>{{ $criticalCount }}</strong> produk dalam status KRITIS (≤7 hari)</p>
        <p><strong>{{ $warningCount }}</strong> produk dalam status PERINGATAN (≤30 hari)</p>
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
                    <th>Expired Date</th>
                    <th>Status</th>
                    <th>Batch</th>
                    <th class="action-cell">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                    $status = $product->expiry_status;
                    $daysLeft = $product->days_until_expired;
                    
                    // Tentukan class baris
                    $rowClass = '';
                    if ($status == 'expired') $rowClass = 'expired-row';
                    elseif ($status == 'critical') $rowClass = 'critical-row';
                    elseif ($status == 'warning') $rowClass = 'warning-row';
                    
                    // Tentukan badge
                    $badgeClass = '';
                    $badgeText = '';
                    
                    if ($status == 'expired') {
                        $badgeClass = 'badge-expired';
                        $badgeText = 'EXPIRED';
                    } elseif ($status == 'critical') {
                        $badgeClass = 'badge-critical';
                        $badgeText = $daysLeft . ' HARI';
                    } elseif ($status == 'warning') {
                        $badgeClass = 'badge-warning';
                        $badgeText = $daysLeft . ' HARI';
                    } elseif ($status == 'safe') {
                        $badgeClass = 'badge-safe';
                        $badgeText = $daysLeft . ' HARI';
                    } else {
                        $badgeClass = 'badge-none';
                        $badgeText = 'NON-EXPIRY';
                    }
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->expired_date)
                            {{ \Carbon\Carbon::parse($product->expired_date)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    </td>
                    <td>{{ $product->batch_number ?? '-' }}</td>
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