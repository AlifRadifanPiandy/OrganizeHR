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
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('no_telepon')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota');
            $table->string('industri')->nullable();
            $table->date('tanggal_gabung')->nullable();
            $table->string('logo_perusahaan')->nullable();
            $table->string('jumlah_karyawan')->nullable();
            $table->string('npwp_perusahaan')->nullable();
            $table->date('tanggal_kena_pajak')->nullable();
            $table->string('nama_penanggung_pajak')->nullable();
            $table->string('npwp_penanggung_pajak')->nullable();
            $table->string('kode_referral');
            $table->foreignId('id_pj_perusahaan')->constrained('pjperusahaans')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
