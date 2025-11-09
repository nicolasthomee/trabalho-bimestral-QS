<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProtectedRouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function rota_protegida_retorna_401_se_nao_autenticado()
    {
        $response = $this->getJson('/api/tarefas');

        $response->assertStatus(401);
    }

    /** @test */
    public function rota_protegida_retorna_200_se_autenticado()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/tarefas');

        $response->assertStatus(200);
    }
}
