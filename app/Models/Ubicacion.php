<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $fillable = [
        'ciudad',
        'user_id',
        'latitud',
        'longitud',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'latitud',
        'longitud',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
