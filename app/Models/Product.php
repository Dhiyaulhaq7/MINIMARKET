<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;
    
    // Kolom-kolom yang diperbolehkan untuk diisi - TAMBAH KOLOM EXPIRED
    protected $fillable = [
        'name',
        'code',
        'price',
        'stock',
        'expired_date',
        'manufacture_date',
        'batch_number',
        'has_expiry',
        'days_to_expire'
    ];

    protected $dates = [
        'expired_date',
        'manufacture_date'
    ];

    // Scope untuk produk hampir expired
    public function scopeNearlyExpired($query, $days = 30)
    {
        return $query->where('has_expiry', true)
                    ->where('expired_date', '<=', now()->addDays($days))
                    ->where('stock', '>', 0);
    }

    // Scope untuk produk sudah expired
    public function scopeExpired($query)
    {
        return $query->where('has_expiry', true)
                    ->where('expired_date', '<', now())
                    ->where('stock', '>', 0);
    }

    // Hitung sisa hari sampai expired
    public function getDaysUntilExpiredAttribute()
    {
        if (!$this->expired_date) return null;
        
        return Carbon::now()->diffInDays($this->expired_date, false);
    }

    // Cek status expired
    public function getExpiryStatusAttribute()
    {
        if (!$this->has_expiry) return 'non-expiry';
        
        $daysLeft = $this->days_until_expired;
        
        if ($daysLeft < 0) return 'expired';
        if ($daysLeft <= 7) return 'critical';
        if ($daysLeft <= 30) return 'warning';
        
        return 'safe';
    }
}