<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodis = [
            // D3
            ['kode' => 'D3-TI',  'nama' => 'Teknik Informatika',          'jenjang' => 'D3'],
            ['kode' => 'D3-MI',  'nama' => 'Manajemen Informatika',        'jenjang' => 'D3'],
            ['kode' => 'D3-AK',  'nama' => 'Akuntansi',                    'jenjang' => 'D3'],

            // S1
            ['kode' => 'S1-TI',  'nama' => 'Teknik Informatika',           'jenjang' => 'S1'],
            ['kode' => 'S1-SI',  'nama' => 'Sistem Informasi',             'jenjang' => 'S1'],
            ['kode' => 'S1-TK',  'nama' => 'Teknik Komputer',              'jenjang' => 'S1'],
            ['kode' => 'S1-MN',  'nama' => 'Manajemen',                    'jenjang' => 'S1'],
            ['kode' => 'S1-AK',  'nama' => 'Akuntansi',                    'jenjang' => 'S1'],
            ['kode' => 'S1-HK',  'nama' => 'Hukum',                        'jenjang' => 'S1'],
            ['kode' => 'S1-PS',  'nama' => 'Psikologi',                    'jenjang' => 'S1'],
            ['kode' => 'S1-PD',  'nama' => 'Pendidikan',                   'jenjang' => 'S1'],
            ['kode' => 'S1-DK',  'nama' => 'Desain Komunikasi Visual',     'jenjang' => 'S1'],
            ['kode' => 'S1-TE',  'nama' => 'Teknik Elektro',               'jenjang' => 'S1'],
            ['kode' => 'S1-TS',  'nama' => 'Teknik Sipil',                 'jenjang' => 'S1'],
            ['kode' => 'S1-KM',  'nama' => 'Komunikasi',                   'jenjang' => 'S1'],

            // S2
            ['kode' => 'S2-TI',  'nama' => 'Teknik Informatika',           'jenjang' => 'S2'],
            ['kode' => 'S2-MN',  'nama' => 'Manajemen',                    'jenjang' => 'S2'],
        ];

        DB::table('prodis')->insertOrIgnore(
            array_map(fn($p) => array_merge($p, [
                'created_at' => now(),
                'updated_at' => now(),
            ]), $prodis)
        );
    }
}
