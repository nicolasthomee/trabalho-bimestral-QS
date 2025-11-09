<?php

namespace Tests\Unit\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TarefaModelTest2 extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function uma_tarefa_pode_ser_marcada_como_concluida()
    {
        $user = User::factory()->create();
        $tarefa = Tarefa::factory()->create(['user_id' => $user->id, 'concluida' => false]);

        $tarefa->update(['concluida' => true]);

        $this->assertTrue($tarefa->fresh()->concluida);
    }

    /** @test */
    public function uma_tarefa_pode_ser_atualizada()
    {
        $user = User::factory()->create();
        $tarefa = Tarefa::factory()->create(['user_id' => $user->id, 'titulo' => 'Titulo Antigo']);

        $tarefa->update(['titulo' => 'Titulo Novo']);

        $this->assertEquals('Titulo Novo', $tarefa->fresh()->titulo);
    }
}
