@extends('layouts.app')

@section('content')
    <div style="padding:20px">

        <h1>EVENT SCHEDULE</h1>
        <div class="grid">
            <div id="eventModal3"
                style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
                <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;position:relative">
                    <button onclick="closeModal()" style="position:absolute;top:10px;right:10px;font-weight:bold">✖</button>
                    <div id="modalContent"></div>
                </div>
            </div>
            <div>
                <h3>SHOW EVENTS</h3>

                @foreach ($showEvents as $event)
                    <div class="card" data-id="{{ $event->id }}">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div style="font-weight:700">EVENT ID:{{ $event->id }} - {{ $event->title }}</div>
                            <div style="font-size:12px">Mode: {{ $event->mode }}</div>
                        </div>

                        <div style="margin-top:12px;display:flex;gap:8px">
                            <button class="btn green set-status" data-status="available">AVAILABLE</button>
                            <button class="btn red set-status" data-status="unavailable">UNAVAILABLE</button>
                            <button class="btn orange set-status" data-status="cancelled">CANCEL</button>
                        </div>

                        <button class="btn large" onclick="viewEvent({{ $event->id }})">VIEW EVENT</button>
                    </div>
                @endforeach
            </div>

            <div class="other-event">
                <h3>OTHER EVENTS</h3>

                @foreach ($otherEvents as $event)
                    <div class="card" data-id="{{ $event->id }}">
                        <div class="event-meta">EVENT ID: {{ $event->title }}</div>
                        <div class="event-meta">MODE: {{ $event->mode }}</div>

                        <div>
                            <button class="btn large btn orange set-status" onclick="viewEvent({{ $event->id }})">VIEW
                                EVENT</button>
                            <button class="btn large " style="background:#24323a;color:#fff;margin-top:8px"
                                onclick="viewAttendance({{ $event->id }})">VIEW ATTENDANCE</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <template id="toast-template">
            <div
                style="position:fixed;right:20px;bottom:20px;background:#111;color:#fff;padding:10px 14px;border-radius:6px;box-shadow:0 2px 6px rgba(0,0,0,.2)">
                Updated</div>
        </template>
    </div>
@endsection

@push('scripts')
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const modal = document.getElementById("eventModal3");
        document.querySelectorAll('.set-status').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const status = btn.dataset.status;
                const card = btn.closest('.card');
                const id = card.dataset.id;

                fetch(`/events/${id}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) showToast('Status: ' + data.status);
                    })
                    .catch(err => showToast('Error'));
            });
        });


        function viewAttendance(id) {
            alert('Open attendance for ID: ' + id);
        }

        function showToast(text) {
            const t = document.createElement('div');
            t.textContent = text;
            Object.assign(t.style, {
                position: 'fixed',
                right: '20px',
                bottom: '20px',
                background: '#111',
                color: '#fff',
                padding: '10px 14px',
                borderRadius: '6px'
            });
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 1600);
        }

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

                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('eventModal3').style.display = 'flex';

                    window.addEventListener("click", e => {
                        if (e.target === modal) closeModal();
                    });
                });
        }

        function closeModal() {
            document.getElementById('eventModal3').style.display = 'none';
        }
    </script>
@endpush
