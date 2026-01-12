@extends('layouts.app')

@section('content')
    <div class="content" style="padding:20px">
        <h2 class="page-title">EVENT AVAILABILITY STATUS</h2>

        <table class="event-table">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @php $hasRecord = false; @endphp

            @foreach ($events as $event)
                @php  
                    $myPerformer = $event->selectedPerformers->where('user_id', Auth::id())->first();
                @endphp

                @if ($myPerformer && $myPerformer->status != "available")
                    @php $hasRecord = true; @endphp

                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ ucfirst($event->title) }}</td>
                        <td>
                            <button class="btn-view" onclick="viewEvent({{ $event->id }})">VIEW EVENT</button>
                        </td>
                        <td class="{{ strtolower($myPerformer->status) }}">
                            {{ ucfirst($myPerformer->status) }}
                        </td>
                    </tr>
                @endif
            @endforeach

            @if (!$hasRecord)
                <tr>
                    <td colspan="4" style="text-align:center;">
                        <span>Record is Empty</span>
                    </td>
                </tr>
            @endif


            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="eventModal2"
        style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
        <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;position:relative;margin:auto; top:50%;transform:translateY(-50%)">

            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function viewEvent(id) {
            const modal = document.getElementById("eventModal2");
            fetch(`/events/${id}`)
                .then(r => r.json())
                .then(ev => {
                    let html = `<h2>${ev.title}</h2>`;
                    html += `<p><strong>Client:</strong> ${ev.client ?? '-'}</p>`;
                    html += `<p><strong>Venue:</strong> ${ev.venue ?? '-'}</p>`;
                    html += `<p><strong>Type:</strong> ${ev.type ?? '-'}</p>`;
                    html += `<p><strong>Date:</strong> ${ev.date ?? '-'}</p>`;
                    html += `<p><strong>Time:</strong> ${ev.time ?? '-'}</p>`;
                    html += `<p><strong>Status:</strong> ${ev.status}</p>`;
                    html += `<p><strong>Required Performers:</strong> ${ev.required_performers ?? '-'}</p>`;
                    html += `<p><strong>Description:</strong> ${ev.description ?? '-'}</p>`;

                    if (ev.selected_performers && ev.selected_performers.length) {
                        html += `<p><strong>Selected Performers:</strong></p>`;
                        html += ev.selected_performers.map(p =>
                            `<span style='background:#3ab76a;color:#fff;padding:4px 8px;border-radius:6px;margin-right:6px'>${p}</span>`
                        ).join('');
                    }

                    document.getElementById("modalContent").innerHTML = html;
                    document.getElementById("eventModal2").style.display = "block";
                });

            window.addEventListener("click", e => {
                if (e.target === modal) closeModal();
            });
        }

        function closeModal() {
            document.getElementById("eventModal2").style.display = "none";
        }
    </script>
@endpush

<style>
    .event-table thead {
        background-color: rgb(250, 183, 59);
    }

    .event-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: rgb(221, 218, 224);
    }

    .event-table th,
    .event-table td {
        padding: 10px;
        text-align: center;
        border: 1px solid rgb(196, 194, 198);
    }

    .btn-view {
        background: goldenrod;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 5px;
        color: white;
    }

    .selected {
        color: green;
        font-weight: bold;
    }

    .unselected {
        color: red;
        font-weight: bold;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 20px;
        width: 50%;
        border-radius: 10px;
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
    }
</style>
