@extends('layouts.stylepages')


@section('title', 'Create User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-user-plus"></i>
            Create New User
        </h1>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to Users
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Create Form -->
        <div class="col-md-8">
            <x-adminlte-card title="User Information" theme="primary" collapsible>
                <form action="{{ route('users.store') }}" method="POST" id="createForm">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required placeholder="Enter full name...">
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
                            name="email" value="{{ old('email') }}" required placeholder="Enter email address...">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            User will receive login credentials at this email address.
                        </small>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-group">
                        <label for="role">
                            <i class="fas fa-user-tag"></i>
                            User Role <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                            required>
                            <option value="">Select Role</option>
                            <option value="User" {{ old('role') === 'User' ? 'selected' : '' }}>
                                <i class="fas fa-user"></i> Regular User
                            </option>
                            <option value="Formateur" {{ old('role') === 'Formateur' ? 'selected' : '' }}>
                                <i class="fas fa-user-shield"></i>Formateur
                            </option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                <i class="fas fa-user-shield"></i> Administrator
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="roleDescription">
                            Select the appropriate role for this user.
                        </small>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required placeholder="Enter password...">
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
                            Confirm Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required placeholder="Confirm password...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="passwordConfirmationIcon"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            Re-enter the password to confirm.
                        </small>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="form-group">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthText" class="form-text text-muted">Password strength will appear
                            here</small>
                    </div>

                    <!-- Submit Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                <i class="fas fa-user-plus"></i> Create User
                            </button>
                            <button type="button" class="btn btn-warning btn-lg" onclick="generatePassword()">
                                <i class="fas fa-key"></i> Generate Password
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Guidelines -->
        <div class="col-md-4">
            <x-adminlte-card title="User Roles" theme="info" collapsible>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Role Permissions:</strong>
                </div>

                <h6><i class="fas fa-user text-primary"></i> Regular User:</h6>
                <ul>
                    <li>Upload and manage own documents</li>
                    <li>View public documents</li>
                    <li>Download allowed documents</li>
                    <li>Update own profile</li>
                </ul>

                <h6><i class="fas fa-user-shield text-danger"></i> Administrator:</h6>
                <ul>
                    <li>All regular user permissions</li>
                    <li>Manage all users</li>
                    <li>Validate documents</li>
                    <li>Manage categories</li>
                    <li>Access admin dashboard</li>
                    <li>System configuration</li>
                </ul>
            </x-adminlte-card>

            <!-- Password Guidelines -->
            <x-adminlte-card title="Password Guidelines" theme="warning" collapsible>
                <h6><i class="fas fa-shield-alt text-success"></i> Strong Password:</h6>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Mix of uppercase and lowercase</li>
                    <li>Include numbers</li>
                    <li>Include special characters</li>
                    <li>Avoid common words</li>
                </ul>

                <div class="alert alert-warning">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i>
                        Users will be required to change their password on first login.
                    </small>
                </div>
            </x-adminlte-card>

            <!-- User Preview -->
            <x-adminlte-card title="User Preview" theme="secondary" collapsible>
                <div class="text-center">
                    <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 id="previewName">User Name</h5>
                    <p id="previewEmail" class="text-muted">user@example.com</p>
                    <span id="previewRole" class="badge badge-primary">Role</span>

                    <div class="alert alert-success mt-3">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            This is how the user will appear in the system.
                        </small>
                    </div>
                </div>
            </x-adminlte-card>
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
                const name = $(this).val() || 'User Name';
                $('#previewName').text(name);
            });

            $('#email').on('input', function() {
                const email = $(this).val() || 'user@example.com';
                $('#previewEmail').text(email);
            });

            $('#role').on('change', function() {
                const role = $(this).val();
                const roleText = $(this).find('option:selected').text().trim();

                if (role === 'admin') {
                    $('#previewRole').removeClass('badge-primary').addClass('badge-danger').text(
                        'Administrator');
                    $('#roleDescription').text('Administrators have full access to all system features.');
                } else if (role === 'User') {
                    $('#previewRole').removeClass('badge-danger').addClass('badge-primary').text(
                        'Regular User');
                    $('#roleDescription').text(
                        'Regular users can manage their own documents and access public content.');
                } else {
                    $('#previewRole').removeClass('badge-danger badge-primary').addClass('badge-secondary')
                        .text('Role');
                    $('#roleDescription').text('Select the appropriate role for this user.');
                }
            });

            // Password strength checker
            $('#password').on('input', function() {
                checkPasswordStrength($(this).val());
            });

            // Form validation
            $('#createForm').submit(function(e) {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    return false;
                }

                $('#submitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Creating...');
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
            checkPasswordStrength(password);

            // Show generated password temporarily
            $('#password').attr('type', 'text');
            $('#password_confirmation').attr('type', 'text');

            setTimeout(function() {
                $('#password').attr('type', 'password');
                $('#password_confirmation').attr('type', 'password');
            }, 3000);
        }
    </script>
@endpush
