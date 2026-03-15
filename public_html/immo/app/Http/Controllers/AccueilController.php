<?php

namespace App\Http\Controllers;

use App\Events\AnnonceSubmitted;
use App\Events\MailEvent;
use App\Models\Annonce;
use App\Models\AnnonceFront;
use App\Models\Bien;
use App\Models\Client;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\Fournisseur;
use App\Models\Image;
use App\Models\Immo;
use App\Models\Level;
use App\Models\Piece;
use App\Models\Specialisation;
use App\Models\Type;
use App\Models\AnnonceVue;
use App\Models\Region;
use App\Models\TypeImmo;
use App\Models\TypeLocation;
use App\Models\User;
use App\Scopes\AnnonceScope;
use App\Scopes\ImmoScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AccueilController extends Controller
{
    //
    public $regions = [];
    public $apiKey;
    public function __construct()
    {
        $this->apiKey = "AIzaSyCaSfdQyOwQoWtaDwtL5AMOm3eA492dg9M";
        $json = @file_get_contents(base_path('communes.json')) ?: '[]';
        $this->regions = json_decode($json, true) ?? [];
        // $communes = ["Dakar", "Saint-Louis", "Thiès", "Ziguinchor", "Kaolack"];
        // foreach ($communes as $commune) {
        //     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($commune . ", Sénégal") . "&key=" . $this->apiKey;
        //     $response = file_get_contents($url);
        //     $data = json_decode($response, true);
        //     dd($data);
        //     if ($data['status'] == 'OK') {
        //         $location = $data['results'][0]['geometry']['location'];
        //         echo "Commune : $commune, Latitude : {$location['lat']}, Longitude : {$location['lng']}<br>";
        //     } else {
        //         echo "Coordonnées non trouvées pour : $commune<br>";
        //     }
        // }

    }
    public function accueil(){
        // $faker = Faker::create();
        // $imageDir = public_path('uploads');
        // $imagePath = $faker->image($imageDir, 640, 480, 'cats', false, true, 'Faker');

        // dd($imagePath);
        $types = Type::actif()->get();
        $type_immos = TypeImmo::actif()->get();
        $annonce_news = Annonce::withoutGlobalScope(AnnonceScope::class)->where('is_premium',0)->latest()->take(8)->get();
        $annonce_zones = Annonce::withoutGlobalScope(AnnonceScope::class)->where('is_premium',0)->latest()->take(4)->get();
        $annonce_premium = Annonce::withoutGlobalScope(AnnonceScope::class)->where('is_premium',1)->latest()->take(6)->get();
        
        $agents = Fournisseur::actif()->limit(4)->get();
        $regions = $this->regions;
        $apiKey = $this->apiKey;
        $type_locations = TypeLocation::all();
        // event(new MailEvent('inscription:new', 'abnsndoye@gmail.com'));
        return view('welcome',compact('types','type_immos','annonce_news','agents','annonce_premium','regions','apiKey','annonce_zones','type_locations'));
    }
    public function acheter(){
        $types = Type::actif()->get();
        $type_immos = TypeImmo::actif()->get();
        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo.bien','images'])->where('type_location_id',1)->get();
        if (isset($_GET['type'])) {
            $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo.bien'])->where('type_immo_id',(int)$_GET['type'])->where('type_location_id',1)->get();
        }
        $type_locations = TypeLocation::all();
        $type = 'achat';
        return view('template.pages.locations',compact('types','type_immos','annonces','type_locations','type'));
    }
    public function louer(){
        $types = Type::actif()->get();
        $type_immos = TypeImmo::actif()->get();
        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo.bien','images'])->where('type_location_id',2)->get();
        if (isset($_GET['type'])) {
            $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo.bien'])->where('type_immo_id',(int)$_GET['type'])->where('type_location_id',2)->get();
        }
        // foreach ($a as $key => $value) {
        //     $value->update(['type_immo_id'=>$value->immo->type_immo_id]);
        // }
        // session()->forget('search_type_immo');
        // dd(Session::remove('search_type_immo'));
        $type_locations = TypeLocation::all();
        $type = 'location';

        return view('template.pages.locations',compact('types','type_immos','annonces','type_locations','type'));
    }
    public function faq(){
        return view('template.pages.faq');
    }    
    public function cgu(){
        return view('template.pages.cgu');
    }
    public function agents(){
        $agents = Fournisseur::actif()->limit(4)->get();
        $agents = Fournisseur::withoutGlobalScope(AnnonceScope::class)->actif()->paginate(18)->appends(['sort' => 'id']);
        $specialisations = Specialisation::all();
        $type_locations = TypeLocation::all();
        return view('template.pages.agents',compact('agents','specialisations','type_locations'));
    }
    public function publierAnnonce(Request $request){
        $data = $request->all();
        // $request->validate([
        //     'immo.name'=>'required|max:255',
        //     'immo.montant'=>'required',
        //     'immo.type_immo_id'=>'required|exists:type_immos,id',
        // ]);
        // dd($data['images']);
        if (Auth::user() && 
        Auth::user()->fournisseur) {
            $data['immo']['fournisseur_id']= Auth::user()->fournisseur->id;
        }
        $data['immo']['type_location_id'] = request('type_location_id');
        if (Auth::user() && 
        Auth::user()->fournisseur) {
            $data['fournisseur_id'] = Auth::user()->fournisseur->id;
        }
        $data['immo']['supercie'] = $data['immo']['superficie'];
        $data['immo']['type_immo_id'] = $data['immo']['type_immo_id'];
        $adresse = $data['adresse'];

        unset($data['adresse']);
        $data['immo']['level_id'] = $data['level_id'];
        DB::beginTransaction();
        if($immo = Immo::create($data['immo'])){
            $name = $data['immo']['name'];
            // unset($data['immo']);
            $annonce = new Annonce();
            $annonce->pieces = $data['pieces'];
            $annonce->comodites = $data['comodites']??[];
            $annonce->meubles = $data['meuble'];
            $annonce->description = request('description');
            $annonce->date_disponibilite = $data['date_disponibilite'];
            $annonce->status = 2;
            $annonce->immo_id = $immo->id;
            $annonce->prix = $immo->montant;
            $annonce->name = $immo->name;
            $annonce->adresse = $adresse;
            $annonce->url_video             = request('url_video');
            $annonce->visite_virtuelle      = request('visite_virtuelle');
            $annonce->visite_virtuelle_type = request('visite_virtuelle_type', 'none');
            $annonce->matterport_url        = request('matterport_url');

            // Upload photos 360° (max 10)
            if (request('visite_virtuelle_type') === 'pannellum' && $request->hasFile('visite_360_images')) {
                $urls = [];
                foreach (array_slice($request->file('visite_360_images'), 0, 10) as $file360) {
                    $path = $file360->store('annonces/360', 'public');
                    $urls[] = 'storage/' . $path;
                }
                $annonce->visite_360_images = $urls;
            }

            $annonce->type_immo_id = $immo->type_immo_id;
            // $annonce->commune_id = $immo->bien?$immo->bien->commune_id:null;
            // $annonce->departement_id = $immo->bien&&$immo->commune?$immo->commune->departement_id:null;
            $annonce->slug = Str::slug($name.$immo->id);
            $annonce->superficie = $immo->supercie;
            $annonce->chambres = request('pieces')[1]['Chambres'];
            $annonce->toillettes = request('pieces')[3]['Toillettes'];
            $annonce->cuisines = request('pieces')[4]['Cuisines'];
            $annonce->salons = request('pieces')[2]['Salons'];
            $annonce->lat = request('lat');
            $annonce->lon = request('lon');
            $annonce->type_location_id = $immo->type_location_id;
            $annonce->commune_id = $data['commune_id'];
            $annonce->departement_id = $data['departement_id'];
            $annonce->region = $data['region'] ?? null;
            if (Auth::user() && Auth::user()->fournisseur && Auth::user()->fournisseur->is_premium) {
                $annonce->is_premium = 1;
            }
            try {
                // dd($annonce);

                if($annonce->save()){
                    if(count($data['images']) > 0) $annonce->savePJ($data['images'],'App\Models\Annonce');
                    AnnonceSubmitted::dispatch($annonce);
                }
                DB::commit();
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
                DB::rollBack();
            }
            // dd('ok');
            Session::flash('success', __('general.success'));
            return redirect()->route('annonce',$annonce->slug);

        }

        Session::flash('success', __('general.success'));

        // return redirect()->back();
    }
    public function modifierAnnonce(Request $request, Annonce $annonce)
    {
        $data = $request->all();
        if (Auth::user() && Auth::user()->fournisseur) {
            $data['immo']['fournisseur_id'] = Auth::user()->fournisseur->id;
            $data['fournisseur_id'] = Auth::user()->fournisseur->id;
        }
        $data['immo']['type_location_id'] =  request('type_location_id');
        $data['immo']['supercie'] = $data['immo']['superficie'];
        $data['immo']['type_immo_id'] = $data['immo']['type_immo_id'];
        $adresse = $data['adresse'];
        $data['immo']['level_id'] = $data['level_id'];
        $adresse = $data['adresse'];
        unset($data['adresse']);

        DB::beginTransaction();

        try {
            // Mise à jour de l'immo
            $immo = $annonce->immo;
            $immo->update($data['immo']);

            // Mise à jour de l'annonce
            $annonce->pieces = $data['pieces'];
            $annonce->comodites = $data['comodites'] ?? [];
            $annonce->meubles = $data['meuble'];
            $annonce->description = $data['description'];
            $annonce->date_disponibilite = $data['date_disponibilite'];
            $annonce->status = 2;
            $annonce->prix = $immo->montant;
            $annonce->url_video = request('url_video');
            $annonce->visite_virtuelle = request('visite_virtuelle');
            $annonce->name = $immo->name;
            $annonce->adresse = $adresse;
            $annonce->type_immo_id = $immo->type_immo_id;
            $annonce->slug = Str::slug($immo->name . '-' . $immo->id);
            $annonce->superficie = $immo->supercie;
            $annonce->chambres = $data['pieces'][1]['Chambres'] ?? 0;
            $annonce->toillettes = $data['pieces'][3]['Toillettes'] ?? 0;
            $annonce->cuisines = $data['pieces'][4]['Cuisines'] ?? 0;
            $annonce->salons = $data['pieces'][2]['Salons'] ?? 0;
            $annonce->lat = $data['lat'];
            $annonce->lon = $data['lon'];
            $annonce->type_location_id = $immo->type_location_id;
            $annonce->commune_id = $data['commune_id'];
            $annonce->departement_id = $data['departement_id'];
            $annonce->region = $data['region'] ?? null;
            $annonce->is_premium = 0;

            if (Auth::user()->fournisseur && Auth::user()->fournisseur->is_premium) {
                $annonce->is_premium = 1;
            }

            $annonce->save();

            // Gestion des images : remplacement ou ajout
            if (!empty($data['images'])) {
                $annonce->updatePJ($data['images'], 'App\Models\Annonce');
            }

            DB::commit();
            Session::flash('success', __('general.success'));
            return redirect()->route('annonce', $annonce->slug);

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function inscriptionFormShow(){
        if(Auth::user()){
            $immo = new Immo();
            $pieces = Piece::all();
            $type_locations = TypeLocation::all();
            $levels = Level::all();
            $biens = Bien::all();
            $type_immos = TypeImmo::all();
            $communes = Commune::actif()->get();
            $departements = Departement::actif()->get();
            $regions = Region::with(['departements' => function($q) {
                $q->actif()->with(['communes' => function($q2) { $q2->actif(); }]);
            }])->where('status', 1)->get();
            return view('template.pages.publication',compact('immo','pieces','biens','levels','type_locations','type_immos','communes','departements','regions'));
        } 
        return view('template.pages.inscription');
    }
    public function doPublication(){
        if(Auth::user()){
            return view('template.pages.publication');

        } 
        return view('template.pages.inscription');
    }
    public function inscrire(Request $request){
        $this->validate($request, [
            'inlineRadioOptions' => 'required|in:fournisseur,client,agent',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed',//|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=_!?,;-])(?=.*[A-Z])[0-9a-zA-Z!@#\$%\^\&*\)\(@#$%^&+=_!?,;-]{8,}$/|min:8',
        ]);
        $data = $request->all();
        $email = $data['email'];
        $pwd = $data['password'];
        $type = $data['inlineRadioOptions'];
        if ($type == 'agent') {
           $data['is_agent'] = 1;
        }
        unset($data['email']);
        unset($data['password']);
        unset($data['inlineRadioOptions']);
        $user = new User();
        $user->password = Hash::make($pwd);
        $user->email = $email;
        $profil_id = $type == 'client'?3:2;
        if ($user->save()) {
            $data['user_id']=$user->id;
            $user->createRole($profil_id,$user->id);
            if($profil_id == 3) Client::create($data);
            if($profil_id == 2) Fournisseur::create($data);
            event(new MailEvent('inscription:new', $user->email));

            Session::flash('success', "L'opération a été effectuée.");
            return redirect()->route('login');
        }
        Session::flash('error', "L'opération a échoué.");
        return redirect()->back();
    }

    public function annonce($slug){
        $message = "Découvrez notre nouveau produit !";
        $pageAccessToken = "38d90ab3abf73311d4efaba6ffe0f5c6";
        $pageId = "9814784561947385";


        $annonce = Annonce::withoutGlobalScope(AnnonceScope::class)->where('slug',$slug)->first();
        if (!$annonce) abort(404);

        // Enregistre la vue (1 par IP toutes les 24h)
        $ip = request()->ip();
        $deja = AnnonceVue::where('annonce_id', $annonce->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();
        if (!$deja) {
            AnnonceVue::create([
                'annonce_id' => $annonce->id,
                'ip_address' => $ip,
                'user_agent' => substr(request()->userAgent() ?? '', 0, 255),
                'created_at' => now(),
            ]);
        }

        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo.bien'])->where('type_location_id',$annonce->type_location_id)->inRandomOrder()->limit(4)->get();
        $url = route('annonce', $annonce->slug);
        // $url = 'https://vytimo.softek-group.com/annonces/test-2-annonce22';
        // dd($url);
        return view('template.pages.annonce',compact('annonce','annonces','url','message'));
    }

    public function agentView($id){
        $agent = Fournisseur::find($id);
        $immos = Immo::withoutGlobalScope(ImmoScope::class)->where('fournisseur_id',$agent->id)->pluck('id');
        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)->with(['immo','images'])->whereIn('immo_id',$immos)->get();
        $url = route('agent.show', $agent->id);

        return view('template.pages.agent',compact('agent','annonces','url'));
    }

    function publierSurFacebook($message, $pageAccessToken, $pageId)
    {
        $url = "https://graph.facebook.com/{$pageId}/feed";

        $response = Http::post($url, [
            'message' => $message,
            'access_token' => $pageAccessToken,
        ]);

        if ($response->successful()) {
            return 'Publication réussie !';
        }

        return 'Erreur : ' . $response->body();
    }

    public function destroyImage($id){
        $image = Image::find($id);
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Image supprimée']);

    }
}
