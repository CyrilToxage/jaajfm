<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserRegistered
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // Connecter automatiquement l'utilisateur après inscription
        Auth::login($event->user);
    }
}
