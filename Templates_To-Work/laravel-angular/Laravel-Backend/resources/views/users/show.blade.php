@extends('layouts.stylepages')


@section('title', $user->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-user"></i>
            {{ $user->name }}
            @if ($user->id === Auth::id())
                <span class="badge badge-primary">You</span>
            @endif
        </h1>
        <div>
            @if ($user->id === Auth::id())
                <a href="{{ route('users.profile') }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            @else
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit User
                </a>
            @endif
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to Users
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- User Information -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <x-adminlte-card title="User Information" theme="primary" collapsible>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Full Name:</strong></td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>
                                    {{ $user->email }}
                                    @if ($user->email_verified_at)
                                        <span class="badge badge-success badge-sm ml-2">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge badge-warning badge-sm ml-2">
                                            <i class="fas fa-clock"></i> Unverified
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
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
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Member Since:</strong></td>
                                <td>
                                    {{ $user->created_at->format('F d, Y \a\t H:i') }}
                                    <br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>
                                    {{ $user->updated_at->format('F d, Y \a\t H:i') }}
                                    <br>
                                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-success badge-lg">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Action Buttons -->
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-tools"></i> Actions</h6>
                        <div class="btn-group">
                            <a href="{{ route('documents.index', ['user' => $user->id]) }}" class="btn btn-primary">
                                <i class="fas fa-file"></i> View Documents ({{ $user->documents_count }})
                            </a>
                            @if ($user->isAdmin())
                                <a href="{{ route('validations.index', ['validator' => $user->id]) }}"
                                    class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> View Validations ({{ $user->validations_count }})
                                </a>
                            @endif
                            @if ($user->id === Auth::id())
                                <a href="{{ route('users.profile') }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                            @else
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                @if ($user->documents_count == 0)
                                    <button type="button" class="btn btn-danger" onclick="deleteUser()">
                                        <i class="fas fa-trash"></i> Delete User
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- User Statistics -->
            <x-adminlte-card title="Activity Statistics" theme="info" collapsible>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border-right">
                            <h3 class="text-primary">{{ $user->documents_count }}</h3>
                            <p class="text-muted">Total Documents</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-right">
                            <h3 class="text-success">{{ $user->validations_count }}</h3>
                            <p class="text-muted">Validations Performed</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-info">{{ $user->created_at->diffInDays(now()) }}</h3>
                        <p class="text-muted">Days as Member</p>
                    </div>
                </div>

                <!-- Documents by Status Chart -->
                @if (!empty($userStats['documents_by_status']))
                    <hr>
                    <h6><i class="fas fa-chart-pie"></i> Documents by Status</h6>
                    <div class="row">
                        @foreach ($userStats['documents_by_status'] as $status => $count)
                            <div class="col-md-4 text-center">
                                <div class="progress-group">
                                    @php
                                        $badgeClass = match ($status) {
                                            'published' => 'success',
                                            'draft' => 'warning',
                                            'archived' => 'secondary',
                                            default => 'primary',
                                        };
                                        $percentage =
                                            $user->documents_count > 0
                                                ? round(($count / $user->documents_count) * 100)
                                                : 0;
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }} badge-lg">
                                        {{ ucfirst($status) }}: {{ $count }}
                                    </span>
                                    <div class="progress progress-sm mt-2">
                                        <div class="progress-bar bg-{{ $badgeClass }}"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $percentage }}%</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Validations by Status Chart (for admins) -->
                @if ($user->isAdmin() && !empty($userStats['validations_by_status']))
                    <hr>
                    <h6><i class="fas fa-chart-bar"></i> Validations by Status</h6>
                    <div class="row">
                        @foreach ($userStats['validations_by_status'] as $status => $count)
                            <div class="col-md-4 text-center">
                                <div class="progress-group">
                                    @php
                                        $badgeClass = match ($status) {
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            'pending' => 'warning',
                                            'blocked' => 'dark',
                                            default => 'primary',
                                        };
                                        $percentage =
                                            $user->validations_count > 0
                                                ? round(($count / $user->validations_count) * 100)
                                                : 0;
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }} badge-lg">
                                        {{ ucfirst($status) }}: {{ $count }}
                                    </span>
                                    <div class="progress progress-sm mt-2">
                                        <div class="progress-bar bg-{{ $badgeClass }}"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $percentage }}%</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-adminlte-card>

            <!-- Recent Documents -->
            <x-adminlte-card title="Recent Documents" theme="success" collapsible>
                @if ($recentDocuments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Validation</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentDocuments as $document)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $document->getFileIcon() }} mr-2"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ Str::limit($document->title, 30) }}</h6>
                                                    <small
                                                        class="text-muted">{{ $document->getFormattedFileSize() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $document->categorie->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $document->getStatusBadgeClass() }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $document->getValidationBadgeClass() }}">
                                                {{ $document->getValidationStatus() }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $document->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('documents.show', $document) }}" class="btn btn-info"
                                                    title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ $document->getDownloadUrl() }}" class="btn btn-success"
                                                    title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('documents.index', ['user' => $user->id]) }}" class="btn btn-primary">
                            <i class="fas fa-list"></i> View All Documents
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No documents yet</h5>
                        <p class="text-muted">This user hasn't uploaded any documents.</p>
                        @if ($user->id === Auth::id())
                            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Upload First Document
                            </a>
                        @endif
                    </div>
                @endif
            </x-adminlte-card>

            <!-- Recent Validations (for admins) -->
            @if ($user->isAdmin() && $recentValidations->count() > 0)
                <x-adminlte-card title="Recent Validations" theme="warning" collapsible>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentValidations as $validation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $validation->document->getFileIcon() }} mr-2"></i>
                                                <span>{{ Str::limit($validation->document->title, 30) }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $validation->document->user->name }}</td>
                                        <td>
                                            <span class="badge {{ $validation->getStatusBadgeClass() }}">
                                                {{ ucfirst($validation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $validation->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('validations.show', $validation) }}"
                                                    class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('documents.show', $validation->document) }}"
                                                    class="btn btn-success" title="View Document">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('validations.index', ['validator' => $user->id]) }}" class="btn btn-warning">
                            <i class="fas fa-list"></i> View All Validations
                        </a>
                    </div>
                </x-adminlte-card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- User Avatar & Quick Info -->
            <x-adminlte-card title="User Profile" theme="primary" collapsible>
                <div class="text-center">
                    <div class="avatar-circle-large mb-3">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>

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

                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-primary">{{ $user->documents_count }}</h5>
                            <small class="text-muted">Documents</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success">{{ $user->validations_count }}</h5>
                            <small class="text-muted">Validations</small>
                        </div>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Quick Actions -->
            <x-adminlte-card title="Quick Actions" theme="success" collapsible>
                <div class="btn-group-vertical w-100">
                    <a href="{{ route('documents.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">
                        <i class="fas fa-file"></i> View User Documents
                    </a>
                    @if ($user->isAdmin())
                        <a href="{{ route('validations.index', ['validator' => $user->id]) }}"
                            class="btn btn-outline-success">
                            <i class="fas fa-check-circle"></i> View Validations
                        </a>
                    @endif
                    @if ($user->id === Auth::id())
                        <a href="{{ route('users.profile') }}" class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit My Profile
                        </a>
                        <a href="{{ route('documents.create') }}" class="btn btn-outline-info">
                            <i class="fas fa-plus"></i> Upload Document
                        </a>
                    @else
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                    @endif
                </div>
            </x-adminlte-card>

            <!-- User Timeline -->
            <x-adminlte-card title="User Timeline" theme="dark" collapsible>
                <div class="timeline timeline-sm">
                    <div class="time-label">
                        <span class="bg-primary">
                            {{ $user->updated_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-edit bg-warning"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $user->updated_at->format('H:i') }}
                            </span>
                            <h3 class="timeline-header">Profile Updated</h3>
                            <div class="timeline-body">
                                Profile was last updated {{ $user->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-user-plus bg-success"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $user->created_at->format('H:i') }}
                            </span>
                            <h3 class="timeline-header">User Joined</h3>
                            <div class="timeline-body">
                                Became a member {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- System Information -->
            <x-adminlte-card title="System Information" theme="secondary" collapsible>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>User ID:</strong></td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email Verified:</strong></td>
                        <td>
                            @if ($user->email_verified_at)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-warning">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Account Status:</strong></td>
                        <td><span class="badge badge-success">Active</span></td>
                    </tr>
                    <tr>
                        <td><strong>Last Login:</strong></td>
                        <td>
                            <small class="text-muted">
                                @if ($user->id === Auth::id())
                                    Currently online
                                @else
                                    Not tracked
                                @endif
                            </small>
                        </td>
                    </tr>
                </table>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($user->id !== Auth::id())
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                        <button type="button" class="close" style="opacity: 0;"  data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning!</strong> This action cannot be undone.
                        </div>
                        <p>Are you sure you want to delete this user?</p>
                        <p><strong>User:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        @if ($user->documents_count > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                This user has {{ $user->documents_count }} document(s).
                                You cannot delete this user until all documents are removed or reassigned.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="opacity: 0;" >Cancel</button>
                        @if ($user->documents_count == 0)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@push('css')
    <style>
        .avatar-circle-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #6c757d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto;
        }

        .progress-group {
            margin-bottom: 1rem;
        }

        .timeline-sm .timeline-item {
            margin-bottom: 10px;
        }
    </style>
@endpush

@push('js')
    <script>
        function deleteUser() {
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
