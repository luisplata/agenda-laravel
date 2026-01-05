<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckSubscriptionsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = now();

        // Buscar suscripciones activas
        $subscriptions = Subscription::where('status', 1)->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->expires_at < $today) {
                // Marcar como suspendida por pago
                $subscription->update(['status' => 3]);

                // Ocultar la persona ligada a la suscripción
                $person = Person::where('user_id', $subscription->user_id)->first();
                if ($person) {
                    $person->update(['is_visible' => false]);
                }
            }
        }
    }
}
