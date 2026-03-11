<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCursoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('centro_curso')->insert([
            ['centro_id' => 1, 'curso_id' => 1, 'preco' => 10000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 2, 'curso_id' => 2, 'preco' => 15000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 3, 'curso_id' => 3, 'preco' => 12000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 2, 'curso_id' => 4, 'preco' => 11000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 1, 'curso_id' => 5, 'preco' => 18000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 3, 'curso_id' => 6, 'preco' => 13000, 'created_at' => $now, 'updated_at' => $now],
            ['centro_id' => 1, 'curso_id' => 7, 'preco' => 16000, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}