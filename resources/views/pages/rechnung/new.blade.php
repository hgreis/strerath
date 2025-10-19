@extends('layouts.main')
@section('content')
    <h1>Unternehmer-Rechnung</h1>
    <form action="/rechnung/new" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{  Form::hidden('company', $rechnung->company->id) }}

    @if ($rechnung->company->id == 2)
        <div class="my1002">
    @else
        <div class="my1003">
    @endif
        <div class="my1014">
            {{  Form::label('fahrer', 'Fahrer / Unternehmer:') }}
            <select name='fahrer' class='form-control'>
                @if (isset($rechnung->fahrer))
                    <option value="{{ $input->fahrer }}">{{ $input->fahrer }}</option>
                @endif
                <option value="">---Bitte Auswählen---</option>
                @foreach ($drivers as $driver)
                        <option value="{{ $driver->name }}">{{ $driver->name }}</option>
                @endforeach
            </select><br>
        </div>
        <div class="my1014">
            {{ Form::label('Original Rehnungsnummer') }}
            {{ Form::text('name', $rechnung->name, ['class' => 'form-control']) }}
        </div>
        <div class="my1014">
            @if (isset($input->deliveryNote))
                 <a target="_blank" href="/uploads/{{ $rechnung->id }} Lieferschein.pdf">{{ $rechnung->id }} Lieferschein.pdf </a> 
            @else
                    <label>Unternehmer-Rechnung: </label>
            @endif
            {{ Form::file('doc') }}<br>
        </div>
        <button class="form-control" 
                onclick="window.location.href=
                    '/credit/{{ $rechnung->id }}/printPDF/19'">
            <b>Aufträge hinzufügen</b>
        </button><br>
    </div>
    </form>
@endsection

