<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use App\Models\Commune;
use App\Models\Type;
use App\Models\TypeBien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BiensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $espace;
    public function __construct(User $user)
    {
        $this->espace = !$user->fournisseur?'admin':'agent';
    }
    public function index($id=null)
    {
        //
        $biens = Bien::actif()->get();
        $types = Type::actif()->get();
        $type_biens = TypeBien::actif()->get();
        $communes = Commune::actif()->get();
        return view($this->espace.'.biens.index',compact('biens','types','type_biens','communes'));
    }
    public function getData()
    {
        $data = Bien::all();
        return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route($this->espace.'.produits.show',[$row->id]).'" data-id="'.$row->id.'" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
                    // $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-xs">Delete</a>';
                    return $btn;
                })
                ->addColumn('fournisseur', function($item) {
                    return $item->fournisseur->nom;
                })
                ->rawColumns(['action','fournisseur'])
                ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $bien = new Bien();
        $data = $request->validate([
            'name'=>'required|max:255',
            'superficie'=>'max:100',
            'montant'=>'required|max:11',
            'adresse'=>'max:200',
            'commune_id'=>'required|exists:communes,id',
            'type_id'=>'required|exists:types,id',
            'type_bien_id'=>'required|exists:type_biens,id',

        ]);
        // dd($data);
        if ($bien->create($data)) {
            Session::flash('success', __('general.success'));
            return redirect()->route($this->espace.'.immos.create',['bien'=>$bien->id]);
        }
        Session::flash('error', __('general.error'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $bien = Bien::find($id);
        $immos = $bien->immos()->paginate(16)->appends(['sort' => 'id']);
        return view($this->espace.'.biens.show',compact('bien','immos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bien = Bien::find($id);
        $types = Type::actif()->get();
        $type_biens = TypeBien::actif()->get();
        $communes = Commune::actif()->get();
        return view($this->espace.'.biens.edit',compact('bien','types','type_biens','communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $station = Bien::find($id);

        $request->validate([
            'name'=>'required|max:255',
        ]);
        $data = request()->all();
        $station->update($data) ?
            Session::flash('success', __('general.success'))  :
            Session::flash('error', __('general.error'));

        return redirect()->route($this->espace.'.biens.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bien = Bien::find($id);
        $bien->status= 0;
        if($bien->update()) {
            Session::flash('success',__('general.success'));
        } else {
            Session::flash('error', __('general.error'));
        }

        return back();
    }
}
