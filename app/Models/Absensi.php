<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'karyawan_id', 'tanggal', 'jam_masuk',
        'jam_pulang', 'foto_masuk', 'latitude',
        'longitude', 'status'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}