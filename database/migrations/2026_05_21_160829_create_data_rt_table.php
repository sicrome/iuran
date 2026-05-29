<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_rt', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rt');
            $table->string('kode_pos')->nullable();  // ← tambahkan nullable
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->text('alamat_lengkap');
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telepon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_rt');
    }
};