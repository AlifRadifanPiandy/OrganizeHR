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
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('masuk');
            $table->time('keluar');
            $table->string('keterangan');
            $table->string('jam_kerja');
            $table->string('total_kehadiran');
            $table->time('rata_waktu_masuk');
            $table->time('rata_waktu_keluar');
            $table->foreignId('id_pegawai')->constrained('pegawais')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_perusahaan')->constrained('perusahaans')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};
