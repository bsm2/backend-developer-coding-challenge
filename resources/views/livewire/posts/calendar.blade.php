<div class="py-16">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-20">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div>
                    <div>
                        <div id="calendar" class="text-white"></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
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
                        const response = await fetch(
                            `/calendar-events?start=${info.startStr}&end=${info.endStr}`);
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
