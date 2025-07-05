@extends('layouts.stylepages')


@section('title', 'Create Validation')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-plus"></i>
            Create New Validation
        </h1>
        <div>
            <a href="{{ route('validations.pending') }}" class="btn btn-warning">
                <i class="fas fa-clock"></i> Pending Validations
            </a>
            <a href="{{ route('validations.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> All Validations
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Create Form -->
        <div class="col-md-8">
            <x-adminlte-card title="New Validation Form" theme="primary" collapsible>
                <form action="{{ route('validations.store', $document) }}" method="POST">
                    @csrf

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Document:</strong> {{ $document->title }}
                        <br>
                        <strong>Category:</strong> {{ $document->categorie->name }}
                        <br>
                        <strong>Uploaded by:</strong> {{ $document->user->name }}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">
                                    <i class="fas fa-flag"></i>
                                    Validation Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>
                                        <i class="fas fa-clock"></i> Pending Review
                                    </option>
                                    <option value="Approved" {{ old('status') === 'Approved' ? 'selected' : '' }}>
                                        <i class="fas fa-check"></i> Approved
                                    </option>
                                    <option value="Rejected" {{ old('status') === 'Rejected' ? 'selected' : '' }}>
                                        <i class="fas fa-times"></i> Rejected
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quick Actions</label>
                                <div>
                                    <div class="btn-group btn-group-sm w-100">
                                        <button type="button" class="btn btn-success" onclick="setStatus('Approved')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="setStatus('Rejected')">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                        <button type="button" class="btn btn-warning" onclick="setStatus('Pending')">
                                            <i class="fas fa-clock"></i> Pending
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commentaire">
                            <i class="fas fa-comment"></i>
                            Validation Comment
                            <span class="text-muted">(Required for rejection)</span>
                        </label>
                        <textarea name="commentaire" id="commentaire" rows="4"
                            class="form-control @error('commentaire') is-invalid @enderror" placeholder="Add your validation comment here...">{{ old('commentaire') }}</textarea>
                        @error('commentaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Provide detailed feedback about your validation decision.
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="confirmValidation" required>
                            <label class="custom-control-label" for="confirmValidation">
                                I confirm that I have reviewed the document and my validation decision is accurate.
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Create Validation
                            </button>
                            <a href="{{ route('validations.pending') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Document Preview -->
        <div class="col-md-4">
            <x-adminlte-card title="Document Information" theme="info" collapsible>
                <div class="text-center mb-3">
                    <i class="fas fa-file fa-4x text-primary mb-2"></i>
                    <h5>{{ $document->title }}</h5>
                    <p class="text-muted">{{ $document->type }}</p>
                </div>

                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td><span class="badge badge-info">{{ $document->categorie->name }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Uploaded By:</strong></td>
                        <td>{{ $document->user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Upload Date:</strong></td>
                        <td>
                            {{ $document->created_at ? $document->created_at->format('M d, Y') : 'No Date' }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Current Status:</strong></td>
                        <td>
                            <span class="badge {{ $document->getValidationBadgeClass() }}">
                                {{ $document->getValidationStatus() }}
                            </span>
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="btn-group btn-group-sm w-100 mb-3">
                    <a href="{{ route('validations.download-document', $document) }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="{{ route('validations.view-document', $document) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-eye"></i> View File
                    </a>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Note:</strong> Please review the document carefully before making your validation decision.
                </div>
            </x-adminlte-card>

            <!-- Validation Guidelines -->
            <x-adminlte-card title="Validation Guidelines" theme="secondary" collapsible>
                <div class="small">
                    <h6><i class="fas fa-check-circle text-success"></i> Approve if:</h6>
                    <ul>
                        <li>Document is complete and accurate</li>
                        <li>All required information is present</li>
                        <li>Format meets standards</li>
                        <li>Content is appropriate</li>
                    </ul>

                    <h6><i class="fas fa-times-circle text-danger"></i> Reject if:</h6>
                    <ul>
                        <li>Document is incomplete</li>
                        <li>Contains errors or inaccuracies</li>
                        <li>Wrong format or category</li>
                        <li>Inappropriate content</li>
                    </ul>

                    <h6><i class="fas fa-clock text-warning"></i> Set Pending if:</h6>
                    <ul>
                        <li>Requires additional review</li>
                        <li>Waiting for more information</li>
                        <li>Need to consult with others</li>
                    </ul>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).ready(function() {
            // Status change handler
            $('#status').change(function() {
                const status = $(this).val();
                const commentField = $('#commentaire');

                if (status === 'Rejected') {
                    commentField.prop('required', true);
                    commentField.attr('placeholder', 'Comment is required when rejecting a document...');
                    commentField.closest('.form-group').find('label').html(
                        '<i class="fas fa-comment"></i> Validation Comment <span class="text-danger">*</span> <span class="text-muted">(Required for rejection)</span>'
                        );
                } else {
                    commentField.prop('required', false);
                    commentField.attr('placeholder', 'Add your validation comment here...');
                    commentField.closest('.form-group').find('label').html(
                        '<i class="fas fa-comment"></i> Validation Comment <span class="text-muted">(Optional)</span>'
                        );
                }
            });
        });

        function setStatus(status) {
            $('#status').val(status).trigger('change');

            // Set appropriate comment based on status
            const commentField = $('#commentaire');
            if (status === 'Approved' && !commentField.val()) {
                commentField.val('Document approved - meets all requirements.');
            } else if (status === 'Pending' && !commentField.val()) {
                commentField.val('Document requires further review.');
            } else if (status === 'Rejected') {
                commentField.val('').focus();
            }
        }

        // Form validation
        $('form').submit(function(e) {
            const status = $('#status').val();
            const comment = $('#commentaire').val().trim();

            if (status === 'Rejected' && !comment) {
                e.preventDefault();
                alert('Comment is required when rejecting a document.');
                $('#commentaire').focus();
                return false;
            }

            if (!$('#confirmValidation').is(':checked')) {
                e.preventDefault();
                alert('Please confirm your validation decision.');
                $('#confirmValidation').focus();
                return false;
            }
        });
    </script>
@endpush
