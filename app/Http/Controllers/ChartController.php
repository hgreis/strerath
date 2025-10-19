<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mission;
use App\Driver;
use App\Customer;
use App\Bill;
use App\Credit;
use App\Company;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function missions(Request $request) {
    	$datum = $request->startDatum;
        $arr = explode('.', $datum);
        $start = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);

		$datum = $request->endDatum;
        $arr = explode('.', $datum);
        $end = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);

        $companies = Company::all();
        $companies->start = date_format(date_create($start), 'd.m.Y');
        $companies->end = date_format(date_create($end), 'd.m.Y');
		$start->day = $start->day-1;
        foreach ($companies as $company) {
            $company->umsatz = Mission::where('company', $company->id)
                            ->where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisKunde');
            $company->kosten = Mission::where('company', $company->id)
                            ->where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisFahrer');
            $company->gewinn = $company->umsatz - $company->kosten;
        }
        $companies[2] = new Company;
        $companies[2]->nameCompany = 'beide Firmen zusammen';
        $companies[2]->umsatz = Mission::where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisKunde');
        $companies[2]->kosten = Mission::where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisFahrer');
        $companies[2]->gewinn = $companies[2]->umsatz - $companies[2]->kosten;
        $companies[2]->customers = Customer::all();

        return view('pages.chart.missions', compact('companies'));
    }

    public function missionsWithoutDates() {
        $end = Carbon::today();
        $year = $end->year;
        $start = new Carbon('first day of January '.$year);

        $companies = Company::all();
        $companies->start = date_format(date_create($start), 'd.m.Y');
        $companies->end = date_format(date_create($end), 'd.m.Y');
        foreach ($companies as $company) {
            $company->umsatz = Mission::where('company', $company->id)
                            ->where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisKunde');
            $company->kosten = Mission::where('company', $company->id)
                            ->where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisFahrer');
            $company->gewinn = $company->umsatz - $company->kosten;
        }
        $companies[2] = new Company;
        $companies[2]->nameCompany = 'beide Firmen zusammen';
        $companies[2]->umsatz = Mission::where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisKunde');
        $companies[2]->kosten = Mission::where('startDatum', '>=', $start)
                            ->where('startDatum', '<=', $end)
                            ->sum('preisFahrer');
        $companies[2]->gewinn = $companies[2]->umsatz - $companies[2]->kosten;
        $companies[2]->customers = Customer::all();

        return view('pages.chart.missions', compact('companies'));
    }

    public function report($company) {
    	$company = Company::find($company);
    	$bills = Bill::where('company', $company->id)->get();
    	foreach ($bills as $bill) {
			$arr = explode('.', $bill->date);
    		$bill->date  = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
    	} 
    	$year = Carbon::today()->year;
    	$company->year = array(
    		array('month' => 'Januar',
				'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of December'.($year-1)))
										->where('date', '<', new Carbon('first day of February'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of December'.($year-1)))
										->where('date', '<', new Carbon('first day of February'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of December'.($year-1)))
										->where('date', '<', new Carbon('first day of February'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of December'.($year-1)))
										->where('date', '<', new Carbon('first day of February'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of December'.($year-1)))
										->where('credit_paid', '<', new Carbon('first day of February'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of December'.($year-1)))
										->where('bill_paid', '<', new Carbon('first day of February'.$year))
										->sum('preisKunde'),
			),
    		array('month' => 'Februar',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of January'.($year)))
										->where('date', '<', new Carbon('first day of March'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of January'.($year)))
										->where('date', '<', new Carbon('first day of March'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of January'.($year)))
										->where('date', '<', new Carbon('first day of March'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of January'.($year)))
										->where('date', '<', new Carbon('first day of March'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of January'.($year)))
										->where('credit_paid', '<', new Carbon('first day of March'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of January'.($year)))
										->where('bill_paid', '<', new Carbon('first day of March'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'März',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of February'.($year)))
										->where('date', '<', new Carbon('first day of April'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of February'.($year)))
										->where('date', '<', new Carbon('first day of April'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of February'.($year)))
										->where('date', '<', new Carbon('first day of April'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of February'.($year)))
										->where('date', '<', new Carbon('first day of April'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of February'.($year)))
										->where('credit_paid', '<', new Carbon('first day of April'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of February'.($year)))
										->where('bill_paid', '<', new Carbon('first day of April'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'April',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of March'.($year)))
										->where('date', '<', new Carbon('first day of May'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of March'.($year)))
										->where('date', '<', new Carbon('first day of May'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of March'.($year)))
										->where('date', '<', new Carbon('first day of May'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of March'.($year)))
										->where('date', '<', new Carbon('first day of May'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of March'.($year)))
										->where('credit_paid', '<', new Carbon('first day of May'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of March'.($year)))
										->where('bill_paid', '<', new Carbon('first day of May'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'Mai',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of April'.($year)))
										->where('date', '<', new Carbon('first day of June'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of April'.($year)))
										->where('date', '<', new Carbon('first day of June'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of April'.($year)))
										->where('date', '<', new Carbon('first day of June'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of April'.($year)))
										->where('date', '<', new Carbon('first day of June'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of April'.($year)))
										->where('credit_paid', '<', new Carbon('first day of June'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of April'.($year)))
										->where('bill_paid', '<', new Carbon('first day of June'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'Juni',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of May'.($year)))
										->where('date', '<', new Carbon('first day of July'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of May'.($year)))
										->where('date', '<', new Carbon('first day of July'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of May'.($year)))
										->where('date', '<', new Carbon('first day of July'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of May'.($year)))
										->where('date', '<', new Carbon('first day of July'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of May'.($year)))
										->where('credit_paid', '<', new Carbon('first day of July'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of May'.($year)))
										->where('bill_paid', '<', new Carbon('first day of July'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'Juli',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of June'.($year)))
										->where('date', '<', new Carbon('first day of August'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of June'.($year)))
										->where('date', '<', new Carbon('first day of August'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of June'.($year)))
										->where('date', '<', new Carbon('first day of August'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of June'.($year)))
										->where('date', '<', new Carbon('first day of August'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of June'.($year)))
										->where('credit_paid', '<', new Carbon('first day of August'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of June'.($year)))
										->where('bill_paid', '<', new Carbon('first day of August'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'August',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of July'.($year)))
										->where('date', '<', new Carbon('first day of September'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of July'.($year)))
										->where('date', '<', new Carbon('first day of September'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of July'.($year)))
										->where('date', '<', new Carbon('first day of September'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of July'.($year)))
										->where('date', '<', new Carbon('first day of September'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of July'.($year)))
										->where('credit_paid', '<', new Carbon('first day of September'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of July'.($year)))
										->where('bill_paid', '<', new Carbon('first day of September'.$year))
										->sum('preisKunde'),										
    		),
    		array('month' => 'September',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of August'.($year)))
										->where('date', '<', new Carbon('first day of October'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of August'.($year)))
										->where('date', '<', new Carbon('first day of October'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of August'.($year)))
										->where('date', '<', new Carbon('first day of October'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of August'.($year)))
										->where('date', '<', new Carbon('first day of October'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of August'.($year)))
										->where('credit_paid', '<', new Carbon('first day of October'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of August'.($year)))
										->where('bill_paid', '<', new Carbon('first day of October'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'Oktober',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of September'.($year)))
										->where('date', '<', new Carbon('first day of November'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of September'.($year)))
										->where('date', '<', new Carbon('first day of November'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of September'.($year)))
										->where('date', '<', new Carbon('first day of November'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of September'.($year)))
										->where('date', '<', new Carbon('first day of November'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of September'.($year)))
										->where('credit_paid', '<', new Carbon('first day of November'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of September'.($year)))
										->where('bill_paid', '<', new Carbon('first day of November'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'November',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of October'.($year)))
										->where('date', '<', new Carbon('first day of December'.$year))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of October'.($year)))
										->where('date', '<', new Carbon('first day of December'.$year))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of October'.($year)))
										->where('date', '<', new Carbon('first day of December'.$year))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of October'.($year)))
										->where('date', '<', new Carbon('first day of December'.$year))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of October'.($year)))
										->where('credit_paid', '<', new Carbon('first day of December'.$year))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of October'.($year)))
										->where('bill_paid', '<', new Carbon('first day of December'.$year))
										->sum('preisKunde'),
    		),
    		array('month' => 'Dezember',
    			'billsPriceNet' => $bills->where('date', '>', new Carbon('last day of November'.($year)))
										->where('date', '<', new Carbon('first day of January'.($year+1)))
										->sum('priceNet'),
				'billsPriceGross' => $bills->where('date', '>', new Carbon('last day of November'.($year)))
										->where('date', '<', new Carbon('first day of January'.($year+1)))
										->sum('priceGross'),
				'creditsPriceNet' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of November'.($year)))
										->where('date', '<', new Carbon('first day of January'.($year+1)))
										->sum('priceNet'),
				'creditsPriceGross' => Credit::where('company', $company->id)
										->where('date', '>', new Carbon('last day of November'.($year)))
										->where('date', '<', new Carbon('first day of January'.($year+1)))
										->sum('priceGross'),
				'driversPaid' => Mission::where('company', $company->id)
										->whereNull('credit')
										->where('credit_paid', '>', new Carbon('last day of November'.($year)))
										->where('credit_paid', '<', new Carbon('first day of January'.($year+1)))
										->sum('preisFahrer'),
				'missionsPaid' => Mission::where('company', $company->id)
										->whereNull('bill_id')
										->where('bill_paid', '>', new Carbon('last day of December'.($year)))
										->where('bill_paid', '<', new Carbon('first day of February'.($year+1)))
										->sum('preisKunde'),
    		)
    	);

		$company->yearBillNet	 =   array_sum(array_column($company->year, 'billsPriceNet'));
		$company->yearBillGross	 =   array_sum(array_column($company->year, 'billsPriceGross'));
		$company->yearCreditNet	 =   array_sum(array_column($company->year, 'creditsPriceNet'));
		$company->yearCreditGross	 =   array_sum(array_column($company->year, 'creditsPriceGross'));
		$company->yearDriverPaid	 =   array_sum(array_column($company->year, 'driversPaid'));
		$company->yearMissionsPaid	 =   array_sum(array_column($company->year, 'missionsPaid'));

    	return view('pages.chart.bilance', compact('company'));
    }
}
