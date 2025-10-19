<div class="whitebox">
    {{ Form::hidden('id', $input->id) }}<br>
    <p class="my1012">
        {{ Form::label('parts', 'Wie viele Teilstrecken sollen angelegt werden', ['class' => 'form-control']) }}
    </p>
    <p class="my1011">
        {{ Form::text('parts', '', ['class' => 'form-control']) }}
    </p>

    {{ Form::submit('Tour aufteilen', [
            'class' => 'form-control', 
            'name' => 'submit'])}}
    <br>
</div>