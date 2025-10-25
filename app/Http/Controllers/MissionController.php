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
use PDF;

    
class MissionController extends Controller
{
    // old view with all mission details
    public function viewMissions(Request $request) {
    	$missions = Mission::whereNotNull('id')
            ->orderBy('zielDatum', 'desc')
            ->get();    
            foreach ($missions as $mission) {
                if($mission->bill_id != null)    {
                    $bill = Bill::find($mission->bill_id);
                    $mission->bill_number = $bill->number ?? "nix Rechnung";
                    $mission->bill_price = $bill->priceGross ?? 0;
                }
                if($mission->driver == null) {
                    $mission->driver = new Driver;
                    $mission->driver->name = 'KEIN FAHRER ZUGEWIESEN';
                }
                if($mission->customer == null) {
                    $mission->customer = new Customer;
                    $mission->customer->name = 'KEIN AUFTRAGGEBER ZUGEWIESEN';
                }
            }

            
        $drivers =  Mission::whereNotNull('id')
            ->select('fahrer')
            ->orderBy('fahrer')
            ->distinct()
            ->get();
        $contractors = Driver::whereNotNull('id')
            ->select('contractor')
            ->orderBy('contractor')
            ->distinct()
            ->get();
        $customers =  Mission::whereNotNull('id')
            ->select('kunde')
            ->orderBy('kunde')
            ->distinct()
            ->get();
        $dates = Mission::whereNotNull('id')
            ->select('zielDatum')
            ->orderBy('zielDatum')
            ->distinct()
            ->get();
        if ($request->customer != null) {
            $missions = $missions->where('kunde', $request->customer);
        }
        if ($request->driver != null) {
            $missions = $missions->where('fahrer', $request->driver);
        }
        if ($request->contractor != null) {
            return 'Der Filter "Unternehmer" muss noch programmiert werden';
        }
        return view('pages.view', compact('missions', 'drivers', 'contractors', 'customers'));
    }

    

    public function saveBill(Request $request) {        
        for ($i = 1; $i <= 2; $i++) {
            $customers = Customer::whereHas('missions')
                ->with('missions')
                ->orderBy('name')
                ->get();
            foreach ($customers as $customer) {
                $bill = new Bill;
                $makeBill = 0;
                $sum = 0;
                foreach ($customer->missions as $mission) {
                    if(isset($request[$mission->id])) {
                        if($mission->company == $i) {
                            ++$makeBill;
                        }
                    }
                }
                if ($makeBill > 0) {
                    $bill->date = date("d.m.Y");
                    $bill->save();
                    foreach ($customer->missions as $mission) {
                        if(isset($request[$mission->id])) {
                            if($mission->company == $i) {
                                $mission->bill_id = $bill->id;
                                $mission->save();
                                $sum = $sum + $mission->preisKunde;
                                $bill->company = $mission->company;
                            }
                        }
                    }
                    $bill->customer = $customer->name;
                    $bill->priceNet = $sum;
                    $bill->priceGross = $sum * (100+$customer->taxes)/100;
                    $bill->taxes = $request->taxes;
                    $bill->number = $bill->number();
                    $id = $bill->id;
                    $bill->save();  
                    $bill->savePDF();
                }
            }
        }
        return redirect('/menu_invoice');
    }

    public function showBill($id) {
        $bill = Bill::find($id);
        if ($bill->company == 2)    {
            return response()->file(public_path('Rechnungen/Sabine Heinrichs Transporte RE-'.$bill->number.'.pdf'));
        }

        return response()->file(public_path('Rechnungen/Strerath Transporte RE-'.$bill->number.'.pdf'));
    }



    public function listInvoices($id) {
        $bills = Bill::where('company', $id)
                    ->orderBy('id', 'desc')
                    ->limit(1000)
                    ->get();
        return view('pages.invoices', compact('bills', 'id'));
    }


    public function paidInvoices($id)   {
        $bills = Bill::where('company', $id)
                    ->where('paid', null)
                    ->orderBy('id')
                    ->get();
        return view('pages.invoicesPaid', compact('bills', 'id'));
    }

    public function mission_new() {
        $input = new Mission;
        $input->company = 1;
        $choice = 'Touren-Start';
        return view('pages.mission', compact('input', 'choice'));
    }

    public function mission_newDate($date) {
        $input = new Mission;
        $input->company = 1;
        $input->startDatum = date_format(date_create($date), 'd.m.Y');
        $input->zielDatum = date_format(date_create($date), 'd.m.Y');
        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');
        return view('pages.missionNew', compact('input', 'drivers', 'customers'));
    }

    public function viewMission($id) {
        if ( isset(Submission::where('sub', $id)->first()->original)) {
            $id = Submission::where('sub', $id)->first()->original;
        }
        $input = Mission::find($id);
        $choice = 'Touren-Start';
        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');
        return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));

    }

    public function viewMissionDriver($id) {
        if ( isset(Submission::where('sub', $id)->first()->original)) {
            $id = Submission::where('sub', $id)->first()->original;
            return redirect('mission/'.$id.'/edit');    
        }
        $choice = 'Fahrer/Unternehmer';
        $input = Mission::find($id);
        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');
        return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));
    }

    public function viewMissionCustomer($id) {
        if ( isset(Submission::where('sub', $id)->first()->original)) {
            $id = Submission::where('sub', $id)->first()->original;
            return redirect('mission/'.$id.'/edit');    
        }
        $input = Mission::find($id);
        $choice = 'Kunde';
        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');
        return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));
    }

    public function edit($id) {
        $input = Mission::find($id);
        $input->submissions = Submission::where('original', $input->id)->get();
            foreach ($input->submissions as $sub) {
                $sub->mission = Mission::find($sub->sub);
            }
        $choice = 'Tour aufteilen';
        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');
        return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));
    }

    public function mission_submit(Request $request) {

        if (isset($request->id)) {
            $input = Mission::find($request->id);
        }
        else {
            $input = new Mission;
        }
        if (isset($request->delete))    {
            $input->submissions = Submission::where('original', $input->id)->get();
            foreach ($input->submissions as $sub) {
                $sub->mission = Mission::find($sub->sub)->delete();
                $sub->delete();
            }
            $input->delete();
            return view('pages.menu');
        }

        $input->fill($request->all());

        if (isset($request->startDatum)) {
            $datum = $request->startDatum;
            $arr = explode('.', $datum);
            $input->startDatum = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
        }
        if (isset($request->zielDatum)) {
            $datum = $request->zielDatum;
            $arr = explode('.', $datum);
            $input->zielDatum = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
        }

        $input->save();

        //file upload: order confirmation
        if (isset($request->missionConfirmation)) {
            $file = $request->file('missionConfirmation');
            $destinationPath = 'uploads';
            $file->move($destinationPath, $input->id.' Auftragsbestaetigung.'.$file->getClientOriginalExtension() );    
            $input->missionConfirmation=true;
            $input->save();
        }

        //file upload: delivery note
        if (isset($request->deliveryNote)) {
            $file = $request->file('deliveryNote');
            $destinationPath = 'uploads';
            $file->move($destinationPath, $input->id.' Lieferschein.'.$file->getClientOriginalExtension() );
            $input->deliveryNote=true;
            $input->save();
        }        

        $choice = $request->submit;
        if ($choice == 'Speichern/Menu') {            
            return redirect('/mission/calendar/'.$input->id);
        }

        $input = Mission::find($input->id);


        $customers = Customer::all()->sortBy('name');
        $drivers = Driver::all()->sortBy('name');

        if ($choice == 'Tour aufteilen') { 
            $input->submissions = Submission::where('original', $input->id)->get();
            foreach ($input->submissions as $sub) {
                $sub->mission = Mission::find($sub->sub);
            }
            if ($input->submissions->count() == 0) {
                if (isset($request->parts)) {
                    for ($i=1; $i < $request->parts+1; $i++) { 
                        $mission = new Mission;
                        $mission->startDatum = $input->startDatum;
                        $mission->zielDatum = $input->zielDatum;
                        $mission->kunde = $input->kunde;
                        $mission->company = $input->company;
                        $mission->deliveryNote = $input->deliveryNote;
                        $mission->kundeBemerkung = 'Originalauftrag: '.$input->id;
                        if ($i == 1) {
                            $mission->startOrt = $input->startOrt;
                        }
                        if ($i == $request->parts) {
                            $mission->zielOrt = $input->zielOrt;
                        }
                        $mission->save();

                        $submission = new Submission;
                        $submission->original = $input->id;
                        $submission->sub = $mission->id;
                        $submission->part = $i;
                        $submission->save();
                    }
                    Mission::find($input->id)->update(['fahrer' => null, 'preisFahrer' => null]);

                    return redirect('mission/'.$input->id.'/edit'); 
                }
                $input->startDatum = date_format(date_create($input->startDatum), 'd.m.Y');
                if($input->zielDatum == null){
                    $input->zielDatum =date_format(date_create($input->startDatum), 'd.m.Y');
                } else {
                    $input->zielDatum =date_format(date_create($input->zielDatum), 'd.m.Y');
                }
                return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));
            }
        }

        if ($choice == 'Aktualisieren') {
            $sub_1 = Mission::find($request->sub1);
            $sub_1->zielOrt = $request->zielOrt1;
            $sub_1->fahrer = $request->fahrer1;
            $sub_1->preisFahrer = $request->preisFahrer1;
            $sub_1->startDatum = $input->startDatum;
            $sub_1->zielDatum = $input->zielDatum;
            $sub_1->kunde = $input->kunde;
            $sub_1->company = $input->company;
            $sub_1->deliveryNote = $input->deliveryNote;
            $sub_1->startOrt = $input->startOrt;
            $sub_1->save();

            $sub_2 = Mission::find($request->sub2);
            $sub_2->zielOrt = $request->zielOrt2;
            $sub_2->fahrer = $request->fahrer2;
            $sub_2->preisFahrer = $request->preisFahrer2;
            $sub_2->startOrt = $sub_1->zielOrt;
            $sub_2->startDatum = $input->startDatum;
            $sub_2->zielDatum = $input->zielDatum;
            $sub_2->kunde = $input->kunde;
            $sub_2->deliveryNote = $input->deliveryNote;
            $sub_2->company = $input->company;
            $sub_2->save();

            if (isset($request->sub3)) {
                $sub_3 = Mission::find($request->sub3);
                $sub_3->zielOrt = $request->zielOrt3;
                $sub_3->fahrer = $request->fahrer3;
                $sub_3->preisFahrer = $request->preisFahrer3;
                $sub_3->startOrt = $sub_2->zielOrt;
                $sub_3->startDatum = $input->startDatum;
                $sub_3->zielDatum = $input->zielDatum;
                $sub_3->kunde = $input->kunde;
                $sub_3->deliveryNote = $input->deliveryNote;
                $sub_3->company = $input->company;
                $sub_3->save();
            }

            if (isset($request->sub4)) {
                $sub_4 = Mission::find($request->sub4);
                $sub_4->zielOrt = $request->zielOrt4;
                $sub_4->fahrer = $request->fahrer4;
                $sub_4->preisFahrer = $request->preisFahrer4;
                $sub_4->startOrt = $sub_3->zielOrt;
                $sub_4->startDatum = $input->startDatum;
                $sub_4->zielDatum = $input->zielDatum;
                $sub_4->kunde = $input->kunde;
                $sub_4->deliveryNote = $input->deliveryNote;
                $sub_4->company = $input->company;
                $sub_4->save();
            }

            if (isset($request->sub5)) {
                $sub_5 = Mission::find($request->sub5);
                $sub_5->zielOrt = $request->zielOrt5;
                $sub_5->fahrer = $request->fahrer5;
                $sub_5->preisFahrer = $request->preisFahrer5;
                $sub_5->startOrt = $sub_5->zielOrt;
                $sub_5->startDatum = $input->startDatum;
                $sub_5->zielDatum = $input->zielDatum;
                $sub_5->kunde = $input->kunde;
                $sub_5->deliveryNote = $input->deliveryNote;
                $sub_5->company = $input->company;
                $sub_5->save();
            }
            return redirect('mission/'.$input->id.'/edit'); 

            $choice = 'Kunde';
        }

        $input->startDatum = date_format(date_create($input->startDatum), 'd.m.Y');
        if($input->zielDatum == null){
            $input->zielDatum =date_format(date_create($input->startDatum), 'd.m.Y');
        } else {
            $input->zielDatum =date_format(date_create($input->zielDatum), 'd.m.Y');
        }


        return view('pages.mission', compact('input', 'choice', 'customers', 'drivers'));
    }
    

    public function viewNoDriver(Request $request)  {
        $missions = Mission::where('bill_id', null)
            ->where('fahrer', null)
            ->orderBy('zielDatum')
            ->get();
        foreach ($missions as $mission) {
            $mission->parts = Submission::where('original', $mission->id)->count();
        } 

        $missions =  $missions->where('parts', 0);
        $drivers =  Mission::where('bill_id', null)
            ->select('fahrer')
            ->orderBy('fahrer')
            ->distinct()
            ->get();
        $contractors = Driver::whereNotNull('id')
            ->select('contractor')
            ->orderBy('contractor')
            ->distinct()
            ->get();
        $customers =  Mission::where('bill_id', null)
            ->select('kunde')
            ->orderBy('kunde')
            ->distinct()
            ->get();
        $dates = Mission::where('bill_id', null)
            ->select('zielDatum')
            ->orderBy('zielDatum')
            ->distinct()
            ->get();
        if ($request->customer != null) {
            $missions = $missions->where('kunde', $request->customer);
        }
        if ($request->driver != null) {
            $missions = $missions->where('fahrer', $request->driver);
        }
        return view('pages.view', compact('missions', 'dates', 'drivers', 'contractors', 'customers'));    }

    
        public function viewNoDeliveryNote(Request $request)  {
        $missions = Mission::whereNull('bill_id')
            ->whereNull('deliveryNote')
            ->whereNull('bill_paid')
            ->orderBy('zielDatum')
            ->get();
        $drivers =  Mission::where('bill_id', null)
            ->select('fahrer')
            ->orderBy('fahrer')
            ->distinct()
            ->get();
        $customers =  Mission::where('bill_id', null)
            ->select('kunde')
            ->orderBy('kunde')
            ->distinct()
            ->get();
        if ($request->customer != null) {
            $missions = $missions->where('kunde', $request->customer);
        }
        if ($request->driver != null) {
            $missions = $missions->where('fahrer', $request->driver);
        }

        return view('pages.mission.nodeliverynote', compact('missions', 'drivers', 'customers'));    
    }

    public function overview($id) {
        $mission = Mission::find($id);
        if($mission->bill_id != null)    {
            $mission->bill_number = Bill::find($mission->bill_id)->number;
            $mission->bill_price = Bill::find($mission->bill_id)->priceGross;
        }
        if($mission->driver == null) {
            $mission->driver = new Driver;
            $mission->driver->name = 'KEIN FAHRER ZUGEWIESEN';
        }
        if($mission->customer == null) {
            $mission->customer = new Customer;
            $mission->customer->name = 'KEIN AUFTRAGGEBER ZUGEWIESEN';
        }
        return view('pages.mission_overview', compact('mission'));
    }

    public function unpaidMissions($company) {
        $missions = Mission::where('bill_id', null)
                        ->where('bill_paid', null)
                        ->where('company', $company)
                        ->whereNotNull('preisKunde')
                        ->orderBy('startDatum')
                        ->get()
                        ->sortBy('kunde')
                        ->groupBy('kunde');
        $missions->company = $company;
        return view('pages.missionsPaid', compact('missions'));
    }

    public function payMission($id) {
        $mission = Mission::find($id);
        $mission->bill_paid = now();
        $mission->save();
        $missions = Mission::where('bill_id', null)
                        ->where('bill_paid', null)
                        ->where('company', $mission->company)
                        ->where('kunde', $mission->kunde)
                        ->orderBy('startDatum')
                        ->get()
                        ->sortBy('kunde')
                        ->groupBy('kunde');
        $missions->company = $mission->company;
        if($missions->count() == 0) {
            return view('pages.menu_invoice');
        }
        return view('pages.missionsPaidCustomer', compact('missions'));
    }

    public function payDriverList($company) {
        $missions = Mission::where('company', $company)
                    ->whereNull('credit')
                    ->whereNull('credit_paid')
                    ->whereNotNull('fahrer')
                    ->orderBy('startDatum')
                    ->get()
                    ->sortBy('fahrer')
                    ->groupBy('fahrer');
        $missions->company = $company;
        return view('pages.missionsPayDriver', compact('missions'));
    }

    public function payDriver($id) {
        $mission = Mission::find($id);
        $mission->credit_paid = now();
        $mission->save();
        return redirect('/missionsPayDriver/'.$mission->company);
    }


    public function calendar() {
        $missions = Mission::orderBy('startDatum', 'desc')
                    ->limit(3000)
                    ->get()
                    ->groupBy('startDatum');
        return view('pages.calendar', compact('missions'));
    }


    public function mission_delete($id) {
        $mission = Mission::find($id);
        $mission->delete();
        return redirect(route('calendar'));
    }
}
