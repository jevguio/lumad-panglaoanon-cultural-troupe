@extends('layouts.app')

@section('content')
    <h2 style="color:#b22222; margin-bottom:20px;">COSTUME STATUS</h2>

    @foreach ($performers as $performer)
        @if ($performer->id === Auth::user()->id)
            <div style="margin-bottom:25px; border:1px solid #ddd; border-radius:8px; overflow:hidden;">


                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#31708f;color:white; text-align:left;">
                            <th style="padding:8px; border:1px solid #ddd;">Costume ID</th>
                            <th style="padding:8px; border:1px solid #ddd;">Details</th>
                            <th style="padding:8px; border:1px solid #ddd;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($performer->costumes as $costume)
                            <tr style="background:#f2f2f2;">
                                <td style="padding:8px; border:1px solid #ddd;">Costume {{ $costume->id }}</td>

                                <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                                    <button class="view-costume-btn" data-id="{{ $costume->id }}"
                                        style="background:#f5a623; color:white; border:none; padding:5px 10px; border-radius:4px;">
                                        VIEW
                                    </button>
                                    @if ($costume->status != 'lost')
                                        <button class="costume-action-btn" data-id="{{ $costume->id }}"
                                            style="background:#31708f; color:white; border:none; padding:5px 10px; border-radius:4px;">
                                            ACTION
                                        </button>
                                    @endif
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
        @endif
    @endforeach
    <div style="margin-bottom:25px; border:1px solid #ddd; border-radius:8px; overflow:hidden;">
        <div style="background:#31708f; color:white; padding:10px; font-weight:bold;">
            AVAILABLE COSTUME
        </div>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#31708f;color:white; text-align:left;">
                    <th style="padding:8px; border:1px solid #ddd;">Costume ID</th>
                    <th style="padding:8px; border:1px solid #ddd;">Costume Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($costumes as $costume)
                    <tr style="background-color:#f2f2f2">
                        <td style="padding:8px; border:1px solid #ddd;">Costume {{ $costume->id }}</td>
                        <td style="padding:8px; border:1px solid #ddd; text-align:center;">
                            <button class="view-costume-btn" data-id="{{ $costume->id }}"
                                style="background:#f5a623; color:white; border:none; padding:5px 10px; border-radius:4px;">
                                VIEW
                            </button>

                            <button class="costume-action-btn" data-id="{{ $costume->id }}"
                                style="background:#31708f; color:white; border:none; padding:5px 10px; border-radius:4px;">
                                ACTION
                            </button>
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
    {{-- ============================= --}}
    {{-- View Costume Modal --}}
    {{-- ============================= --}}
    <div id="costumeModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeCostumeModal">&times;</span>
            <h2 id="costumeModalTitle"></h2>

            <p><b>Status:</b> <span id="costumeModalStatus"></span></p>
            <p><b>Date Returned:</b> <span id="costumeModalReturned"></span></p>
            <p><b>Date Lost:</b> <span id="costumeModalLost"></span></p>
            <p><b>Date Complied:</b> <span id="costumeModalComplied"></span></p>
            <img id="costumeModalPreviewIMG"   width="100">
            @foreach (json_decode($costume->report_img ?? '[]') as $img)
                <img src="{{ asset( $img) }}" width="100">
            @endforeach
            <div id="lostReportSection2" style="margin-top:10px; display:none;">
                <p><b>Lost Report Images:</b></p>
                <div id="costumeReportImages" style="display:flex; gap:8px; flex-wrap:wrap;"></div>

                <p style="margin-top:8px;"><b>Report Detail:</b></p>
                <p id="costumeReportDetail"></p>
            </div>
        </div>
    </div>


    {{-- ============================= --}}
    {{-- Performer Action Modal --}}
    {{-- ============================= --}}
    <div id="costumeActionModal" class="modal">
        <div class="modal-card">
            <span class="close" id="closeCostumeAction">&times;</span>
            <h2 id="actionModalTitle"></h2>

            <p><b>Status:</b> <span id="actionModalStatus"></span></p>
            <div id="lostReportSection" style="margin-top:15px; ">
                <label><b>Detailed Report</b></label>
                <textarea id="reportDetail" rows="4" style="width:100%; padding:8px; margin-top:5px;"></textarea>

                <label style="margin-top:10px;"><b>Upload Images</b></label>
                <input type="file" id="reportImages" multiple accept="image/*" style="margin-top:5px;">
            </div>
            <div style="margin-top:15px;">
                <button id="borrowBtn" class="action-btn" style="background:#4CAF50;">BORROW</button>
                <button id="returnBtn" class="action-btn" style="background:#2196F3;">RETURN</button>
                <button id="lostBtn" class="action-btn" style="background:#f44336;">REPORT LOST</button>
                <button id="CNFlostBtn" class="action-btn" style="background:#f44336;">CONFIRM LOST</button>
            </div>
        </div>
    </div>


    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .modal-card {
            background: white;
            margin: 8% auto;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            cursor: pointer;
            font-size: 24px;
        }

        .action-btn {
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 8px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // -----------------------
        // VIEW COSTUME MODAL
        // -----------------------
        const modal = document.getElementById('costumeModal');
        const closeBtn = document.getElementById('closeCostumeModal');
        const lostReportSection = document.getElementById('lostReportSection');
        const lostBtn = document.getElementById('lostBtn');
        const returnBtn = document.getElementById('returnBtn');
        const CNFlostBtn = document.getElementById('CNFlostBtn');
        lostBtn.onclick = () => {
            lostReportSection.style.display = 'block';
            lostBtn.style.display = 'none';
            CNFlostBtn.style.display = 'block';
        };

        document.querySelectorAll('.view-costume-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                fetch(`/performer/costume/${btn.dataset.id}`)
                    .then(r => r.json()).
                then(data => {
                    document.getElementById('costumeModalTitle').textContent = "Costume #" + data
                        .id;
                    document.getElementById('costumeModalStatus').textContent = data.status ?? '—';
                    document.getElementById('costumeModalReturned').textContent = data
                        .date_returned ?? '—';
                    document.getElementById('costumeModalLost').textContent = data.date_lost ?? '—';
                    document.getElementById('costumeModalComplied').textContent = data
                        .date_complied ?? '—';

                    const reportSection = document.getElementById('lostReportSection2');
                    const imgContainer = document.getElementById('costumeReportImages');
                    const detailContainer = document.getElementById('costumeReportDetail');

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
                            const image = document.createElement('img');
                            image.src = `/${img}`;
                            image.style.width = '100px';
                            image.style.borderRadius = '6px';
                            imgContainer.appendChild(data.img);
                    }

                    modal.style.display = 'block';
                });
            });
        });

        closeBtn.onclick = () => modal.style.display = 'none';



        // -----------------------
        // ACTION MODAL
        // -----------------------
        const actionModal = document.getElementById('costumeActionModal');
        const closeAction = document.getElementById('closeCostumeAction');
        let selectedCostumeId = null;

        document.querySelectorAll('.costume-action-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedCostumeId = btn.dataset.id;

                fetch(`/performer/costume/${selectedCostumeId}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.status == "borrowed") {

                            document.getElementById('borrowBtn').style.display = 'none';
                            CNFlostBtn.style.display = 'none';
                            lostReportSection.style.display = 'none';
                        } else {

                            document.getElementById('borrowBtn').style.display = 'block';
                            CNFlostBtn.style.display = 'none';
                            lostReportSection.style.display = 'none';
                            lostBtn.style.display = 'none';
                            returnBtn.style.display = 'none';
                        }
                        document.getElementById('actionModalTitle').textContent = "Costume #" + data.id;
                        document.getElementById('actionModalStatus').textContent = data.status;
                        actionModal.style.display = 'block';
                    });
            });
        });

        closeAction.onclick = () => actionModal.style.display = 'none';



        // -----------------------
        // ACTION BUTTONS
        // -----------------------
        function updateCostumeAction(actionType) {

            if (actionType === 'lost') {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('report_detail', document.getElementById('reportDetail').value);

                const files = document.getElementById('reportImages').files;
                for (let i = 0; i < files.length; i++) {
                    formData.append('report_img[]', files[i]);
                }

                fetch(`/performer/costume/${selectedCostumeId}/lost`, {
                    method: 'POST',
                    body: formData
                }).then(() => location.reload());

                return;
            }

            // Normal actions
            fetch(`/performer/costume/${selectedCostumeId}/${actionType}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }).then(() => location.reload());
        }

        document.getElementById('borrowBtn').onclick = () => updateCostumeAction('borrow');
        document.getElementById('returnBtn').onclick = () => updateCostumeAction('return');
        document.getElementById('CNFlostBtn').onclick = () => updateCostumeAction('lost');

        window.onclick = e => {
            if (e.target === modal) modal.style.display = 'none';
            if (e.target === actionModal) actionModal.style.display = 'none';
        };
    </script>
@endpush
