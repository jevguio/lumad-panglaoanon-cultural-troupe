@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-danger">PERFORMER ATTENDANCE</h2>

        @foreach ($events as $event)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <b>Event ID: {{ $event->id }}</b> - {{ $event->title ?? 'Untitled' }}
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-info">
                            <tr>
                                <th>Performer ID</th>
                                <th>Name</th>
                                <th>Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->performers as $performer)
                                <tr>
                                    <td>Performer {{ $performer->id }}</td>
                                    <td>{{ $performer->name }}</td>
                                    <td>
                                        <form action="{{ route('attendance.update', [$event->id, $performer->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" name="status" value="present"
                                                class="status-btn {{ $performer->pivot->attendance === 'present' ? 'active present' : '' }}">
                                                PRESENT
                                            </button>

                                            <button type="submit" name="status" value="absent"
                                                class="status-btn {{ $performer->pivot->attendance === 'absent' ? 'active absent' : '' }}">
                                                ABSENT
                                            </button>

                                            <button type="submit" name="status" value="late"
                                                class="status-btn {{ $performer->pivot->attendance === 'late' ? 'active late' : '' }}">
                                                LATE
                                            </button>

                                            <style>
                                                .status-btn {
                                                    padding: 6px 12px;
                                                    margin-right: 5px;
                                                    border: 1px solid #ccc;
                                                    background: white;
                                                    color: #333;
                                                    font-size: 14px;
                                                    border-radius: 4px;
                                                    cursor: pointer;
                                                    transition: background 0.3s, color 0.3s;
                                                }

                                                .status-btn:hover {
                                                    background: #f0f0f0;
                                                }

                                                .status-btn.active.present {
                                                    background: #4caf50;
                                                    color: white;
                                                    border-color: #4caf50;
                                                }

                                                .status-btn.active.absent {
                                                    background: #f44336;
                                                    color: white;
                                                    border-color: #f44336;
                                                }

                                                .status-btn.active.late {
                                                    background: #ff9800;
                                                    color: white;
                                                    border-color: #ff9800;
                                                }
                                            </style>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
