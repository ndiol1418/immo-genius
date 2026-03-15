<?php
namespace App\Mail;

use App\Models\ContratLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoyerRetardMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contrat;

    public function __construct(ContratLocation $contrat)
    {
        $this->contrat = $contrat;
    }

    public function build()
    {
        return $this->subject('Loyer en retard — ' . config('app.name'))
            ->view('emails.loyer-retard');
    }
}
