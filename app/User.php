<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'status_id',
        'name', 
        'last_name1',
        'last_name2',
        'email',
        'phone',
        'cp',
        'asentamiento',
        'ciudad',
        'municipio',
        'estado',
        'calle_numero',
        'image',
        'password',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'password',
    ];
    public function estatus()
    {
        return $this->belongsTo
        (
            'App\UserStatus',
            'status_id',
            'id'
            
        )
        ->withDefault();
    }
    public function roles()
    {
        return $this->belongsTo
        (
            'App\UserRol',
            'id',
            'rol_id'
        )
        ->withDefault();
    }

    public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
    }
    
}
