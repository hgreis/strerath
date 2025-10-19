<div style="width: 600px; float: left">
    <h1>Auftrag {{ $input->id }}: Fahrer zuweisen</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
    <div class="form-group">
        {{  Form::label('fahrer', 'Name:') }}
        <select name='fahrer' class='form-control'">
                @if (isset($input->fahrer))
                    <option value="{{ $input->fahrer }}">{{ $input->fahrer }}</option>
                @endif
                <option value="">---Bitte Auswählen---</option>
                @foreach ($drivers as $driver)
                        <option value="{{ $driver->name }}">{{ $driver->name }}</option>
                @endforeach
        </select>
    </div>
    <div class="form-group">
        {{ Form::hidden('id', $input->id) }}
        {{ Form::hidden('customer', 1) }}
        {{ Form::label('preisFahrer', 'Preis:') }}
        {{ Form::text('preisFahrer', $input->preisFahrer, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        @if (isset($input->deliveryNote))
                 <a target="_blank" href="/uploads/{{ $input->id }} Lieferschein.pdf">{{ $input->id }} Lieferschein.pdf </a> 
        @else
                <label>Ablieferbeleg: </label>
        @endif
        {{ Form::file('deliveryNote') }}
    </div>
    <div class="whitebox2">        
        @include('pages.forms.mission_driver_info')
    </div>
</div>
