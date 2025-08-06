<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reschedule extends Model
{
    use HasFactory;

    protected $table = 'reschedule';

    protected $fillable = [
        'id_reschedule',
        'id_tiket',
        'jadwal_lama',
        'jadwal_baru',
        'status_reschedule'
    ];

    protected $casts = [
        'jadwal_lama' => 'datetime',
        'jadwal_baru' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_reschedule)) {
                $model->id_reschedule = 'RSC-' . strtoupper(Str::random(8));
            }
        });
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket');
    }
}