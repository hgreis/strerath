<div style="width: 600px; float: left">
<h1>Auftrag {{ $input->id }}: LÖSCHEN</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
    <div class="form-group">
        {{ Form::hidden('id', $input->id) }}
        {{ Form::submit('LÖSCHEN', [
            'class' => 'form-control',
            'class' => 'redButton', 
            'name' => 'delete'])}}
    </div>
</div>
