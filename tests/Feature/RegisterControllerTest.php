<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    /**
     * Test con datos válidos.
     *
     * @return void
     */
    public function test_register_with_valid_data()
    {
        User::where('email', 'john.doe@example.com')->delete();
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201); // Esperamos un estado 201 para "Creado"
        $response->assertJsonStructure([
            'message', // Mensaje de éxito
            'user' => [ // El usuario está dentro de la clave "user"
                'id', 'name', 'email', 'created_at', 'updated_at', 'role', // Confirmar que la respuesta tiene estos campos
            ],
        ]);
    }



    /**
     * Test de validación de errores.
     *
     * @return void
     */
    public function test_register_with_validation_errors()
    {
        $response = $this->postJson('/api/register', [
            // Falta el campo 'email' y 'password'
        ]);

        $response->assertStatus(422); // Esperamos un estado 422 para "Error de validación"
        $response->assertJsonValidationErrors(['name', 'email', 'password']); // Verifica que 'name', 'email' y 'password' tienen errores de validación
    }

    /**
     * Test con correo ya registrado.
     *
     * @return void
     */
    public function test_register_with_existing_email()
    {
        User::where('email', 'existing@example.com')->delete();
        // Crear un usuario de prueba
        $user = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Jane Doe',
            'email' => 'existing@example.com', // El mismo correo
            'password' => 'password123',
            'password_confirmation' => 'password123', // Confirmación de la contraseña
        ]);

        $response->assertStatus(422); // Debería retornar un error 422
        $response->assertJsonValidationErrors(['email']); // Verifica que 'email' tiene un error
    }

}
