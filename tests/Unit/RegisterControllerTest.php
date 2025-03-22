<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Mockery;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function it_registers_a_new_user()
    {
        // Datos simulados de entrada
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Mockear la validación
        Validator::shouldReceive('make')->andReturnSelf();
        Validator::shouldReceive('fails')->andReturn(false);

        // 🔥 Mockear el modelo User para que no intente conectarse a la BD
        $mockUser = Mockery::mock('overload:' . User::class);
        $mockUser->shouldReceive('create')->andReturn((object) [
            'id' => 1,
            'name' => 'Test User',
            'role' => 'Model',
            'email' => 'test@example.com',
        ]);

        $controller = new RegisterController();
        $response = $controller->register($request);

        $this->assertEquals(201, $response->status());
        $this->assertEquals('User registered successfully', $response->getData(true)['message']);
    }

    #[Test]
    public function it_fails_if_validation_fails()
    {
        $request = new Request([
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        Validator::shouldReceive('make')->andReturnSelf();
        Validator::shouldReceive('fails')->andReturn(true);
        Validator::shouldReceive('errors')->andReturn(['email' => 'Invalid email']);

        $controller = new RegisterController();
        $response = $controller->register($request);

        $this->assertEquals(422, $response->status());
        $this->assertArrayHasKey('errors', $response->getData(true));
    }
}
