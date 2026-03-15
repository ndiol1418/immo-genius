<?php
namespace App\Mail;

use App\Models\ContratLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContratSigneMail extends Mailable
{
    use Queueable, SerializesModels;
    public $contrat;
    protected $pdfPath;

    public function __construct(ContratLocation $contrat, string $pdfPath)
    {
        $this->contrat = $contrat;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Contrat de location signé — ' . config('app.name'))
            ->view('emails.contrat-signe')
            ->attach($this->pdfPath, [
                'as'   => "contrat-{$this->contrat->id}.pdf",
                'mime' => 'application/pdf',
            ]);
    }
}
