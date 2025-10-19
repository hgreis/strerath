<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers';
    protected $fillable=[
    	'name','street','city','country', 'steuernr', 'phone','email','notice', 'taxes', 'duration', 
    ];

    public function missions() {
    	return $this->hasMany('App\Mission', 'kunde', 'name');
    }
}
