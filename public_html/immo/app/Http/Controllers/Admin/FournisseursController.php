<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilitiesController;
use App\Http\Custom\Log;
use App\Models\Commande;
use App\Models\Compte;
use App\Models\Desserte;
use App\Models\Fournisseur;
use App\Models\Taxe;
use App\Models\Zone;
use App\Models\User;
use App\Models\Utils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class FournisseursController extends Controller
{
    public function index(){
        $fournisseurs = Fournisseur::orderBy('nom', 'ASC')->get();
        return view('admin.fournisseurs.index',compact('fournisseurs'));
    }
    public function getData()
    {
        $data = Fournisseur::all();
        return DataTables::of($data)

                ->addColumn('royalties', function($item) {
                    return $item->royalties()['commandes'];
                })
                ->addColumn('ca', function($item) {
                    return $item->getCaCurrentMonth();
                })
                ->addColumn('ca_royalties', function($item) {
                    return $item->ca_royalties();
                })
                ->rawColumns(['royalties','ca','ca_royalties'])
                ->make(true);
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed',//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
        ]);
        $data = $request->all();
        $email = $data['email'];
        $pwd = $data['password'];
        unset($data['email']);
        unset($data['password']);
        $user = new User();
        $user->password = Hash::make($pwd);
        $user->email = $email;
        $profil_id = 2;
        if ($user->save()) {
            $data['user_id']=$user->id;
            if (Auth::user()->fournisseur) {
                # code...
                $data['ouwner_id']= Auth::user()->fournisseur->id;
                if(count($data['images']) > 0) Utils::savePJ($data['images'],'App\Models\User','profils',$user->id);

            }
            $user->createRole($profil_id,$user->id);
            Fournisseur::create($data);
            Session::flash('success', "L'opération a été effectuée.");
            return redirect()->back();
        }
        Session::flash('error', "L'opération a échoué.");
        return redirect()->back();
    }

    public function formatDataUser($fournisseur){
        return [
            'username'=>'fournisseur'.$fournisseur->id,
            'password'=>Hash::make(request('Passer123#')),
            'profil'=>'fournisseur',
            'Nom'=>request('contact'),
            'email'=>explode(",", request('email'))[0],
            'telephone'=>request('telephone'),
            'compte_id'=>request('compte_id'),
            'statut'=>1

        ];
    }

    public function validateForm($request){
        $user = Auth::user();
        return $request->validate([
            'nom'=>'required|max:255',
            'prenom'=>'required|max:255',
            'telephone'=>'',
            'adresse'=>'',
            'description'=>'',
            'bio'=>'',
            'site'=>'',
            'experience'=>'',
            'zones'=>'',
            'images'=>'',
            // 'email' => 'required|unique:users,email,' . $user->id . '|max:255',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $fournisseur = Fournisseur::find($id);
        return view('admin.fournisseurs.show',compact('fournisseur'));
    }

    public function create(){
        $fournisseur = new Fournisseur();
        return view('admin.fournisseurs.create', compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $fournisseur = Fournisseur::find($id);

        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fournisseur = Fournisseur::find($id);
        $user = Auth::user();
        $validate = $this->validateForm($request);
        // dd($validate);
        $fournisseur->update($validate);
        // dd($fournisseur);
        if(request('password')!== null){
            $request->validate([
                'email' => 'required|unique:users,email,' . $user->id . '|max:255',
            ]);
            $email = request('email');
            $pwd = request('password');
            request()->validate([
                'password' => 'required|confirmed'//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
            ]);

            $user = User::where('email',$email)->first();
            if($user && $fournisseur->user_id == $user->id){
                $user->password = Hash::make($pwd);
            }
        }
        // dd($data_user);

        // if($user->update($data_user)){}
        if(request()->has('images') && count($validate['images']) > 0) Utils::savePJ($validate['images'],'App\Models\User','profils',$user->id);


        Log::ACTION_GENEGAL("Mise à jour fournisseur", "L'administrateur " . $user->nom_complet . " a modifié le fournisseur : $fournisseur->name.");
        Session::flash('success', __('fournisseur.update_fam'));
        return redirect()->back();
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */

    public function destroy($id){
        $fournisseur = Fournisseur::where('id',$id)->get()->first();
        if($fournisseur){
            $fournisseur->etat = $fournisseur->etat == 1 ? 0 : 1;
            $fournisseur->save();
            Session::flash('success', __('fournisseur.success_delete'));
            Log::ACTION_GENEGAL("delete", Auth::user()->nom_complet );
            return back();
        }
        Session::flash('error', __('fournisseur.error_delete'));
		return back();
    }

    public function importCsv(Request $request) {
        if ($request->hasFile('file') && request()->file('file')->isValid()) {
            $file_name =  $_FILES['file']['tmp_name'];
            $data_csv = UtilitiesController::read_csv($file_name);
            $result = Fournisseur::insert_data_csv($data_csv);
            if($result){
                Session::flash('success', $result[1].' fournisseur(s) importés.');
                Session::flash('error', $result[0].' erreurs d\'importation.');
            }else Session::flash('error',"erreurs d\'importation. Veuillez revoir le fichier importé");
        }
        return back();
    }

}
