<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    use HasFactory;

    protected $table = 'armada';

    protected $fillable = [
        'no_unik',
        'id_admin',
        'supir',
        'jumlah_kursi',
        'no_kendaraan',
        'rute_asal',
        'rute_tujuan',
        'harga_tiket',
        'jam_berangkat'
    ];

    protected $casts = [
        'harga_tiket' => 'decimal:2',
        'jam_berangkat' => 'datetime:H:i'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
