<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_sampahs', function (Blueprint $table) {
            $table->foreignId('warga_id')->nullable()->after('id')->constrained('warga')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bank_sampahs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('warga_id');
        });
    }
};
