<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom icon menjadi VARCHAR dengan charset utf8mb4
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->string('icon', 50)->default('📢')->change();
        });
        
        // Ubah charset tabel menjadi utf8mb4
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->string('icon', 50)->default('')->change();
        });
    }
};