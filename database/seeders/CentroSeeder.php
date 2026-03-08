<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Centro;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // Centro::create([
        //     'nome' => 'MC4',
        //     'localizacao' => 'Vila de Viana',
        //     'contactos' => ['923456789'],
        //     'email' => 'vila@centro.ao',
        // ]);

        // Centro::create([
        //     'nome' => 'MC5',
        //     'localizacao' => 'Kimbango',
        //     'contactos' => ['924567890', '975678901'],
        //     'email' => 'kimbango@centro.ao',
        // ]);

    $now = now();
    Centro::insert([
        ['nome' => 'Centro de Formação Luanda', 'localizacao' => 'Avenida Príncipe Nero, Talatona, Luanda', 'contactos' => json_encode(['923111222']), 'email' => 'luanda@centro.ao', 'created_at' => $now, 'updated_at' => $now],
        ['nome' => 'Instituto Técnico Benguela', 'localizacao' => 'Av. 21 de Janeiro, Benguela', 'contactos' => json_encode(['931222333']), 'email' => 'benguela@instituto.ao', 'created_at' => $now, 'updated_at' => $now],
        ['nome' => 'Academia Huambo', 'localizacao' => 'Rua da Independência, Huambo', 'contactos' => json_encode(['943333444']), 'email' => 'huambo@academia.ao', 'created_at' => $now, 'updated_at' => $now],
    ]);

    }
}
