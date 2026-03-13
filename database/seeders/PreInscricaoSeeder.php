<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreInscricao;

class PreInscricaoSeeder extends Seeder
{
    public function run(): void
    {
        // PreInscricao::create([
        //     'curso_id' => 1,
        //     'centro_id' => 1,
        //     'turma_id' => 1,
        //     'nome_completo' => 'João Pedro',
        //     'contactos' => ['923456789'],
        //     'email' => 'joao@email.com',
        //     'status' => 'pendente',
        //     'observacoes' => 'Quero estudar à noite.'
        // ]);

        // PreInscricao::create([
        //     'curso_id' => 2,
        //     'centro_id' => 2,
        //     'turma_id' => 3,
        //     'nome_completo' => 'Maria Luísa',
        //     'contactos' => ['951456700'],
        //     'email' => 'maria@email.com',
        //     'status' => 'confirmado',
        //     'observacoes' => null
        // ]);

        $now = now();

        $inscricoes = [
            ['turma_id' => 1, 'nome_completo' => 'João Pedro', 'contactos' => ['923111111'], 'email' => 'joao@teste.com', 'status' => 'pendente', 'observacoes' => 'Quero estudar à tarde.'],
            ['turma_id' => 2, 'nome_completo' => 'Maria Luísa', 'contactos' => ['923222222'], 'email' => 'maria@teste.com', 'status' => 'confirmado', 'observacoes' => null],
            ['turma_id' => 3, 'nome_completo' => 'Carlos Pinto', 'contactos' => ['923333333'], 'email' => 'carlos@teste.com', 'status' => 'pendente', 'observacoes' => 'Preferência para manha.'],
            ['turma_id' => 4, 'nome_completo' => 'Ana Paula', 'contactos' => ['923444444'], 'email' => 'ana@teste.com', 'status' => 'pendente', 'observacoes' => null],
            ['turma_id' => 5, 'nome_completo' => 'Bruno Dias', 'contactos' => ['923555555'], 'email' => 'bruno@teste.com', 'status' => 'pendente', 'observacoes' => 'Quero estudar online.'],
            ['turma_id' => 6, 'nome_completo' => 'Carla Torres', 'contactos' => ['923666666'], 'email' => 'carla@teste.com', 'status' => 'pendente', 'observacoes' => null],
            ['turma_id' => 7, 'nome_completo' => 'Daniel Lima', 'contactos' => ['923777777'], 'email' => 'daniel@teste.com', 'status' => 'pendente', 'observacoes' => null],
        ];

        foreach ($inscricoes as $inscricao) {
            PreInscricao::updateOrCreate(
                ['turma_id' => $inscricao['turma_id'], 'email' => $inscricao['email']],
                array_merge($inscricao, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}