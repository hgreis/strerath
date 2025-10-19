<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
    	'nameCompany', 'nameOwner', 'street', 'city', 'country', 'phone', 'cellphone', 'email', 'url', 'taxNumber', 'venue', 'bank', 'iban', 'bic', 'logo', 'accountNumber'
    ];

    public function missions() {
		return $this->hasMany('App\Mission', 'company');
	}
}
