<?php
namespace App\Http\View\Composers;

use App\Http\Controllers\Admin\MenusController;
use App\Models\Commande;
use App\Models\Comodite;
use App\Models\Liste;
use App\Models\Profil;
use App\Models\TypeImmo;
use App\Models\TypeLocation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserComposer {
    //required method
    public function compose(View $view) {
        if(Auth::check()) {
            $user = Auth::user();
            $espace = 'admin';
            if($user->is_admin) $sidebar = MenusController::getSuperAdminMenus();
            elseif($user->role->profil->name == 'admin')  {$sidebar = MenusController::getAdminMenus(); $espace='admin';}
            elseif($user->role->profil->name == 'fournisseur' && $user->fournisseur->ouwner_id !=null) {$sidebar = MenusController::getAgentMenus();$espace='agent';}
            elseif($user->role->profil->name == 'fournisseur') {$sidebar = MenusController::getFournisseurMenus();$espace='agent';}
            else{$sidebar = MenusController::getClientMenus();$espace='client';}
            $view->with([
                '_user' => $user,
                '_sidebar' => $sidebar,
                '_users' => User::actif()->get(),
                '_espace'=>$espace,
                '_profils'=>Profil::all(),
                'type_immos'=>TypeImmo::all(),
                'comodites'=>Comodite::all(),
            ]);
        }
        else {

            $view->with([
                'type_locations'=>TypeLocation::all(),
                'type_immos'=>TypeImmo::all(),
                'comodites'=>Comodite::all(),
            ]);
        }
    }

}
