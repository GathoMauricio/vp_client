<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinalUser extends Model
{
    protected $table = 'final_users';
	protected $primaryKey = 'id';
	public $timestamps = true;

    protected $fillable = [
        'id',
        'customer_id',
        'name',
        'last_name1',
        'last_name2',
        'email',
        'phone',
        'extension',
        'area_descripcion',
        'cp',
        'asentamiento',
        'ciudad',
        'municipio',
        'estado',
        'calle_numero',
        'image',
        'password'
    ];
    public function customer()
    {
        return $this->belongsTo
        (
            'App\Customer',
            'customer_id',
            'id'
            
        )
        ->withDefault();
    }
}
