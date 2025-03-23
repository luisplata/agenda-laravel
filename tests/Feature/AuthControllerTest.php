<?php
// tests/Feature/AuthControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    // Test con credenciales válidas
    public function test_login_with_valid_credentials()
    {
        User::where('email', 'test@example.com')->delete();
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    // Test con credenciales incorrectas
    public function test_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Credenciales incorrectas']);
    }

    // Test de validación de campos
    public function test_login_with_validation_errors()
    {
        $response = $this->postJson('/api/login', [
            // No enviar los campos email y password
        ]);

        $response->assertStatus(422);  // Verifica que el código de estado sea 422

        // Verifica que la respuesta JSON contiene los errores para los campos 'email' y 'password'
        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
    }
}
