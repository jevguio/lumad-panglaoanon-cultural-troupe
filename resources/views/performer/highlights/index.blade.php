@extends('layouts.app')

@section('content')
<div class="container" style="padding:20px">

    <h2 class="mb-3" style="color:#8B0000;">EVENT HIGHLIGHTS</h2>

    <h4 class="mt-4">SHOW EVENTS</h4>

    <div style="display:grid;grid-template-columns:repeat(2,minmax(50%,100%));gap:12px;">

        {{-- SHOW EVENTS --}}
        @foreach ($showEvents as $event)
            @php
                $mediaCount = $event->highlights->flatMap->files->count();
            @endphp

            <div style="border:1px solid #ccc;padding:14px;border-radius:8px;background:#ffffff;">

<div style="
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap:8px 20px;
    font-size:14px;
">

    <div><strong>Event ID:</strong> {{ $event->id }}</div>
    <div><strong>Title:</strong> {{ $event->title }}</div>

    <div><strong>Description:</strong> {{ $event->description }}</div>
    <div><strong>Venue:</strong> {{ $event->venue }}</div>

    <div><strong>Client:</strong> {{ $event->client }}</div>
    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>

    <div><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
    <div><strong>Total Media:</strong> {{ $mediaCount }}</div>

</div>

                <br><br>

                <button
                    onclick="openModal('modal-show-{{ $event->id }}')"
                    style="padding:7px 14px;border:none;border-radius:4px;background:#8B0000;color:white;cursor:pointer;">
                    View Highlights
                </button>
            </div>

            {{-- MODAL --}}
            <div id="modal-show-{{ $event->id }}" class="ev-modal">
                <div class="ev-modal-content">

                    <div class="ev-modal-header">
                        <h3>{{ $event->title }} — Gallery</h3>
                        <span class="ev-close" onclick="closeModal('modal-show-{{ $event->id }}')">&times;</span>
                    </div>

                    <div class="ev-gallery">
                        @forelse ($event->highlights as $highlight)
                            @foreach ($highlight->files as $file)
                                <div>
                                    @if ($file->type === 'image')
                                        <img src="{{ asset($file->paths) }}">
                                    @elseif ($file->type === 'video')
                                        <video src="{{ asset($file->paths) }}" controls></video>
                                    @endif
                                </div>
                            @endforeach
                        @empty
                            <p style="color:#888;">No highlights available.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        @endforeach

        {{-- OTHER EVENTS --}}
        @foreach ($otherEvents as $event)
            @php
                $mediaCount = $event->highlights->flatMap->files->count();
            @endphp

            <div style="border:1px solid #ccc;padding:14px;border-radius:8px;background:#ffffff;">
<div style="
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap:8px 20px;
    font-size:14px;
">

    <div><strong>Event ID:</strong> {{ $event->id }}</div>
    <div><strong>Title:</strong> {{ $event->title }}</div>

    <div><strong>Description:</strong> {{ $event->description }}</div>
    <div><strong>Venue:</strong> {{ $event->venue }}</div>

    <div><strong>Client:</strong> {{ $event->client }}</div>
    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>

    <div><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
    <div><strong>Total Media:</strong> {{ $mediaCount }}</div>

</div>

                <br><br>

                <button
                    onclick="openModal('modal-other-{{ $event->id }}')"
                    style="padding:7px 14px;border:none;border-radius:4px;background:#8B0000;color:white;cursor:pointer;">
                    View Highlights
                </button>
            </div>

            {{-- MODAL --}}
            <div id="modal-other-{{ $event->id }}" class="ev-modal">
                <div class="ev-modal-content">

                    <div class="ev-modal-header">
                        <h3>{{ $event->title }} — Gallery</h3>
                        <span class="ev-close" onclick="closeModal('modal-other-{{ $event->id }}')">&times;</span>
                    </div>

                    <div class="ev-gallery">
                        @forelse ($event->highlights as $highlight)
                            @foreach ($highlight->files as $file)
                                <div>
                                    @if ($file->type === 'image')
                                        <img src="{{ asset($file->paths) }}">
                                    @elseif ($file->type === 'video')
                                        <video src="{{ asset($file->paths) }}" controls></video>
                                    @endif
                                </div>
                            @endforeach
                        @empty
                            <p style="color:#888;">No highlights available.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- MODAL STYLES --}}
<style>
.ev-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0,0,0,0.7);
    padding: 40px 15px;
    overflow-y: auto;
}

.ev-modal-content {
    background: #fff;
    max-width: 1000px;
    margin: auto;
    border-radius: 10px;
    padding: 20px;
    animation: fadeIn .2s ease;
}

.ev-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
}

.ev-close {
    font-size: 28px;
    cursor: pointer;
    color: #8B0000;
}

.ev-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px,1fr));
    gap: 12px;
}

.ev-gallery img,
.ev-gallery video {
    width: 100%;
    border-radius: 8px;
}

@keyframes fadeIn {
    from {opacity: 0; transform: scale(.97);}
    to {opacity: 1; transform: scale(1);}
}
</style>

{{-- MODAL SCRIPT --}}
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = 'auto';
}

window.onclick = function(e) {
    if (e.target.classList.contains('ev-modal')) {
        e.target.style.display = "none";
        document.body.style.overflow = 'auto';
    }
}
</script>

@endsection
