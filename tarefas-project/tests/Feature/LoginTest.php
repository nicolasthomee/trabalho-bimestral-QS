<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function um_usuario_pode_fazer_login_e_receber_um_token()
    {
        $user = User::factory()->create([
            'email' => 'login@teste.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@teste.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /** @test */
    public function um_usuario_nao_pode_fazer_login_com_credenciais_invalidas()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalido@teste.com',
            'password' => 'senha-errada',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
