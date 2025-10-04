@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>MY SCHEDULE</h1>

        <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
            <thead style="background:#2a6ebd; color:white;">
                <tr>
                    <th>Event ID</th>
                    <th>Event Title</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mySchedules as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>
                            <button class="btn orange view-event" data-id="{{ $event->id }}">View Event</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center; color:red;">No schedule assigned</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div id="eventModal" class="modal"
        style="display:none;
    position:fixed;top:0;left:0;width:100%;height:100%;
    background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
        <div style="background:white;padding:20px;border-radius:8px;width:600px;max-width:90%;position:relative;">
            <span id="closeModal"
                style="position:absolute;top:10px;right:15px;cursor:pointer;font-size:20px;">&times;</span>
            <h2 id="eventTitle"></h2>
            <p><strong>Client:</strong> <span id="eventClient"></span></p>
            <p><strong>Venue:</strong> <span id="eventVenue"></span></p>
            <p><strong>Type:</strong> <span id="eventType"></span></p>
            <p><strong>Date:</strong> <span id="eventDate"></span></p>
            <p><strong>Time:</strong> <span id="eventTime"></span></p>
            <p><strong>Description:</strong></p>
            <p id="eventDescription"></p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("eventModal");
            const closeModal = document.getElementById("closeModal");

            document.querySelectorAll(".view-event").forEach(btn => {
                btn.addEventListener("click", function() {
                    const eventId = this.dataset.id;

                    fetch(`/events/${eventId}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById("eventTitle").innerText = data.title;
                            document.getElementById("eventClient").innerText = data.client ??
                                "-";
                            document.getElementById("eventVenue").innerText = data.venue ?? "-";
                            document.getElementById("eventType").innerText = data.type ?? "-";
                            document.getElementById("eventDate").innerText = data.date ?? "-";
                            document.getElementById("eventTime").innerText = data.time ?? "-";
                            document.getElementById("eventDescription").innerText = data
                                .description ?? "-";

                            modal.style.display = "flex";
                        });
                });
            });

            closeModal.addEventListener("click", () => {
                modal.style.display = "none";
            });

            window.addEventListener("click", e => {
                if (e.target === modal) modal.style.display = "none";
            });
        });
    </script>
@endpush
