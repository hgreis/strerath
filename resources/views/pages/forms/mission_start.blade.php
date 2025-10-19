<div style="width: 600px; float: left">
@if(isset($input->id))
    <h1>Auftrag {{ $input->id }}: Touren-Start</h1>
@else
    <h1>Auftrag anlegen: Touren-Start</h1>
@endif
    {{  Form::open(['/mission/new'])  }}
    {{ csrf_field() }}

    <div class="form-group">
        {{ Form::label('startDatum', 'Datum:') }}
        {{ Form::text('startDatum', $input->startDatum, ['class' => 'date form-control', 'required']) }}
        {{ Form::text('id', $input->id, ['hidden' => 'true']) }}
    </div>
    <div class="form-group">
        {{ Form::label('startName', 'Name:') }}
        {{ Form::text('startName', $input->startName, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('startStrasse', 'Strasse und Hausnummer:') }}
        {{ Form::text('startStrasse', $input->startStrasse, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('startOrt', 'Länderkennung - PLZ und Stadt:') }}
        {{ Form::text('startOrt', $input->startOrt, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('startBemerkung', 'Bemerkung:') }}
        {{ Form::text('startBemerkung', $input->startBemerkung, ['class' => 'form-control']) }}
    </div>
</div>