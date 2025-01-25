<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $fillable = [
        'nombre',
        'about',
        'horario',
        'tarifa',
        'whatsapp',
        'telegram',
        'mapa',
    ];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
