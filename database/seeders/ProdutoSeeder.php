<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use App\Models\Categoria;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // Obter categorias
        $snackComida = \App\Models\Categoria::where('tipo', 'snack_comida')->first();
        $snackBebida = \App\Models\Categoria::where('tipo', 'snack_bebida')->first();
        $lojaMateriais = \App\Models\Categoria::where('tipo', 'loja_materiais')->first();
        $lojaHardware = \App\Models\Categoria::where('tipo', 'loja_hardware')->first();
        $servico = \App\Models\Categoria::where('tipo', 'servico')->first();

        // SNACKBAR - COMIDAS
        Produto::create([
            'nome' => 'Cachorro Quente',
            'descricao' => 'Cachorro quente com molho e cebola',
            'preco' => 19.99,
            'categoria_id' => $snackComida->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => true
        ]);

        Produto::create([
            'nome' => 'Francesinha',
            'descricao' => 'Francesinha com queijo e presunto',
            'preco' => 15.99,
            'categoria_id' => $snackComida->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => true
        ]);

        // SNACKBAR - BEBIDAS
        Produto::create([
            'nome' => 'Coca-Cola',
            'descricao' => 'Coca-Cola 330ml',
            'preco' => 3.50,
            'categoria_id' => $snackBebida->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => false
        ]);

        Produto::create([
            'nome' => 'Suco Natural',
            'descricao' => 'Suco natural de laranja fresco',
            'preco' => 5.00,
            'categoria_id' => $snackBebida->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => false
        ]);

        // LOJA - MATERIAIS
        Produto::create([
            'nome' => 'Caderno A4',
            'descricao' => 'Caderno A4 100 folhas pautadas',
            'preco' => 8.99,
            'categoria_id' => $lojaMateriais->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => false
        ]);

        Produto::create([
            'nome' => 'Lápis HB',
            'descricao' => 'Lápis HB para escrever e desenho',
            'preco' => 1.50,
            'categoria_id' => $lojaMateriais->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => false
        ]);

        // LOJA - HARDWARE
        Produto::create([
            'nome' => 'Monitor 24" LG',
            'descricao' => 'Monitor LG 24 polegadas Full HD',
            'preco' => 189.99,
            'categoria_id' => $lojaHardware->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => true
        ]);

        Produto::create([
            'nome' => 'Teclado Mecânico',
            'descricao' => 'Teclado mecânico RGB com switches',
            'preco' => 149.99,
            'categoria_id' => $lojaHardware->id,
            'tipo_item' => 'produto',
            'ativo' => true,
            'em_destaque' => false
        ]);

        // SERVIÇOS
        Produto::create([
            'nome' => 'Criação de Sistema de Notas',
            'descricao' => 'Desenvolvimento de sistema de gestão de notas para sua instituição',
            'preco' => null,
            'categoria_id' => $servico->id,
            'tipo_item' => 'servico',
            'ativo' => true,
            'em_destaque' => true
        ]);

        Produto::create([
            'nome' => 'Design Gráfico',
            'descricao' => 'Serviços de design gráfico e criação de materiais visuais',
            'preco' => null,
            'categoria_id' => $servico->id,
            'tipo_item' => 'servico',
            'ativo' => true,
            'em_destaque' => false
        ]);

        Produto::create([
            'nome' => 'Consultoria IT',
            'descricao' => 'Consultoria técnica em tecnologia e infraestrutura',
            'preco' => null,
            'categoria_id' => $servico->id,
            'tipo_item' => 'servico',
            'ativo' => true,
            'em_destaque' => false
        ]);
    }
}
