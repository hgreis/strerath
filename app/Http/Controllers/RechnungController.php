<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Mission;
use App\Submission;
use App\Driver;
use App\Customer;
use App\Bill;
use App\Company;
use App\Rechnung;
use PDF;

class RechnungController extends Controller
{
    public function new($company) {
    	$rechnung = new Rechnung;
    	$rechnung->company($company);
    	
    	$drivers = Driver::all();
    	
    	return view('pages.rechnung.new', compact('rechnung', 'drivers', 'missions'));
    }

    public function submit(Request $request) {
	
    	$rechnung = new Rechnung;
    	$rechnung->company = $request->company;
    	$rechnung->driver_id = Driver::where('name', $request->fahrer)->first()->id;
    	$rechnung->name = $request->name;
    	$rechnung->priceNet = 0;
    	$rechnung->priceGross = 0;
    	$rechnung->date = now();
    	$rechnung->save();

//file upload: doc
        if (isset($request->doc)) {
            $file = $request->file('doc');
            $destinationPath = 'uploads';
            $file->move($destinationPath, 'Unternehmer-Rechnung_'.$rechnung->id.'.'.$file->getClientOriginalExtension() );    
            $rechnung->doc=true;
            $rechnung->save();
        }

    	$rechnung->missions();
    	$rechnung->driver();

    	$missions = Mission::where('fahrer', $rechnung->driver->name)
    				->whereNull('credit')
    				->whereNull('ur')
    				->get();

    	return view('pages.rechnung.edit', compact('rechnung', 'missions'));
    }

    public function addMission($rechnungs_id, $mission_id) {
		$mission = Mission::find($mission_id);
		$mission->ur = $rechnungs_id;
		$mission->save();

		$rechnung = Rechnung::find($rechnungs_id);
		$rechnung->missions();
		$rechnung->driver();

    	$missions = Mission::where('fahrer', $rechnung->driver->name)
    				->whereNull('credit')
    				->whereNull('ur')
    				->get();

    	return view('pages.rechnung.edit', compact('rechnung', 'missions'));
    }

    public function subMission($rechnungs_id, $mission_id) {
		$mission = Mission::find($mission_id);
		$mission->ur = null;
		$mission->save();

		$rechnung = Rechnung::find($rechnungs_id);
		$rechnung->missions();
		$rechnung->driver();

    	$missions = Mission::where('fahrer', $rechnung->driver->name)
    				->whereNull('credit')
    				->whereNull('ur')
    				->get();

    	return view('pages.rechnung.edit', compact('rechnung', 'missions'));
    }

    public function edit($rechnungs_id) {
    	$rechnung = Rechnung::find($rechnungs_id);
		$rechnung->missions();
		$rechnung->driver();

    	$missions = Mission::where('fahrer', $rechnung->driver->name)
    				->whereNull('credit')
    				->whereNull('ur')
    				->get();

    	return view('pages.rechnung.edit', compact('rechnung', 'missions'));
    }

    public function list($company) {
    	$rechnungen = Rechnung::where('company', $company)->get();
    	$rechnungen->company = $company;

    	foreach ($rechnungen as $rechnung) {
    		$rechnung->driver();
    	}

    	return view('pages.rechnung.list', compact('rechnungen'));
    }

    public function payList($company) {
    	$rechnungen = Rechnung::where('company', $company)
    				->whereNull('paid')
    				->get();
    	$rechnungen->company = $company;
    	foreach ($rechnungen as $rechnung) {
    		$rechnung->missions();
    		$rechnung->driver();
    		$rechnung->proof = $rechnung->missions->where('bill_paid', null)->count();
    	}

    	return view('pages.rechnung.pay', compact('rechnungen'));
    }

    public function pay($rechnungs_id) {
    	$rechnung = Rechnung::find($rechnungs_id);
    	$rechnung->paid = now();
    	$rechnung->save();

    	$rechnungen = Rechnung::where('company', $rechnung->company)
    				->whereNull('paid')
    				->get();
    	$rechnungen->company = $rechnung->company;
    	foreach ($rechnungen as $rechnung) {
    		$rechnung->driver();
    	}

    	return view('pages.rechnung.pay', compact('rechnungen'));	
    }

    public function delete($rechnungs_id) {
    	$text = 'Die Unternehmer-Rechnung wurde gelöscht.<br> Alle zugehörigen Aufträge wurden freigegeben.';
    	Mission::where('ur', $rechnungs_id)->update(['ur' => null]);
    	$rechnung = Rechnung::find($rechnungs_id)->delete();

    	return $text;
    }
}
