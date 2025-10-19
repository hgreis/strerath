<div style="float: right; width: 30%; padding-top: 20px ">
    <div class="form-group">
        @if ($input->company == 2)
            <p style="margin-left: 20px">
                {{ Form::radio('company', 1)  }} STRERATH Transporte<br>
                {{ Form::radio('company', 2, true)  }} Sabine Heinrichs Transporte<br>
            </p>
        @else
            <p style="margin-left: 20px">
                {{ Form::radio('company', 1, true)  }} STRERATH Transporte<br>
                {{ Form::radio('company', 2)  }} Sabine Heinrichs Transporte<br>
            </p>
        @endif
        

        {{ Form::submit('Touren-Start', [
            'class' => 'blackButton', 
        	'name' => 'submit'])}}
        {{ Form::submit('Touren-Ziel', [
        	'class' => 'blackButton', 
        	'name' => 'submit'])}}
        {{ Form::submit('Kunde', [
        	'class' => 'blackButton',
        	'name' => 'submit'])}} 
        {{ Form::submit('Fahrer/Unternehmer', [
        	'class' => 'blackButton', 
        	'name' => 'submit'])}}
        @if ($choice != 'Tour aufteilen')
            {{ Form::submit('Tour aufteilen', [
                'class' => 'blackButton', 
                'name' => 'submit'])}}
        @endif
        {{ Form::submit('Auftrag Löschen', [
        	'class' => 'redButton', 
        	'name' => 'submit'])}}
        {{ Form::submit('Speichern/Menu', [
            'class' => 'blackButton', 
            'name' => 'submit'])}}
    </div>
</div>