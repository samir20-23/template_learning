@extends('layouts.stylepages')


@section('title', 'User Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-users"></i>
            User Management
        </h1>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Add User
            </a>
            <a href="{{ route('users.export') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['admins'] }}</h3>
                    <p>Administrators</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['regular_users'] }}</h3>
                    <p>Regular Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['total_documents'] }}</h3>
                    <p>Total Documents</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <x-adminlte-card title="Users" theme="primary" collapsible>
        <!-- Search and Filters -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search users..."
                        value="{{ $search }}">
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-control">
                        <option value="">All Roles</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="Formateur" {{ $role === 'Formateur' ? 'selected' : '' }}>Formateur</option>

                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-control">
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Sort by Name</option>
                        <option value="email" {{ $sort === 'email' ? 'selected' : '' }}>Sort by Email</option>
                        <option value="role" {{ $sort === 'role' ? 'selected' : '' }}>Sort by Role</option>
                        <option value="documents_count" {{ $sort === 'documents_count' ? 'selected' : '' }}>Sort by
                            Documents</option>
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-control">
                        <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form id="bulkActionForm" method="POST" action="{{ route('users.bulk-action') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger" onclick="bulkAction('delete')">
                            <i class="fas fa-trash"></i> Delete Selected
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <span id="selectedCount" class="badge badge-info">0 selected</span>
                </div>
            </div>

            <!-- Users Table -->
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Documents</th>
                                <th>Validations</th>
                                <th>Joined</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                                class="custom-control-input user-checkbox" id="user{{ $user->id }}"
                                                {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                            <label class="custom-control-label" for="user{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user) }}"
                                            class="d-flex align-items-center text-decoration-none text-dark">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary text-white mr-3"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        {{ $user->name }}
                                                        @if ($user->id === Auth::id())
                                                            <span class="badge badge-primary badge-sm">You</span>
                                                        @endif
                                                    </h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </td>

                                    <td>
                                        @if ($user->isAdmin())
                                            <span class="badge badge-danger">
                                                <i class="fas fa-user-shield"></i> Admin
                                            </span>
                                        @elseif ($user->isFormateur())
                                            <span class="badge" style="background-color: #5354e9; color: white;">
                                                <i class="fas fa-user-shield"></i> Formateur
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-user"></i> User
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $user->documents_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $user->validations_count }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-info"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($user->id !== Auth::id())
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-5x text-muted mb-3"></i>
                    <h4 class="text-muted">No users found</h4>
                    <p class="text-muted">No users match your search criteria.</p>
                </div>
            @endif
        </form>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </x-adminlte-card>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button type="button" class="close" style="opacity: 0;" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Are you sure you want to delete this user?</p>
                    <div id="userInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="opacity: 0;" >Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #6c757d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#selectAll').change(function() {
                $('.user-checkbox:not(:disabled)').prop('checked', this.checked);
                updateSelectedCount();
            });

            $('.user-checkbox').change(function() {
                updateSelectedCount();
            });

            function updateSelectedCount() {
                const count = $('.user-checkbox:checked').length;
                $('#selectedCount').text(count + ' selected');
            }
        });

        function deleteUser(userId, userName) {
            $('#userInfo').html(`<strong>User:</strong> ${userName}`);
            $('#deleteForm').attr('action', `/users/${userId}`);
            $('#deleteModal').modal('show');
        }

        function bulkAction(action) {
            const selectedIds = $('.user-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Please select at least one user.');
                return;
            }

            const actionNames = {
                'delete': 'delete',
                'make_admin': 'make admin',
                'make_Formateur': 'make Formateur',
                'make_user': 'make regular user'
            };

            if (confirm(`Are you sure you want to ${actionNames[action]} ${selectedIds.length} user(s)?`)) {
                $('#bulkActionForm').find('input[name="action"]').remove();
                $('#bulkActionForm').append(`<input type="hidden" name="action" value="${action}">`);
                $('#bulkActionForm').submit();
            }
        }
    </script>
@endpush
