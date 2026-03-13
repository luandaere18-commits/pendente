<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroCursoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $centroCursos = [
            ['centro_id' => 1, 'curso_id' => 1, 'preco' => 10000],
            ['centro_id' => 2, 'curso_id' => 1, 'preco' => 11000],
            ['centro_id' => 2, 'curso_id' => 2, 'preco' => 15000],
            ['centro_id' => 3, 'curso_id' => 2, 'preco' => 14000],
            ['centro_id' => 3, 'curso_id' => 3, 'preco' => 12000],
            ['centro_id' => 1, 'curso_id' => 3, 'preco' => 12500],
            ['centro_id' => 1, 'curso_id' => 4, 'preco' => 11500],
            ['centro_id' => 2, 'curso_id' => 4, 'preco' => 11000],
            ['centro_id' => 2, 'curso_id' => 5, 'preco' => 17000],
            ['centro_id' => 3, 'curso_id' => 5, 'preco' => 17500],
            ['centro_id' => 1, 'curso_id' => 6, 'preco' => 13000],
            ['centro_id' => 3, 'curso_id' => 6, 'preco' => 12500],
            ['centro_id' => 1, 'curso_id' => 7, 'preco' => 16000],
            ['centro_id' => 2, 'curso_id' => 7, 'preco' => 16500],
        ];

        foreach ($centroCursos as $item) {
            DB::table('centro_curso')->updateOrInsert(
                ['centro_id' => $item['centro_id'], 'curso_id' => $item['curso_id']],
                ['preco' => $item['preco'], 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }
}