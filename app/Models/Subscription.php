<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expires_at',
        'status',
    ];

    /**
     * Relación: Una suscripción pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar si la suscripción está activa.
     */
    public function isActive()
    {
        return $this->status === 1 && Carbon::now()->lt(Carbon::parse($this->expires_at));
    }

    /**
     * Marcar la suscripción como cancelada.
     */
    public function cancel()
    {
        $this->update(['status' => 2]);
    }

    /**
     * Marcar la suscripción como suspendida por pago.
     */
    public function suspendForPayment()
    {
        $this->update(['status' => 3]);
    }

    /**
     * Reactivar la suscripción si estaba suspendida por pago.
     */
    public function reactivate()
    {
        if ($this->status === 3) {
            $this->update(['status' => 1]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($subscription) {
            $person = $subscription->user->person;

            if ($person) {
                $person->is_visible = $subscription->status === 1; // Solo visible si la suscripción está abierta
                $person->save();
            }
        });
    }

}
