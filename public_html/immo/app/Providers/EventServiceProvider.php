<?php

namespace App\Providers;

use App\Events\AnnonceSubmitted;
use App\Events\AnnonceValidated;
use App\Events\MailEvent;
use App\Events\NewComment;
use App\Listeners\MailListener;
use App\Listeners\NotifyAdminAnnonceSubmitted;
use App\Listeners\NotifyAgentAnnonceValidated;
use App\Listeners\NotifyAgentNewComment;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Observers\CommandeObserver;
use App\Observers\FournisseurObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\ActionLog::class => [
            \App\Listeners\SaveLogAction::class,
        ],

        MailEvent::class => [
            MailListener::class,
        ],

        // ── Notifications temps réel ──────────────────────────────────────
        AnnonceSubmitted::class => [
            NotifyAdminAnnonceSubmitted::class,
        ],

        AnnonceValidated::class => [
            NotifyAgentAnnonceValidated::class,
        ],

        NewComment::class => [
            NotifyAgentNewComment::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // parent::boot();
        Commande::observe(CommandeObserver::class);
        Fournisseur::observe(FournisseurObserver::class);
        //
    }
}
