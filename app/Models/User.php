<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\CustomResetPasswordLink;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function person()
    {
        return $this->hasOne(Person::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->person()->delete();
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordLink($token));
    }

    public function ultimaUbicacion()
    {
        return $this->hasOne(Ubicacion::class)->latestOfMany();
    }

}
