<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formador;

class FormadorSeeder extends Seeder
{
    public function run(): void
    {



        $now = now();

        $formadores = [
            ['nome' => 'Ana Silva', 'email' => 'ana@formador.com', 'contactos' => ['923888888'], 'especialidade' => 'Informática', 'bio' => 'Especialista em informática.', 'foto_url' => null],
            ['nome' => 'Bruno Costa', 'email' => 'bruno@formador.com', 'contactos' => ['923999999'], 'especialidade' => 'Gestão', 'bio' => 'Gestor experiente.', 'foto_url' => null],
            ['nome' => 'Carla Dias', 'email' => 'carla@formador.com', 'contactos' => ['924111111'], 'especialidade' => 'Inglês', 'bio' => 'Professora de inglês.', 'foto_url' => null],
            ['nome' => 'Daniel Rocha', 'email' => 'daniel@formador.com', 'contactos' => ['924222222'], 'especialidade' => 'Matemática', 'bio' => 'Matemático.', 'foto_url' => null],
            ['nome' => 'Eduarda Lima', 'email' => 'eduarda@formador.com', 'contactos' => ['924333333'], 'especialidade' => 'Programação', 'bio' => 'Desenvolvedora web.', 'foto_url' => null],
            ['nome' => 'Fernando Pinto', 'email' => 'fernando@formador.com', 'contactos' => ['924444444'], 'especialidade' => 'Contabilidade', 'bio' => 'Contabilista.', 'foto_url' => null],
            ['nome' => 'Gabriela Torres', 'email' => 'gabriela@formador.com', 'contactos' => ['924555555'], 'especialidade' => 'Design', 'bio' => 'Designer gráfico.', 'foto_url' => null],
        ];

        foreach ($formadores as $formador) {
            Formador::updateOrCreate(
                ['email' => $formador['email']],
                array_merge($formador, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
