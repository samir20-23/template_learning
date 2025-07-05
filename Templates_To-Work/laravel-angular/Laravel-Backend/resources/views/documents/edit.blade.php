@extends('layouts.stylepages')


@section('title', 'Edit Document')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-edit"></i>
            Edit Document
        </h1>
        <div>
            <a href="{{ route('documents.show', $document) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> View Document
            </a>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Edit Document Information" theme="warning" collapsible>
                <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data"
                    id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Current File Info -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Current File Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>File:</strong> {{ $document->original_name ?? $document->title }}<br>
                                <strong>Size:</strong> {{ $document->getFormattedFileSize() }}<br>
                                <strong>Type:</strong> {{ strtoupper($document->type) }}
                            </div>
                            <div class="col-md-6">
                                <strong>Uploaded:</strong> {{ $document->created_at->format('M d, Y') }}<br>
                                <strong>Downloads:</strong> {{ $document->download_count }}<br>
                                <strong>Status:</strong>
                                <span class="badge {{ $document->getStatusBadgeClass() }}">
                                    {{ ucfirst($document->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Replace File (Optional) -->
                    <div class="form-group">
                        <label for="file">
                            <i class="fas fa-file"></i>
                            Replace File (Optional)
                        </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                id="file" name="file"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif">
                            <label class="custom-file-label" for="file">Choose new file...</label>
                        </div>
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Leave empty to keep current file. Maximum size: 30MB
                        </small>
                    </div>

                    <!-- Document Title -->
                    <div class="form-group">
                        <label for="title">
                            <i class="fas fa-heading"></i>
                            Document Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $document->title) }}" required
                            placeholder="Enter document title...">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="4" placeholder="Enter document description...">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="categorie_id">
                            <i class="fas fa-folder"></i>
                            Category <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('categorie_id') is-invalid @enderror" id="categorie_id"
                            name="categorie_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('categorie_id', $document->categorie_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- … up to Category field … --}}

                    {{-- Status and Visibility (only for admin/formateur) --}}
                    @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isFormateur()))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-flag"></i>
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="draft"
                                            {{ old('status', $document->status) === 'draft' ? 'selected' : '' }}>
                                            <i class="fas fa-edit"></i> Draft
                                        </option>
                                        <option
                                            value="published"{{ old('status', $document->status) === 'published' ? 'selected' : '' }}>
                                            <i class="fas fa-check"></i> Published
                                        </option>
                                        <option value="archived"
                                            {{ old('status', $document->status) === 'archived' ? 'selected' : '' }}>
                                            <i class="fas fa-archive"></i> Archived
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-eye"></i> Visibility
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_public" name="is_public"
                                            value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_public">
                                            <i class="fas fa-globe"></i> Make this document public
                                        </label>
                                    </div>
                                    @error('is_public')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Public documents can be viewed by all users.
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- … Submit buttons & rest of form … --}}


                    <!-- Validation Warning -->
                    @if ($document->validation && $document->validation->isApproved())
                        <diz`v class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Note:</strong> This document has been validated and approved.
                            Making changes may require re-validation.
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg" id="updateBtn">
                                <i class="fas fa-save"></i> Update Document
                            </button>
                            <a href="{{ route('documents.show', $document) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteDocument()">
                                <i class="fas fa-trash"></i> Delete Document
                            </button>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Document Info Sidebar -->
        <div class="col-md-4">
            <!-- Current File Preview -->
            <x-adminlte-card title="Current File" theme="info" collapsible>
                <div class="text-center">
                    <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

                        <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                    </a>
                    <h6>{{ $document->original_name ?? $document->title }}</h6>
                    <p class="text-muted">{{ $document->getFormattedFileSize() }}</p>

                    <div class="btn-group btn-group-sm w-100">
                        <a href="{{ $document->getDownloadUrl() }}" class="btn btn-success" title="Download">
                            <i class="fas fa-download"></i>
                        </a>

                        @if (in_array($document->mime_type, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif']))
                            <a href="{{ route('documents.view', $document) }}" class="btn btn-info" target="_blank">
                                <i class="fas fa-eye"></i> View
                            </a>
                        @endif
                    </div>
                </div>
            </x-adminlte-card>

            <!-- New File Preview -->
            <x-adminlte-card title="New File Preview" theme="secondary" collapsible>
                <div id="newFilePreview" class="text-center" style="display: none;">
                    <div id="newPreviewIcon"></div>
                    <div id="newPreviewInfo"></div>
                </div>
                <div id="noNewPreview" class="text-center text-muted">
                    <i class="fas fa-upload fa-3x mb-2"></i>
                    <p>Select a new file to replace current one</p>
                </div>
            </x-adminlte-card>

            <!-- Document Statistics -->
            <x-adminlte-card title="Document Statistics" theme="success" collapsible>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $document->updated_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Downloads:</strong></td>
                        <td>
                            <span class="badge badge-info">{{ $document->download_count }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td>{{ $document->categorie->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Owner:</strong></td>
                        <td>{{ $document->user->name }}</td>
                    </tr>
                    @if ($document->validation)
                        <tr>
                            <td><strong>Validation:</strong></td>
                            <td>
                                <span class="badge {{ $document->validation->getStatusBadgeClass() }}">
                                    {{ $document->validation->status }}
                                </span>
                            </td>
                        </tr>
                    @endif
                </table>
            </x-adminlte-card>

            <!-- Edit History -->
            <x-adminlte-card title="Recent Changes" theme="dark" collapsible>
                <div class="timeline timeline-sm">
                    <div class="time-label">
                        <span class="bg-primary">
                            {{ $document->updated_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-edit bg-warning"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $document->updated_at->format('H:i') }}
                            </span>
                            <h3 class="timeline-header">Last Modified</h3>
                            <div class="timeline-body">
                                Document was last updated {{ $document->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Document</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Are you sure you want to delete this document?</p>
                    <p><strong>Title:</strong> {{ $document->title }}</p>
                    <p><strong>File:</strong> {{ $document->original_name }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('documents.destroy', $document) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Document
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
            // File input change handler
            $('#file').change(function() {
                const file = this.files[0];
                if (file) {
                    // Update file label
                    $(this).next('.custom-file-label').text(file.name);

                    // Show new file preview
                    showNewFilePreview(file);
                } else {
                    // Reset preview
                    $('#noNewPreview').show();
                    $('#newFilePreview').hide();
                    $(this).next('.custom-file-label').text('Choose new file...');
                }
            });

            // Form validation
            $('#editForm').submit(function(e) {
                const file = $('#file')[0].files[0];
                if (file && file.size > 30 * 1024 * 1024) { // 30MB
                    e.preventDefault();
                    alert('File size must be less than 30MB.');
                    return false;
                }

                // Show loading state
                $('#updateBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Updating...');
            });
        });

        function showNewFilePreview(file) {
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const extension = file.name.split('.').pop().toLowerCase();

            let icon = 'fas fa-file';
            let color = 'text-dark';

            switch (extension) {
                case 'pdf':
                    icon = 'fas fa-file-pdf';
                    color = 'text-danger';
                    break;
                case 'doc':
                case 'docx':
                    icon = 'fas fa-file-word';
                    color = 'text-primary';
                    break;
                case 'xls':
                case 'xlsx':
                    icon = 'fas fa-file-excel';
                    color = 'text-success';
                    break;
                case 'ppt':
                case 'pptx':
                    icon = 'fas fa-file-powerpoint';
                    color = 'text-warning';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    icon = 'fas fa-file-image';
                    color = 'text-info';
                    break;
                case 'txt':
                    icon = 'fas fa-file-alt';
                    color = 'text-muted';
                    break;
            }

            $('#newPreviewIcon').html(`<i class="${icon} ${color} fa-4x mb-2"></i>`);
            $('#newPreviewInfo').html(`
        <h6>${file.name}</h6>
        <p class="text-muted">
            ${fileSize} MB<br>
            ${extension.toUpperCase()} File
        </p>
        <div class="alert alert-warning">
            <small><i class="fas fa-exclamation-triangle"></i> This will replace the current file</small>
        </div>
    `);

            $('#noNewPreview').hide();
            $('#newFilePreview').show();
        }

        function deleteDocument() {
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
