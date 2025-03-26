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
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
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

    public function isVisible()
    {
        return $this->user->subscription && $this->user->subscription->isActive();
    }

}
