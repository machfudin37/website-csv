<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahModel extends Model
{
    use HasFactory;
    protected $table = 'daerah';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_daerah',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
