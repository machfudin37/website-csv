<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyakitModel extends Model
{
    use HasFactory;
    protected $table = 'penyakit';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_pasien',
        'nik',
        'tanggal_lahir',
        'nohp',
        'jenis_kelamin',
        'alamat',
        'jenis_penyakit',
        'tanggal_berobat',
        'daerah',
        'nama_file',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
