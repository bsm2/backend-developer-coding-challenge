<div>
    <div id="calendar" class="text-white"></div>
</div>

@script()
    <script>
        $(document).ready(function() {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                events: async function(info, successCallback, failureCallback) {
                    try {
                        const response = await fetch(`/calendar-events?start=${info.startStr}&end=${info.endStr}`);
                        const result = await response.json();
                        successCallback(result.data);
                    } catch (error) {
                        failureCallback(error);
                    }
                }
                //events: @json($posts), // from Livewire component
            });

            calendar.render();
        });
    </script>
@endscript
