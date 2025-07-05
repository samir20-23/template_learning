@extends('layouts.stylepages')

@section('title', 'Edit Validation')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-edit"></i>
            Edit Validation
        </h1>
        <div>
            <a href="{{ route('validations.show', $validation) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> View Details
            </a>
            <a href="{{ route('validations.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Validation Form" theme="warning" collapsible>
                <form action="{{ route('validations.update', $validation) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                    <option value="Pending"
                                        {{ old('status', $validation->status) === 'Pending' ? 'selected' : '' }}>
                                        <i class="fas fa-clock"></i> Pending
                                    </option>
                                    <option value="Approved"
                                        {{ old('status', $validation->status) === 'Approved' ? 'selected' : '' }}>
                                        <i class="fas fa-check"></i> Approved
                                    </option>
                                    <option value="Rejected"
                                        {{ old('status', $validation->status) === 'Rejected' ? 'selected' : '' }}>
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
                                <label>Current Status</label>
                                <div>
                                    <span class="badge badge-lg {{ $validation->getStatusBadgeClass() }}">
                                        <i class="{{ $validation->getStatusIcon() }}"></i>
                                        {{ $validation->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commentaire">
                            <i class="fas fa-comment"></i>
                            Comment
                            <span class="text-muted">(Required for rejection)</span>
                        </label>
                        <textarea name="commentaire" id="commentaire" rows="4"
                            class="form-control @error('commentaire') is-invalid @enderror" placeholder="Add your validation comment here...">{{ old('commentaire', $validation->commentaire) }}</textarea>
                        @error('commentaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Provide detailed feedback about the validation decision.
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="confirmValidation" required>
                            <label class="custom-control-label" for="confirmValidation">
                                I confirm that I have reviewed the document and my validation decision is final.
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Update Validation
                            </button>
                            <a href="{{ route('validations.show', $validation) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteValidation()">
                                <i class="fas fa-trash"></i> Delete Validation
                            </button>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Document Preview -->
        <div class="col-md-4">
            <x-adminlte-card title="Document Preview" theme="info" collapsible>
                <div class="text-center mb-3">
                    @if ($validation->document->isImage())
                        {{-- Show image thumbnail --}}

                        @if ($validation->document->fileExists())
                            <a href="{{ $validation->document->fileUrl() }}">
                                <a href="{{ $validation->document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

                                    <i class="{{ $validation->document->getFileIcon() }} fa-3x mb-2"></i>
                                    {{-- <img src="{{ $validation->document->fileUrl() }}" alt="{{ $validation->document->title }}"
                                                        class="img-fluid mb-2" style="max-height:150px;"> --}}
                                </a>
                            @else
                                <a href="{{ $validation->document->fileUrl() }}">
                                    <a href="{{ $validation->document->fileUrl() }}" target="_blank"
                                        rel="noopener noreferrer">

                                        <i class="{{ $validation->document->getFileIcon() }} fa-3x mb-2"></i>
                                    </a>
                        @endif
                    @else
                        <a href="{{ $validation->document->fileUrl() }}">
                            <a href="{{ $validation->document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

                                <i class="{{ $validation->document->getFileIcon() }} fa-3x mb-2"></i>
                            </a>
                    @endif
                    <h5>{{ $validation->document->title }}</h5>
                    <p class="text-muted">{{ $validation->document->type }}</p>
                </div>

                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td><span class="badge badge-info">{{ $validation->document->categorie->name }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Uploaded By:</strong></td>
                        <td>{{ $validation->document->user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Upload Date:</strong></td>
                        <td>
                            @if ($validation->document && $validation->document->created_at)
                                {{ $validation->document->created_at->format('M d, Y') }}
                            @else
                                No Date
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>File Size:</strong></td>
                        <td>
                            @if (Storage::exists($validation->document->chemin_fichier))
                                {{ number_format(Storage::size($validation->document->chemin_fichier) / 1024, 2) }} KB
                            @else
                                <span class="text-danger">File not found</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="btn-group btn-group-sm w-100 mb-3">
                    <a href="{{ $validation->document->getDownloadUrl() }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="{{ route('validations.view-document', $validation->document) }}" class="btn btn-info"
                        target="_blank">
                        <i class="fas fa-eye"></i> View
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-bolt"></i> Quick Actions</h6>
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
            </x-adminlte-card>

            <!-- Validation Info -->
            <x-adminlte-card title="Validation Information" theme="secondary" collapsible>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $validation->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $validation->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @if ($validation->validated_at)
                        <tr>
                            <td><strong>Validated:</strong></td>
                            <td>{{ $validation->validated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @endif
                    @if ($validation->validator)
                        <tr>
                            <td><strong>Validator:</strong></td>
                            <td>{{ $validation->validator->name }}</td>
                        </tr>
                    @endif
                </table>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Validation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Are you sure you want to delete this validation record?</p>
                    <p><strong>Document:</strong> {{ $validation->document->title }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>


                    <form action="{{ route('validations.destroy', $validation) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Validation
                        </button>
                    </form>
                </div>
            </div>
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
                        '<i class="fas fa-comment"></i> Comment <span class="text-danger">*</span> <span class="text-muted">(Required for rejection)</span>'
                    );
                } else {
                    commentField.prop('required', false);
                    commentField.attr('placeholder', 'Add your validation comment here...');
                    commentField.closest('.form-group').find('label').html(
                        '<i class="fas fa-comment"></i> Comment <span class="text-muted">(Optional)</span>'
                    );
                }
            });

            // Trigger change event on page load
            $('#status').trigger('change');
        });

        function setStatus(status) {
            $('#status').val(status).trigger('change');

            // Set appropriate comment based on status
            const commentField = $('#commentaire');
            if (status === 'Approved' && !commentField.val()) {
                commentField.val('Document approved - meets all requirements.');
            } else if (status === 'Pending' && !commentField.val()) {
                commentField.val('Document requires further review.');
            }
        }

        function deleteValidation() {
            const modalEl = document.getElementById('deleteModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
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
