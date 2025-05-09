<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->string('nik');
            $table->string('tanggal_lahir');
            $table->string('nohp');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->string('jenis_penyakit');
            $table->string('tanggal_berobat');
            $table->string('nama_file');
            $table->string('daerah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
