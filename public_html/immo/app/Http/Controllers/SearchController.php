<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Fournisseur;
use App\Models\Specialisation;
use App\Models\Type;
use App\Models\TypeImmo;
use App\Models\TypeLocation;
use App\Scopes\AnnonceScope;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    protected $searchedAnnonces;

    public function __construct()
    {
        $this->searchedAnnonces = Annonce::actif()->get();
    }
    public function search(Request $request) {
        $search = request('search');
        if($search) {
            $budgets = explode ('-',$search['prix']);
          
            $query = Annonce::withoutGlobalScope(AnnonceScope::class);
            if ($search['adresse']) {
                $query->where('adresse','Like', '%'.$search['adresse'].'%');
            }
            if ($search['type']) {
                // $query->orWhere('type_location_id', $search['type']);
            }
            if ($search['prix']) {
                // $query->orWhereIn('adresse', $budgets);
            }
        }
        $annonces = $query->get();

        $types = Type::actif()->get();
        $type_locations = TypeLocation::actif()->get();
        $type_immos = TypeImmo::actif()->get();
        $type = TypeImmo::where('id',$search['type'])->first();
        $search['name'] = $type->name;
        return view("template.pages.locations", compact("annonces",'types','type_immos','search','type_locations'));
    }
    public function resetSearch()
    {
        session()->forget([
            'search_type_locations',
            'search_type_immo',
            'search_chambres',
            'search_toillettes',
            'search_min_size',
            'search_max_size',
            'search_meuble',
            'search_comodites'
        ]);

        return redirect()->back()->with('message', 'Recherche réinitialisée');
    }
    public function searchMore(Request $request)
    {
        
        session([
            'search_type_locations' => $request->input('type_location_id'),
            'search_type_immo' => $request->input('type_immo_id', []),
            'search_chambres' => $request->input('chambres'),
            'search_toillettes' => $request->input('toillettes'),
            'search_min_size' => $request->input('min_size'),
            'search_max_size' => $request->input('max_size'),
            'search_meuble' => $request->input('meuble'),
            'search_comodites' => $request->input('comodites', []),
        ]);
        if (request()->has('init')) {
            self::resetSearch();
        }
        // Appliquer les filtres à la requête
        $query = Annonce::withoutGlobalScope(AnnonceScope::class);
        if ($request->filled('type_location_id')) {
            $query->orWhere('type_location_id', $request->input('type_location_id'));
        }

        if ($request->filled('type_immo_id')) {
            $query->orWhereIn('type_immo_id', $request->input('type_immo_id',[]));
        }

        if ($request->filled('chambres')) {
            $query->orWhere('chambres', $request->input('chambres'));
        }

        if ($request->filled('toillettes')) {
            $query->orWhere('toillettes', $request->input('toillettes'));
        }
        // $rooms = $request->input('rooms', []); // Assurez-vous que 'filters' correspond au nom de l'input dans le formulaire
        // if (!empty($rooms)) {
        //     $query->orWhere(function ($q) use ($rooms) {
        //         foreach ($rooms as $key => $criteria) {
        //             foreach ($criteria as $attribute => $value) {
        //                 // Appliquer whereJsonContains
        //                 $q->orWhereJsonContains('details', [$attribute => $value]);
        //             }
        //         }
        //     });
        // }
        if ($request->filled('min_size')) {
            $query->orWhere('superficie', '>=', $request->input('min_size'));
        }

        if ($request->filled('max_size')) {
            $query->orWhere('superficie', '<=', $request->input('max_size'));
        }

        if ($request->filled('meuble')) {
            $query->orWhere('meubles', $request->input('meuble'));
        }

        if ($request->filled('comodites')) {
            $query->orWhere(function ($q) use ($request) {
                foreach ($request->input('comodites', []) as $comodite) {
                    $q->orWhereJsonContains('comodites', $comodite);
                }
            });
            
        }

        if ($request->filled('visite')) {
            $query->orWhere('visite_virtuelle', $request->input('visite'));
        }

        $annonces = $query->get();
        $types = Type::actif()->get();
        $type_immos = TypeImmo::actif()->get();
        $search = '';
        return view("template.pages.locations", compact("annonces",'types','type_immos','search'));

    }
    static function searchReturn(Annonce $item, $mots) {
        $budgets = explode ('-',$mots['prix']);
        dd($mots);
        // dd(strtolower($item->adresse), strtolower($mots['adresse']));
        $condition = (
            (
                ($item->type_immo_id ==  $mots['type_im']) ||
                (strpos(strtolower($item->adresse), strtolower($mots['adresse']))  !== false) ||
                (strpos(strtolower($item->commune?$item->commune->name:''), strtolower($mots['adresse']))  !== false)) &&
                (in_array($item->prix, $budgets)  !== false)
            // (strpos(strtolower($item->type_document->name ?? ""), $mots)  !== false ) ||
            // (strpos(strtolower($item->collaborateur->nom_complet ?? ""), $mots)  !== false)
            );
        return $condition;
    }

    /**
     * Annonces proches via formule Haversine.
     * POST /annonces/near-me
     * Body: { lat, lon, rayon (km, défaut 10) }
     */
    public function nearMe(Request $request)
    {
        $request->validate([
            'lat'   => ['required', 'numeric', 'between:-90,90'],
            'lon'   => ['required', 'numeric', 'between:-180,180'],
            'rayon' => ['nullable', 'numeric', 'min:1', 'max:100'],
        ]);

        $lat   = (float) $request->lat;
        $lon   = (float) $request->lon;
        $rayon = (float) ($request->rayon ?? 10);

        // Haversine en SQL (R = 6371 km)
        $haversine = "(6371 * ACOS(
            COS(RADIANS({$lat})) * COS(RADIANS(lat)) *
            COS(RADIANS(lon) - RADIANS({$lon})) +
            SIN(RADIANS({$lat})) * SIN(RADIANS(lat))
        ))";

        $annonces = Annonce::withoutGlobalScope(AnnonceScope::class)
            ->with(['immo', 'images', 'commune'])
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->whereRaw("{$haversine} <= ?", [$rayon])
            ->selectRaw("*, {$haversine} AS distance")
            ->orderByRaw($haversine)
            ->limit(50)
            ->get();

        return response()->json([
            'annonces' => $annonces->map(fn($a) => [
                'id'       => $a->id,
                'name'     => $a->name,
                'slug'     => $a->slug,
                'prix'     => $a->prix,
                'lat'      => $a->lat,
                'lon'      => $a->lon,
                'distance' => round($a->distance, 2),
                'image'    => $a->images->first()?->url,
                'commune'  => $a->commune?->name,
                'url'      => route('annonce', $a->slug),
            ]),
            'total' => $annonces->count(),
        ]);
    }

    public function agentSearch(Request $request){
        $query = Fournisseur::withoutGlobalScope(AnnonceScope::class)->actif();
        $specialisations = Specialisation::all();
        if ($request->filled('lieu')) {
            $query->where('adresse', 'LIKE', "%{$request->input('lieu')}%");
        }

        if ($request->filled('agent')) {
            $search = $request->input('agent');
            // dd($search);
            $query->where(function($query) use ($search) {
                $query->where('nom', 'LIKE', "%{$search}%")   
                ->orWhere('prenom', 'LIKE', "%{$search}%");
            });
            
        }
        if ($request->filled('specialisation_id')) {
            $query->orWhereHas('agent_specialisations', function ($query) {
                $query->where('id', request('specialisation_id')); // Exemple : spécialisation "Plomberie"
            });
        }
        $agents = $query->paginate(18)->appends(['sort' => 'id']);
        $specialisations = Specialisation::all();
        return view('template.pages.agents',compact('agents','specialisations'));
    }
}
