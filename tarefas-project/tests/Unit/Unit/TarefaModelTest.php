<?php

namespace Tests\Unit\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TarefaModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function uma_tarefa_pertence_a_um_usuario()
    {
        $user = User::factory()->create();
        $tarefa = Tarefa::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $tarefa->user);
    }

    /** @test */
    public function uma_tarefa_pode_ser_criada_com_sucesso()
    {
        $user = User::factory()->create();
        $tarefa = Tarefa::create([
            'user_id' => $user->id,
            'titulo' => 'Tarefa de Teste',
            'descricao' => 'Descrição da Tarefa de Teste',
            'concluida' => false,
        ]);

        $this->assertDatabaseHas('tarefas', [
            'titulo' => 'Tarefa de Teste',
            'user_id' => $user->id,
        ]);
    }
}
