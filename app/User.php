<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;


use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table='usuario';
    protected $primaryKey = 'idUsuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUsuario', 'nombreUsuario', 'mailUsuario', 'claveUsuario', 'auth_key','idRol','eliminado','email_verified_at','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'claveUsuario', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
/*
    public function rol()
    {
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }
*/

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public static function checkToken($token){
        if($token){
            return true;
        }
        return false;
    }
   

    public function Persona()
    {
        return $this->belongsTo('App\Persona', 'idUsuario', 'idUsuario');
    }

    public function getAuthPassword()
    {
        return $this->claveUsuario;
    }

    public function Rol() {
        return $this->hasOne('App\Rol', 'idRol', 'idRol');
    }

        public function rolesAutorizados($roles)
    {
        if ($this->tieneAlgunRol($roles)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }
    public function tieneAlgunRol($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->tieneRol($role)) {
                    return true;
                }
            }
        } else {
            if ($this->tieneRol($roles)) {
                return true;
            }
        }
        return false;
    }
    public function tieneRol($role)
    {
        if ($this->Rol()->where('idRol', $role)->first()) {
            return true;
        }
        return false;
    }

}
