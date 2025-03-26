<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'about',
        'horario',
        'tarifa',
        'whatsapp',
        'telegram',
        'mapa',
        'user_id',
    ];

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->media()->delete();
            $user->tags()->delete();
        });
    }
}
