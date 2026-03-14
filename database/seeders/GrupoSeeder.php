<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // GRUPO 1: SNACKBAR
        Grupo::create([
            'nome' => 'snackbar',
            'display_name' => 'Snackbar',
            'icone' => 'fas fa-utensils',
            'ordem' => 1,
            'ativo' => true
        ]);

        // GRUPO 2: PRODUTOS
        Grupo::create([
            'nome' => 'produtos',
            'display_name' => 'Produtos',
            'icone' => 'fas fa-box',
            'ordem' => 2,
            'ativo' => true
        ]);

        // GRUPO 3: SERVIÇOS
        Grupo::create([
            'nome' => 'servicos',
            'display_name' => 'Serviços',
            'icone' => 'fas fa-cogs',
            'ordem' => 3,
            'ativo' => true
        ]);
    }
}
