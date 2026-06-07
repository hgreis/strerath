<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use App\Mission;
use App\Customer;
class Listing extends Model
{
    protected $table = 'listings';
    protected $fillable = [
    	'company', 'customer', 'date', 'priceNet', 'priceGross', 
    ];

    public function savePDF()	{
		$missions = Mission::where('listing', $this->id)->get();
		$company = Company::find($this->company);
		$customer = Customer::find($this->customer);


		// Use PDF facade statically
        PDF::SetTitle('Gutschrift');
        PDF::SetMargins(20,30,20,20);
        
        if ($company->id == 2)   {
            PDF::SetHeaderCallback(function($pdf) {
                $pdf->SetY(15);
                $pdf->SetFont('helvetica', 'b', 20);
                $pdf->SetTextColor(200,10,10);
                $pdf->Cell(0, 10,'Sabine Heinrichs Transporte' , 0, false, 'C', 0, '', 0, false, 'T', 'M');
            });    
        } else {
            PDF::SetHeaderCallback(function($pdf) {
                $pdf->SetY(15);
                $pdf->SetFont('helvetica', 'b', 20);
                $pdf->SetTextColor(200,10,10);
                $pdf->Cell(0, 10,'STRERATH Transporte' , 0, false, 'C', 0, '', 0, false, 'T', 'M');
            });
        }
        
        PDF::setFooterCallback(function($pdf) {
                $pdf->SetY(-15);
                $pdf->SetFont('helvetica', '', 8);
                $pdf->Cell(0, 10, 'Seite '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        PDF::AddPage();



        //adressfield
        PDF::Ln(20);
        PDF::SetFont('helvetica','',8);
        PDF::SetTextColor(200,10,10);
        PDF::Cell(0, 0, $company->nameCompany.' - '.$company->street.' - '.$company->city, 0, 1, '', 0, '', 0);
        PDF::SetFont('times','',12);
        PDF::SetTextColor(0,0,0);
        PDF::Cell(0,0,$customer->name,0,1);
        PDF::Cell(0,0,$customer->street,0,1);
        PDF::Cell(0,0,$customer->city,0,1);
        

        // Logo
        $image_file = 'images/fs logo.jpg';
        PDF::Image($image_file, 140, 50, 50, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);

        // head with invoice-number
        PDF::Ln(20);
        PDF::Cell(0,0,'Mönchengladbach, den '.date("d.m.Y", strtotime($this->date)) ,0,1,'R');
        PDF::Ln(10);
        PDF::SetFont('helvetica','B',15);
        PDF::Cell(0,0,'Fahrtenauflistung zur Erstellung einer Gutschrift',0,1);


        // table with missions
        PDF::Ln(10);
        PDF::SetFont('helvetica','B',10);
        PDF::SetFillColor(226,14,14);
        PDF::Cell(40,0,'Tour-Nr.',1,0,'C',1,'C');
        PDF::Cell(20,0,'Datum',1,0,'C',1,'C');
        PDF::Cell(90,0,'Tourenbeschreibung',1,0,'',1,'C');
        PDF::Cell(20,0,'Preis',1,1,'C',1,'C');
        PDF::SetFont('helvetica','',9);
        PDF::Ln(2);
        foreach ($missions as $mission) {
            PDF::Cell(40,0,$mission->kundeBemerkung,0,0,'C');
            PDF::Cell(20,0,date("d.m.Y", strtotime($mission->zielDatum)),0,0,'C');
            PDF::Cell(90,0,$mission->startOrt.' nach '.$mission->zielOrt,0,0,'L');
            PDF::Cell(18,0,number_format($mission->preisKunde, 2, ",", "").' €',0,1,'R');
            PDF::Ln(2);
        };
        PDF::writeHTML('<hr>');

        //summary with taxes
        PDF::Cell(50,0,'',0,0);
        PDF::Cell(100,0,'Summe (netto)',0,0,'R');
        PDF::Cell(18,0,number_format($this->priceNet, 2, ',', '').' €',0,1,'R');
        PDF::Cell(50,0,'',0,0);
        PDF::Cell(100,0,'19% Mehrwertsteuer',0,0,'R');
        PDF::Cell(18,0,number_format($this->priceNet*0.19, 2, ',', '').' €',0,1,'R');
        PDF::SetFont('helvetica','b',10);
        PDF::Cell(50,0,'',0,0);
        PDF::Cell(100,0,'Gutschriftsbetrag (brutto)',0,0,'R');
        PDF::Cell(18,0,number_format(($this->priceGross), 2, ',', '').' €',0,1,'R');



		//save the PDF file 
		PDF::Output(public_path('Fahrtenauflistungen/'.$company->nameCompany.' Liste-' .$this->id . '.pdf'), 'F');
		PDF::reset();

		return;
	}
}
