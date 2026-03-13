<?php

namespace Tests\Feature;

use App\Models\Centro;
use App\Models\Curso;
use App\Models\Formador;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TurmaApiTest extends TestCase
{
    // use RefreshDatabase; // Commented out to avoid issues with seeders

    private $user;
    private $centro;
    private $curso;
    private $formador;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data manually
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

        // Create admin user for API authentication
        $this->user = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($this->user);
    }

    // ========== READ (GET) TESTS ==========

    /**
     * Test: API GET - Listar todas as turmas
     */
    public function test_api_index_turmas()
    {
        Turma::factory()->count(3)->create();

        $response = $this->getJson('/api/turmas');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'curso_id',
                'centro_id',
                'formador_id',
                'data_arranque',
                'duracao_semanas',
                'dia_semana',
                'periodo',
                'hora_inicio',
                'hora_fim',
                'status',
                'vagas_totais',
                'publicado',
                'created_at',
                'updated_at',
                'curso' => [
                    'id',
                    'nome'
                ],
                'formador' => [
                    'id',
                    'nome'
                ],
                'centro' => [
                    'id',
                    'nome'
                ]
            ]
        ]);
    }

    /**
     * Test: API GET - Buscar turma por ID existente
     */
    public function test_api_show_turma_existente()
    {
        $turma = Turma::factory()->create();

        $response = $this->getJson("/api/turmas/{$turma->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'dados' => [
                'id',
                'curso_id',
                'centro_id',
                'formador_id',
                'data_arranque',
                'duracao_semanas',
                'dia_semana',
                'periodo',
                'hora_inicio',
                'hora_fim',
                'status',
                'vagas_totais',
                'publicado',
                'curso' => [
                    'id',
                    'nome'
                ],
                'formador' => [
                    'id',
                    'nome'
                ]
            ]
        ]);
    }

    /**
     * Test: API GET - Buscar turma por ID inexistente
     */
    public function test_api_show_turma_inexistente()
    {
        $response = $this->getJson('/api/turmas/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'erro',
            'mensagem' => 'Turma não encontrada!'
        ]);
    }

    // ========== CREATE (POST) TESTS ==========

    /**
     * Test: API POST - Criar turma com dados válidos
     */
    public function test_api_store_turma_com_dados_validos()
    {
        // Restore Sanctum
        Sanctum::actingAs($this->user);
        $dados = [
            'curso_id' => $this->curso->id,
            'centro_id' => $this->centro->id,
            'formador_id' => null, // Remover formador para simplificar
            'data_arranque' => now()->addDays(10)->toDateString(),
            'duracao_semanas' => 8,
            'dia_semana' => ['Segunda'],
            'periodo' => 'manha',
            'hora_inicio' => '08:00',
            'hora_fim' => '10:00',
            'status' => 'planeada',
            'vagas_totais' => 25,
            'publicado' => true
        ];

        $response = $this->postJson('/api/turmas', $dados);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'mensagem',
            'dados' => [
                'id',
                'curso_id',
                'centro_id',
                'formador_id',
                'data_arranque',
                'duracao_semanas',
                'dia_semana',
                'periodo',
                'hora_inicio',
                'hora_fim',
                'status',
                'vagas_totais',
                'publicado'
            ]
        ]);

        $this->assertDatabaseHas('turmas', [
            'curso_id' => $dados['curso_id'],
            'centro_id' => $dados['centro_id'],
            'periodo' => 'manhã', // Normalizado
            'hora_inicio' => '08:00'
        ]);
    }

    /**
     * Test: API POST - Criar turma sem autenticação
     */
    public function test_api_store_turma_sem_autenticacao()
    {
        // Remove authentication
        $this->user = null;

        $dados = [
            'curso_id' => 1,
            'centro_id' => 1,
            'data_arranque' => now()->addDays(10)->toDateString(),
            'dia_semana' => ['Segunda'],
            'periodo' => 'manhã',
            'hora_inicio' => '08:00'
        ];

        $response = $this->postJson('/api/turmas', $dados);

        $response->assertStatus(401);
    }

    /**
     * Test: API POST - Criar turma com dados inválidos
     */
    public function test_api_store_turma_com_dados_invalidos()
    {
        $dados = [
            'curso_id' => 9999, // Inexistente
            'centro_id' => 1,
            'data_arranque' => 'invalid-date',
            'dia_semana' => 'invalid',
            'periodo' => 'invalid',
            'hora_inicio' => '25:00'
        ];

        $response = $this->postJson('/api/turmas', $dados);

        $response->assertStatus(422);
    }

    /**
     * Test: API POST - Criar turma com centro que não oferece o curso
     */
    public function test_api_store_turma_centro_nao_oferece_curso()
    {
        $centro2 = Centro::factory()->create();

        $dados = [
            'curso_id' => $this->curso->id,
            'centro_id' => $centro2->id, // Centro que não oferece o curso
            'data_arranque' => now()->addDays(10)->toDateString(),
            'dia_semana' => ['Segunda'],
            'periodo' => 'manhã',
            'hora_inicio' => '08:00'
        ];

        $response = $this->postJson('/api/turmas', $dados);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'erro',
            'mensagem' => 'O centro selecionado não oferece o curso escolhido.'
        ]);
    }

    /**
     * Test: API POST - Criar turma com status inscricoes_abertas sem formador
     */
    public function test_api_store_turma_inscricoes_abertas_sem_formador()
    {
        $curso = Curso::first();
        $centro = Centro::first();

        // Garantir que o centro oferece o curso
        if (!$centro->cursos()->where('cursos.id', $curso->id)->exists()) {
            $centro->cursos()->attach($curso->id, [
                'preco' => 150.00,
                'duracao' => 40,
                'data_arranque' => now()->addMonths(1)->toDateString()
            ]);
        }

        $dados = [
            'curso_id' => $curso->id,
            'centro_id' => $centro->id,
            'formador_id' => null,
            'data_arranque' => now()->addDays(10)->toDateString(),
            'dia_semana' => ['Segunda'],
            'periodo' => 'manhã',
            'hora_inicio' => '08:00',
            'status' => 'inscricoes_abertas'
        ];

        $response = $this->postJson('/api/turmas', $dados);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'erro',
            'mensagem' => 'Formador obrigatório para turmas com inscrições abertas.'
        ]);
    }

    // ========== UPDATE (PUT) TESTS ==========

    /**
     * Test: API PUT - Atualizar turma com dados válidos
     */
    public function test_api_update_turma_com_dados_validos()
    {
        $turma = Turma::factory()->create();

        $dados = [
            'centro_id' => $turma->centro_id,
            'formador_id' => $turma->formador_id,
            'data_arranque' => now()->addDays(20)->toDateString(),
            'duracao_semanas' => 10,
            'dia_semana' => ['Terça', 'Quinta'],
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'hora_fim' => '16:00',
            'status' => 'inscricoes_abertas',
            'vagas_totais' => 30,
            'publicado' => false
        ];

        $response = $this->putJson("/api/turmas/{$turma->id}", $dados);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'mensagem',
            'dados'
        ]);

        $this->assertDatabaseHas('turmas', [
            'id' => $turma->id,
            'duracao_semanas' => 10,
            'periodo' => 'tarde',
            'hora_inicio' => '14:00',
            'vagas_totais' => 30
        ]);
    }

    /**
     * Test: API PUT - Atualizar turma inexistente
     */
    public function test_api_update_turma_inexistente()
    {
        $dados = [
            'dia_semana' => ['Segunda'],
            'periodo' => 'manhã',
            'hora_inicio' => '08:00'
        ];

        $response = $this->putJson('/api/turmas/9999', $dados);

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'erro',
            'mensagem' => 'Turma não encontrada!'
        ]);
    }

    /**
     * Test: API PUT - Atualizar turma com dados inválidos
     */
    public function test_api_update_turma_com_dados_invalidos()
    {
        $turma = Turma::factory()->create();

        $dados = [
            'dia_semana' => 'invalid',
            'periodo' => 'invalid',
            'hora_inicio' => '25:00',
            'hora_fim' => '01:00' // Antes da hora_inicio
        ];

        $response = $this->putJson("/api/turmas/{$turma->id}", $dados);

        $response->assertStatus(422);
    }

    // ========== DELETE (DELETE) TESTS ==========

    /**
     * Test: API DELETE - Deletar turma existente
     */
    public function test_api_destroy_turma_existente()
    {
        $turma = Turma::factory()->create();

        $response = $this->deleteJson("/api/turmas/{$turma->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'sucesso',
            'mensagem' => 'Turma deletada com sucesso!'
        ]);

        $this->assertDatabaseMissing('turmas', ['id' => $turma->id]);
    }

    /**
     * Test: API DELETE - Deletar turma inexistente
     */
    public function test_api_destroy_turma_inexistente()
    {
        $response = $this->deleteJson('/api/turmas/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'erro',
            'mensagem' => 'Turma não encontrada!'
        ]);
    }

    /**
     * Test: API DELETE - Deletar turma sem autenticação
     */
    public function test_api_destroy_turma_sem_autenticacao()
    {
        $turma = Turma::factory()->create();

        // Remove authentication
        $this->user = null;

        $response = $this->deleteJson("/api/turmas/{$turma->id}");

        $response->assertStatus(401);
    }
}