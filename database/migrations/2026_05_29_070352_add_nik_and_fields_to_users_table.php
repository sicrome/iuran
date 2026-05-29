<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'no_kk')) {
                $table->string('no_kk', 20)->nullable()->after('nik');
            }
            if (!Schema::hasColumn('users', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable()->after('no_kk');
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 15)->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('users', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('users', 'agama')) {
                $table->string('agama', 20)->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('users', 'status_perkawinan')) {
                $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->nullable()->after('agama');
            }
            if (!Schema::hasColumn('users', 'pekerjaan')) {
                $table->string('pekerjaan')->nullable()->after('status_perkawinan');
            }
            if (!Schema::hasColumn('users', 'rt_rw')) {
                $table->string('rt_rw', 20)->nullable()->after('pekerjaan');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('rt_rw');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_kk', 'nama_lengkap', 'no_hp', 'tempat_lahir',
                'tanggal_lahir', 'jenis_kelamin', 'agama', 'status_perkawinan',
                'pekerjaan', 'rt_rw', 'alamat'
            ]);
        });
    }
};