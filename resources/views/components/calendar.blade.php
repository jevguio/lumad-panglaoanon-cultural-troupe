<div id="calendar" style="width: 80%; margin-left: auto; margin-right: auto; background-color: white; padding: 10px; border-radius: 10px;"></div>

<!-- DATE EVENT LIST MODAL -->
<div class="modal fade" style="width: 90%; margin-left: auto; margin-right: auto;" id="dateEventsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Events on <span id="modalDate"></span></h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="dateEventList"></div>
        </div>
    </div>
</div>

<!-- EVENT DETAILS MODAL -->
<div class="modal fade " style="position: fixed; z-index: 1051;" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="eventTitle"></h5>
                <button class="btn-close" data-bs-dismiss="modal" onclick="closeEvent()"></button>
            </div>

            <div class="modal-body">
                <p><strong>Venue:</strong> <span id="eventVenue"></span></p>
                <p><strong>Date:</strong> <span id="eventDate"></span></p>
                <p><strong>Time:</strong> <span id="eventTime"></span></p>
                <p><strong>Description:</strong></p>
                <p id="eventDescription"></p>
            </div>

        </div>
    </div>
</div>
@push('scripts') 
<script> 
// Open event modal
function openEvent(id, title, start, end, venue, desc) {
    document.getElementById("eventTitle").innerText = title;
    document.getElementById("eventVenue").innerText = venue;
    document.getElementById("eventDescription").innerText = desc;

    let date = start.substring(0, 10);
    let time = start.substring(11, 16);

    document.getElementById("eventDate").innerText = date;
    document.getElementById("eventTime").innerText = time;

    new bootstrap.Modal(document.getElementById("eventModal")).show();
}

function closeEvent() { 
    new bootstrap.Modal(document.getElementById("eventModal")).hide();
}
</script>
@endpush
