@extends('layouts.app')

@section('content')
    <div style="padding: 20px; max-width: 900px; margin: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2 style="color: #b22222;">MANAGE PERFORMER ACCOUNTS</h2>
            <button id="openAddModal"
                style="background: #4CAF50; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">
                ➕ Add Account
            </button>
        </div>

        @if (session('success'))
            <div style="background: #d4edda; color: #155724; padding: 8px; margin-bottom: 10px; border-radius: 4px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background: #31708f; color: white;">
                    <th style="padding: 8px; border: 1px solid #ddd;">PERFORMER ID</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Name</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr style="background-color: rgb(228, 228, 228);">
                        <td style="padding: 8px; border: 1px solid #ddd;">Performer {{ $index + 1 }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->name }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ ucfirst($user->type) }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">
                            <button class="editBtn" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}" data-type="{{ $user->type }}"
                                style="background: #4CAF50; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer;">
                                UPDATE
                            </button>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')"
                                    style="background: #e74c3c; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer;">
                                    REMOVE
                                </button>
                            </form>
                            <button class="viewBtn" data-id="Performer {{ $index + 1 }}" data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}" data-type="{{ ucfirst($user->type) }}"
                                style="background: orange; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer;">
                                VIEW
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h3>Add Account</h3>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div>
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div>
                    <label>Type</label>
                    <select name="type" required>
                        <option value="user">Performer</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h3>Update Account</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label>Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" required>
                </div>
                <div>
                    <label>New Password (optional)</label>
                    <input type="password" name="password">
                </div>
                <div>
                    <label>Type</label>
                    <select name="type" id="editType" required>
                        <option value="user">Performer</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeViewModal">&times;</span>
            <h3>View Performer</h3>

            <div>
                <label>Performer ID</label>
                <input type="text" id="viewId" readonly>
            </div>

            <div>
                <label>Name</label>
                <input type="text" id="viewName" readonly>
            </div>

            <div>
                <label>Email</label>
                <input type="text" id="viewEmail" readonly>
            </div>

            <div>
                <label>Type</label>
                <input type="text" id="viewType" readonly>
            </div>

            <button onclick="document.getElementById('viewModal').style.display='none'">
                Close
            </button>
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
            background: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 400px;
            margin: 8% auto;
            padding: 20px;
            border-radius: 6px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 8px;
            font-size: 22px;
            cursor: pointer;
        }

        .modal-content form div {
            margin-bottom: 10px;
        }

        .modal-content input,
        .modal-content select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        .modal-content button {
            background: #31708f;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>

    <script>
        // View Modal Close Button
        document.getElementById('closeViewModal').onclick = () => {
            document.getElementById('viewModal').style.display = 'none';
        };

        // View Buttons Logic
        document.querySelectorAll('.viewBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('viewId').value = btn.getAttribute('data-id');
                document.getElementById('viewName').value = btn.getAttribute('data-name');
                document.getElementById('viewEmail').value = btn.getAttribute('data-email');
                document.getElementById('viewType').value = btn.getAttribute('data-type');

                document.getElementById('viewModal').style.display = 'block';
            });
        });

        document.getElementById('openAddModal').onclick = () => {
            document.getElementById('addModal').style.display = 'block';
        }
        document.getElementById('closeAddModal').onclick = () => {
            document.getElementById('addModal').style.display = 'none';
        }

        document.getElementById('closeEditModal').onclick = () => {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = (e) => {
            if (e.target == document.getElementById('addModal')) document.getElementById('addModal').style.display =
                'none';
            if (e.target == document.getElementById('editModal')) document.getElementById('editModal').style.display =
                'none';
        }

        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                document.getElementById('editName').value = btn.getAttribute('data-name');
                document.getElementById('editEmail').value = btn.getAttribute('data-email');
                document.getElementById('editType').value = btn.getAttribute('data-type');
                document.getElementById('editForm').action = `/users/${id}`;
                document.getElementById('editModal').style.display = 'block';
            });
        });
    </script>
@endsection
