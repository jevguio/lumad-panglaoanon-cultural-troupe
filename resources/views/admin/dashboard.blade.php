@extends('layouts.app')

@section('content')
    <div class=" " style="width: 100%;">

        {{-- Welcome Section --}}
        <div class="p-5    text-white  text-center"
            style="width: 100%; background-color: #BB5248;margin-top:5%;margin-bottom:5%;">
            <h1 class="fw-bold text-white">Welcome to TroupeSync</h1>
            <p>Manage events, costumes, and more.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-dark" style="margin:10px;">Get Started</a>
            <div class="d-flex justify-content-center gap-3">
                <a href="#overview" class="btn main">Overview</a>
                <a href="#events" class="btn main">Schedule</a>
                <a href="#costumes" class="btn main">Costumes</a>
            </div>
        </div>

        {{-- Quick Stats --}}
        <h3 id="overview" class="text-center mb-3 fw-bold">Quick Stats</h3>
        <center>
            <p>Keep track of your troupe's activities.</p>
            <a href="{{ route('costume.status') }}" class="btn btn-dark" style="margin:10px;">View Details</a>
        </center>
        <div  class="row mb-5" style="padding:0px 50px;">
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
        <h3  id="costumes" class="text-center mb-3 fw-bold">Costumes Management</h3>
        <div class=" justify-content-between align-items-center mb-3"
            style="padding:0px 50px; text-align: center;margin-bottom:15px;">
            <p class="mb-0">Overview of available costumes</p>
            <a href="{{ route('costumes.store') }}" class="btn btn-dark"  style="margin:10px;">Add Costume</a>
        </div>
        <div class="row mb-5" style="padding:0px 50px;">
            @forelse($costumes as $costume)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if ($costume->image)
                            <img src="{{ asset('storage/' . $costume->image) }}" class="card-img-top"
                                style="height:250px; object-fit:cover;">
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
        <h3 id="events" class="text-center mb-3">Upcoming Events</h3>
        <div class=" justify-content-between  align-items-center mb-3" style="padding:0px 50px; text-align: center;">
            <p class="mb-0">Stay on top of scheduled events</p>
            <a href="{{ route('events.index') }}" class="btn btn-dark"  style="margin:10px;">Add Event</a>
        </div>
        <div class="row" style="padding:0px 50px;">
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
