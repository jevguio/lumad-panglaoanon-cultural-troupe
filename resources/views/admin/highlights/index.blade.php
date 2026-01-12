@extends('layouts.app')

@section('content')
<div class="container" style="padding:20px">
    <div style="display: flex;">
        <h2 class="mb-3" style="color:#8B0000; flex: 1;">MANAGE EVENT HIGHLIGHTS</h2>
        <button id="addHighlightBtn"
            style="background:#4CAF50;color:white;padding:8px 12px;border:none;border-radius:4px;cursor:pointer;">+ ADD /
            UPDATE HIGHLIGHT</button>
    </div>

    <h4 class="mt-4">SHOW EVENTS</h4>
    <div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:10px;">
        @foreach ($showEvents as $event)
        <div class="event-card" data-event-id="{{ $event->id }}"
            data-highlight-id="{{ $event->highlights->first()->id ?? '' }}"
            style="border:1px solid #ccc;padding:10px;border-radius:6px;">
            <strong>Event ID:</strong> {{ $event->id }} <br>
            <strong>Title:</strong> {{ $event->title }} <br>
            <button class="editHighlightBtn"
                style="background:#4CAF50;color:white;border:none;padding:4px 8px;margin-top:5px;">EDIT</button>
          <button class="deleteHighlightBtn"
                style="background:#ce1616;color:white;border:none;padding:4px 8px;margin-top:5px;">DELETE</button>
        </div>
        @endforeach
    </div>

    <h4 class="mt-4">OTHER EVENTS</h4>
    <div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:10px;">
        @foreach ($otherEvents as $event)
        <div class="event-card" data-event-id="{{ $event->id }}"
            data-highlight-id="{{ $event->highlights->first()->id ?? '' }}"
            style="border:1px solid #ccc;padding:10px;border-radius:6px;">
            <strong>Event ID:</strong> {{ $event->id }} <br>
            <strong>Title:</strong> {{ $event->title }} <br>
            <button class="editHighlightBtn"
                style="background:#4CAF50;color:white;border:none;padding:4px 8px;margin-top:5px;">EDIT</button>
          <button class="deleteHighlightBtn"
                style="background:#ce1616;color:white;border:none;padding:4px 8px;margin-top:5px;">DELETE</button>
       </div>
        @endforeach
    </div>
</div>

<!-- MODAL -->
<div id="highlightModal" class="modal"
    style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
    <div style="background:white;padding:20px;border-radius:8px;width:500px;position:relative;max-height:90vh;overflow:auto;">
        <button type="button" id="closeModalBtn"
            style="position:absolute;top:10px;right:10px;background:none;border:none;font-size:18px;cursor:pointer;">✖</button>
        <h4 id="modalTitle">ADD HIGHLIGHT</h4>
        <form id="highlightForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="highlightMethod" name="_method" value="POST">

            <label>Event ID</label>
            <input type="number" name="event_id" id="eventIdField" required
                style="width:100%;padding:5px;margin-bottom:10px;">

            <label>Image Media</label>
            <input type="file" name="images[]" id="imageInput" multiple accept="image/*"
                style="width:100%;margin-bottom:10px;">
            <div id="imagePreview" style="display:flex;flex-wrap:wrap;gap:5px;"></div>

            <label>Video Media</label>
            <input type="file" name="videos[]" id="videoInput" multiple accept="video/*"
                style="width:100%;margin-bottom:10px;">
            <div id="videoPreview" style="display:flex;flex-wrap:wrap;gap:5px;"></div>

            <div id="progressContainer" style="display:none;margin-top:10px;">
                <progress id="uploadProgress" value="0" max="100" style="width:100%;"></progress>
            </div>

            <div style="margin-top:10px;">
                <button type="submit" style="background:#4CAF50;color:white;border:none;padding:6px 10px;">SAVE</button>
                <button type="button" id="cancelModalBtn"
                    style="background:#ccc;border:none;padding:6px 10px;">CANCEL</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const modal = document.getElementById('highlightModal');
    const form = document.getElementById('highlightForm');
    const methodField = document.getElementById('highlightMethod');
    const title = document.getElementById('modalTitle');
    const eventIdField = document.getElementById('eventIdField');
    const imgInput = document.getElementById('imageInput');
    const vidInput = document.getElementById('videoInput');
    const imgPreview = document.getElementById('imagePreview');
    const vidPreview = document.getElementById('videoPreview');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('uploadProgress');
    let isUploading = false;
    let currentAction = '{{ route('highlights.store') }}';
    let currentMethod = 'POST';

    function createPreviewElement(src, type, isExisting = false) {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.style.width = '80px';
        wrapper.style.height = '80px';

        const removeBtn = document.createElement('button');
        removeBtn.textContent = '✖';
        removeBtn.style.position = 'absolute';
        removeBtn.style.top = '2px';
        removeBtn.style.right = '2px';
        removeBtn.style.background = 'rgba(0,0,0,0.6)';
        removeBtn.style.color = 'white';
        removeBtn.style.border = 'none';
        removeBtn.style.cursor = 'pointer';
        removeBtn.style.fontSize = '12px';

        if (type === 'image') {
            const img = document.createElement('img');
            img.src = isExisting ? `/${src}` : URL.createObjectURL(src);
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            wrapper.appendChild(img);
        } else {
            const vid = document.createElement('video');
            vid.src = isExisting ? `/${src}` : URL.createObjectURL(src);
            vid.style.width = '100%';
            vid.style.height = '100%';
            vid.controls = true;
            wrapper.appendChild(vid);
        }

        removeBtn.onclick = () => wrapper.remove();
        wrapper.appendChild(removeBtn);

        if (type === 'image') imgPreview.appendChild(wrapper);
        else vidPreview.appendChild(wrapper);
    }

    function openHighlightModal(eventId, highlightId = null) {
        modal.style.display = 'flex';
        imgPreview.innerHTML = '';
        vidPreview.innerHTML = '';
        imgInput.value = '';
        vidInput.value = '';

        eventIdField.value = eventId;

        if (highlightId) {
            title.textContent = 'UPDATE HIGHLIGHT';
            currentAction = `/event-highlights/${highlightId}/update`;
            currentMethod = 'POST';
            methodField.value = 'POST';

            fetch(`/event-highlights/${highlightId}`)
                .then(res => res.json())
                .then(data => {
                    data.files.forEach(file => {
                        if (file.type === 'image') createPreviewElement(file.paths, 'image', true);
                        else createPreviewElement(file.paths, 'video', true);
                    });
                });
        } else {
            title.textContent = 'ADD HIGHLIGHT';
            currentAction = '{{ route('highlights.store') }}';
            currentMethod = 'POST';
            methodField.value = 'POST';
        }
    }

    function closeHighlightModal() {
        if (isUploading && !confirm('Files are still uploading. Do you want to cancel?')) return;
        modal.style.display = 'none';
    }

    document.getElementById('addHighlightBtn').addEventListener('click', () => openHighlightModal(null));
    document.getElementById('closeModalBtn').addEventListener('click', closeHighlightModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeHighlightModal);

    document.querySelectorAll('.editHighlightBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const parent = btn.closest('.event-card');
            const eventId = parent.dataset.eventId;
            const highlightId = parent.dataset.highlightId || null;
            openHighlightModal(eventId, highlightId);
        });
    });

    imgInput.addEventListener('change', (e) => {
        imgPreview.innerHTML = '';
        Array.from(e.target.files).forEach(file => createPreviewElement(file, 'image'));
    });

    vidInput.addEventListener('change', (e) => {
        vidPreview.innerHTML = '';
        Array.from(e.target.files).forEach(file => createPreviewElement(file, 'video'));
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        isUploading = true;
        progressContainer.style.display = 'block';
        progressBar.value = 0;

        const xhr = new XMLHttpRequest();
        xhr.open(currentMethod, currentAction, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) progressBar.value = (e.loaded / e.total) * 100;
        });

        xhr.onload = () => {
            isUploading = false;
            progressContainer.style.display = 'none';
            if (xhr.status === 200) {
                alert('Highlight saved successfully!');
                window.location.reload();
            } else alert('Upload failed.');
        };

        xhr.onerror = () => {
            isUploading = false;
            progressContainer.style.display = 'none';
            alert('An error occurred during upload.');
        };

        xhr.send(formData);
    });

    window.addEventListener('beforeunload', (e) => {
        if (isUploading) {
            e.preventDefault();
            e.returnValue = 'Files are still uploading. Are you sure you want to leave?';
        }
    });
    
    document.querySelectorAll('.deleteHighlightBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const parent = btn.closest('.event-card');
            const highlightId = parent.dataset.highlightId;
            if (!highlightId) {
                alert('No highlight exists for this event.');
                return;
            }

            if (!confirm('Are you sure you want to delete this highlight?')) return;

            fetch(`/event-highlights/${highlightId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (res.ok) {
                    alert('Highlight deleted successfully!');
                    parent.remove(); // remove card from DOM
                } else {
                    alert('Failed to delete highlight.');
                    console.error(res);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred while deleting.');
            });
        });
    });

});
</script>
@endpush
