<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_iurans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('icon')->nullable();
            $table->decimal('nominal_default', 12, 2)->default(0);
            $table->decimal('denda_per_hari', 12, 2)->default(0);
            $table->integer('batas_tanggal')->default(25);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_iurans');
    }
};