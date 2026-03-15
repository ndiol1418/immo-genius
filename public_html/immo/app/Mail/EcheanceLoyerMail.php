<?php
namespace App\Mail;

use App\Models\ContratLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EcheanceLoyerMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contrat;

    public function __construct(ContratLocation $contrat)
    {
        $this->contrat = $contrat;
    }

    public function build()
    {
        return $this->subject('Rappel échéance de loyer — ' . config('app.name'))
            ->view('emails.echeance-loyer');
    }
}
