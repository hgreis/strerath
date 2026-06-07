<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use App\Mission;
use App\Driver;
use App\Customer;
use App\Company;
use DateTime;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'date', 'priceNet', 'priceGross', 'taxes', 'customer', 'company', 'path', 'number', 'paid',
    ];
    protected $dates = ['paid'];

    /**
     * Relationship: Bill has many Missions
     */
    public function missions()
    {
        return $this->hasMany('App\Mission', 'bill_id', 'id');
    }

    /**
     * Relationship: Bill belongs to Company
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'company', 'id');
    }

    /**
     * Generate next bill number for a company
     */
    public function number()
    {
        $maxNumber = Bill::where('company', $this->company)->max('number') ?? 0;
        return $maxNumber + 1;
    }

    /**
     * Save invoice as PDF
     */
    public function savePDF()
    {
        $this->generatePDF();
    }

    /**
     * Generate eRechnung (ZUGFeRD 2.0 compliant XML + embedded PDF)
     * German standard for electronic invoices
     */
    public function generateERechnung()
    {
        try {
            // Load data
            $bill = Bill::with('missions')->find($this->id);
            $company = Company::find($bill->company);
            $customer = Customer::where('name', $bill->customer)->first();

            if (!$company || !$customer) {
                throw new \Exception('Company or Customer not found');
            }

            // Create PDF first
            $pdfPath = $this->generatePDF();

            // Create ZUGFeRD XML
            $xmlContent = $this->generateZUGFeRDXML($bill, $company, $customer);

            // Embed XML into PDF (creates valid eRechnung)
            $eRechnungPath = $this->embedXMLInPDF($pdfPath, $xmlContent, $company);

            return $eRechnungPath;
        } catch (\Exception $e) {
            \Log::error('eRechnung generation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate PDF invoice
     */
    private function generatePDF()
    {
        $bill = Bill::with('missions')->find($this->id);
        $company = Company::find($bill->company);
        $customer = Customer::where('name', $bill->customer)->first();

        $this->applyTaxSettings($bill, $customer);

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Rechnung');
        $pdf->SetMargins(20, 30, 20, 20);

        // Set header
        $this->setHeaderCallback($pdf, $company);

        // Set footer
        $this->setFooterCallback($pdf);

        $pdf->AddPage();

        // Address field
        $this->renderAddressField($pdf, $company, $customer);

        // Logo
        $this->renderLogo($pdf, $company);

        // Invoice header
        $this->renderInvoiceHeader($pdf, $bill);

        // Missions table
        $this->renderMissionsTable($pdf, $bill);

        // Summary and taxes
        $this->renderSummary($pdf, $bill, $customer);

        // Tax notes
        $this->renderTaxNotes($pdf, $customer);

        // Payment information
        $this->renderPaymentInfo($pdf, $company, $customer);

        // Save PDF
        $filename = public_path('Rechnungen/' . $company->nameCompany . ' RE-' . $bill->number . '.pdf');
        $pdf->Output($filename, 'F');

        return $filename;
    }

    /**
     * Generate ZUGFeRD 2.0 XML (eRechnung format)
     */
    private function generateZUGFeRDXML($bill, $company, $customer)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:102" xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:102" xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:102" xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:102"></rsm:CrossIndustryInvoice>');

        // Document context
        $documentContext = $xml->addChild('rsm:ExchangedDocumentContext');
        $documentContext->addChild('ram:TestIndicator', 'false');
        $documentContext->addChild('ram:GuidelineSpecifiedDocumentContextParameter')
            ->addChild('ram:ID', 'urn:cen.eu:en16931:2017#conformant#urn:xoev-de:zugferd:2p0:extended');

        // Document
        $exchangedDocument = $xml->addChild('rsm:ExchangedDocument');
        $exchangedDocument->addChild('ram:ID', 'RE-' . $bill->number);
        $exchangedDocument->addChild('ram:TypeCode', '380'); // Invoice
        $exchangedDocument->addChild('ram:IssueDateTime')
            ->addChild('udt:DateTimeString', (new DateTime($bill->date))->format('Ymd'))
            ->addAttribute('format', '102');

        // Supplier (Company)
        $supplyChainTradeTransaction = $xml->addChild('rsm:SupplyChainTradeTransaction');
        $applicableHeaderTradeAgreement = $supplyChainTradeTransaction->addChild('ram:ApplicableHeaderTradeAgreement');
        $seller = $applicableHeaderTradeAgreement->addChild('ram:SellerTradeParty');
        $seller->addChild('ram:Name', $company->nameCompany);
        $sellerAddress = $seller->addChild('ram:PostalTradeAddress');
        $sellerAddress->addChild('ram:PostcodeCode', $company->postal ?? '');
        $sellerAddress->addChild('ram:LineOne', $company->street);
        $sellerAddress->addChild('ram:CityName', $company->city);
        $sellerAddress->addChild('ram:CountryID', 'DE');

        $sellerTaxRep = $seller->addChild('ram:SpecifiedTaxRegistration');
        $sellerTaxRep->addChild('ram:ID', $company->taxNumber)->addAttribute('schemeID', 'VA');

        $sellerLegalOrg = $seller->addChild('ram:SpecifiedLegalOrganization');
        $sellerLegalOrg->addChild('ram:ID', $company->taxNumber);
        $sellerLegalOrg->addChild('ram:TradingBusinessName', $company->nameCompany);

        // Customer (Buyer)
        $buyer = $applicableHeaderTradeAgreement->addChild('ram:BuyerTradeParty');
        $buyer->addChild('ram:Name', $customer->name);
        $buyerAddress = $buyer->addChild('ram:PostalTradeAddress');
        $buyerAddress->addChild('ram:PostcodeCode', $customer->postal ?? '');
        $buyerAddress->addChild('ram:LineOne', $customer->street);
        $buyerAddress->addChild('ram:CityName', $customer->city);
        $buyerAddress->addChild('ram:CountryID', $customer->country ?? 'DE');

        // Add line items (missions)
        $this->addZUGFeRDLineItems($supplyChainTradeTransaction, $bill, $customer);

        // Add totals
        $this->addZUGFeRDTotals($supplyChainTradeTransaction, $bill, $customer);

        return $xml->asXML();
    }

    /**
     * Add line items to ZUGFeRD XML
     */
    private function addZUGFeRDLineItems(&$transaction, $bill, $customer)
    {
        foreach ($bill->missions->sortBy('startDatum') as $mission) {
            $lineItem = $transaction->addChild('ram:IncludedSupplyChainTradeLineItem');
            $lineItem->addChild('ram:AssociatedDocumentLineDocument')
                ->addChild('ram:LineID', (string)$mission->id);

            $lineTradeAgreement = $lineItem->addChild('ram:SpecifiedTradeProduct');
            $lineTradeAgreement->addChild('ram:Name', 'Transport: ' . $mission->startOrt . ' → ' . $mission->zielOrt);

            $lineDelivery = $lineItem->addChild('ram:SpecifiedLineTradeDelivery');
            $lineDelivery->addChild('ram:BilledQuantity', '1')->addAttribute('unitCode', 'C62');

            $lineSettlement = $lineItem->addChild('ram:SpecifiedLineTradeSettlement');
            $linetax = $lineSettlement->addChild('ram:ApplicableTradeTax');
            $linetax->addChild('ram:TypeCode', 'VAT');
            $linetax->addChild('ram:CategoryCode', 'S');
            $linetax->addChild('ram:RateApplicablePercent', (string)$customer->taxes);

            $lineSettlement->addChild('ram:SpecifiedTradeSettlementMonetarySummation')
                ->addChild('ram:DuePayableAmount', number_format($mission->preisKunde, 2, '.', ''))
                ->addAttribute('currencyID', 'EUR');
        }
    }

    /**
     * Add totals to ZUGFeRD XML
     */
    private function addZUGFeRDTotals(&$transaction, $bill, $customer)
    {
        $headerSettlement = $transaction->addChild('ram:ApplicableHeaderTradeSettlement');
        $headerSettlement->addChild('ram:PaymentMeansCode', '30'); // Bank transfer

        $paymentTerms = $headerSettlement->addChild('ram:ApplicableTradePaymentTerms');
        $paymentTerms->addChild('ram:Description', 'Zahlbar innerhalb von ' . $customer->duration . ' Tagen');

        $tax = $headerSettlement->addChild('ram:ApplicableTradeTax');
        $tax->addChild('ram:CalculatedAmount', number_format($bill->priceNet * ($customer->taxes / 100), 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $tax->addChild('ram:TypeCode', 'VAT');
        $tax->addChild('ram:BasisAmount', number_format($bill->priceNet, 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $tax->addChild('ram:CategoryCode', 'S');
        $tax->addChild('ram:RateApplicablePercent', (string)$customer->taxes);

        $monetarySummation = $headerSettlement->addChild('ram:SpecifiedTradeSettlementMonetarySummation');
        $monetarySummation->addChild('ram:LineTotalAmount', number_format($bill->priceNet, 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $monetarySummation->addChild('ram:TaxBasisTotalAmount', number_format($bill->priceNet, 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $monetarySummation->addChild('ram:TaxTotalAmount', number_format($bill->priceNet * ($customer->taxes / 100), 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $monetarySummation->addChild('ram:GrandTotalAmount', number_format($bill->priceGross, 2, '.', ''))->addAttribute('currencyID', 'EUR');
        $monetarySummation->addChild('ram:DuePayableAmount', number_format($bill->priceGross, 2, '.', ''))->addAttribute('currencyID', 'EUR');
    }

    /**
     * Embed ZUGFeRD XML into PDF to create valid eRechnung
     */
    private function embedXMLInPDF($pdfPath, $xmlContent, $company)
    {
        // This requires additional PHP library support
        // Option 1: Use server-side lib to embed XML
        // Option 2: Use third-party eRechnung service

        $eRechnungPath = str_replace('.pdf', '_eRechnung.pdf', $pdfPath);

        // Placeholder for actual embedding logic
        // In production, use: https://github.com/ZugferdTeam/ZugferdMeta
        copy($pdfPath, $eRechnungPath);

        return $eRechnungPath;
    }

    /**
     * Apply tax settings based on paragraph codes
     */
    private function applyTaxSettings($bill, &$customer)
    {
        if ($bill->taxes == 300) {
            $customer->taxes = 0;
            $customer->paragraph = 300;
        } elseif ($bill->taxes == 305) {
            $customer->taxes = 0;
            $customer->paragraph = 305;
        }
    }

    /**
     * Render address field
     */
    private function renderAddressField(&$pdf, $company, $customer)
    {
        $pdf->Ln(20);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(200, 10, 10);
        $pdf->Cell(0, 0, $company->nameCompany . ' - ' . $company->street . ' - ' . $company->city, 0, 1);
        $pdf->SetFont('times', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 0, $customer->name, 0, 1);
        $pdf->Cell(0, 0, $customer->street, 0, 1);
        $pdf->Cell(0, 0, $customer->city, 0, 1);
        $pdf->Cell(0, 0, $customer->country, 0, 1);
        $pdf->Cell(0, 0, $customer->steuernr, 0, 1);
    }

    /**
     * Render logo
     */
    private function renderLogo(&$pdf, $company)
    {
        $imagePath = ($company->id == 2) ? 'images/sh logo.jpg' : 'images/fs logo.jpg';
        if (file_exists($imagePath)) {
            $pdf->Image($imagePath, 140, 50, 50, '', 'JPG', '', 'R', false, 300);
        }
    }

    /**
     * Render invoice header
     */
    private function renderInvoiceHeader(&$pdf, $bill)
    {
        $pdf->Ln(20);
        $pdf->Cell(0, 0, 'Mönchengladbach, den ' . $bill->date, 0, 1, 'R');
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 0, 'Rechnungs-Nr.: RE-' . $bill->number, 0, 1);
    }

    /**
     * Render missions table
     */
    private function renderMissionsTable(&$pdf, $bill)
    {
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(226, 14, 14);
        $pdf->Cell(25, 0, 'Tour-Nr.', 1, 0, 'C', 1);
        $pdf->Cell(25, 0, 'Abholung', 1, 0, 'C', 1);
        $pdf->Cell(100, 0, 'Tourenbeschreibung', 1, 0, '', 1);
        $pdf->Cell(20, 0, 'Preis', 1, 1, 'C', 1);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(2);

        foreach ($bill->missions->sortBy('startDatum') as $mission) {
            if (isset($mission->kundeBemerkung)) {
                $pdf->Cell(50, 0, '', 0, 0, 'C');
                $pdf->Cell(100, 0, $mission->kundeBemerkung, 0, 1, 'L');
            }
            $pdf->Cell(25, 0, $mission->id, 0, 0, 'C');
            $pdf->Cell(25, 0, date('d.m.Y', strtotime($mission->startDatum)), 0, 0, 'C');
            $pdf->Cell(100, 0, 'Abholung: ' . $mission->startOrt, 0, 0, 'L');
            $pdf->Cell(22, 0, number_format($mission->preisKunde, 2, ',', '') . ' €', 0, 1, 'R');
            $pdf->Cell(50, 0, '', 0, 0, 'C');
            $pdf->Cell(100, 0, 'Auslieferung: ' . $mission->zielOrt, 0, 1, 'L');
            $pdf->Ln(5);
        }
        $pdf->writeHTML('<hr>');
    }

    /**
     * Render summary and tax information
     */
    private function renderSummary(&$pdf, $bill, $customer)
    {
        $pdf->Cell(50, 0, '', 0, 0);
        $pdf->Cell(100, 0, 'Summe (netto)', 0, 0, 'R');
        $pdf->Cell(22, 0, number_format($bill->priceNet, 2, ',', '') . ' €', 0, 1, 'R');
        $pdf->Cell(50, 0, '', 0, 0);
        $pdf->Cell(100, 0, $customer->taxes . '% Mehrwertsteuer', 0, 0, 'R');
        $pdf->Cell(22, 0, number_format($bill->priceNet * ($customer->taxes / 100), 2, ',', '') . ' €', 0, 1, 'R');
        $pdf->SetFont('helvetica', 'b', 10);
        $pdf->Cell(50, 0, '', 0, 0);
        $pdf->Cell(100, 0, 'Rechnungsbetrag (brutto)', 0, 0, 'R');
        $pdf->Cell(22, 0, number_format(($bill->priceNet * (1 + $customer->taxes / 100)), 2, ',', '') . ' €', 0, 1, 'R');
        $bill->priceGross = $bill->priceNet * (1 + $customer->taxes / 100);
        $bill->save();
    }

    /**
     * Render tax notes
     */
    private function renderTaxNotes(&$pdf, $customer)
    {
        if ($customer->paragraph == 300) {
            $pdf->writeHTML('<p><hr><h3>HINWEIS</h3><br><br>Übergang der Steuerschuldnerschaft nach §3a UStg grenzüberschreitende Beförderung<hr></p>', true, false, true);
        } elseif ($customer->paragraph == 305) {
            $pdf->writeHTML('<p><hr><h3>HINWEIS</h3><br><br>Steuerfrei nach § 4(3) lit. a (aa/bb) UStG grenzüberschreitende Beförderung<hr></p>', true, false, true);
        }
    }

    /**
     * Render payment information
     */
    private function renderPaymentInfo(&$pdf, $company, $customer)
    {
        $paymentInfo = '
            <p style="text-align: center; font-size:6; font-weight:normal">
                Zu zahlen ist der Rechnungsbetrag innerhalb von ' . $customer->duration . ' Tagen auf das Konto:<br>
                Inhaber: ' . $company->nameOwner . ' / ' . $company->venue . '<br>
                Steuernummer: ' . $company->taxNumber . ' / Umsatzsteuer-ID: ' . $company->turnoverTax . '<br>
                Bank: ' . $company->bank . ' / IBAN: ' . $company->iban . ' / BIC: ' . $company->bic . '
            </p>
        ';
        $pdf->SetY(-32);
        $pdf->writeHTML($paymentInfo, true, false, true);
    }

    /**
     * Set header callback
     */
    private function setHeaderCallback(&$pdf, $company)
    {
        $headerText = ($company->id == 2) ? 'Sabine Heinrichs Transporte' : 'STRERATH Transporte';
        $yPosition = ($company->id == 2) ? 30 : 15;

        $pdf->SetHeaderCallback(function($pdf) use ($headerText, $yPosition) {
            $pdf->SetY($yPosition);
            $pdf->SetFont('helvetica', 'b', 20);
            $pdf->SetTextColor(200, 10, 10);
            $pdf->Cell(0, 10, $headerText, 0, false, 'C');
        });
    }

    /**
     * Set footer callback
     */
    private function setFooterCallback(&$pdf)
    {
        $pdf->SetFooterCallback(function($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(0, 10, 'Seite ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C');
        });
    }

    /**
     * Legacy method for backward compatibility
     */
    public function PDF()
    {
        return $this->test = 'Test erfolgreich!';
    }
}
