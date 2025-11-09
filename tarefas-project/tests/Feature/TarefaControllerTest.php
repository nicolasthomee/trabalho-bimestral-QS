<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TarefaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function um_usuario_autenticado_pode_listar_suas_tarefas()
    {
        Tarefa::factory()->count(2)->create(['user_id' => $this->user->id]);
        Tarefa::factory()->count(1)->create(); // Tarefa de outro usuário

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/tarefas');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    /** @test */
    public function um_usuario_autenticado_pode_criar_uma_nova_tarefa()
    {
        $tarefaData = [
            'titulo' => 'Nova Tarefa',
            'descricao' => 'Descrição da nova tarefa',
            'concluida' => false,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/tarefas', $tarefaData);

        $response->assertStatus(201)
            ->assertJsonFragment(['titulo' => 'Nova Tarefa']);

        $this->assertDatabaseHas('tarefas', [
            'user_id' => $this->user->id,
            'titulo' => 'Nova Tarefa',
        ]);
    }
}
