<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoubleAuthCodeMail extends Mailable
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

    public function __construct(string $complement_subject,
                                string $contentHTML)
    {
        $this->complement_subject = $complement_subject;;
        $this->contentHTML = $contentHTML;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->complement_subject;
        return $this->subject($subject)
                    ->markdown('emails.code', [
                        'complement_subject' => $this->complement_subject,
                        'content' => $this->contentHTML,
                    ]);
    }
}
