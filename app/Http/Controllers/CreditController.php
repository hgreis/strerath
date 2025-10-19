<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mission;
use App\Driver;
use App\Customer;
use App\Bill;
use App\Company;
use App\Credit;
use PDF;

class CreditController extends Controller
{
    public function saveCredit(Request $request)	{
    	$summe = 0;
    	$driver = Driver::where('name', $request->submit)->first();
        $driver->company = Company::find($request->company);
    	$driver->missions = Mission::where('fahrer', $driver->name)
    				->where('company', $request->company)
    				->where('credit', null)
    				->get();
    	
    	$credit = new Credit;
    	$credit->date = now();
        $credit->driver = $driver->id;
    	$credit->company = $request->company;
    	$credit->number = $credit->getNumber();
        $credit->taxes = $request->taxes;
    	$credit->save();
    	foreach ($driver->missions as $mission) {
    		if(isset($request[$mission->id])) {
    			Mission::find($mission->id)->update(['credit' => $credit->number]);
    			$summe = $summe + $mission->preisFahrer;
    		}
    	}
    	$credit->priceNet = $summe;
        if ($credit->taxes != 19) {
            $credit->priceGross = $summe;
        } else {
            $credit->priceGross = $summe * 1.19;    
        }
    	$credit->save();
        $credit->savePDF();

        
        return redirect('/credits/'.$request->company);
    }

    public function listForCredits($company) {
        if($company == 1) {
            $drivers = Driver::whereHas('missions', function($query) {
                    $query->whereNull('credit')
                        ->where('company', 1);
                })->with(['missions' => function($query) {
                    $query->whereNull('credit')
                        ->where('company', 1)
                        ->orderBy('zielDatum');
                }])->orderBy('name')->get();
        }
        if($company == 2) {
            return 'Für Sabine Heinrichs Transporte sind keine Gutschriften vorgesehen.';
        }
        return view('pages.creditsGenerate', compact('company', 'drivers'));
    }

 
 
    public function listCredits($company)   {
        $credits = Credit::where('company', $company)->get()->sortByDesc('number');
        $credits->company = $company;
        foreach ($credits as $credit) {
            $credit->driver = Driver::find($credit->driver);
        }
        return view('pages.listCredits', compact('credits'));
    }

 

    public function payCredits($company) {
        $credits = Credit::where('company', $company)
            ->where('credit_paid', null)
            ->get();
        $credits->company = $company;
        foreach ($credits as $credit) {
            $credit->driver = Driver::find($credit->driver);
        }
        return view('pages.payCredits', compact('credits'));
    }

    public function payCredit($id)  {
        $credit = Credit::find($id);
        $credit->credit_paid = now();
        $credit->save();
        return redirect('/payCredits/'.$credit->company);
    }


    public function edit($id) {
        $credit = Credit::find($id);
        $credit->fahrer = Driver::find($credit->driver);
        $credit->missions = Mission::where('credit', $credit->number)->get();
        $missions = Mission::where('fahrer', $credit->fahrer->name)
                            ->where('company', 1)
                            ->whereNull('credit')
                            ->get();
        return view('pages.credit.edit', compact('credit', 'missions'));
    }


    public function deleteMission($id, $mission) {
        Mission::find($mission)->update(['credit' => null]);
        return redirect('credit/'.$id.'/edit');
    }

    public function addMission($id, $mission) {
        $credit = Credit::find($id);
        Mission::find($mission)->update(['credit' => $credit->number]);
        return redirect('credit/'.$id.'/edit');    
    }

    public function printPDF($id, $taxes) {
        $credit = Credit::find($id);
        $credit->taxes = $taxes;
        $credit->save();
        $missions = Mission::where('credit', $credit->number)->get();
        $credit->priceNet = $missions->sum('preisFahrer');
        if ($credit->taxes != 19) {
            $credit->priceGross = $missions->sum('preisFahrer');
        } else {
            $credit->priceGross = $missions->sum('preisFahrer') * 1.19;    
        }        
        $credit->save();
        $credit->savePDF();
        return redirect('listCredits/1');    
    }
}
