<link href='{{ asset("css/interactiveCalander.css")}}' rel='stylesheet' />
<link href='{{ asset("fullcalendar/core/main.css")}}' rel='stylesheet' />
<link href='{{ asset("fullcalendar/daygrid/main.css")}}' rel='stylesheet' />

<script src='{{ asset("fullcalendar/core/main.js")}}'></script>
<script src='{{ asset("fullcalendar/daygrid/main.js")}}'></script>

<div class="row">
    <div class="col-md-12">
        <h2>calender</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="calendar"></div>
    </div>
</div>


<script>
    var calendar;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
            defaultView: 'dayGridMonth',
            defaultDate: '{{date("Y-m-d")}}',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: <?php echo json_encode($calendar); ?>,
            timeFormat: 'H:mm',  // uppercase H for 24-hour clock
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
            displayEventEnd: true
        });

    });

    $(document).ready(function(){
        calendar.render();
    });

</script>