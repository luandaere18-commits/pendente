<?php

namespace Tests\Feature;

use App\Models\Centro;
use App\Models\Curso;
use App\Models\Formador;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurmaWebTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $centro;
    private $curso;
    private $formador;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->centro = Centro::factory()->create();
        $this->curso = Curso::factory()->create();
        $this->formador = Formador::factory()->create();

        // Create centro_curso relationship
        \DB::table('centro_curso')->insert([
            'centro_id' => $this->centro->id,
            'curso_id' => $this->curso->id,
            'preco' => 150.00,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create admin user for authentication
        $this->user = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->user);
    }

    // ========== READ (GET) TESTS ==========

    /**
     * Test: Web GET - Listar todas as turmas (index)
     */
    public function test_web_index_turmas()
    {
        Turma::factory()->count(3)->create();

        $response = $this->get('/turmas');

        $response->assertStatus(200);
        $response->assertViewIs('turmas.index');
        $response->assertViewHas('turmas');
    }

    /**
     * Test: Web GET - Mostrar formulário de criação (create)
     */
    public function test_web_create_turma()
    {
        $response = $this->get('/turmas/create');

        $response->assertStatus(200);
        $response->assertViewIs('turmas.create');
        $response->assertViewHas(['cursos', 'formadores']);
    }

    /**
     * Test: Web GET - Mostrar turma específica (show)
     */
    public function test_web_show_turma()
    {
        $turma = Turma::factory()->create();

        $response = $this->get("/turmas/{$turma->id}");

        $response->assertStatus(200);
        $response->assertViewIs('turmas.show');
        $response->assertViewHas('turma');
    }

    /**
     * Test: Web GET - Mostrar formulário de edição (edit)
     */
    public function test_web_edit_turma()
    {
        $turma = Turma::factory()->create();

        $response = $this->get("/turmas/{$turma->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('turmas.edit');
        $response->assertViewHas(['turma', 'cursos', 'formadores']);
    }

    // ========== CREATE (POST) TESTS ==========

    /**
     * Test: Web POST - Criar turma com dados válidos (store)
     */
    public function test_web_store_turma_com_dados_validos()
    {
        $dados = [
            'curso_id' => $this->curso->id,
            'centro_id' => $this->centro->id,
            'formador_id' => $this->formador->id,
            'duracao_semanas' => 8,
            'dia_semana' => ['Segunda', 'Quarta'],
            'periodo' => 'manha',
            'hora_inicio' => '08:00',
            'hora_fim' => '10:00',
            'data_arranque' => now()->addDays(10)->toDateString(),
            'vagas_totais' => 25,
            'status' => 'planeada',
            'publicado' => true
        ];

        $response = $this->post('/turmas', $dados);

        $response->assertRedirect('/turmas');
        $response->assertSessionHas('success', 'Turma criada com sucesso!');

        $this->assertDatabaseHas('turmas', [
            'curso_id' => $dados['curso_id'],
            'centro_id' => $dados['centro_id'],
            'periodo' => 'manha',
            'hora_inicio' => '08:00',
            'vagas_totais' => 25
        ]);
    }

    /**
     * Test: Web POST - Criar turma com dados inválidos (store)
     */
    public function test_web_store_turma_com_dados_invalidos()
    {
        $dados = [
            'curso_id' => 9999, // Inexistente
            'centro_id' => $this->centro->id,
            'data_arranque' => 'invalid-date',
            'dia_semana' => [],
            'periodo' => 'invalid',
            'hora_inicio' => '25:00',
            'vagas_totais' => 0
        ];

        $response = $this->post('/turmas', $dados);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['curso_id', 'data_arranque', 'dia_semana', 'periodo', 'hora_inicio', 'vagas_totais']);
    }

    /**
     * Test: Web POST - Criar turma com centro que não oferece o curso
     */
    public function test_web_store_turma_centro_nao_oferece_curso()
    {
        $centro2 = Centro::factory()->create();

        $dados = [
            'curso_id' => $this->curso->id,
            'centro_id' => $centro2->id,
            'dia_semana' => ['Segunda'],
            'periodo' => 'manha',
            'hora_inicio' => '08:00',
            'hora_fim' => '10:00',
            'data_arranque' => now()->addDays(10)->toDateString(),
            'vagas_totais' => 25
        ];

        $response = $this->post('/turmas', $dados);

        $response->assertRedirect();
        $response->assertSessionHasErrors('centro_id');
    }

    // ========== UPDATE (PUT) TESTS ==========

    /**
     * Test: Web PUT - Atualizar turma com dados válidos (update)
     */
    public function test_web_update_turma_com_dados_validos()
    {
        $turma = Turma::factory()->create([
            'curso_id' => $this->curso->id,
            'centro_id' => $this->centro->id
        ]);

        $dados = [
            'curso_id' => $this->curso->id,
            'centro_id' => $this->centro->id,
            'formador_id' => $this->formador->id,
            'duracao_semanas' => 10,
            'dia_semana' => ['Terça', 'Quinta'],
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'hora_fim' => '16:00',
            'data_arranque' => now()->addDays(15)->toDateString(),
            'vagas_totais' => 30,
            'status' => 'inscricoes_abertas',
            'publicado' => false
        ];

        $response = $this->put("/turmas/{$turma->id}", $dados);

        $response->assertRedirect('/turmas');
        $response->assertSessionHas('success', 'Turma atualizada com sucesso!');

        $this->assertDatabaseHas('turmas', [
            'id' => $turma->id,
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'vagas_totais' => 30,
            'status' => 'inscricoes_abertas'
        ]);
    }

    /**
     * Test: Web PUT - Atualizar turma com dados inválidos (update)
     */
    public function test_web_update_turma_com_dados_invalidos()
    {
        $turma = Turma::factory()->create();

        $dados = [
            'curso_id' => 9999,
            'centro_id' => $this->centro->id,
            'data_arranque' => 'invalid',
            'dia_semana' => [],
            'periodo' => 'invalid',
            'vagas_totais' => -1
        ];

        $response = $this->put("/turmas/{$turma->id}", $dados);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['curso_id', 'data_arranque', 'dia_semana', 'periodo', 'vagas_totais']);
    }

    // ========== DELETE (DELETE) TESTS ==========

    /**
     * Test: Web DELETE - Deletar turma existente (destroy)
     */
    public function test_web_destroy_turma()
    {
        $turma = Turma::factory()->create();

        $response = $this->delete("/turmas/{$turma->id}");

        $response->assertRedirect('/turmas');
        $response->assertSessionHas('success', 'Turma deletada com sucesso!');

        $this->assertDatabaseMissing('turmas', ['id' => $turma->id]);
    }

    /**
     * Test: Web DELETE - Tentar deletar turma inexistente (destroy)
     */
    public function test_web_destroy_turma_inexistente()
    {
        $response = $this->delete('/turmas/9999');

        $response->assertStatus(404);
    }

    // ========== ADDITIONAL TESTS ==========

    /**
     * Test: Web GET - Filtrar turmas por curso
     */
    public function test_web_index_turmas_filtrar_por_curso()
    {
        $curso2 = Curso::factory()->create();
        Turma::factory()->create(['curso_id' => $this->curso->id]);
        Turma::factory()->create(['curso_id' => $curso2->id]);

        $response = $this->get("/turmas?curso_id={$this->curso->id}");

        $response->assertStatus(200);
        $response->assertViewIs('turmas.index');
        $turmas = $response->viewData('turmas');
        $this->assertCount(1, $turmas);
        $this->assertEquals($this->curso->id, $turmas->first()->curso_id);
    }

    /**
     * Test: Web GET - Filtrar turmas por status
     */
    public function test_web_index_turmas_filtrar_por_status()
    {
        Turma::factory()->create(['status' => 'planeada']);
        Turma::factory()->create(['status' => 'em_andamento']);

        $response = $this->get('/turmas?status=planeada');

        $response->assertStatus(200);
        $response->assertViewIs('turmas.index');
        $turmas = $response->viewData('turmas');
        $this->assertCount(1, $turmas);
        $this->assertEquals('planeada', $turmas->first()->status);
    }

    /**
     * Test: Web GET - Filtrar turmas por período
     */
    public function test_web_index_turmas_filtrar_por_periodo()
    {
        Turma::factory()->create(['periodo' => 'manha']);
        Turma::factory()->create(['periodo' => 'tarde']);

        $response = $this->get('/turmas?periodo=manha');

        $response->assertStatus(200);
        $response->assertViewIs('turmas.index');
        $turmas = $response->viewData('turmas');
        $this->assertCount(1, $turmas);
        $this->assertEquals('manha', $turmas->first()->periodo);
    }
}