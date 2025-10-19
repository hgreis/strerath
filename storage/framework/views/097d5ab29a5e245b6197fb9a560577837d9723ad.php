
        $html2 ='
                <p style="text-align: center; font-size:6; font-weight:normal">
                    Zu zahlen ist der Rechnungsbetrag innerhalb von '.$customer->duration.' Tagen auf das Konto:<br>
                    Inhaber: '.$company->nameOwner.' / '.$company->venue.'<br>
                    Steuernummer: '.$company->taxNumber.' /  
                    Umsatzsteuer-ID: '.$company->turnoverTax.'<br>
                    Bank: '.$company->bank.' /
                    IBAN: '.$company->iban.' / 
                    BIC: '.$company->bic.'
                </p>
        ';
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
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf::SetTitle('Rechnung');
        $pdf::SetMargins(20,30,20,20);
        
        if ($company->id == 2)   {
            $pdf::SetHeaderCallback(function($pdf) {
                // Position at 30 mm from bottom
                $pdf->SetY(30);
                // Set font
                $pdf->SetFont('helvetica', 'b', 20);
                $pdf->SetTextColor(200,10,10);
                // Page number
                $pdf->Cell(0, 10,'Sabine Heinrichs Transporte' , 0, false, 'C', 0, '', 0, false, 'T', 'M');
            });    
        } else {
            $pdf::SetHeaderCallback(function($pdf) {
                // Position at 15 mm from bottom
                $pdf->SetY(15);
                // Set font
                $pdf->SetFont('helvetica', 'b', 20);
                $pdf->SetTextColor(200,10,10);
                // Page number
                $pdf->Cell(0, 10,'STRERATH Transporte' , 0, false, 'C', 0, '', 0, false, 'T', 'M');
            });
        }
        $pdf::setFooterCallback(function($pdf) {
                // Position at 15 mm from bottom
                $pdf->SetY(-15);
                // Set font
                $pdf->SetFont('helvetica', '', 8);
                // Page number
                $pdf->Cell(0, 10, 'Seite '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        });
        $pdf::AddPage();

        //adressfield
        $pdf::Ln(20);
        $pdf::SetFont('helvetica','',8);
        $pdf::SetTextColor(200,10,10);
        $pdf::Cell(0, 0, $company->nameCompany.' - '.$company->street.' - '.$company->city, 0, 1, '', 0, '', 0);
        $pdf::SetFont('times','',12);
        $pdf::SetTextColor(0,0,0);
        $pdf::Cell(0,0,$customer->name,0,1);
        $pdf::Cell(0,0,$customer->street,0,1);
        $pdf::Cell(0,0,$customer->city,0,1);
        $pdf::Cell(0,0,$customer->country,0,1);
        $pdf::Cell(0,0,$customer->steuernr,0,1);

        // Logo

        if ($company->id == 2) {
            $image_file = 'images/sh logo.jpg';
            $pdf::Image($image_file, 140, 50, 50, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
        } else {
            $image_file = 'images/fs logo.jpg';
            $pdf::Image($image_file, 140, 50, 50, '', 'JPG', '', 'R', false, 300, '', false, false, 0, false, false, false);
        }

        // head with invoice-number
        $pdf::Ln(20);
        $pdf::Cell(0,0,'Mönchengladbach, den '.$bill->date ,0,1,'R');
        $pdf::Ln(10);
        $pdf::SetFont('helvetica','B',15);
        $pdf::Cell(0,0,'Rechnungs-Nr.: RE-'.$bill->number,0,1);

        // table with missions
        $pdf::Ln(10);
        $pdf::SetFont('helvetica','B',10);
        $pdf::SetFillColor(226,14,14);
        $pdf::Cell(25,0,'Tour-Nr.',1,0,'C',1,'C');
        $pdf::Cell(25,0,'Abholung',1,0,'C',1,'C');
        $pdf::Cell(100,0,'Tourenbeschreibung',1,0,'',1,'C');
        $pdf::Cell(20,0,'Preis',1,1,'C',1,'C');
        $pdf::SetFont('helvetica','',10);
        $pdf::Ln(2);
        foreach ($bill->missions->sortBy('startDatum') as $mission) {
            if (isset($mission->kundeBemerkung)) {
                $pdf::Cell(50,0,'',0,0,'C');
                $pdf::Cell(100,0,$mission->kundeBemerkung,0,1,'L');
            }
            $pdf::Cell(25,0,$mission->id,0,0,'C');
            $pdf::Cell(25,0,date("d.m.Y", strtotime($mission->startDatum)),0,0,'C');
            $pdf::Cell(100,0,'Abholung: '.$mission->startOrt,0,0,'L');
            $pdf::Cell(22,0,number_format($mission->preisKunde, 2, ",", "").' €',0,1,'R');
            $pdf::Cell(50,0,'',0,0,'C');
            $pdf::Cell(100,0,'Auslieferung: '.$mission->zielOrt,0,1,'L');
            $pdf::Ln(5);
        };
        $pdf::writeHTML('<hr>');

        //summary with taxes
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,'Summe (netto)',0,0,'R');
        $pdf::Cell(22,0,number_format($bill->priceNet, 2, ',', '').' €',0,1,'R');
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,$customer->taxes.'% Mehrwertsteuer',0,0,'R');
        $pdf::Cell(22,0,number_format($bill->priceNet*($customer->taxes/100), 2, ',', '').' €',0,1,'R');
        $pdf::SetFont('helvetica','b',10);
        $pdf::Cell(50,0,'',0,0);
        $pdf::Cell(100,0,'Rechnungsbetrag (brutto)',0,0,'R');
        $pdf::Cell(22,0,number_format(($bill->priceNet*(1 + $customer->taxes/100)), 2, ',', '').' €',0,1,'R');
        $bill->priceGross = $bill->priceNet*(1 + $customer->taxes/100);
        $bill->save();

        if($customer->paragraph == 300) {
            $pdf::writeHTML($html300, true, false, true, false, '');
        }elseif($customer->paragraph == 305) {
            $pdf::writeHTML($html305, true, false, true, false, '');
        }

        // payment advice
        $pdf::SetY(-32);
        $pdf::writeHTML($html2, true, false, true, false, '');

        //save the PDF file 
        $pdf::Output(public_path('Rechnungen/'.$company->nameCompany.' RE-' .$bill->number . '.pdf'), 'F');
        $pdf::reset();
<?php /**PATH /var/www/StrerathTransporte/resources/views/magecompPDF.blade.php ENDPATH**/ ?>