<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use App\Mission;

class Credit extends Model
{
    protected $table = 'credits';
    protected $fillable = [
		'date', 'driver', 'priceNet', 'priceGross', 'credit_paid', 'company', 'number',
	];

	public function credit ()	{
		return $this->hasMany('App\Mission', 'credit', 'number');
	}

	public function getNumber()	{
		return Credit::where('company', $this->company)->max('number')+1;
	}

	public function savePDF()	{
		$missions = Mission::where('credit', $this->number)->get();
		$company = Company::find($this->company);
		$driver = Driver::find($this->driver);

        $html2 ='
                <p style="text-align: center; font-size:6; font-weight:normal">
                    Inhaber: '.$company->nameOwner.' / '.$company->venue.'<br>
                    Steuernummer: '.$company->taxNumber.' /  
                    Umsatzsteuer-ID: '.$company->turnoverTax.'<br>
                    Bank: '.$company->bank.' /
                    IBAN: '.$company->iban.' / 
                    BIC: '.$company->bic.'
                </p>';
        $html300 ='
                    <p>
                        <hr><h3>HINWEIS</h3><br><br>
                         Übergang der Steuerschuldnerschaft nach §3a UStg grenzüberschreitende Beförderung
                        <hr>
                    </p>
        ';
        $html305 ='
                    <p>
                        <hr><h3>HINWEIS</h3><br><br>
                        Steuerfrei nach § 4(3) lit. a (aa/bb) UStG grenzüberschreitende Beförderung
                        <hr>
                    </p>
        ';

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
        PDF::Cell(0,0,$driver->contractor,0,1);
        PDF::Cell(0,0,$driver->street,0,1);
        PDF::Cell(0,0,$driver->city,0,1);
        PDF::Cell(0,0,$driver->land,0,1);
        PDF::Cell(0,0,$driver->steuernr,0,1);
        

        // Logo
        $image_file = 'images/fs logo.jpg';
        PDF::Image($image_file, 140, 50, 50, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);

        // head with invoice-number
        PDF::Ln(20);
        PDF::Cell(0,0,'Mönchengladbach, den '.date("d.m.Y", strtotime($this->date)) ,0,1,'R');
        PDF::Ln(10);
        PDF::SetFont('helvetica','B',15);
        PDF::Cell(0,0,'Gutschrift-Nr.: GS-'.$this->number,0,1);


        // table with missions
        PDF::Ln(10);
        PDF::SetFont('helvetica','B',10);
        PDF::SetFillColor(226,14,14);
        PDF::Cell(15,0,'Tour',1,0,'C',1,'C');
        PDF::Cell(20,0,'Lieferung',1,0,'C',1,'C');
        PDF::Cell(115,0,'Tourenbeschreibung',1,0,'',1,'C');
        PDF::Cell(20,0,'Preis',1,1,'C',1,'C');
        PDF::SetFont('helvetica','',9);
        PDF::Ln(2);
        foreach ($missions as $mission) {
            PDF::Cell(15,0,$mission->id,0,0,'C');
            PDF::Cell(20,0,date("d.m.Y", strtotime($mission->zielDatum)),0,0,'C');
            PDF::Cell(115,0,$mission->startOrt.' nach '.$mission->zielOrt,0,0,'L');
            PDF::Cell(18,0,number_format($mission->preisFahrer, 2, ",", "").' €',0,1,'R');
            PDF::Ln(2);
        };
        PDF::writeHTML('<hr>');

        if ($this->taxes != 19) {
            //summary with no taxes
            PDF::Cell(50,0,'',0,0);
            PDF::Cell(100,0,'Summe (netto)',0,0,'R');
            PDF::Cell(18,0,number_format($this->priceNet, 2, ',', '').' €',0,1,'R');
            PDF::Cell(50,0,'',0,0);
            PDF::Cell(100,0,'Mehrwertsteuerbefreit',0,0,'R');
            PDF::Cell(18,0,number_format(0, 2, ',', '').' €',0,1,'R');
            PDF::SetFont('helvetica','b',10);
            PDF::Cell(50,0,'',0,0);
            PDF::Cell(100,0,'Gutschriftsbetrag (brutto)',0,0,'R');
            PDF::Cell(18,0,number_format(($this->priceGross), 2, ',', '').' €',0,1,'R');
        } else {
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
        }
        


        if($this->taxes == 300) {
            PDF::writeHTML($html300, true, false, true, false, '');
        }elseif($this->taxes == 305) {
            PDF::writeHTML($html305, true, false, true, false, '');
        }



        //duration information
        PDF::writeHTML('
        	<br><br><br>
        	<p style="text-align: center">
        		Der Gutschriftsbetrag wird innerhalb der nächsten 45 Tage überwiesen
        	</p>
        ');

        // payment advice
        PDF::SetY(-32);
        PDF::writeHTML($html2, true, false, true, false, '');


		//save the PDF file 
		PDF::Output(public_path('Gutschriften/'.$company->nameCompany.' GS-' .$this->number . '.pdf'), 'F');
		PDF::reset();

		return;
	}
}
