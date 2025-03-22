<?php

use App\Models\Person;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('retorna 404 si no hay personas registradas', function () {
    $response = $this->getJson('/api/people');

    $response->assertStatus(404)
        ->assertJson(['message' => 'No hay personas registradas']);
});

test('retorna la lista de personas con tags y media', function () {
    $person = Person::factory()->create();
    $person->tags()->create([
        'tipo' => 'tag',
        'valor' => 'tag-value'
    ]);
    $person->media()->create([
        'type' => 'image',
        'file_path' => 'path/to/file'
    ]);

    $response = $this->getJson('/api/people');

    $response->assertStatus(200)
        ->assertJsonStructure([
            '*' => [
                'id',
                'nombre',
                'about',
                'horario',
                'tarifa',
                'whatsapp',
                'telegram',
                'mapa',
                'created_at',
                'updated_at',
                'tags' => [
                    '*' => ['id', 'person_id', 'tipo', 'valor', 'created_at', 'updated_at']
                ],
                'media' => [
                    '*' => ['id', 'type', 'file_path', 'person_id', 'created_at', 'updated_at']
                ]
            ]
        ]);
});

test('retorna 404 si la persona no existe', function () {
    $response = $this->getJson('/api/people/999'); // ID que no existe

    $response->assertStatus(404)
        ->assertJson(['message' => 'Persona no encontrada']);
});

test('retorna una persona con tags y media', function () {
    $person = Person::factory()->create();
    $person->tags()->create([
        'tipo' => 'tag',
        'valor' => 'tag-value'
    ]);
    $person->media()->create([
        'type' => 'image',
        'file_path' => 'path/to/file'
    ]);

    $response = $this->getJson("/api/people/{$person->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'nombre',
            'about',
            'horario',
            'tarifa',
            'whatsapp',
            'telegram',
            'mapa',
            'created_at',
            'updated_at',
            'tags' => [
                '*' => ['id', 'person_id', 'tipo', 'valor', 'created_at', 'updated_at']
            ],
            'media' => [
                '*' => ['id', 'type', 'file_path', 'person_id', 'created_at', 'updated_at']
            ]
        ]);
});

test('retorna 404 si la persona no existe al incrementar vistas', function () {
    $response = $this->getJson('/api/increment/999'); // ID inexistente

    $response->assertStatus(404)
        ->assertJson(['message' => 'Persona no encontrada']);
});

test('incrementa las vistas de una persona sin views', function () {
    $person = Person::factory()->create();

    $response = $this->getJson("/api/increment/{$person->id}");

    $response->assertStatus(200)
        ->assertJson([
            "message" => "Ok",
            "views" => 1
        ]);

    expect(Tag::where('person_id', $person->id)->where('tipo', 'views')->first())
        ->not->toBeNull()
        ->valor->toBe('1');
});

test('incrementa las vistas de una persona con views existente', function () {
    $person = Person::factory()->create();
    Tag::factory()->create([
        'person_id' => $person->id,
        'tipo' => 'views',
        'valor' => '5' // Simulamos que ya tiene 5 vistas
    ]);

    $response = $this->getJson("/api/increment/$person->id");

    $response->assertStatus(200)
        ->assertJson([
            "message" => "Ok",
            "views" => 6
        ]);

    expect(Tag::where('person_id', $person->id)->where('tipo', 'views')->first())
        ->not->toBeNull()
        ->valor->toBe('6');
});
