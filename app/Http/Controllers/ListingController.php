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
use App\Listing;
use PDF;

class ListingController extends Controller
{
    public function listForListings()   {
        $customers = Customer::whereHas('missions', function($query) {
                    $query->whereNull('bill_id')
                        ->whereNull('listing')
                        ->where('company', 1);
                })->with(['missions' => function($query) {
                    $query->whereNull('bill_id')
                        ->whereNull('listing')
                        ->where('company', 1)
                        ->whereNotNull('preisKunde');
                }])->orderBy('name')->get();
        return view('pages.listingsGenerate', compact('customers'));
    }

    public function listingSave(Request $request)   {
        $summe = 0;
        $customer = Customer::where('name', $request->submit)->first();
        $customer->missions = Mission::where('kunde', $customer->name)
                                ->whereNull('bill_id')
                                ->whereNull('listing')
                                ->get();
        $listing = new Listing;
        $listing->company = 1;
        $listing->customer = $customer->id;
        $listing->date = now();
        $listing->save();
        foreach ($customer->missions as $mission) {
            if(isset($request[$mission->id])) {
                $missionToUpdate = Mission::find($mission->id);
                $missionToUpdate->listing = $listing->id;
                $missionToUpdate->save();
                $summe = $summe + $mission->preisKunde;
            }
        }
        $listing->priceNet = $summe;
        $listing->priceGross = $summe * 1.19;
        $listing->save();
        $listing->savePDF();

        return view('pages.menu_invoice');
    }

    public function listListings()  {
        $listings = Listing::all()->sortByDesc('id');
        foreach ($listings as $listing) {
            $listing->customer = Customer::find($listing->customer);
        }
        return view('pages.listingsList', compact('listings'));
    }

    public function edit($id) {
        $list = Listing::find($id);
        $list->kunde = Customer::find($list->customer);
        $list->missions = Mission::where('listing', $id)->get();
        $missions = Mission::where('kunde', $list->kunde->name)
                            ->where('company', 1)
                            ->whereNotNull('preisKunde')
                            ->whereNull('listing')
                            ->get();
        return view('pages.listings.edit', compact('list', 'missions'));
    }

    public function deleteMission($id, $mission) {
        $mission = Mission::find($mission);
        $mission->listing = null;
        $mission->save();
        return redirect('listing/'.$id.'/edit');
    }

    public function addMission($id, $mission) {
        $mission = Mission::find($mission);
        $mission->listing = $id;
        $mission->save();
        return redirect('listing/'.$id.'/edit');    
    }

    public function printPDF($id) {
        $list = Listing::find($id);
        $list->savePDF();
        return redirect('listings');    
    }

}
