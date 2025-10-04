@extends('layouts.app')

@section('content')

    <div class=" py-4" style="width: 100%;">

        {{-- Welcome Section --}}
        <div class="p-5 mb-4 bg-danger text-white rounded-3 text-center">
            <h1 class="fw-bold">Welcome to TroupeSync</h1>
            <p>Manage events, costumes, and more.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn btn-dark">Overview</a>
                <a href="{{ route('events.index') }}" class="btn btn-light">Schedule</a>
                <a href="{{ route('costume.status') }}" class="btn btn-light">Costumes</a>
            </div>
        </div>
    
        {{-- Quick Stats --}}
        <h3 class="text-center mb-3">Quick Stats</h3>
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h5>Upcoming Events</h5>
                        <p class="display-6">{{ $upcomingEvents }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h5>Total Costumes</h5>
                        <p class="display-6">{{ $totalCostumes }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center bg-light">
                    <div class="card-body">
                        <h5>Members Active</h5>
                        <p class="display-6">{{ $activeMembers }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Costume Management --}}
        <h3 class="text-center mb-3">Costumes Management</h3>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">Overview of available costumes</p>
            <a href="{{ route('costumes.store') }}" class="btn btn-dark">Add Costume</a>
        </div>
        <div class="row mb-5">
            @forelse($costumes as $costume)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if($costume->image)
                            <img src="{{ asset('storage/'.$costume->image) }}" class="card-img-top" style="height:250px; object-fit:cover;">
                        @endif
                        <div class="card-body text-center">
                            <h5>{{ $costume->name }}</h5>
                            <p class="text-muted">{{ ucfirst($costume->status) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>No costumes available.</p>
            @endforelse
        </div>
    
        {{-- Upcoming Events --}}
        <h3 class="text-center mb-3">Upcoming Events</h3>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="mb-0">Stay on top of scheduled events</p>
            <a href="{{ route('events.create') }}" class="btn btn-dark">Add Event</a>
        </div>
        <div class="row">
            @forelse($events as $event)
                <div class="col-md-4 mb-3">
                    <div class="card text-center p-3">
                        <h5>{{ $event->title }}</h5>
                        <p class="text-muted">Date: {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                        <p>Location: {{ $event->venue ?? 'TBA' }}</p>
                    </div>
                </div>
            @empty
                <p>No upcoming events.</p>
            @endforelse
        </div>
    
    </div>


{{-- Footer --}}
<footer class="text-center mt-5">
    <p class="mb-1">© {{ date('Y') }} TroupeSync</p>
    <p class="mb-1">Follow Us on Social Media</p>
    <p>Contact Us: info@troupesync.com</p>
</footer>
@endsection
