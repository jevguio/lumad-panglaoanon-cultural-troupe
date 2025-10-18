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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->performers as $performer)
                                <tr>
                                    <td>Performer {{ $performer->id }}</td>
                                    <td>{{ $performer->name }}</td>
                                    <td> 
                                        {{$performer->pivot->attendance}}
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
