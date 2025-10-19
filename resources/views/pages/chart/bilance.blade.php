@extends('layouts.main')
@section('content')
    <h1>{{ $company->nameCompany }} - Finanzreport</h1>
    <div class="whitebox" style="text-align: center">
    		INFO: für die Berechnung relevant sind das Rechnungsdatum, Gutschriftsdatum und der Tag, an dem eine Fahrt quittiert wird.

    </div>
    
    @if($company->id == 1)
    	<div class="redbox" style="padding-top: 30px">
    @else
    	<div class="pinkbox" style="padding-top: 30px">
    @endif
    		<table class="table" style="width: 90%;" align="center">
    			<tr class="my1000">
    				<th rowspan="2"></th>
                    <th colspan="2" class="my1000" style="border-bottom: black !important">Rechnungen</th>
    				<th class="my1000" rowspan="2" style="border-bottom: black !important">Gutschriften</th>
    				<th colspan="2" class="my1000" style="border-bottom: black !important;">
                        Unternehmer-Gutschriften
                    </th>
    				<th rowspan="2" class="my1000" style="border-left: white !important">Unternehmer-<br>Rechnungen</th>
    			</tr>
    			<tr class="my1000">
    				<th class="my1000" style="border-top: black !important">Netto</th>
    				<th class="my1000" style="border-top: black !important">Brutto</th>
    				<th class="my1000" style="border-top: black !important">Netto</th>
    				<th class="my1000" style="border-top: black !important">Brutto</th>
    			</tr>
    		@foreach($company->year as $month)
    			<tr class="my1001">
    				<th class="my1000">{{ $month['month'] }}</th>
    				<td class="my1007">
    					{{ number_format($month['billsPriceNet'], 2, ',', '. ') }} €
    				</td>
    				<td class="my1007">
    					{{ number_format($month['billsPriceGross'], 2, ',', '. ') }} €
    				</td>
                    <td class="my1007">
                        {{ number_format($month['missionsPaid'], 2, ',', '. ') }} €
                    </td>
    				<td class="my1008">
    					{{ number_format($month['creditsPriceNet'], 2, ',', '. ') }} €
    				</td>
    				<td class="my1008">
    					{{ number_format($month['creditsPriceGross'], 2, ',', '. ') }} €
    				</td>
    				<td class="my1008">
    					{{ number_format($month['driversPaid'], 2, ',', '. ') }} €
    				</td>
    			</tr>
    		@endforeach
    			<tr class="my1001">
    				<th class="my1000">Summe</th>
    				<td class="my1007">
    					{{ number_format($company->yearBillNet, 2, ',', '. ') }} €
    				</td>
    				<td class="my1007">
    					{{ number_format($company->yearBillGross, 2, ',', '. ') }} €
    				</td>
                    <td class="my1007">
                        {{ number_format($company->yearMissionsPaid, 2, ',', '. ') }} €
                    </td>
    				<td class="my1008">
    					{{ number_format($company->yearCreditNet, 2, ',', '. ') }} €
    				</td>
    				<td class="my1008">
    					{{ number_format($company->yearCreditGross, 2, ',', '. ') }} €
    				</td>
    				<td class="my1008">
    					{{ number_format($company->yearDriverPaid, 2, ',', '. ') }} €
    				</td>
    			</tr>
    		</table>
    	</div>
@endsection

