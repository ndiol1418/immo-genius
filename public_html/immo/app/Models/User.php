<?php

namespace App\Models;

use App\Scopes\CompteScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // protected static function boot(){
    //     // parent::boot();
    //     static::addGlobalScope(new CompteScope);
    // }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function scopeActif($q){
        return $q->where('status',1);
    }
    public function scopeSuperviseurs($q){
        return $q->where('profil','superviseur');
    }
    public function compte() {
        return $this->belongsTo(Compte::class);
    }

    public function collaborateur() {
        return $this->hasOne(Collaborateur::class, 'user_id');
    }

    public function fournisseur() {
        return $this->hasOne(Fournisseur::class,'user_id');
    }
    public function fournisseurs() {
        return $this->hasMany(Fournisseur::class,'user_id');
    }
    public function client() {
        return $this->hasOne(Client::class);
    }

    public function role() {
        return $this->hasOne(Role::class, 'user_id')->with(['profil']);
    }

    public function CollaborateurByIgg($user,$igg) {
        if($user->igg == $igg){
            return $user;
        }
        return null;
    }

    public function getProfilNameAttribute() {
        if($this->is_admin) {
            return "Administrateur";
        }
        return $this->role->profil->name ?? "Non défini";
    }

    public function getNomCompletAttribute() {
        if ($this->role && $this->role->profil->name == 'fournisseur') return $this->fournisseur->nom_complet;
        if ($this->role && $this->role->profil->name == 'client') return $this->client->nom_complet;
        return $this->collaborateur->nom_complet;
    }


    public function getRoleNotDefinedAttribute(){
        $roles = $this->roles;
        $profil_ids  = [];
        foreach ($roles as $role) {
            array_push($profil_ids, $role->profil_id);
        }
        $profils = Profil::whereNotIn('id',$profil_ids)->get();
        return $profils;
    }

    static function storeOrUpdate($user_data){
        // dd($user_data);
        $exist = User::where('email',$user_data['email'])->first();
        $user_data['password'] = Hash::make(request('password'));
        if (!$exist) {
            $user = new User($user_data);
            if($user->save($user_data))return $user;
            return false;
        }
        return false;
    }
    public function qrCode(){
        // $google2fa->setWindow(2);
        $secret = $this->google2fa_secret;

        $google2fa = new Google2FA();
        $inlineUrl = $google2fa->getQRCodeUrl(
            'VYTIMO',
            'GesImo',
            $secret
        );

        return QrCode::size(100)->generate($inlineUrl);
    }
    public function createRole($profil_id,$user_id){
        $role = new Role();
        $role->profil_id = $profil_id;
        $role->user_id = $user_id;
        return $role->save();
    }
}
