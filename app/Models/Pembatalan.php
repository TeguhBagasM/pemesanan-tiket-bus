<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembatalan extends Model
{
    use HasFactory;

    protected $table = 'pembatalan';

    protected $fillable = [
        'id_pembatalan',
        'id_tiket',
        'alasan',
        'tgl_pembatalan',
        'refund',
        'status_pembatalan'
    ];

    protected $casts = [
        'tgl_pembatalan' => 'datetime',
        'refund' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_pembatalan)) {
                $model->id_pembatalan = 'BTL-' . strtoupper(Str::random(8));
            }
        });
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket');
    }
}