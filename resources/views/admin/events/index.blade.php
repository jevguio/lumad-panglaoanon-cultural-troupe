@extends('layouts.app')

@section('content')
    <div style=" padding: 10px 50px; ">
        <h1>EVENT SCHEDULE</h1>
        <button onclick="openModal()">ADD EVENT</button>
        <div>
            <div id="updateModal"
                style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
                <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;position:relative">
                    <button onclick="closeUpdateModal()"
                        style="position:absolute;top:10px;right:10px;font-weight:bold">✖</button>
                    <h2>Update Event</h2>
                    <form id="updateForm">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="updateEventId">

                        <div class="mb-2">
                            <label>Title</label>
                            <input type="text" id="updateTitle" name="title" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Venue</label>
                            <input type="text" id="updateVenue" name="venue" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Date</label>
                            <input type="date" id="updateDate" name="date" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Time</label>
                            <input type="time" id="updateTime" name="time" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Description</label>
                            <textarea id="updateDescription" name="description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation -->
            <div id="deleteModal"
                style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
                <div
                    style="background:#fff;padding:20px;border-radius:12px;max-width:400px;width:90%;border-radius:12px;text-align:center">
                    <h3>Are you sure you want to delete this event?</h3>
                    <div style="margin-top:20px">
                        <button class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                        <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    </div>
                </div>
            </div>

            <div id="eventModal3"
                style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);align-items:center;justify-content:center;z-index:1000">
                <div style="background:#fff;padding:20px;border-radius:12px;max-width:500px;width:90%;position:relative">
                    <button onclick="closeModal()" style="position:absolute;top:10px;right:10px;font-weight:bold">✖</button>
                    <div id="modalContent"></div>
                </div>
            </div>
            <h3>SHOW EVENTS</h3>
            <div class="grid grid-cols-3">

                @foreach ($showEvents as $event)
                    <div class="card" data-id="{{ $event->id }}">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div style="font-weight:700">EVENT ID:{{ $event->id }} - {{ $event->title }}</div>
                            <div style="font-size:12px">Mode: {{ $event->mode }}</div>
                        </div>

                        <div style="margin-top:12px;display:flex;gap:8px">
                            <button class="btn large orange" onclick="viewEvent({{ $event->id }})">VIEW EVENT</button>
                            <button class="btn large green" onclick="openUpdateModal({{ $event->id }})">UPDATE</button>
                            <button class="btn large red" onclick="openDeleteModal({{ $event->id }})">REMOVE</button>

                        </div>

                    </div>
                @endforeach
            </div>


            <h3>OTHER EVENTS</h3>
            <div class=" grid grid-cols-3 ">

                @foreach ($otherEvents as $event)
                    <div class="card" data-id="{{ $event->id }}">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div style="font-weight:700">EVENT ID: {{ $event->id }} - {{ $event->title }}</div>
                            <div style="font-size:12px">Mode: {{ $event->mode }}</div>
                        </div>

                        <div style="margin-top:12px;display:flex;gap:8px">
                            {{-- <button class="btn green set-status" data-status="available">AVAILABLE</button>
                    <button class="btn red set-status" data-status="unavailable">UNAVAILABLE</button>
                    <button class="btn orange set-status" data-status="cancelled">CANCEL</button> --}}

                            <button class="btn large orange" onclick="viewEvent({{ $event->id }})">VIEW EVENT</button>
                            <button class="btn large green" onclick="openUpdateModal({{ $event->id }})">UPDATE</button>
                            <button class="btn large red" onclick="openDeleteModal({{ $event->id }})">REMOVE</button>
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


        <!-- Modal -->
        <div class="modal-bg" id="eventModal4">
            <div class="modal2">
                <span class="close-btn" onclick="closeModal2()">✖</span>

                <h3>CREATE EVENT</h3>

                <form id="eventForm" method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" name="title" placeholder="Enter event title" required>
                    </div>

                    <div class="form-group">
                        <label>Client:</label>
                        <input type="text" name="client" placeholder="Enter event client">
                    </div>

                    <div class="form-group">
                        <label>Venue:</label>
                        <input type="text" name="venue" placeholder="Enter event venue">
                    </div>

                    <div class="form-group">
                        <label>Type:</label>
                        <input type="text" name="type" placeholder="Enter event type">
                    </div>

                    <div class="form-group">
                        <label>Is Show:</label>
                        <input type="checkbox" name="is_show_event" >
                    </div>

                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date" name="date">
                    </div>

                    <div class="form-group">
                        <label>Time:</label>
                        <input type="time" name="time">
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Required Performers:</label>
                        <input type="number" name="performers" placeholder="Enter number">
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" placeholder="Enter event description"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" onclick="closeModal()">CANCEL</button>
                        <button type="submit" class="btn btn-add">ADD EVENT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        
document.addEventListener('DOMContentLoaded', function() {

        function openModal() {
            document.getElementById("eventModal4").style.display = "flex";
        }

        function closeModal2() {
            document.getElementById("eventModal4").style.display = "none";
        }

        // Close when clicking outside
        document.getElementById("eventModal4").addEventListener("click", function(e) {
            if (e.target === this) {
                closeModal2();
            }
        });
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const modal = document.getElementById("eventModal3");

        // =================== UPDATE ===================
        function openUpdateModal(id) {
            fetch(`/events/${id}`)
                .then(r => r.json())
                .then(ev => {
                    document.getElementById("updateEventId").value = ev.id;
                    document.getElementById("updateTitle").value = ev.title;
                    document.getElementById("updateVenue").value = ev.venue;
                    document.getElementById("updateDate").value = ev.date;
                    document.getElementById("updateTime").value = ev.time;
                    document.getElementById("updateDescription").value = ev.description;

                    document.getElementById("updateModal").style.display = "flex";
                });
        }

        document.getElementById("updateForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const id = document.getElementById("updateEventId").value;

            fetch(`/events/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        title: document.getElementById("updateTitle").value,
                        venue: document.getElementById("updateVenue").value,
                        date: document.getElementById("updateDate").value,
                        time: document.getElementById("updateTime").value,
                        description: document.getElementById("updateDescription").value,
                    })
                }).then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast("Event updated!");
                        closeUpdateModal();
                        setTimeout(() => location.reload(), 1000);
                    }
                });
        });

        function closeUpdateModal() {
            document.getElementById("updateModal").style.display = "none";
        }

        // =================== DELETE ===================
        let deleteId = null;

        function openDeleteModal(id) {
            deleteId = id;
            document.getElementById("deleteModal").style.display = "flex";
        }

        document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
            if (!deleteId) return;

            fetch(`/events/${deleteId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrf,
                        "Accept": "application/json"
                    }
                }).then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast("Event deleted!");
                        closeDeleteModal();
                        setTimeout(() => location.reload(), 1000);
                    }
                });
        });

        function closeDeleteModal() {
            document.getElementById("deleteModal").style.display = "none";
        }
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

                    if (ev.selectedPerformers && ev.selectedPerformers.length) {
                        html += `<p><strong>Selected Performers:</strong></p>`;
                        html += ev.selectedPerformers.map(p =>
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
    })
    </script>
@endpush
