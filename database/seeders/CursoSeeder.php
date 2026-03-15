<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Curso::create([
        //     'centro_id' => 1,
        //     'nome' => 'Informática Básica',
        //     'descricao' => 'Curso introdutório de informática.',
        //     'programa' => 'Windows, Word, Excel, Internet',
        //     'duracao' => '3 meses',
        //     'preco' => 25000.00,
        //     'area' => 'Tecnologia',
        //     'imagem_url' => null,
        //     'ativo' => true
        // ]);

        // Curso::create([
        //     'centro_id' => 2,
        //     'nome' => 'Gestão Empresarial',
        //     'descricao' => 'Curso de gestão para empreendedores.',
        //     'programa' => 'Administração, Finanças, Marketing',
        //     'duracao' => '4 meses',
        //     'preco' => 35000.00,
        //     'area' => 'Negócios',
        //     'imagem_url' => null,
        //     'ativo' => true
        // ]);

        $now = now();

        $cursos = [
            ['nome' => 'Informática Básica', 'descricao' => 'Curso de introdução à informática.', 'programa' => 'Windows, Word, Excel', 'area' => 'Tecnologia', 'ativo' => true],
            ['nome' => 'Gestão Empresarial', 'descricao' => 'Curso de gestão.', 'programa' => 'Administração, RH', 'area' => 'Gestão', 'ativo' => true],
            ['nome' => 'Inglês', 'descricao' => 'Curso de inglês básico.', 'programa' => 'Gramática, Conversação', 'area' => 'Idiomas', 'ativo' => true],
            ['nome' => 'Matemática Aplicada', 'descricao' => 'Curso de matemática.', 'programa' => 'Álgebra, Estatística', 'area' => 'Ciências', 'ativo' => true],
            ['nome' => 'Programação Web', 'descricao' => 'Curso de web.', 'programa' => 'HTML, CSS, JS', 'area' => 'Tecnologia', 'ativo' => true],
            ['nome' => 'Contabilidade', 'descricao' => 'Curso de contabilidade.', 'programa' => 'Balanço, Fiscal', 'area' => 'Gestão', 'ativo' => true],
            ['nome' => 'Design Gráfico', 'descricao' => 'Curso de design.', 'programa' => 'Photoshop, Illustrator', 'area' => 'Artes', 'ativo' => true],
        ];

        foreach ($cursos as $curso) {
            Curso::updateOrCreate(
                ['nome' => $curso['nome']],
                array_merge($curso, ['updated_at' => $now, 'created_at' => $now])
            );
        }
    }
}
