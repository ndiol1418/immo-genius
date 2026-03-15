<?php

namespace App\Listeners;

use App\Events\MailEvent;
use App\Mail\DoubleAuthCodeMail;
use App\Mail\EmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MailEvent $event)
    {
        $commande = $event->commande;
        $event_name = $event->even_name;
        $attachement = $event->attachement;
        switch ($event_name) {
            case 'commande:gerant':
                $this->commandeOuvert($commande,$attachement);
                break;
            case 'commande:confirme':
                $this->commandeConfirme($commande,$attachement);
                break;
            case 'commande:reception':
                $this->commandeReceptionner($commande,$attachement);
                break;
            case 'auth:2fa':
                $this->sendCode2Fa($event->user,$event->code);
                break;
            case 'inscription:new':
                $this->inscription($event->commande);
                break;

            default:
                # code...
                break;
        }
    }

    protected function inscription($email)
    {
        $complement_subject = "Inscription réussie";

        $contentHTML = "<br>Bienvenue";
        $contentHTML .= "<br>Nous sommes ravis de vous compter parmi nos membres.";
        $contentHTML .= "<br><br>";
        $contentHTML .= "Votre inscription sur <strong>VYTIMO</strong> a bien été prise en compte.";
        $contentHTML .= "<br><br>";
        $contentHTML .= "Vous pouvez dès à présent vous connecter avec vos identifiants.<br><br>";
        // dd($user);
        // if($user){
            // $email = $commande->fournisseur->user->email;
            // $email = 'abnsndoye@gmail.com';
            try {
                //code...
                Mail::to($email)->send(new DoubleAuthCodeMail($complement_subject, $contentHTML));
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        // }
    }
    protected function sendCode2Fa($user,$code)
    {
        $complement_subject = "$code est votre code de double authentification à workspace";

        $contentHTML = "<br>Une demande de connexion à votre compte workspace a été réalisée.";
        $contentHTML .= "<br>Pour finaliser cette connexion, vous devez utiliser le code suivant, qui a une durée de validité de 2 minutes, sur la page de connexion.";
        $contentHTML .= "<br><br>";
        $contentHTML .= "<strong style='text-align:center'>$code</strong>";
        $contentHTML .= "<br><br>";
        $contentHTML .= "Ce code est à usage unique. Ce code est rendu invalide si un mauvais code est renseigné sur l'espace client.<br><br>";
        $contentHTML .= "Si vous n'êtes pas à l'origine de cette tentative de connexion, changez immédiatement votre mot de passe sur votre compte workspace !<br><br>";
        $contentHTML .= "Ne transmettez pas ce mail ou ce code à une personne tierce.<br>
                        Le support technique ne vous demandera jamais ce code.<br>
                        Ce code doit uniquement être utilisé directement sur l'espace de verification pour valider votre connexion.!<br><br>";
        if($user){
            $gerant = $user->Nom;
            // $email = $commande->fournisseur->user->email;
            $email = 'abnsndoye@afridev-group.com';
            try {
                //code...
                // Mail::to($email)->send(new DoubleAuthCodeMail($complement_subject, $contentHTML,$gerant,null,null,true));
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }
    }
    protected function commandeOuvert($commande,$attachement=null)
    {
        $complement_subject = "Demande de confirmation";

        $contentHTML = "<br>Une commande vous a été adressée par la station ".$commande->station->nom.".";
        $contentHTML .= "<br>Vous avez en pièce jointe le bon de commande";
        $contentHTML .= "<br><br>Veuillez cliquer sur le lien ci-dessous pour confirmer cette commande:<br>";
        if($commande){
            $user = $commande->station->user;
            $gerant = $user->Nom;
            // $email = $commande->fournisseur->user->email;
            $email = 'abnsndoye@gmail.com';
            try {
                //code...
                // Mail::to($email)->send(new EmailNotification($complement_subject, $contentHTML,$gerant, $commande,$attachement,true));
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }
    }
    protected function commandeConfirme($commande,$attachement=null)
    {
        $complement_subject = "Demande de confirmation";

        $contentHTML = "<br>La commande Numero ".$commande->ref." a été confirmée";
        $contentHTML .= "<br>Vous avez en pièce jointe le bon de commande";
        if($commande){
            $user = $commande->station->user;
            $gerant = $user->Nom;
            // $email = $commande->fournisseur->user->email;
            $email = 'abnsndoye@gmail.com';
            try {
                //code...
                Mail::to($email)->send(new EmailNotification($complement_subject, $contentHTML,$gerant, $commande,$attachement));
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }
    }
    protected function commandeReceptionner($commande,$attachement=null)
    {
        $complement_subject = "Reception de commande";
        $contentHTML = "<br>La commande Numero ".$commande->ref." a été receptionnée";
        $contentHTML .= "<br>Vous avez en pièce jointe le bon de reception";
        if($commande){
            $user = $commande->station->user;
            $gerant = $user->Nom;
            // $email = $commande->fournisseur->user->email;
            $email = 'abnsndoye@gmail.com';
            try {
                //code...
                Mail::to($email)->send(new EmailNotification($complement_subject, $contentHTML,$gerant, $commande,$attachement,null,'view'));
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }
    }
    protected function envoiEmailBroadcast(string $complement_subject,string $contentHTML,$solde,$reclamation = null,$regularisation = null){
        if(!$solde) {
        $solde = $reclamation->solde ?? null;
        if(!$solde) {
            $solde = $regularisation->reclamation->solde ?? null;
        }
        }

        if($solde) {
            // $user_ids = $this->getUserIdsForNotify($solde);
            // $collaborateurs = Collaborateur::whereIn('user_id', $user_ids)->get();

            // $this->sendEmailToCollaborateurs($collaborateurs,$complement_subject,$contentHTML,$solde,$reclamation,$regularisation);
        }

    }
}
