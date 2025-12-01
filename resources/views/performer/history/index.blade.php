@extends('layouts.app')

@section('content')
    <div class="container">

        <div id="eventViewer"
            style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
            <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;position:relative">
                <button onclick="closeModal()" style="position:absolute;top:10px;right:10px;font-weight:bold">✖</button>
                <div id="eventModalContent"></div>
            </div>
        </div>
        <h2 class="mb-4 text-danger">PERFORMER ATTENDANCE</h2>

        <div class="  mb-4">
            <div class=" p-0">
                <table class="table table-bordered mb-0" style="background-color:  #5490BE; padding:10px;">
                    <thead class=" " style="background-color: #5490BE;">
                        <tr style="background-color:  #5490BE;">
                            <th style="background-color:  #5490BE;">Event ID</th>
                            <th style="background-color:  #5490BE;">Event Details</th>
                            <th style="background-color:  #5490BE;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showEvents as $event)
                            <tr style="background-color: #D9D9D9; padding:10px;">
                                <td>Performer {{ $event->id }}</td>
                                <td>
                                    <button class="btn large btn orange set-status"
                                        onclick="viewEvent({{ $event->id }})">VIEW
                                        EVENT</button>
                                </td>
                                <td>
                                    @foreach ($event->performers as $performer)
                                        @if ($performer->id == Auth::user()->id)
                                            {{ $performer->pivot->attendance }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function viewEvent(id) {
            fetch(`/events/${id}`)
                .then(r => r.json())
                .then(ev => {
                    let html = `<h2>${ev.title}</h2>`;
                    html += `<p><strong>Client:</strong> ${ev.client}</p>`;
                    html += `<p><strong>Venue:</strong> ${ev.venue}</p>`;
                    html += `<p><strong>Type:</strong> ${ev.type}</p>`;
                    html += `<p><strong>Date:</strong> ${ev.date}</p>`;
                    html += `<p><strong>Time:</strong> ${ev.time}</p>`;
                    html += `<p><strong>Status:</strong> ${ev.status}</p>`;
                    html += `<p><strong>Required Performers:</strong> ${ev.required_performers}</p>`;
                    html += `<p><strong>Description:</strong> ${ev.description}</p>`;

                    if (ev.selected_performers && ev.selected_performers.length) {
                        html += `<p><strong>Selected Performers:</strong></p>`;
                        html += ev.selected_performers.map(p =>
                            `<span style='background:#3ab76a;color:#fff;padding:4px 8px;border-radius:6px;margin-right:6px'>${p}</span>`
                        ).join('');
                    }

                    document.getElementById('eventModalContent').innerHTML = html;
                    document.getElementById('eventViewer').style.display = 'flex';

                    window.addEventListener("click", e => {
                        if (e.target === modal) closeModal();
                    });
                });
        }

        function closeModal() {
            document.getElementById('eventViewer').style.display = 'none';
        }
    </script>
@endpush
