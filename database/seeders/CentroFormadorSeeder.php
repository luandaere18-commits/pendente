<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroFormadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = now();

        $centroFormadores = [
            ['centro_id' => 1, 'formador_id' => 1],
            ['centro_id' => 2, 'formador_id' => 2],
            ['centro_id' => 3, 'formador_id' => 3],
            ['centro_id' => 2, 'formador_id' => 4],
            ['centro_id' => 2, 'formador_id' => 5],
            ['centro_id' => 3, 'formador_id' => 6],
            ['centro_id' => 3, 'formador_id' => 7],
        ];

        foreach ($centroFormadores as $item) {
            DB::table('centro_formador')->updateOrInsert(
                ['centro_id' => $item['centro_id'], 'formador_id' => $item['formador_id']],
                ['updated_at' => $now, 'created_at' => $now]
            );
        }
    }
}
