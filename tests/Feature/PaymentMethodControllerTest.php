<?php
// tests/Feature/PaymentMethodControllerTest.php

namespace Tests\Feature;

use Tests\TestCase;

class PaymentMethodControllerTest extends TestCase
{
    /**
     * Test para verificar que la respuesta de la lista de métodos de pago es exitosa.
     *
     * @return void
     */
    public function test_get_payment_methods_list()
    {
        // Realiza una solicitud GET a la ruta 'payment_methods_list'
        $response = $this->getJson('/api/payment_methods_list');

        // Verifica que la respuesta tenga un estado 200 (OK)
        $response->assertStatus(200);

        // Verifica que el contenido JSON de la respuesta sea el esperado
        $response->assertJson([
            [
                'name' => 'paypal',
                'icon' => 'paypal',
            ],
            [
                'name' => 'binance',
                'icon' => 'binance_icon',
            ],
            [
                'name' => 'other_bank',
                'icon' => 'more_icons_to_bank',
            ]
        ]);
    }

    /**
     * Test para verificar que la respuesta tiene una estructura adecuada.
     *
     * @return void
     */
    public function test_payment_methods_structure()
    {
        // Realiza una solicitud GET a la ruta 'payment_methods_list'
        $response = $this->getJson('/api/payment_methods_list');

        // Verifica que la respuesta tenga la estructura esperada
        $response->assertJsonStructure([
            '*' => [
                'name',
                'icon',
            ]
        ]);
    }

    /**
     * Test para verificar que la respuesta sea en formato JSON.
     *
     * @return void
     */
    public function test_payment_methods_response_is_json()
    {
        // Realiza una solicitud GET a la ruta 'payment_methods_list'
        $response = $this->getJson('/api/payment_methods_list');

        // Verifica que el contenido de la respuesta sea de tipo JSON
        $response->assertHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
