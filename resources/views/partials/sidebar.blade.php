@php
    $bgColor = match (Auth::user()->type) {
        'admin' => '#BB5248',
        'manager' => '#D48C06', // example blue for manager
        default => '#D48C06', // example green for performer
    };
@endphp

<div id="sidebar" class="sidebar" style="position: relative; 
background-color: {{ $bgColor }} !important;"> 
    <nav style="position:fixed; width: 300px;">
        <div style="display: flex;left:0;top:20px; position: sticky; ">
            <div class="targ2" style="flex: 1;"></div>
            <a class="targ" href="{{ route('dashboard') }}"
                style="border-color:black;border-width:4px; text-decoration: none; color: black; text-align: center; border-style:solid; border-radius: 30px;  width:40px; height:40px;background-color:transparent; font-weight: bold; font-size: 22px;padding:0px;margin:0px;">
                x</a>


            <img src="{{ asset('icons/Menu.png') }}" onclick="toggleBtnOff()" class="targMenu hidden"
                style="margin-left: auto;margin-right: auto;border:none;background-color:transparent; width: 40px;"></img>
        </div>
        <div style="margin-top: 45px;"></div>
        <div class="head targ" id="headProf" style="display: flex;">
            <img class="avatar" src="{{ asset('icons/avatar.png') }}">
            <div>
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="" style="font-size:12px;opacity:.9">
                    @switch(Auth::user()->type)
                        @case('admin')
                            Administrator
                        @break

                        @case('manager')
                            Manager
                        @break

                        @default
                            Cultural Performer
                    @endswitch

                </div>
            </div>
        </div>
        <ul id="sidebarMenu">
            <li class="{{ request()->is('event-schedule') ? 'active' : '' }}" data-link="{{ route('events.index') }}">
                <a href="{{ route('events.index') }}" style="display: flex;">
                    <img src="{{ asset('icons/Schedule.png') }}" style="width:30px;  border: none;">
                    <span>Event Schedule</span></a>
            </li>
            @if (Auth::user()->type == 'admin')
                <li class="{{ request()->is('performer/availability') ? 'active' : '' }}"
                    data-link="{{ route('performer.availability') }}">
                    <a href="{{ route('performer.availability') }}" style="display: flex;">
                        <img src="{{ asset('icons/Theatre Mask.png') }}" style="width:30px;  border: none;">
                        <span>Performer Availability</span></a>
                </li>

                <li class="{{ request()->is('performer/attendance') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('performer.attendance') }}" style="display: flex;">
                        <img src="{{ asset('icons/Attendance.png') }}" style="width:30px;  border: none;">
                        <span>Performer Attendance</span></a>
                </li>
                <li class="{{ request()->is('performer/history') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('performer.history') }}">
                        <img src="{{ asset('icons/Historical.png') }}" style="width:30px;  border: none;">
                        <span>Performer History</span></a>
                </li>
                <li class="{{ request()->is('manage-costume') ? 'active' : '' }}"
                    data-link="{{ route('manage-costume') }}">
                    <a href="{{ route('manage-costume') }}">

                        <img src="{{ asset('icons/Kimono.png') }}" style="width:30px;  border: none;">
                        <span>Costume Status</span></a>
                </li>
                <li class="{{ request()->is('users') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('users.index') }}">
                        <img src="{{ asset('icons/Person.png') }}" style="width:30px;  border: none;">
                        <span>Manage Accounts</span></a>
                </li>
                <li class="{{ request()->is('manage/events/hignlights') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('manage.events.highlights') }}">
                        <img src="{{ asset('icons/Spotlight.png') }}" style="width:30px;  border: none;">
                        <span>Manage Highlights</span></a>
                </li>
            @else
                <li class="{{ request()->is('event-availability-status') ? 'active' : '' }}"
                    data-link="{{ route('event.availability') }}">
                    <a href="{{ route('event.availability') }}">
                        <img src="{{ asset('icons/Theatre Mask.png') }}" style="width:30px;  border: none;">
                        Event Availability Status</a>
                </li>

                <li class="{{ request()->is('my-schedule') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('my.schedule') }}">

                        <img src="{{ asset('icons/Attendance.png') }}" style="width:30px;  border: none;">My
                        Schedule</a>
                </li>

                <li class="{{ request()->is('attendance') ? 'active' : '' }}"
                    data-link="{{ route('attendance.index') }}">
                    <a href="{{ route('attendance.index') }}">
                        <img src="{{ asset('icons/Attendance.png') }}" style="width:30px;  border: none;">
                        Event Attendance Status</a>
                </li>
                <li class="{{ request()->is('manage-costume') ? 'active' : '' }}"
                    data-link="{{ route('manage-costume') }}">
                    <a href="{{ route('manage-costume') }}">
                        <img src="{{ asset('icons/Kimono.png') }}" style="width:30px;  border: none;">
                        Manage Costume</a>
                </li>

                <li class="{{ request()->is('view/events/history') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('view.events.history') }}">
                        <img src="{{ asset('icons/Historical.png') }}" style="width:30px;  border: none;">
                        Event History</a>
                </li>
                <li class="{{ request()->is('view/events/hignlights') ? 'active' : '' }}"
                    data-link="{{ route('my.schedule') }}">
                    <a href="{{ route('view.events.highlights') }}"> 
                        <img src="{{ asset('icons/Spotlight.png') }}" style="width:30px;  border: none;">
                        Events Highlights</a>
                </li>
            @endif
        </ul>
        <div class="logout targ">
            <a href="{{ route('logout') }}" style="text-decoration: none;color:white">Logout</a>
        </div>
    </nav>
</div>
