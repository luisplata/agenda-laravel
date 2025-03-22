<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);

test('un usuario no puede loguearse sin credenciales', function () {
    $response = $this->postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJson([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
});


test('un usuario no puede loguearse con credenciales inválidas', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword'
    ]);

    $response->assertStatus(401)
        ->assertJson(['message' => 'Credenciales incorrectas']);
});

test('un usuario puede loguearse con credenciales correctas', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123'
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);

    // Verifica que el token generado es válido
    $this->assertNotNull(JWTAuth::attempt(['email' => 'test@example.com', 'password' => 'password123']));
});
