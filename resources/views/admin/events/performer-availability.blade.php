@extends('layouts.app')

@section('content')
    <div style="padding:20px">

        <h2 style="color:#b22222; margin-bottom:20px;">PERFORMER AVAILABILITY</h2>

        @foreach ($events as $event)
            <div style="margin-bottom:25px; border:1px solid #ddd; border-radius:8px; overflow:hidden;">
                <div style="background:#f5a623; color:white; padding:10px; font-weight:bold;">
                    Event ID: {{ $event->id }} - {{ $event->title }}
                </div>
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#31708f; color:white;">
                            <th style="padding:8px; border:1px solid #ddd;">Performer ID</th>
                            <th style="padding:8px; border:1px solid #ddd;">Name</th>
                            <th style="padding:8px; border:1px solid #ddd;">Confirmation</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($event->performers as $performer) 
                            @if ($performer)
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">{{ $performer->id }}</td>
                                    <td style="padding:8px; border:1px solid #ddd;">{{ $performer->name }}</td>
                                    <td style="padding:8px; border:1px solid #ddd;">
                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $performer->id }}" data-status="selected"
                                            style="{{ $performer->pivot->status == 'selected' ? 'background-color:#4CAF50; color:white;' : ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            SELECT
                                        </button>

                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $performer->id }}" data-status="unselected"
                                            style="{{ $performer->pivot->status == 'unselected' ? 'background-color:#e74c3c; color:white;' : ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            UNSELECT
                                        </button>

                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $performer->id }}" data-status="undo"
                                            style="{{ $performer->pivot->status == 'undo' ? 'background-color:#f39c12; color:white;' : ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            UNDO
                                        </button>
                                    </td>
                                </tr>
                            {{-- @else
                                <tr>
                                    <td style="padding:8px; border:1px solid #ddd;">{{ $user->id }}</td>
                                    <td style="padding:8px; border:1px solid #ddd;">{{ $user->name }}</td>
                                    <td style="padding:8px; border:1px solid #ddd;">
                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $user->id }}" data-status="selected"
                                            style="{{ ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            SELECT
                                        </button>

                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $user->id }}" data-status="unselected"
                                            style="{{ ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            UNSELECT
                                        </button>

                                        <button class="btn-availability" data-event="{{ $event->id }}"
                                            data-user="{{ $user->id }}" data-status="undo"
                                            style="{{ ' color:#000000; ' }} padding:4px 10px; border:none; border-radius:4px;">
                                            UNDO
                                        </button>
                                    </td>
                                </tr> --}}
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-availability').forEach(btn => {
            btn.addEventListener('click', function() {
                const eventId = this.dataset.event;
                const userId = this.dataset.user;
                const status = this.dataset.status;

                fetch(`/events/${eventId}/performers/${userId}/availability`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Status updated: ${data.status.toUpperCase()}`);
                            location.reload();
                        }
                    });
            });
        });
    </script>
@endpush
