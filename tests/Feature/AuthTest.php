<?php

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

test('auth @me', function () {
    // Crear un usuario
    $user = User::factory()->create();

    // Generar un token para el usuario
    $token = JWTAuth::fromUser($user);

    // Hacer la petición enviando el token en el body
    $response = $this->getJson('/api/me?token='.$token);

    // Verificar que la respuesta sea correcta
    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
        ]);
});

test('auth @logout', function () {
    // Crear un usuario
    $user = User::factory()->create();

    // Generar un token para el usuario
    $token = JWTAuth::fromUser($user);

    // Hacer la petición con el token en los headers
    $response = $this->postJson('/api/logout');

    // Verificar que la respuesta sea correcta
    $response->assertStatus(200)
        ->assertJson(['message' => 'Sesión cerrada']);
});
