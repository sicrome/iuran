<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        
        $categories = [
            ['name' => 'Iuran Warga', 'type' => 'pemasukan', 'icon' => '💰'],
            ['name' => 'Donasi', 'type' => 'pemasukan', 'icon' => '🤝'],
            ['name' => 'Sumbangan', 'type' => 'pemasukan', 'icon' => '🎁'],
            ['name' => 'Kegiatan Rutin', 'type' => 'pengeluaran', 'icon' => '📋'],
            ['name' => 'Kebersihan', 'type' => 'pengeluaran', 'icon' => '🧹'],
            ['name' => 'Perawatan', 'type' => 'pengeluaran', 'icon' => '🔧'],
            ['name' => 'Keamanan', 'type' => 'pengeluaran', 'icon' => '🛡️'],
            ['name' => 'Lainnya', 'type' => 'pengeluaran', 'icon' => '📌'],
        ];
        
        foreach ($categories as $cat) {
            Category::create($cat);
        }
        
        $this->command->info('CategorySeeder berhasil: ' . count($categories) . ' kategori ditambahkan');
        Schema::enableForeignKeyConstraints();
    }
}