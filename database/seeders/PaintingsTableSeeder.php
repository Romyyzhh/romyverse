<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PaintingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus lukisan yang ada
        DB::table('paintings')->truncate();
        
        // Pastikan direktori ada
        if (!File::exists(storage_path('app/public/paintings'))) {
            File::makeDirectory(storage_path('app/public/paintings'), 0755, true);
        }
        
        // Contoh lukisan tidak lagi ditambahkan
        $this->command->info("Paintings seeder executed - no example paintings added");
    }
}
