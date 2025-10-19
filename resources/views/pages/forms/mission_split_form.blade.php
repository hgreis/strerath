<div class="whitebox">
{{ Form::hidden('id', $input->id) }}
@foreach($input->submissions as $sub)
    {{ Form::hidden('original', $sub->original) }}
    {{ Form::hidden('sub'.$sub->part, $sub->sub) }}
    <div class="flip">
        <b>Teilstrecke {{ $sub->part }}: </b> {{ $sub->mission->startOrt }} &rarr; {{ $sub->mission->zielOrt }}
    </div>
    <div class="panel">
        <div class="my1013">
            <p class="my1011">
                {{ Form::label('zielOrt', 'bis', ['class' => 'form-control']) }}
            </p>
            <p class="my1012">
                {{ Form::text('zielOrt'.$sub->part, $sub->mission->zielOrt, ['class' => 'form-control']) }}
            </p>
        </div>

        <div class="my1013">
            <p class="my1011">
                {{ Form::label('fahrer'.$sub->part, 'Fahrer', [
                        'class' => 'form-control']) }}
            </p>
            <p class="my1012">
                <select name='fahrer{{ $sub->part }}' class='form-control'">
                        @if (isset($sub->mission->fahrer))
                            <option value="{{ $sub->mission->fahrer }}">{{ $sub->mission->fahrer }}</option>
                        @endif
                        <option value="">---Bitte Auswählen---</option>
                        @foreach ($drivers as $driver)
                                <option value="{{ $driver->name }}">{{ $driver->name }}</option>
                        @endforeach
                </select>
            </p>
        </div>

        <div class="my1013">
            <p class="my1011">
                {{ Form::label('preisFahrer'.$sub->part, 'Preis', [
                        'class' => 'form-control']) }}
            </p>
            <p class="my1012">
                {{ Form::text('preisFahrer'.$sub->part, $sub->mission->preisFahrer, [
                    'class' => 'form-control']) }}
            </p><br>
        </div>
    </div>
@endforeach
<br>{{ Form::submit('Aktualisieren', [
            'class' => 'form-control', 
            'name' => 'submit'])}}<br>
</div>