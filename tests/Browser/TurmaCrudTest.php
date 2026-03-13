<?php

namespace Tests\Browser;

use App\Models\Centro;
use App\Models\Curso;
use App\Models\Formador;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\Browser\DuskTestCase;

class TurmaCrudTest extends DuskTestCase
{
    use DatabaseTransactions;

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

        // Create admin user
        $this->user = User::factory()->create(['is_admin' => true, 'password' => bcrypt('password')]);
    }

    /**
     * Test: Browser CRUD - Create, Read, Update, Delete Turma
     */
    public function test_crud_turma()
    {
        $this->browse(function (Browser $browser) {
            // Login
            $browser->visit('/login')
                    ->type('email', $this->user->email)
                    ->type('password', 'password') // Assuming default password
                    ->press('Entrar')
                    ->assertPathIs('/dashboard');

            // ========== CREATE (Criar Turma) ==========
            $browser->visit('/turmas/create')
                    ->assertSee('Criar Turma')
                    ->select('curso_id', $this->curso->id)
                    ->pause(1000) // Wait for JS to load centros
                    ->select('centro_id', $this->centro->id)
                    ->select('formador_id', $this->formador->id)
                    ->type('duracao_semanas', '8')
                    ->select('dia_semana', ['Segunda', 'Quarta'])
                    ->select('periodo', 'manhã')
                    ->type('hora_inicio', '08:00')
                    ->type('hora_fim', '10:00')
                    ->type('data_arranque', now()->addDays(10)->format('Y-m-d'))
                    ->type('vagas_totais', '25')
                    ->select('status', 'planeada')
                    ->check('publicado')
                    ->press('Criar Turma')
                    ->assertPathIs('/turmas')
                    ->assertSee('Turma criada com sucesso!');

            // Get the created turma
            $turma = Turma::latest()->first();
            $this->assertNotNull($turma);

            // ========== READ (Ler Turma) ==========
            $browser->visit("/turmas/{$turma->id}")
                    ->assertSee('Detalhes da Turma')
                    ->assertSee($this->curso->nome)
                    ->assertSee($this->centro->nome);

            // ========== UPDATE (Atualizar Turma) ==========
            $browser->visit("/turmas/{$turma->id}/edit")
                    ->assertSee('Editar Turma')
                    ->select('status', 'inscricoes_abertas')
                    ->type('vagas_totais', '30')
                    ->uncheck('publicado')
                    ->press('Atualizar Turma')
                    ->assertPathIs('/turmas')
                    ->assertSee('Turma atualizada com sucesso!');

            // Verify update
            $turma->refresh();
            $this->assertEquals('inscricoes_abertas', $turma->status);
            $this->assertEquals(30, $turma->vagas_totais);
            $this->assertFalse($turma->publicado);

            // ========== DELETE (Deletar Turma) ==========
            $browser->visit('/turmas')
                    ->assertSee($this->curso->nome)
                    ->click('form[action*="' . $turma->id . '"] button[type="submit"]') // Click delete button in form
                    ->acceptDialog() // Confirm delete
                    ->assertPathIs('/turmas')
                    ->assertSee('Turma deletada com sucesso!');

            // Verify deletion
            $this->assertDatabaseMissing('turmas', ['id' => $turma->id]);
        });
    }

    /**
     * Test: Browser - Listar turmas com filtros
     */
    public function test_listar_turmas_com_filtros()
    {
        // Create test turmas
        $turma1 = Turma::factory()->create(['status' => 'planeada']);
        $turma2 = Turma::factory()->create(['status' => 'em_andamento']);

        $this->browse(function (Browser $browser) {
            // Login
            $browser->visit('/login')
                    ->type('email', $this->user->email)
                    ->type('password', 'password')
                    ->press('Entrar')
                    ->assertPathIs('/dashboard');

            // List all turmas
            $browser->visit('/turmas')
                    ->assertSee('Turmas')
                    ->assertSee($turma1->curso->nome)
                    ->assertSee($turma2->curso->nome);

            // Filter by status
            $browser->select('filtro_status', 'planeada')
                    ->press('Filtrar')
                    ->assertSee($turma1->curso->nome)
                    ->assertDontSee($turma2->curso->nome);
        });
    }

    /**
     * Test: Browser - Validação de formulário
     */
    public function test_validacao_formulario()
    {
        $this->browse(function (Browser $browser) {
            // Login
            $browser->visit('/login')
                    ->type('email', $this->user->email)
                    ->type('password', 'password')
                    ->press('Entrar')
                    ->assertPathIs('/dashboard');

            // Try to create with invalid data
            $browser->visit('/turmas/create')
                    ->press('Criar Turma')
                    ->assertPathIs('/turmas/create')
                    ->assertSee('O campo curso id é obrigatório')
                    ->assertSee('O campo centro id é obrigatório');
        });
    }
}