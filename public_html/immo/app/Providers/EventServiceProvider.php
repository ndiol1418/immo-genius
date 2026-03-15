<?php

namespace App\Providers;

use App\Events\MailEvent;
use App\Listeners\MailListener;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Immo;
use App\Observers\CommandeObserver;
use App\Observers\FournisseurObserver;
use App\Observers\ImmoObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        // \App\Events\DocumentsEvent::class => [
        //     \App\Listeners\DocumentsListener::class,
        // ],

        // 'Illuminate\Mail\Events\MessageSending' => [
        //     '\App\Listeners\CheckEmailPreferences',
        // ],
        MailEvent::class=>[MailListener::class]
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
