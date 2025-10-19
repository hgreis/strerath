<script 
src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>

<div style="width: 600px; float: left">
    <h1>Auftrag {{ $input->id }}: Fahrt aufteilen</h1>
    <form action="/mission/new" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
    <div class="whitebox">
        <div class="flip">
            <b>INFO:</b>
        </div>
        <div class="panel">
                Dieser Auftrag wird in mehrere neue Fahrten aufgeteilt. Es existieren somit der Original-Auftrag und alle Teilstrecken. Diese Teilstrecken können jedoch nicht einzelnd editiert werden, sie dienen nur einer transparenten Planung und Abrechnung.
        </div>
    </div>
    @if ($input->submissions->count() == 0)
        @include('pages.forms.mission_splitquest')
    @else
        @include('pages.forms.mission_split_form')
    @endif
    
</div>

<script>
    var acc = document.getElementsByClassName("flip");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>