@extends('layouts.main')
@include('pages.datepicker')
@section('content')
    <h1>Neuen Auftrag anlegen</h1>
        <form action="/mission/new" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
        <h3>
            
            @if ($input->company == 2)
                <input type="radio" name="company" value="1"> Strerath Transporte &nbsp &nbsp &nbsp
                <input type="radio" name="company" value="2" checked> <nobr> Sabine Heinrichs Transporte</nobr><br>
            @else
                <input type="radio" name="company" value="1" checked> Strerath Transporte &nbsp &nbsp &nbsp
                <input type="radio" name="company" value="2"> Sabine Heinrichs Transporte<br>
            @endif
        </h3>
        <div style="width: 45%; min-width: 400px; float: left" class="whitebox">
            <h3>Touren - Start</h3>
                        {{ Form::text('id', $input->id, ['hidden' => 'true']) }}
                        {{ Form::label('startDatum', 'Datum:') }}
                        {{ Form::text('startDatum', $input->startDatum, ['class' => 'date form-control', 'required']) }}<br>
                        {{ Form::label('startOrt', 'PLZ und Stadt:') }}
                        {{ Form::text('startOrt', $input->startOrt, ['class' => 'form-control', 'required']) }}
        </div>

        <div style="width: 45%; min-width: 400px; float: right" class="whitebox">
            <h3>Touren - Ziel</h3>
                        {{ Form::label('zielDatum', 'Datum:') }}
                        {{ Form::text('zielDatum', $input->zielDatum, ['class' => 'date form-control', 'required']) }}<br>
                        {{ Form::label('zielOrt', 'PLZ und Stadt:') }}
                        {{ Form::text('zielOrt', $input->zielOrt, ['class' => 'form-control', 'required']) }}
        </div>

        <div style="width: 45%; min-width: 400px; float: left" class="whitebox">
            <h3>Auftraggeber</h3>
            {{  Form::label('zielName', 'Name:') }}
            <select name='kunde' class='form-control'">
                @if (isset($input->kunde))
                    <option value="{{ $input->kunde }}">{{ $input->kunde }}</option>
                @endif
                <option value="">---Bitte Auswählen---</option>
                @foreach ($customers as $customer)
                        <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                @endforeach
            </select><br>
            {{ Form::label('preisKunde', 'Preis (Euro):') }}
            {{ Form::text('preisKunde', $input->preisKunde, ['class' => 'form-control']) }}<br>
            @if (isset($input->missionConfirmation))
                 <a target="_blank" href="/uploads/{{ $input->id }} Auftragsbestaetigung.pdf">{{ $input->id }} Auftragsbestätigung.pdf </a> 
            @else
                <label>Auftragsbestätigung:</label>
            @endif
            <input type="file" name="missionConfirmation"><br>
            {{ Form::label('kundeBemerkung', 'Bemerkung (Auftragsnummer, erscheint auf der Rechnung): ') }}
            {{ Form::text('kundeBemerkung', $input->kundeBemerkung, ['class' => 'form-control']) }}<br>
        </div>    
        
        <div style="width: 45%; min-width: 400px; float: right" class="whitebox">
            <h3>Fahrer / Unternehmer</h3>
            {{  Form::label('fahrer', 'Name:') }}
            <select name='fahrer' class='form-control'>
                @if (isset($input->fahrer))
                    <option value="{{ $input->fahrer }}">{{ $input->fahrer }}</option>
                @endif
                <option value="">---Bitte Auswählen---</option>
                @foreach ($drivers as $driver)
                        <option value="{{ $driver->name }}">{{ $driver->name }}</option>
                @endforeach
            </select><br>
            {{ Form::label('preisFahrer', 'Preis (Euro):') }}
            {{ Form::text('preisFahrer', $input->preisFahrer, ['class' => 'form-control']) }}<br>
            @if (isset($input->deliveryNote))
                 <a target="_blank" href="/uploads/{{ $input->id }} Lieferschein.pdf">{{ $input->id }} Lieferschein.pdf </a> 
            @else
                    <label>Ablieferbeleg: </label>
            @endif
            {{ Form::file('deliveryNote') }}<br>
            {{ Form::submit('Speichern/Menu', [
                    'class' => 'form-control',
                    'class' => 'blackButton', 
                    'name' => 'submit',
                    'style' => 'width: 100%' ])}}
        </div>
    </form>
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>  
@endsection

