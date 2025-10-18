@php
    $bgColor = match(Auth::user()->type) {
        'admin' => '#000000',
        'manager' => '#1e40af', // example blue for manager
        default => '#047857',  // example green for performer
    };
@endphp

<div id="sidebar" class="sidebar" style="position: relative; 
background-color: {{ $bgColor }} !important;">
 
    <button id="toggleBtnOff" onclick="toggleBtnOff()"
        style="border-color:black;border-width:4px;border-style:solid; border-radius: 30px; position: absolute; right: 20px; top:20px; width:40px;height:40px;background-color:transparent; font-weight: bold; font-size: 22px;padding:0px;margin:0px;">
        x</button>
    <div class="profile" style="margin-top: 35px;">
        <div class="avatar"></div>
        <div>
            <div class="name">{{ Auth::user()->name }}</div>
            <div style="font-size:12px;opacity:.9">
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
    <nav>
        <ul id="sidebarMenu">
            <li class="{{ request()->is('event-schedule') ? 'active' : '' }}" data-link="{{ route('events.index') }}">
                <a href="{{ route('events.index') }}">Event Schedule</a>
            </li>
            @if(Auth::user()->type=="admin")
            
            <li class="{{ request()->is('performer/availability') ? 'active' : '' }}"
                data-link="{{ route('performer.availability') }}">
                <a href="{{ route('performer.availability') }}">Performer Availability</a>
            </li>
            
            <li class="{{ request()->is('performer/attendance') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('performer.attendance') }}">Performer Attendance</a>
            </li>
            <li class="{{ request()->is('performer/history') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('performer.history') }}">Performer Attendance</a>
            </li>
            <li class="{{ request()->is('costume/status') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('costume.status') }}">Costume Status</a>
            </li>
            <li class="{{ request()->is('users') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('users.index') }}">Manage Accounts</a>
            </li>
            <li class="{{ request()->is('manage/events/hignlights') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('manage.events.highlights') }}">Manage Highlights</a>
            </li>
            @else
            <li class="{{ request()->is('event-availability-status') ? 'active' : '' }}"
                data-link="{{ route('event.availability') }}">
                <a href="{{ route('event.availability') }}">Event Availability Status</a>
            </li>
            
            <li class="{{ request()->is('my-schedule') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('my.schedule') }}">My Schedule</a>
            </li>
            
            <li class="{{ request()->is('attendance') ? 'active' : '' }}" data-link="{{ route('attendance.index') }}">
                <a href="{{ route('attendance.index') }}">Event Attendance Status</a>
            </li>
            <li class="{{ request()->is('manage-costume') ? 'active' : '' }}"
                data-link="{{ route('manage-costume') }}">
                <a href="{{ route('manage-costume') }}">Manage Costume</a>
            </li>
            
            <li class="{{ request()->is('view/events/history') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('view.events.history') }}">Event History</a>
            </li>
            <li class="{{ request()->is('view/events/hignlights') ? 'active' : '' }}" data-link="{{ route('my.schedule') }}">
                <a href="{{ route('view.events.highlights') }}">Events Highlights</a>
            </li>
            @endif
        </ul>
    </nav>
    <div class="logout">
        <a href="{{ route('logout') }}" style="text-decoration: none;color:white">Logout</a>
    </div>
</div>
