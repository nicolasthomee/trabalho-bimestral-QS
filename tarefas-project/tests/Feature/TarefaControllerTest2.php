<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TarefaControllerTest2 extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function um_usuario_nao_autenticado_nao_pode_acessar_tarefas()
    {
        $response = $this->getJson('/api/tarefas');

        $response->assertStatus(401);
    }

    /** @test */
    public function um_usuario_nao_autenticado_nao_pode_criar_tarefas()
    {
        $tarefaData = [
            'titulo' => 'Tarefa Não Autorizada',
            'descricao' => 'Descrição da tarefa não autorizada',
            'concluida' => false,
        ];

        $response = $this->postJson('/api/tarefas', $tarefaData);

        $response->assertStatus(401);
    }
}
