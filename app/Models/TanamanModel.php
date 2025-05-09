<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanamanModel extends Model
{
    use HasFactory;
    protected $table = 'tanaman';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_tanaman',
        'jenis_tanaman',
        'tanggal_tanam',
        'kondisi_tanaman',
        'alamat',
        'nohp',
        'nama_file',
        'daerah',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
