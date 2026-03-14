<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categorias
        $comida = Categoria::where('nome', 'Comida')->first();
        $bebida = Categoria::where('nome', 'Bebida')->first();
        $materiais = Categoria::where('nome', 'Materiais Escolares')->first();
        $eletronicos = Categoria::where('nome', 'Eletrônicos')->first();
        $desenvolvimento = Categoria::where('nome', 'Desenvolvimento')->first();
        $monografia = Categoria::where('nome', 'Monografia')->first();
        $auditoria = Categoria::where('nome', 'Auditoria')->first();

        // SNACKBAR - COMIDA (2 itens)
        Item::create([
            'nome' => 'Cachorro Quente',
            'descricao' => 'Delicioso cachorro quente com molho especial',
            'preco' => 19.99,
            'categoria_id' => $comida->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Francesinha',
            'descricao' => 'Francesinha tradicional com queijo',
            'preco' => 25.99,
            'categoria_id' => $comida->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 2,
            'ativo' => true
        ]);

        // SNACKBAR - BEBIDA (2 itens)
        Item::create([
            'nome' => 'Coca-Cola',
            'descricao' => 'Coca-Cola 330ml (fria)',
            'preco' => 3.50,
            'categoria_id' => $bebida->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Suco Natural',
            'descricao' => 'Suco natural de laranja fresco',
            'preco' => 5.00,
            'categoria_id' => $bebida->id,
            'tipo' => 'produto',
            'destaque' => false,
            'ordem' => 2,
            'ativo' => true
        ]);

        // PRODUTOS - MATERIAIS ESCOLARES (2 itens)
        Item::create([
            'nome' => 'Caderno A4',
            'descricao' => 'Caderno A4 com 100 folhas pautadas',
            'preco' => 8.99,
            'categoria_id' => $materiais->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Lápis HB',
            'descricao' => 'Lápis HB para escrever e desenho',
            'preco' => 1.50,
            'categoria_id' => $materiais->id,
            'tipo' => 'produto',
            'destaque' => false,
            'ordem' => 2,
            'ativo' => true
        ]);

        // PRODUTOS - ELETRÔNICOS (5 itens)
        Item::create([
            'nome' => 'Desktop',
            'descricao' => 'Computador Desktop potente para trabalho',
            'preco' => 399.99,
            'categoria_id' => $eletronicos->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Notebook',
            'descricao' => 'Notebook portátil com processador rápido',
            'preco' => 899.99,
            'categoria_id' => $eletronicos->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 2,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Monitor',
            'descricao' => 'Monitor 24" Full HD para computador',
            'preco' => 189.99,
            'categoria_id' => $eletronicos->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 3,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Impressora HP',
            'descricao' => 'Impressora HP multifunção',
            'preco' => 299.99,
            'categoria_id' => $eletronicos->id,
            'tipo' => 'produto',
            'destaque' => true,
            'ordem' => 4,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'Teclado Mecânico',
            'descricao' => 'Teclado mecânico RGB com switches',
            'preco' => 149.99,
            'categoria_id' => $eletronicos->id,
            'tipo' => 'produto',
            'destaque' => false,
            'ordem' => 5,
            'ativo' => true
        ]);

        // SERVIÇOS - DESENVOLVIMENTO (2 itens)
        Item::create([
            'nome' => 'Sistema Web',
            'descricao' => 'Desenvolvimento de sistema web customizado',
            'preco' => null, // Sob Consulta
            'categoria_id' => $desenvolvimento->id,
            'tipo' => 'servico',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        Item::create([
            'nome' => 'App Mobile',
            'descricao' => 'Desenvolvimento de aplicativo mobile',
            'preco' => null, // Sob Consulta
            'categoria_id' => $desenvolvimento->id,
            'tipo' => 'servico',
            'destaque' => false,
            'ordem' => 2,
            'ativo' => true
        ]);

        // SERVIÇOS - MONOGRAFIA (1 item)
        Item::create([
            'nome' => 'Orientação TCC',
            'descricao' => 'Orientação para Trabalho de Conclusão de Curso',
            'preco' => null, // Sob Consulta
            'categoria_id' => $monografia->id,
            'tipo' => 'servico',
            'destaque' => true,
            'ordem' => 1,
            'ativo' => true
        ]);

        // SERVIÇOS - AUDITORIA (1 item)
        Item::create([
            'nome' => 'Auditoria',
            'descricao' => 'Auditoria de sistemas de informação',
            'preco' => null, // Sob Consulta
            'categoria_id' => $auditoria->id,
            'tipo' => 'servico',
            'destaque' => false,
            'ordem' => 1,
            'ativo' => true
        ]);
    }
}
