@extends('layouts.main')
@include('pages.datepicker')
@section('content')
            
            @if($choice == 'Touren-Start')
            	@include('pages.forms.mission_start')
            @elseif($choice == 'Touren-Ziel')
            	@include('pages.forms.mission_end')
            @elseif($choice == 'Kunde')
                @include('pages.forms.mission_customer')
            @elseif($choice == 'Fahrer/Unternehmer')
                @include('pages.forms.mission_driver')
            @elseif($choice == 'Auftrag Löschen')
                @include('pages.forms.mission_delete')
            @elseif($choice == 'Tour aufteilen')
                @include('pages.forms.mission_split')
            @endif
            @include('pages.forms.mission_menu')

        {{  Form::close() }}
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd.mm.yyyy'

     });

</script>          
@endsection