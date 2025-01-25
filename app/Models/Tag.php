<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['valor', 'tipo'];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public static function CreateTag(Person $person, string $valor, string $tipo)
    {
        $person->tags()->create([
            'valor' => $valor,
            'tipo' => $tipo,
        ]);
    }
}
