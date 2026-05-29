<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iuran_wargas', function (Blueprint $table) {
            $table->enum('verifikasi_status', ['pending', 'diterima', 'ditolak'])->default('pending')->after('status');
            $table->text('alasan_tolak')->nullable()->after('verifikasi_status');
            $table->string('bukti_pembayaran')->nullable()->after('alasan_tolak');
            $table->datetime('tanggal_verifikasi')->nullable()->after('bukti_pembayaran');
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->after('tanggal_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('iuran_wargas', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_status', 'alasan_tolak', 'bukti_pembayaran', 'tanggal_verifikasi', 'diverifikasi_oleh']);
        });
    }
};