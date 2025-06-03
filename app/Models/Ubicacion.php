<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $fillable = [
        'latitud',
        'longitud',
        'ciudad',
        'user_id',
    ];
}
