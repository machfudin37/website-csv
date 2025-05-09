<?php

namespace App\Imports;

use App\Models\PenyakitModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PenyakitImport implements ToModel, WithHeadingRow, WithStartRow
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
        return new PenyakitModel([
            'nama_pasien' => $row['nama_pasien'],
            'nik' => $row['nik'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'nohp' => $row['no_handphone'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'alamat' => $row['alamat'],
            'jenis_penyakit' => $row['jenis_penyakit'],
            'tanggal_berobat' => $row['tanggal_berobat'],
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
