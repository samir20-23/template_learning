@extends('layouts.stylepages')

@section('title', 'Edit User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-user-edit"></i>
            Edit User
        </h1>
        <div>
            <a href="{{ route('users.show', $user) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> View User
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Edit User Information" theme="warning" collapsible>
                <form action="{{ route('users.update', $user) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Current User Info -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Current Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name:</strong> {{ $user->name }}<br>
                                <strong>Email:</strong> {{ $user->email }}<br>
                                <strong>Role:</strong>
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
                            </div>
                            <div class="col-md-6">
                                <strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}<br>
                                <strong>Documents:</strong> {{ $user->documents_count }}<br>
                                <strong>Validations:</strong> {{ $user->validations_count }}
                            </div>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter full name...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}" required
                            placeholder="Enter email address...">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="form-group">
                        <label for="role">
                            <i class="fas fa-user-tag"></i>
                            User Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                            required>
                            <option value="User" {{ old('role', $user->role) === 'User' ? 'selected' : '' }}>
                                Regular User
                            </option>
                            <option value="Formateur" {{ old('role', $user->role) === 'Formateur' ? 'selected' : '' }}>
                                Formateur
                            </option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($user->id === Auth::id())
                            <small class="form-text text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                You are editing your own account. Be careful when changing your role.
                            </small>
                        @endif
                    </div>

                    <!-- Password Section -->
                    <hr>
                    <h5><i class="fas fa-lock"></i> Change Password (Optional)</h5>
                    <p class="text-muted">Leave password fields empty to keep current password.</p>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            New Password
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter new password...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Password must be at least 8 characters long.
                        </small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-lock"></i>
                            Confirm New Password
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm new password...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="passwordConfirmationIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="form-group" id="passwordStrengthContainer" style="display: none;">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="form-text text-muted">Password strength</small>
                    </div>

                    <!-- Submit Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg" id="updateBtn">
                                <i class="fas fa-save"></i> Update User
                            </button>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                        <div>
                            @if ($user->id !== Auth::id() && $user->documents_count == 0)
                                <button type="button" class="btn btn-outline-danger" onclick="deleteUser()">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                            @elseif($user->documents_count > 0)
                                <button type="button" class="btn btn-outline-secondary" disabled
                                    title="Cannot delete - user has documents">
                                    <i class="fas fa-lock"></i> Cannot Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- User Info Sidebar -->
        <div class="col-md-4">
            <!-- Current User Preview -->
            <x-adminlte-card title="User Preview" theme="info" collapsible>
                <div class="text-center">
                    <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 id="previewName">{{ $user->name }}</h5>
                    <p id="previewEmail" class="text-muted">{{ $user->email }}</p>
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
                </div>
            </x-adminlte-card>

            <!-- User Statistics -->
            <x-adminlte-card title="User Statistics" theme="success" collapsible>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Documents:</strong></td>
                        <td>
                            <span class="badge badge-info">{{ $user->documents_count }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Validations:</strong></td>
                        <td>
                            <span class="badge badge-success">{{ $user->validations_count }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Joined:</strong></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $user->updated_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if ($user->email_verified_at)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="text-center">
                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View Full Profile
                    </a>
                </div>
            </x-adminlte-card>

            <!-- Quick Actions -->
            <x-adminlte-card title="Quick Actions" theme="warning" collapsible>
                <div class="btn-group-vertical w-100">
                    <a href="{{ route('documents.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">
                        <i class="fas fa-file"></i> View User's Documents
                    </a>
                    @if ($user->isAdmin())
                        <a href="{{ route('validations.index', ['validator' => $user->id]) }}"
                            class="btn btn-outline-success">
                            <i class="fas fa-check-circle"></i> View Validations
                        </a>
                    @endif
                    <button type="button" class="btn btn-outline-warning" onclick="generatePassword()">
                        <i class="fas fa-key"></i> Generate New Password
                    </button>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  style="opacity: 0;"  data-dismiss="modal">Cancel</button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
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
            border-radius: 50%;
            background: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .password-strength-weak {
            background-color: #dc3545;
        }

        .password-strength-medium {
            background-color: #ffc107;
        }

        .password-strength-strong {
            background-color: #28a745;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Live preview
            $('#name').on('input', function() {
                const name = $(this).val() || '{{ $user->name }}';
                $('#previewName').text(name);
            });

            $('#email').on('input', function() {
                const email = $(this).val() || '{{ $user->email }}';
                $('#previewEmail').text(email);
            });

            $('#role').on('change', function() {
                const role = $(this).val();

                if (role === 'admin') {
                    $('#previewRole').removeClass('badge-primary').addClass('badge-danger').text(
                        'Administrator');
                } else {
                    $('#previewRole').removeClass('badge-danger').addClass('badge-primary').text(
                        'Regular User');
                }
            });

            // Password strength checker
            $('#password').on('input', function() {
                const password = $(this).val();
                if (password.length > 0) {
                    $('#passwordStrengthContainer').show();
                    checkPasswordStrength(password);
                } else {
                    $('#passwordStrengthContainer').hide();
                }
            });

            // Form validation
            $('#editForm').submit(function(e) {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();

                if (password && password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    return false;
                }

                $('#updateBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Updating...');
            });
        });

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + 'Icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let strengthText = '';
            let strengthClass = '';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            const percentage = (strength / 5) * 100;

            if (strength < 3) {
                strengthText = 'Weak password';
                strengthClass = 'password-strength-weak';
            } else if (strength < 5) {
                strengthText = 'Medium strength password';
                strengthClass = 'password-strength-medium';
            } else {
                strengthText = 'Strong password';
                strengthClass = 'password-strength-strong';
            }

            $('#passwordStrength').css('width', percentage + '%').removeClass().addClass('progress-bar ' + strengthClass);
            $('#passwordStrengthText').text(strengthText);
        }

        function generatePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
            let password = "";

            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }

            $('#password').val(password);
            $('#password_confirmation').val(password);
            $('#passwordStrengthContainer').show();
            checkPasswordStrength(password);

            // Show generated password temporarily
            $('#password').attr('type', 'text');
            $('#password_confirmation').attr('type', 'text');

            setTimeout(function() {
                $('#password').attr('type', 'password');
                $('#password_confirmation').attr('type', 'password');
            }, 3000);
        }

        function deleteUser() {
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
