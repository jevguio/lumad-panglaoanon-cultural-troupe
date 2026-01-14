@extends('layouts.app')

@section('content')
    <h2 style="color:#b22222; margin-bottom:20px;">COSTUME STATUS</h2>

    <button id="openAddCostumeModal"
        style="background:#31708f;color:white;padding:8px 12px;border:none;border-radius:6px;cursor:pointer;margin-bottom:20px;">
        + ADD COSTUME
    </button>
    @foreach ($performers as $performer)
        <div style="margin-bottom:25px; border:1px solid #ddd; border-radius:8px; overflow:hidden;">
            <div style="background:#31708f; color:white; padding:10px; font-weight:bold;">
                PERFORMER ID: {{ $performer->name }}
            </div>

            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#31708f;color:white; text-align:left;">
                        <th style="padding:8px; border:1px solid #ddd;">Costume ID</th>
                        <th style="padding:8px; border:1px solid #ddd;">Costume Details</th>
                        <th style="padding:8px; border:1px solid #ddd;">Costume Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($performer->costumes as $costume)
                        <tr style="background-color:#f2f2f2">
                            <td style="padding:8px; border:1px solid #ddd;">Costume {{ $costume->id }}</td>
                            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                                <button class="view-costume-btn" data-id="{{ $costume->id }}"
                                    style="background:#f5a623; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                    VIEW
                                </button>
                                <button class="edit-costume-btn" data-id="{{ $costume->id }}"
                                    style="background:#105bcc; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                    EDIT
                                </button>
                                <button class="delete-costume-btn" data-id="{{ $costume->id }}"
                                    style="background:#ac0808; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">
                                    DELETE
                                </button>
                            </td>
                            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                                <span style="
                                                            {{ strtolower($costume->status) === 'returned'
                        ? 'color:green;'
                        : (strtolower($costume->status) === 'lost'
                            ? 'color:red;'
                            : 'color:orange;') }}">
                                    {{ ucfirst($costume->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align:center; padding:10px;">No costumes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

    <div id="addCostumeModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeAddCostumeModal">&times;</span>
            <h2>Add Costume</h2>

            <form id="addCostumeForm" enctype="multipart/form-data">
                @csrf
                <label>Event ID:</label>
                <input type="number" name="event_id" id="addEventID">

                <label>Costume Name:</label>
                <input type="text" name="name" style="width:100%;padding:8px;margin-bottom:10px;" required>

                <label>Costume Description:</label>
                <textarea name="description" style="width:100%;padding:8px;margin-bottom:10px;" required></textarea>
                <label>Status:</label>
                <select name="status" id="addStatus" style="width:100%;padding:8px;margin-bottom:10px;">
                    <option value="damage">Damage</option>
                    <option value="returned">Returned</option>
                    <option value="lost">Lost</option>
                </select>

                <label>Date Received:</label>
                <input type="datetime-local" name="date_received">

                <label>Costume Image:</label>
                <input type="file" name="image" accept="image/*" style="width:100%;padding:8px;margin-bottom:10px;"
                    required>

                <button type="submit"
                    style="background:#31708f;color:white;padding:8px 12px;border:none;border-radius:6px;width:100%;cursor:pointer;">
                    SAVE COSTUME
                </button>
                <div id="addLoadingBar"
                    style="display:none;width:100%;height:5px;background:#ddd;border-radius:4px;margin-bottom:10px;">
                    <div id="addLoadingFill"
                        style="width:0%;height:100%;background:#31708f;border-radius:4px;transition:width 0.3s;">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div id="editCostumeModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeEditCostumeModal">&times;</span>
            <h2>Edit Costume</h2>

            <form id="editCostumeForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="editCostumeID">

                <label>Event ID:</label>
                <input type="number" name="editEvent_id" id="editEventID">
                <label>Update Name:</label>
                <input type="text" name="name" id="editCostumeName" style="width:100%;padding:8px;margin-bottom:10px;"
                    required>

                <label>Costume Description:</label>
                <textarea id="editDescription" name="description" style="width:100%;padding:8px;margin-bottom:10px;"
                    required></textarea>

                <label>Date Received:</label>
                <input type="datetime-local" name="date_received" id="edit_date_received">

                <label>Status:</label>
                <select name="status" id="editStatus" style="width:100%;padding:8px;margin-bottom:10px;">
                    <option value="damage">Damage</option>
                    <option value="returned">Returned</option>
                    <option value="lost">Lost</option>
                </select>

                <label>Update Image:</label>
                <input type="file" name="image" accept="image/*" style="width:100%;padding:8px;margin-bottom:10px;">
                <img src="" id="editImage" />
                <button type="submit"
                    style="background:#f5a623;color:white;padding:8px 12px;border:none;border-radius:6px;width:100%;cursor:pointer;">
                    UPDATE COSTUME
                </button>
            </form>
        </div>
    </div>

    {{-- View Costume Modal --}}
    <div id="costumeModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeCostumeModal">&times;</span>
            <h2 id="costumeModalTitle"></h2>

            <p><b>Name:</b> <span id="costumeModalName"></span></p>
            <p><b>Description:</b> <span id="costumeModalDescription"></span></p>
            <p><b>Status:</b> <span id="costumeModalStatus"></span></p>
            <p><b>Date Returned:</b> <span id="costumeModalReturned"></span></p>
            <p><b>Date Lost:</b> <span id="costumeModalLost"></span></p>
            <p><b>Date Complied:</b> <span id="costumeModalComplied"></span></p>

            <div id="costumeModalPreviewIMG"> </div>
            <div id="lostReportSection" style="margin-top:10px; display:none;">
                <p><b>Lost Report Images:</b></p>
                <div id="costumeReportImages" style="display:flex; gap:8px; flex-wrap:wrap;"></div>

                <p style="margin-top:8px;"><b>Report Detail:</b></p>
                <p id="costumeReportDetail"></p>
            </div>

        </div>
    </div>


    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            overflow: none;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-card {
            background-color: #fff;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 400px;
            border-radius: 8px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 10px;
        }

        .close:hover {
            color: #000;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ---------------- ADD COSTUME ----------------
            const addModal = document.getElementById('addCostumeModal');
            document.getElementById('openAddCostumeModal').onclick = () => addModal.style.display = 'block';
            document.getElementById('closeAddCostumeModal').onclick = () => addModal.style.display = 'none';

            // ---------------- ADD COSTUME ----------------
            document.getElementById('addCostumeForm').addEventListener('submit', e => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const loadingBar = document.getElementById('addLoadingBar');
                const loadingFill = document.getElementById('addLoadingFill');

                // Show loading bar
                loadingBar.style.display = 'block';
                loadingFill.style.width = '10%';

                // Slowly animate to 70% while waiting for fetch
                let progress = 10;
                const interval = setInterval(() => {
                    if (progress < 70) {
                        progress += 5;
                        loadingFill.style.width = progress + "%";
                    }
                }, 200);
                fetch('/admin/costumes', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(res => res.json())
                    .then(() => {
                        // Finish loading animation
                        clearInterval(interval);
                        loadingFill.style.width = "100%";

                        setTimeout(() => {
                            loadingBar.style.display = 'none';
                            loadingFill.style.width = "0%";
                            location.reload();
                        }, 300);
                    })
                    .catch(() => {
                        clearInterval(interval);
                        loadingFill.style.background = "red";
                        loadingFill.style.width = "100%";

                        setTimeout(() => {
                            loadingFill.style.width = "0%";
                            loadingBar.style.display = "none";
                            alert("Failed to save costume. Try again.");
                        }, 700);
                    });
            });


            // ---------------- EDIT COSTUME ----------------
            const editModal = document.getElementById('editCostumeModal');
            document.getElementById('closeEditCostumeModal').onclick = () => editModal.style.display = 'none';

            document.querySelectorAll('.edit-costume-btn').forEach(btn => {
                btn.onclick = () => {
                    fetch(`/admin/costumes/${btn.dataset.id}`)
                        .then(r => r.json())
                        .then(data => {
                            document.getElementById('editCostumeID').value = data.id;
                            document.getElementById('editEventID').value = data.event_id;
                            document.getElementById('edit_date_received').value = data.date_received;
                            document.getElementById('editDescription').value = data.description;
                            document.getElementById('editImage').src = '/' + data.img;
                            document.getElementById('editCostumeName').value = data.name;
                            document.getElementById('editStatus').value = data.status;
                            editModal.style.display = 'block';
                        });
                };
            });

            document.getElementById('editCostumeForm').addEventListener('submit', e => {
                e.preventDefault();
                const id = document.getElementById('editCostumeID').value;
                const formData = new FormData(e.target);
                formData.append('_method', 'PUT');

                fetch(`/admin/costumes/${id}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(() => location.reload());
            });

            // ---------------- DELETE COSTUME ----------------
            document.querySelectorAll('.delete-costume-btn').forEach(btn => {
                btn.onclick = () => {
                    if (!confirm('Delete this costume?')) return;

                    fetch(`/admin/costumes/${btn.dataset.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => location.reload());
                };
            });

            const modal = document.getElementById('costumeModal');
            const closeBtn = document.getElementById('closeCostumeModal');

            document.querySelectorAll('.view-costume-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    fetch(`/admin/costumes/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('costumeModalTitle').textContent = "Costume #" + data
                                .id;
                            document.getElementById('costumeModalName').textContent = data.name ?? '—';
                            document.getElementById('costumeModalStatus').textContent = data.status ?? '—';
                            document.getElementById('costumeModalDescription').textContent = data.description ?? '—';

                            document.getElementById('costumeModalReturned').textContent = data
                                .date_returned ?? '—';
                            document.getElementById('costumeModalLost').textContent = data.date_lost ?? '—';
                            document.getElementById('costumeModalComplied').textContent = data
                                .date_complied ?? '—';

                            const reportSection = document.getElementById('lostReportSection');
                            const imgContainer = document.getElementById('costumeReportImages');
                            const costumeModalPreviewIMG = document.getElementById('costumeModalPreviewIMG');
                            const detailContainer = document.getElementById('costumeReportDetail');

                            costumeModalPreviewIMG.innerHTML = '';
                            imgContainer.innerHTML = '';
                            detailContainer.textContent = '';

                            if (data.status === 'lost') {
                                reportSection.style.display = 'block';

                                detailContainer.textContent = data.report_detail ?? '—';

                                (data.report_img || []).forEach(img => {
                                    const image = document.createElement('img');
                                    image.src = `/${img}`;
                                    image.style.width = '100px';
                                    image.style.borderRadius = '6px';
                                    imgContainer.appendChild(image);
                                });
                            } else {
                                reportSection.style.display = 'none';
                                if (data.img) {

                                    const image = document.createElement('img');
                                    image.src = `/${data.img}`;
                                    image.style.width = '100px';
                                    image.style.borderRadius = '6px';
                                    costumeModalPreviewIMG.appendChild(image);
                                }
                            }

                            modal.style.display = 'block';
                        });
                });
            });

            closeBtn.addEventListener('click', () => modal.style.display = 'none');
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });
        });
    </script>
@endpush