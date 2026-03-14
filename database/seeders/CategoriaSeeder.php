<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get grupos
        $snackbar = Grupo::where('nome', 'snackbar')->first();
        $produtos = Grupo::where('nome', 'produtos')->first();
        $servicos = Grupo::where('nome', 'servicos')->first();

        // SNACKBAR - COMIDA
        Categoria::create([
            'nome' => 'Comida',
            'descricao' => 'Refeições rápidas',
            'grupo_id' => $snackbar->id,
            'ordem' => 1,
            'ativo' => true
        ]);

        // SNACKBAR - BEBIDA
        Categoria::create([
            'nome' => 'Bebida',
            'descricao' => 'Refrigerantes e sucos',
            'grupo_id' => $snackbar->id,
            'ordem' => 2,
            'ativo' => true
        ]);

        // PRODUTOS - MATERIAIS ESCOLARES
        Categoria::create([
            'nome' => 'Materiais Escolares',
            'descricao' => 'Cadernos, lápis, mochilas',
            'grupo_id' => $produtos->id,
            'ordem' => 1,
            'ativo' => true
        ]);

        // PRODUTOS - ELETRÔNICOS
        Categoria::create([
            'nome' => 'Eletrônicos',
            'descricao' => 'Computadores, impressoras e afins',
            'grupo_id' => $produtos->id,
            'ordem' => 2,
            'ativo' => true
        ]);

        // SERVIÇOS - DESENVOLVIMENTO
        Categoria::create([
            'nome' => 'Desenvolvimento',
            'descricao' => 'Sistemas e aplicativos',
            'grupo_id' => $servicos->id,
            'ordem' => 1,
            'ativo' => true
        ]);

        // SERVIÇOS - MONOGRAFIA
        Categoria::create([
            'nome' => 'Monografia',
            'descricao' => 'Orientação de TCC',
            'grupo_id' => $servicos->id,
            'ordem' => 2,
            'ativo' => true
        ]);

        // SERVIÇOS - AUDITORIA
        Categoria::create([
            'nome' => 'Auditoria',
            'descricao' => 'Auditoria de sistemas',
            'grupo_id' => $servicos->id,
            'ordem' => 3,
            'ativo' => true
        ]);
    }
}


