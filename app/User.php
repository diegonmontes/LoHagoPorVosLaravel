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
        'idUsuario', 'nombreUsuario', 'mailUsuario', 'claveUsuario', 'auth_key','idRol','eliminado','remember_token'
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

}
