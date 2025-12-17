@php
    $bgColor = match (Auth::user()->type) {
        'admin' => '#BB5248',
        'manager' => '#D48C06', // example blue for manager
        default => '#D48C06', // example green for performer
    };
@endphp

<div id="sidebar" class="sidebar collapsed" style="position: relative; 
background-color: {{ $bgColor }} !important;">

    <nav style="position:fixed;">
        <div style="display: flex;left:0;top:20px; position: sticky; "> 
            <img src="{{ asset('icons/Menu.png') }}" onclick="toggleBtnOff()" class="targMenu hidden"
                style="margin-left: auto;margin-right: auto;border:none;background-color:transparent; width: 40px;"></img>
        </div>
        <div style="margin-top: 45px;"></div>
        <div class="head targ" id="headProf" style="display: flex;">
            <img class="avatar" src="{{ asset('icons/avatar.png') }}"> 
        </div>
        <ul id="sidebarMenu">
            <li class="{{ request()->is('event-schedule') ? 'active' : '' }}" data-link="{{ route('events.index') }}">
                <a href="{{ route('events.index') }}">
                    <img src="{{ asset('icons/Schedule.png') }}" style="width:30px;  border: none;"> </a>
            </li>
            @if (Auth::user()->type == 'admin')
                <li class="{{ request()->is('performer/availability') ? 'active' : '' }}"
                    data-link="{{ route('performer.availability') }}">
                    <a href="{{ route('performer.availability') }}">
                        <img src="{{ asset('icons/Theatre Mask.png') }}" style="width:30px;  border: none;"> </a>
                </li>

                <li class="{{ request()->is('performer/attendance') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('performer.attendance') }}">
                        <img src="{{ asset('icons/Attendance.png') }}" style="width:30px;  border: none;"> </a>
                </li>
                <li class="{{ request()->is('performer/history') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('performer.history') }}">
                        <img src="{{ asset('icons/Historical.png') }}" style="width:30px;  border: none;"> </a>
                </li>
                <li class="{{ request()->is('manage-costume') ? 'active' : '' }}"
                    data-link="{{ route('manage-costume') }}">
                    <a href="{{ route('manage-costume') }}">

                        <img src="{{ asset('icons/Kimono.png') }}" style="width:30px;  border: none;"> </a>
                </li>
                <li class="{{ request()->is('users') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('users.index') }}">
                        <img src="{{ asset('icons/Person.png') }}" style="width:30px;  border: none;"> </a>
                </li>
                <li class="{{ request()->is('manage/events/hignlights') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('manage.events.highlights') }}">
                        <img src="{{ asset('icons/Schedule.png') }}" style="width:30px;  border: none;"></a>
                </li>
            @else
                <li class="{{ request()->is('event-availability-status') ? 'active' : '' }}"
                    data-link="{{ route('event.availability') }}">
                    <a href="{{ route('event.availability') }}">
                        <img src="{{ asset('icons/Theatre Mask.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>

                <li class="{{ request()->is('my-schedule') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('my.schedule') }}">
                        <img src="{{ asset('icons/Schedule.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>

                <li class="{{ request()->is('attendance') ? 'active' : '' }}"
                    data-link="{{ route('attendance.index') }}">
                    <a href="{{ route('attendance.index') }}">
                        <img src="{{ asset('icons/Attendance.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>
                <li class="{{ request()->is('manage-costume') ? 'active' : '' }}"
                    data-link="{{ route('manage-costume') }}">
                    <a href="{{ route('manage-costume') }}">
                        <img src="{{ asset('icons/Kimono.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>

                <li class="{{ request()->is('view/events/history') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('view.events.history') }}">
                        <img src="{{ asset('icons/Historical.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>
                <li class="{{ request()->is('view/events/hignlights') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('view.events.highlights') }}">
                        <img src="{{ asset('icons/Schedule.png') }}" style="width:30px;  border: none;">
                    </a>
                </li>
            @endif
        </ul>
        {{-- <div class="logout targ">
            <a href="{{ route('logout') }}" style="text-decoration: none;color:white">Logout</a>
        </div> --}}
    </nav>
</div>
