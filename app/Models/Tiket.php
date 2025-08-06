<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tiket';

    protected $fillable = [
        'id_tiket',
        'id_pembayaran',
        'harga_tiket',
        'no_kursi',
        'status_tiket'
    ];

    protected $casts = [
        'harga_tiket' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_tiket)) {
                $model->id_tiket = 'TIK-' . strtoupper(Str::random(8));
            }
        });
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran');
    }

    public function reschedule()
    {
        return $this->hasMany(Reschedule::class, 'id_tiket');
    }

    public function pembatalan()
    {
        return $this->hasOne(Pembatalan::class, 'id_tiket');
    }
}
