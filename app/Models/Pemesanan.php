<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'id_pemesanan',
        'id_admin',
        'id_pengguna',
        'tgl_pemesanan',
        'status_pembayaran',
        'jadwal_pemesanan',
        'jumlah_tiket',
        'total_harga'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_pemesanan)) {
                $model->id_pemesanan = 'PES-' . strtoupper(Str::random(8));
            }
        });
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan');
    }
}
