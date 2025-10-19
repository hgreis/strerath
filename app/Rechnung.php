<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rechnung extends Model
{
    protected $table = 'rechnungs';
    protected $fillable = [
    	'id', 'driver_id', 'name', 'priceNet', 'priveGross', 'date', 'paid', 'doc', 'company'
    ];

    public function company($company) {
    	$this->company = Company::find($company);
    }

    public function driver() {
    	$this->driver = Driver::find($this->driver_id);
    }

    public function missions() {
        $this->priceNet = Mission::where('ur', $this->id)->sum('preisFahrer');
        $this->priceGross = $this->priceNet * 1.19;
        $this->save();

        $this->missions = Mission::where('ur', $this->id)->get();
    }
}
