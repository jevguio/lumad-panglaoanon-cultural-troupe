@extends('layouts.app')

@section('content')

    <div class=" py-4" style="width: 100%;">

        {{-- Welcome Section --}}
        <div class="p-5 mb-4  text-white rounded-3 text-center" style="background-color: #D48C06;">
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
     
    
    </div>


{{-- Footer --}}
<footer class="text-center mt-5">
    <p class="mb-1">© {{ date('Y') }} TroupeSync</p>
    <p class="mb-1">Follow Us on Social Media</p>
    <p>Contact Us: info@troupesync.com</p>
</footer>
@endsection
