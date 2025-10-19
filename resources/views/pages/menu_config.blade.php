@extends('layouts.main')

@section('content')
    <div>
        <h1>STRERATH Transporte</h1>
        <p>
            <button class="blackButton" onclick="window.location.href='/drivers'" >Fahrer verwalten</button>
            <button class="blackButton" onclick="window.location.href='/customer'" >Kunden verwalten</button><hr>
        </p>
    </div>
@endsection