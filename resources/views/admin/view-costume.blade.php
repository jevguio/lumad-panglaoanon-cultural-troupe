@extends('layouts.app')

@section('content')
    <h2 style="color:#b22222; margin-bottom:20px;">COSTUME STATUS</h2>
 
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
                                    VIEW COSTUME
                                </button>
                            </td>
                            <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                                <span
                                    style="
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
 
    {{-- View Costume Modal --}}
    <div id="costumeModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeCostumeModal">&times;</span>
            <h2 id="costumeModalTitle"></h2>

            <p><b>Status:</b> <span id="costumeModalStatus"></span></p>
            <p><b>Date Returned:</b> <span id="costumeModalReturned"></span></p>
            <p><b>Date Lost:</b> <span id="costumeModalLost"></span></p>
            <p><b>Date Complied:</b> <span id="costumeModalComplied"></span></p>

            <div id="costumeModalPreviewIMG"   > </div>
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
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-card {
            background-color: #fff;
            margin: 8% auto;
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
        document.addEventListener("DOMContentLoaded", function() {
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
                    body: formData
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
                        document.getElementById('costumeModalStatus').textContent = data.status ?? '—';
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
