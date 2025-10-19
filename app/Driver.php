<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table='drivers';
    protected $fillable=[
    	'name','street','city','land','phone','email', 'steuernr','contractor','car_brand','number_plate',
    ];

    public function missions() {
    	return $this->hasMany('App\Mission', 'fahrer', 'name');
    }
}

