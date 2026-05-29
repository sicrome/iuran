<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iuran_wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('bulan_tahun');
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('iuran_wargas');
    }
};