<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class DomPdfController extends Controller
{
    public function getPDF(Request $request) {
        $filename = 'DateiName';
        $data = [
            'title' => 'Senex-Logistcs',
            'date' => date('m/d/Y'),
        ];
        $pdf = PDF::loadView('pdf-view', compact('filename'));
        return $pdf->download($filename);
    }
}
