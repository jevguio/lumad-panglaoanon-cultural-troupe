@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row shadow rounded overflow-hidden" style="max-width: 900px; width: 100%;">

            {{-- Left Side Image --}}
            <div class="col-md-6 p-0">
                <img src="{{ asset('images/logo.png') }}" alt="TroupeSync" class="img-fluid h-100 w-100"
                    style="object-fit: cover;">
            </div>

            {{-- Right Side Login Form --}}
            <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
                <h4 class="fw-bold mb-3 text-center">Welcome to TroupeSync</h4>

                {{-- Role Buttons --}}
                <div class="d-flex justify-content-center mb-4">
                    @if ($isAdminLogin)
                        <a href="{{ route('login', ['isAdminLogin' => true]) }}" class="btn btn-warning me-2 fw-bold px-4">
                            ADMIN
                        </a>

                        <a href="{{ route('login', ['isAdminLogin' => false]) }}" class="btn btn-outline-dark fw-bold px-4">
                            PERFORMER
                        </a> 
                        @else
                        <a href="{{ route('login', ['isAdminLogin' => true]) }}"  class="btn btn-outline-dark fw-bold px-4">
                            ADMIN
                        </a>

                        <a href="{{ route('login', ['isAdminLogin' => false]) }}" class="btn btn-warning me-2 fw-bold px-4">
                            PERFORMER
                        </a>  
                    @endif

                </div>

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                            <span>This will be your TroupeSync identifier.</span>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Enter your password">

                            <span>Keep your password secure.</span>
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-dark px-4">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
