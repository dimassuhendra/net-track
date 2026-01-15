<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['nama_kategori' => 'Bandwidth', 'deskripsi' => 'Masalah kecepatan lambat atau latency tinggi'],
            ['nama_kategori' => 'Transmisi Putus', 'deskripsi' => 'Gangguan pada kabel FO (Cut) atau link radio'],
            ['nama_kategori' => 'Perangkat', 'deskripsi' => 'Kerusakan pada Router, ONT, atau Switch'],
            ['nama_kategori' => 'Human Error', 'deskripsi' => 'Kesalahan konfigurasi atau teknis lapangan'],
            ['nama_kategori' => 'Mati Lampu', 'deskripsi' => 'Gangguan power di sisi pelanggan atau POP'],
            ['nama_kategori' => 'Upstream/Pihak Ketiga', 'deskripsi' => 'Gangguan dari provider pusat'],
        ];

        DB::table('categories')->insert($categories);
    }
}