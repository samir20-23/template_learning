@extends('layouts.stylepages')


@section('title', 'Pending Validations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-clock text-warning"></i>
            Documents Awaiting Validation
        </h1>
        <a href="{{ route('validations.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> All Validations
        </a>
    </div>
@stop

@section('content')
    <x-adminlte-card title="Documents Requiring Validation" theme="warning" collapsible>
        @if ($documents->count() > 0)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>{{ $documents->total() }}</strong> document(s) are waiting for validation.
            </div>

            <div class="row">
                @foreach ($documents as $document)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-file"></i>
                                    {{ Str::limit($document->title, 30) }}
                                </h6>
                            </div>
                            <div class="card-body">
                                @if ($document->isImage())
                                    {{-- Show image thumbnail --}}

                                    @if ($document->fileExists())
                                        <a href="{{ $document->fileUrl() }}">
                                            <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

                                                <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i> 
                                            </a>
                                        @else
                                            <a href="{{ $document->fileUrl() }}">
                                                <a href="{{ $document->fileUrl() }}" target="_blank"
                                                    rel="noopener noreferrer">

                                                    <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                                                </a>
                                    @endif
                                @else
                                    <a href="{{ $document->fileUrl() }}">
                                        <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

                                            <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                                        </a>
                                @endif

                                <div class="mb-2">
                                    <strong>Category:</strong>
                                    <span class="badge badge-info">{{ $document->categorie->name }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Type:</strong>
                                    <span class="badge badge-secondary">{{ $document->type }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Submitted by:</strong>
                                    <br>{{ $document->user->name }}
                                </div>
                                <div class="mb-2">
                                    <strong>Submitted:</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $document->created_at ? $document->created_at->diffForHumans() : 'No Date' }}
                                    </small>

                                </div>
                                @if ($document->validation)
                                    <div class="mb-2">
                                        <strong>Status:</strong>
                                        <span class="badge {{ $document->validation->getStatusBadgeClass() }}">
                                            <i class="{{ $document->validation->getStatusIcon() }}"></i>
                                            {{ $document->validation->status }}
                                        </span>
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <strong>Status:</strong>
                                        <span class="badge badge-secondary">Not Submitted for Validation</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="btn-group btn-group-sm w-100">
                                    @if ($document->validation)
                                        <a href="{{ route('validations.show', $document->validation) }}"
                                            class="btn btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('validations.edit', $document->validation) }}"
                                            class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Validate
                                        </a>
                                    @else
                                        <a href="{{ route('validations.create', $document) }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create Validation
                                        </a>
                                    @endif
                                    <a href="{{ $document->getDownloadUrl() }}" class="btn btn-secondary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <button type="button" class="btn btn-success"
                                        onclick="quickValidate({{ $document->id }}, 'approve')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="quickValidate({{ $document->id }}, 'reject')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $documents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                <h4 class="text-muted">All documents are validated!</h4>
                <p class="text-muted">There are no documents waiting for validation at the moment.</p>
                <a href="{{ route('documents.index') }}" class="btn btn-primary">
                    <i class="fas fa-file"></i> View All Documents
                </a>
            </div>
        @endif
    </x-adminlte-card>

    <!-- Quick Validation Modal -->
    <div class="modal fade" id="quickValidationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validationModalTitle">Validate Document</h5>
                    <button type="button" class="close"   style="opacity: 0;"  data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="quickValidationForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="validationStatus">Status:</label>
                            <select id="validationStatus" name="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="Approved">Approve</option>
                                <option value="Rejected">Reject</option>
                                <option value="Pending">Set as Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="validationComment">Comment:</label>
                            <textarea id="validationComment" name="commentaire" class="form-control" rows="3"
                                placeholder="Add a comment (required for rejection)..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  style="opacity: 0;"  data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Validation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        let currentDocumentId = null;

        function quickValidate(documentId, action) {
            currentDocumentId = documentId;

            if (action === 'approve') {
                $('#validationStatus').val('Approved');
                $('#validationModalTitle').text('Approve Document');
                $('#validationComment').prop('required', false);
            } else if (action === 'reject') {
                $('#validationStatus').val('Rejected');
                $('#validationModalTitle').text('Reject Document');
                $('#validationComment').prop('required', true);
            }

            $('#quickValidationModal').modal('show');
        }

        $('#quickValidationForm').submit(function(e) {
            e.preventDefault();

            const status = $('#validationStatus').val();
            const comment = $('#validationComment').val();

            if (status === 'Rejected' && !comment.trim()) {
                alert('Comment is required when rejecting a document.');
                return;
            }

            // Check if validation exists for this document
            $.ajax({
                url: `/documents/${currentDocumentId}/validation-exists`,
                method: 'GET',
                success: function(response) {
                    if (response.exists) {
                        // Update existing validation
                        updateValidation(response.validation_id, status, comment);
                    } else {
                        // Create new validation
                        createValidation(currentDocumentId, status, comment);
                    }
                },
                error: function() {
                    alert('Error checking validation status.');
                }
            });
        });

        function createValidation(documentId, status, comment) {
            $.ajax({
                url: `/documents/${documentId}/validations`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    commentaire: comment
                },
                success: function(response) {
                    $('#quickValidationModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Error creating validation.');
                }
            });
        }

        function updateValidation(validationId, status, comment) {
            $.ajax({
                url: `/validations/${validationId}`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    commentaire: comment
                },
                success: function(response) {
                    $('#quickValidationModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Error updating validation.');
                }
            });
        }

        // Reset form when modal is hidden
        $('#quickValidationModal').on('hidden.bs.modal', function() {
            $('#quickValidationForm')[0].reset();
            $('#validationComment').prop('required', false);
        });
    </script>
@endpush
