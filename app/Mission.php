<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'missions';
    protected $fillable = [
    	'startDatum', 'startName', 'startStrasse', 'startOrt', 'startLand', 'startBemerkung', 'zielDatum', 'zielName', 'zielStrasse', 'zielOrt', 'zielLand', 'zielBemerkung', 'preisFahrer', 'preisKunde', 'fahrer', 'company', 'kunde', 'kundeBemerkung', 'bill_id', 'bill_paid', 'credit', 'credit_paid'
    ];

    public function driver() {
    	return $this->belongsTo('App\Driver', 'fahrer', 'name');
    }


    public function customer() {
    	return $this->belongsTo('App\Customer', 'kunde', 'name');
    }

//    public function bill() {
//        return $this->belongsTo('App\Bill', 'bill_id', 'id');
//    }

    public function bill() {
        return $this->hasOne('App\Bill', 'bill_id');
    }

    public function company() {
        return $this->belongsTo('App\Company', 'company', 'id');
    }
}
