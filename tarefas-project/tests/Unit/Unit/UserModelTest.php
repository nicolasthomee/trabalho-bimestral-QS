<?php

namespace Tests\Unit\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function um_usuario_pode_ter_varias_tarefas()
    {
        $user = User::factory()->create();
        Tarefa::factory()->count(3)->create(["user_id" => $user->id]);

        $this->assertCount(3, $user->tarefas);
        $this->assertInstanceOf(Tarefa::class, $user->tarefas->first());
    }

    /** @test */
    public function um_usuario_pode_ser_criado_com_sucesso()
    {
        $user = User::create([
            "name" => "Novo Usuário",
            "email" => "novo@usuario.com",
            "password" => "senha-segura",
        ]);

        $this->assertDatabaseHas("users", [
            "email" => "novo@usuario.com",
        ]);
    }
}
