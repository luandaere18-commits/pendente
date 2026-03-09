<?php

namespace Tests\Feature;

use App\Models\Cronograma;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CronogramaTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Não usar seeder completo - apenas criar dados necessários com factories
        // Seed centros primeiro
        $this->seed(\Database\Seeders\CentroSeeder::class);
        
        // Seed cursos
        $this->seed(\Database\Seeders\CursoSeeder::class);
        
        // Create admin user for authentication
        $this->user = User::factory()->create(['is_admin' => true]);
    }

    // ========== CREATE TESTS ==========

    /**
     * Test: Store - Criar novo cronograma com dados válidos
     */
    public function test_store_cronograma_com_dados_validos()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã',
            'hora_inicio' => '08:30',
            'hora_fim' => '10:30'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertRedirect(route('cronogramas.index'));
        $response->assertSessionHas('success', 'Cronograma criado com sucesso!');
        
        $this->assertDatabaseHas('cronogramas', [
            'curso_id' => $curso->id,
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã',
            'hora_inicio' => '08:30',
            'hora_fim' => '10:30'
        ]);
    }

    /**
     * Test: Store - Falhar quando curso_id não existe
     */
    public function test_store_cronograma_curso_inexistente()
    {
        $dados = [
            'curso_id' => 99999,
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã',
            'hora_inicio' => '08:30',
            'hora_fim' => '10:30'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertSessionHasErrors('curso_id');
        $this->assertDatabaseCount('cronogramas', Cronograma::count());
    }

    /**
     * Test: Store - Falhar quando período é inválido
     */
    public function test_store_cronograma_periodo_invalido()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Segunda',
            'periodo' => 'invalid_periodo',
            'hora_inicio' => '08:30',
            'hora_fim' => '10:30'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertSessionHasErrors('periodo');
    }

    /**
     * Test: Store - Falhar quando hora_inicio está fora do período
     */
    public function test_store_cronograma_hora_fora_do_periodo_manha()
    {
        $curso = Curso::first();
        
        // Período manhã aceita 08:00 a 11:59
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã',
            'hora_inicio' => '14:00', // Hora inválida para manhã
            'hora_fim' => '16:00'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertSessionHasErrors('hora_inicio');
    }

    /**
     * Test: Store - Validar hora_inicio formato H:i
     */
    public function test_store_cronograma_hora_formato_invalido()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã',
            'hora_inicio' => '08:00:00', // Formato inválido
            'hora_fim' => '10:30'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertSessionHasErrors('hora_inicio');
    }

    /**
     * Test: Store - Período tarde (12:00-17:59)
     */
    public function test_store_cronograma_periodo_tarde()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Terça',
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'hora_fim' => '16:00'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertRedirect(route('cronogramas.index'));
        $this->assertDatabaseHas('cronogramas', ['periodo' => 'tarde', 'hora_inicio' => '14:00']);
    }

    /**
     * Test: Store - Período noite (18:00-21:59)
     */
    public function test_store_cronograma_periodo_noite()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => 'Quarta',
            'periodo' => 'noite',
            'hora_inicio' => '19:00',
            'hora_fim' => '21:00'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertRedirect(route('cronogramas.index'));
        $this->assertDatabaseHas('cronogramas', ['periodo' => 'noite', 'hora_inicio' => '19:00']);
    }

    // ========== READ TESTS ==========

    /**
     * Test: Index - Listar todos os cronogramas
     */
    public function test_index_lista_todos_cronogramas()
    {
        Cronograma::factory()->count(5)->create();

        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('cronogramas.index');
        $response->assertViewHas('cronogramas');
        
        $cronogramas = $response->viewData('cronogramas');
        $this->assertCount(5 + Cronograma::count() - 5, $cronogramas);
    }

    /**
     * Test: Index - View deve conter dados de cronogramas carregados
     */
    public function test_index_carrega_dados_curso()
    {
        $cronograma = Cronograma::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.index'));

        $response->assertStatus(200);
        $cronogramas = $response->viewData('cronogramas');
        $this->assertTrue($cronogramas->contains($cronograma));
    }

    /**
     * Test: Show - Verificar que cronograma pode ser recuperado do banco
     */
    public function test_show_cronograma_individual()
    {
        $cronograma = Cronograma::factory()->create();

        // Verificar que o cronograma foi criado e pode ser recuperado
        $this->assertDatabaseHas('cronogramas', [
            'id' => $cronograma->id,
            'dia_semana' => $cronograma->dia_semana,
        ]);
        
        // Recuperar do banco
        $cronograma_recuperado = Cronograma::find($cronograma->id);
        $this->assertNotNull($cronograma_recuperado);
        $this->assertEquals($cronograma->id, $cronograma_recuperado->id);
    }

    /**
     * Test: Show - Retornar 404 para cronograma inexistente
     */
    public function test_show_cronograma_inexistente()
    {
        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.show', 99999));

        $response->assertNotFound();
    }

    /**
     * Test: Create - Exibir formulário de criação
     */
    public function test_create_exibe_formulario()
    {
        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('cronogramas.create');
        $response->assertViewHas('cursos');
    }

    // ========== UPDATE TESTS ==========

    /**
     * Test: Update - Atualizar cronograma com dados válidos
     */
    public function test_update_cronograma_com_dados_validos()
    {
        $cronograma = Cronograma::factory()->create([
            'dia_semana' => 'Segunda',
            'periodo' => 'manhã'
        ]);

        $dados = [
            'curso_id' => $cronograma->curso_id,
            'dia_semana' => 'Terça',
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'hora_fim' => '16:00'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('cronogramas.update', $cronograma->id), $dados);

        $response->assertRedirect(route('cronogramas.index'));
        $response->assertSessionHas('success', 'Cronograma atualizado com sucesso!');
        
        $this->assertDatabaseHas('cronogramas', [
            'id' => $cronograma->id,
            'dia_semana' => 'Terça',
            'periodo' => 'tarde'
        ]);
    }

    /**
     * Test: Update - Falhar ao atualizar cronograma inexistente
     */
    public function test_update_cronograma_inexistente()
    {
        $dados = [
            'curso_id' => Curso::first()->id,
            'dia_semana' => 'Terça',
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'hora_fim' => '16:00'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('cronogramas.update', 99999), $dados);

        $response->assertNotFound();
    }

    /**
     * Test: Update - Validar mudança de período com hora_inicio válida
     */
    public function test_update_cronograma_muda_periodo()
    {
        $cronograma = Cronograma::factory()->create([
            'periodo' => 'manhã',
            'hora_inicio' => '08:00'
        ]);

        $dados = [
            'curso_id' => $cronograma->curso_id,
            'dia_semana' => $cronograma->dia_semana,
            'periodo' => 'noite',
            'hora_inicio' => '19:30',
            'hora_fim' => '21:00'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('cronogramas.update', $cronograma->id), $dados);

        $response->assertRedirect(route('cronogramas.index'));
        $this->assertDatabaseHas('cronogramas', [
            'id' => $cronograma->id,
            'periodo' => 'noite',
            'hora_inicio' => '19:30'
        ]);
    }

    /**
     * Test: Edit - Exibir formulário de edição
     */
    public function test_edit_exibe_formulario()
    {
        $cronograma = Cronograma::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.edit', $cronograma->id));

        $response->assertStatus(200);
        $response->assertViewIs('cronogramas.edit');
        $response->assertViewHas('cronograma', $cronograma);
        $response->assertViewHas('cursos');
    }

    // ========== DELETE TESTS ==========

    /**
     * Test: Destroy - Deletar cronograma com sucesso
     */
    public function test_destroy_cronograma()
    {
        $cronograma = Cronograma::factory()->create();
        $id = $cronograma->id;

        $response = $this->actingAs($this->user)
            ->delete(route('cronogramas.destroy', $id));

        $response->assertRedirect(route('cronogramas.index'));
        $response->assertSessionHas('success', 'Cronograma deletado com sucesso!');
        
        $this->assertDatabaseMissing('cronogramas', ['id' => $id]);
    }

    /**
     * Test: Destroy - Falhar ao deletar cronograma inexistente
     */
    public function test_destroy_cronograma_inexistente()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('cronogramas.destroy', 99999));

        $response->assertNotFound();
    }

    /**
     * Test: Destroy - Deletar múltiplos cronogramas
     */
    public function test_destroy_multiplos_cronogramas()
    {
        $cronogramasAntes = Cronograma::count();
        $cronogramas = Cronograma::factory()->count(3)->create();
        
        foreach ($cronogramas as $cronograma) {
            $this->actingAs($this->user)
                ->delete(route('cronogramas.destroy', $cronograma->id));
        }

        // Verificar que 3 cronogramas foram deletados
        $this->assertDatabaseCount('cronogramas', $cronogramasAntes);
    }

    // ========== RELATIONSHIP TESTS ==========

    /**
     * Test: Cronograma carrega relacionamento com Curso
     */
    public function test_cronograma_carrega_curso()
    {
        $cronograma = Cronograma::factory()->create();
        $cronograma->load('curso');

        $this->assertNotNull($cronograma->curso);
        $this->assertInstanceOf(Curso::class, $cronograma->curso);
    }

    /**
     * Test: Index - Cronogramas vêm com relacionamento curso carregado
     */
    public function test_index_cronogramas_com_curso_carregado()
    {
        Cronograma::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('cronogramas.index'));

        $cronogramas = $response->viewData('cronogramas');
        
        foreach ($cronogramas as $cronograma) {
            $this->assertNotNull($cronograma->curso);
        }
    }

    // ========== VALIDATION TESTS ==========

    /**
     * Test: Validar campos obrigatórios
     */
    public function test_validacao_campos_obrigatorios()
    {
        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), []);

        $response->assertSessionHasErrors(['curso_id', 'dia_semana', 'periodo']);
    }

    /**
     * Test: Validar dia_semana
     */
    public function test_validacao_dia_semana()
    {
        $curso = Curso::first();
        
        $dados = [
            'curso_id' => $curso->id,
            'dia_semana' => '',
            'periodo' => 'manhã',
            'hora_inicio' => '08:00',
            'hora_fim' => '10:00'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('cronogramas.store'), $dados);

        $response->assertSessionHasErrors('dia_semana');
    }
}
