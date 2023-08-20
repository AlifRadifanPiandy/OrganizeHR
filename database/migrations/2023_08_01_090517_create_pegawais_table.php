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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('status_kawin');
            $table->string('tempat_lahir');
            $table->string('agama');
            $table->string('telepon');
            $table->string('telepon_lain')->nullable();
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_perusahaan')->unique();
            $table->string('nik');
            $table->string('no_bpjs_tk');
            $table->string('no_kk');
            $table->string('no_bpjs_k');
            $table->string('npwp');
            $table->string('nama_bank');
            $table->string('nama_pemilik_rekening');
            $table->string('nama_cabang_bank');
            $table->string('no_rekening');
            $table->string('tipe_karyawan');
            $table->date('periode_mulai');
            $table->date('periode_akhir');
            $table->date('tanggal_rekrut');
            $table->boolean('status_aktif')->default(true);
            $table->string('id_karyawan');
            $table->date('tanggal_efektif');
            $table->foreignId('id_jabatan')->constrained('jabatans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_departemen')->constrained('departemens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_perusahaan')->constrained('perusahaans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_role')->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
