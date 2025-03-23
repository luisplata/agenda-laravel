<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    #[Test]
    public function it_returns_the_list_of_categories()
    {
        $response = $this->getJson('/api/list_categories');

        $response->assertStatus(200)
            ->assertJson([
                'categories' => [
                    'Dama',
                    'Virtual',
                    'Dama Virtual',
                    'Trans',
                    'Trans Virtual',
                    'Caballero de Compañía',
                    'Caballero Virtual',
                    'Masajista',
                ]
            ]);
    }
}
