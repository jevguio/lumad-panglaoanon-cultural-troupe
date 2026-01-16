@extends('layouts.app')

@section('content')
    <h2 style="color:#b22222; margin-bottom:20px;">PERFORMER HISTORY</h2>

    @foreach ($events as $user)
        <div style="margin-bottom:25px; border:1px solid #ddd; border-radius:8px; overflow:hidden;">
            <div style="background:#f5a623; color:white; padding:10px; font-weight:bold;">
                Performer: {{ $user->name }}
            </div>

            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#31708f; color:white;">
                        <th style="padding:8px; border:1px solid #ddd;">Event ID</th>
                        <th style="padding:8px; border:1px solid #ddd;">Event Details</th>
                        <th style="padding:8px; border:1px solid #ddd;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->attendedEvents as $event)
                        <tr>
                            <td style="padding:8px; border:1px solid #ddd;">{{ $event->title }}</td>

                            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                                <button class="view-details-btn"
                                data-event='@json($event)'>
                                View Details
                            </button>
                            </td>
                            <td style="padding:8px; border:1px solid #ddd;">
                                <span
                                    style="
                                    {{ $event->pivot->attendance == 'present'
                                        ? 'color:green;'
                                        : ($event->pivot->attendance == 'absent'
                                            ? 'color:red;'
                                            : 'color:orange;') }}
                                ">
                                    {{ ucfirst($event->pivot->attendance) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <!-- Modal -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3 id="modalTitle"></h3>
            <p><strong>Date:</strong> <span id="modalDate"></span></p>
            <p><strong>Time:</strong> <span id="modalTime"></span></p>
            <p><strong>Venue:</strong> <span id="modalVenue"></span></p>
            <p><strong>Client:</strong> <span id="modalClient"></span></p>
            <p><strong>Mode:</strong> <span id="modalMode"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Type:</strong> <span id="modalType"></span></p>
            <p><strong>Description:</strong></p>
            <p id="modalDescription"></p>
        </div>
    </div>

    <style>
        .view-details-btn {
            background: #31708f;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-details-btn:hover {
            background: #255f73;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 8% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 10px;
        }

        .close-btn:hover {
            color: #000;
        }
    </style>
@endsection

@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('eventModal');
        const closeBtn = modal.querySelector('.close-btn');

        document.querySelectorAll('.view-details-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const eventData = JSON.parse(btn.getAttribute('data-event'));

                document.getElementById('modalTitle').textContent = eventData.title;
                document.getElementById('modalDate').textContent = eventData.date ?? '—';
                document.getElementById('modalTime').textContent = eventData.time ?? '—';
                document.getElementById('modalVenue').textContent = eventData.venue ?? '—';
                document.getElementById('modalClient').textContent = eventData.client ?? '—';
                document.getElementById('modalMode').textContent = eventData.mode ?? '—';
                document.getElementById('modalStatus').textContent = eventData.status ?? '—';
                document.getElementById('modalType').textContent = eventData.type ?? '—';
                document.getElementById('modalDescription').textContent = eventData.description ?? '—';

                modal.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        });
    </script>
@endpush
