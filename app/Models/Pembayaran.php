<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'id_pembayaran',
        'id_pemesanan',
        'nominal',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'tgl_pembayaran'
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tgl_pembayaran' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_pembayaran)) {
                $model->id_pembayaran = 'PAY-' . strtoupper(Str::random(8));
            }
        });
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_pembayaran');
    }
}