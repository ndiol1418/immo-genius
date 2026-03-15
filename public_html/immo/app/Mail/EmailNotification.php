<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $complement_subject;
    protected $contentHTML;
    protected $commande;
    protected $gerant;
    protected $attachmentPath;
    protected $is_commande;
    public $view;

    public function __construct(string $complement_subject,
                                string $contentHTML,
                                $gerant,
                                $commande=null,$attachmentPath=null,$is_commande = false,$view = null)
    {
        $this->complement_subject = $complement_subject;;
        $this->contentHTML = $contentHTML;
        $this->commande = $commande;
        $this->gerant = $gerant;
        $this->attachmentPath = $attachmentPath;
        $this->is_commande = $is_commande;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return view('emails.notification');
        $subject = $this->complement_subject;
        if($this->view != null){
            return $this->subject($subject)
            ->markdown('emails.reception', [
                'gerant' => $this->gerant,
                'commande' => $this->commande,
                'user' => $this->commande->station->user?? null,
                'station' => $this->commande->station ?? null,
                // 'secteur' => $this->commande->secteur ?? null,
                'complement_subject' => $this->complement_subject,
                'content' => $this->contentHTML,
                'is_commande'=>$this->is_commande??false
            ])
            ->attach($this->attachmentPath??'');
        }else{

            return $this->subject($subject)
                        ->markdown('emails.notification', [
                            'gerant' => $this->gerant,
                            'commande' => $this->commande,
                            'user' => $this->commande->station->user?? null,
                            'station' => $this->commande->station ?? null,
                            // 'secteur' => $this->commande->secteur ?? null,
                            'complement_subject' => $this->complement_subject,
                            'content' => $this->contentHTML,
                            'is_commande'=>$this->is_commande??false
                        ])
                        ->attach($this->attachmentPath??'');
        }
    }
}
