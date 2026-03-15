<?php

namespace App\Mail;

use App\Models\Alerte;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AlerteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alerte;
    public $annonces;

    public function __construct(Alerte $alerte, Collection $annonces)
    {
        $this->alerte  = $alerte;
        $this->annonces = $annonces;
    }

    public function build()
    {
        return $this->subject('Nouvelles annonces correspondant à votre alerte — ' . config('app.name'))
                    ->view('emails.alerte');
    }
}
