<?php

namespace Tests\Unit\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest2 extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function um_usuario_pode_ser_deletado_e_suas_tarefas_tambem()
    {
        $user = User::factory()->create();
        $tarefa = $user->tarefas()->create(['titulo' => 'Tarefa para deletar']);

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    }

    /** @test */
    public function um_usuario_pode_ter_seu_nome_atualizado()
    {
        $user = User::factory()->create(['name' => 'Nome Antigo']);

        $user->update(['name' => 'Nome Novo']);

        $this->assertEquals('Nome Novo', $user->fresh()->name);
    }
}
