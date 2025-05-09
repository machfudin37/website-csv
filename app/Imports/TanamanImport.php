<?php

namespace App\Imports;

use App\Models\TanamanModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TanamanImport implements ToModel, WithHeadingRow, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $daerah;
    protected $nama_file;

    public function __construct($daerah, $nama_file)
    {
        $this->daerah = $daerah;
        $this->nama_file = $nama_file;
    }
    public function model(array $row)
    {
        return new TanamanModel([
            'nama_tanaman' => $row['nama_tanaman'],
            'jenis_tanaman' => $row['jenis_tanaman'],
            'tanggal_tanam' => $row['tanggal_tanam'],
            'kondisi_tanaman' => $row['kondisi_tanaman'],
            'alamat' => $row['alamat'],
            'nohp' => $row['no_handphone'],
            'daerah' => $this->daerah,
            'nama_file' => $this->nama_file,
            'created_at' => now(),
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
