<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_kk')->nullable();
            $table->string('no_rumah')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_kk', 'no_rumah', 'no_telepon', 'pekerjaan', 'tanggal_bergabung', 'status']);
        });
    }
};