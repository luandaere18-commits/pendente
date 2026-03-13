<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminUserSeeder::class,    // Primeiro criar o admin
            CentroSeeder::class,
            CursoSeeder::class,
            CentroCursoSeeder::class,  // Antes dos turmas para criar relacionamentos
            FormadorSeeder::class,
            TurmaSeeder::class,        // Depois dos relacionamentos centro-curso
            CentroFormadorSeeder::class,
            CategoriaSeeder::class,   // Antes dos produtos
            ProdutoSeeder::class,     // Depois das categorias
            PreInscricaoSeeder::class,   // Por último porque depende de todos
        ]); 
    }
}
