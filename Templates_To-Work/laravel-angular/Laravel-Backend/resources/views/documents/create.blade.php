@extends('layouts.stylepages')


@section('content_header')

@section('title', 'Upload Document')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-upload"></i>
            Upload New Document
            <h1>

            </h1>
            <div>
                <a href="{{ route('documents.my-documents') }}" class="btn btn-info">
                    <i class="fas fa-user"></i> My Documents
                </a>
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Documents
                </a>
            </div>
    </div>
@stop

@section('content')

    <div class="row">
        <!-- Upload Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Document Upload Form" theme="primary" collapsible>
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <!-- File Upload -->
                        <div class="form-group">
                            <label for="file">
                                <i class="fas fa-file"></i>
                                Select File <span class="text-danger">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                    id="file" name="file" required
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif">
                                <label class="custom-file-label" for="file">Choose file...</label>
                            </div>
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Supported formats: PDF, Word, Excel, PowerPoint, Text, Images. Maximum size: 30MB
                            </small>
                        </div>

                        <!-- Document Title -->
                        <div class="form-group">
                            <label for="title">
                                <i class="fas fa-heading"></i>
                                Document Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required placeholder="Enter document title...">
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
                                rows="4" placeholder="Enter document description...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Provide a brief description of the document content.
                            </small>
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
                                        {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status and Visibility -->

                        @if (auth()->check() && auth()->user()->isAdmin() || auth()->user()->isFormateur())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">
                                            <i class="fas fa-flag"></i>
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                                <i class="fas fa-edit"></i> Draft
                                            </option>
                                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                                <i class="fas fa-check"></i> Published
                                            </option>
                                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>
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
                                            <i class="fas fa-eye"></i>
                                            Visibility
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public"
                                                value="1" {{ old('is_public') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_public">
                                                <i class="fas fa-globe"></i> Make this document public
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Public documents can be viewed by all users.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Submit Buttons -->
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                    <i class="fas fa-upload"></i> Upload Document
                                </button>
                                <button type="button" class="btn btn-warning btn-lg" onclick="saveDraft()">
                                    <i class="fas fa-save"></i> Save as Draft
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
            </x-adminlte-card>
        </div>

        <!-- Upload Guidelines -->
        <div class="col-md-4">
            <x-adminlte-card title="Upload Guidelines" theme="info" collapsible>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>File Requirements:</strong>
                </div>

                <h6><i class="fas fa-check-circle text-success"></i> Supported Formats:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-file-pdf text-danger"></i> PDF Documents</li>
                    <li><i class="fas fa-file-word text-primary"></i> Word Documents (.doc, .docx)</li>
                    <li><i class="fas fa-file-excel text-success"></i> Excel Files (.xls, .xlsx)</li>
                    <li><i class="fas fa-file-powerpoint text-warning"></i> PowerPoint (.ppt, .pptx)</li>
                    <li><i class="fas fa-file-alt text-muted"></i> Text Files (.txt)</li>
                    <li><i class="fas fa-file-image text-info"></i> Images (.jpg, .png, .gif)</li>
                </ul>

                <h6><i class="fas fa-exclamation-triangle text-warning"></i> Important Notes:</h6>
                <ul>
                    <li>Maximum file size: <strong>30MB</strong></li>
                    <li>Use descriptive titles</li>
                    <li>Select appropriate category</li>
                    <li>Add meaningful descriptions</li>
                    <li>Check visibility settings</li>
                </ul>

                <h6><i class="fas fa-shield-alt text-primary"></i> Security:</h6>
                <ul>
                    <li>Files are scanned for viruses</li>
                    <li>Private documents are secure</li>
                    <li>Access is logged and monitored</li>
                </ul>
            </x-adminlte-card>

            <!-- File Preview -->
            <x-adminlte-card title="File Preview" theme="secondary" collapsible>
                <div id="filePreview" class="text-center" style="display: none;">
                    <div id="previewIcon"></div>
                    <div id="previewInfo"></div>
                </div>
                <div id="noPreview" class="text-center text-muted">
                    <i class="fas fa-file fa-3x mb-2"></i>
                    <p>Select a file to see preview</p>
                </div>
            </x-adminlte-card>

            <!-- Quick Actions -->
            <x-adminlte-card title="Quick Actions" theme="success" collapsible>
                <div class="btn-group-vertical w-100">
                    <button type="button" class="btn btn-outline-primary" onclick="setQuickSettings('document')">
                        <i class="fas fa-file-alt"></i> Standard Document
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="setQuickSettings('report')">
                        <i class="fas fa-chart-line"></i> Report
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="setQuickSettings('presentation')">
                        <i class="fas fa-presentation"></i> Presentation
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="setQuickSettings('manual')">
                        <i class="fas fa-book"></i> Manual/Guide
                    </button>
                </div>
            </x-adminlte-card>
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

                    // Auto-fill title if empty
                    if (!$('#title').val()) {
                        const fileName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
                        $('#title').val(fileName);
                    }

                    // Show file preview
                    showFilePreview(file);
                }
            });

            // Form validation
            $('#uploadForm').submit(function(e) {
                const file = $('#file')[0].files[0];
                if (!file) {
                    e.preventDefault();
                    alert('Please select a file to upload.');
                    return false;
                }

                if (file.size > 30 * 1024 * 1024) { // 30MB
                    e.preventDefault();
                    alert('File size must be less than 30MB.');
                    return false;
                }

                // Show loading state
                $('#submitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Uploading...');
            });
        });

        function showFilePreview(file) {
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

            $('#previewIcon').html(`<i class="${icon} ${color} fa-4x mb-2"></i>`);
            $('#previewInfo').html(`
        <h6>${file.name}</h6>
        <p class="text-muted">
            ${fileSize} MB<br>
            ${extension.toUpperCase()} File
        </p>
    `);

            $('#noPreview').hide();
            $('#filePreview').show();
        }

        function saveDraft() {
            $('#status').val('draft');
            $('#uploadForm').submit();
        }

        function setQuickSettings(type) {
            switch (type) {
                case 'document':
                    $('#status').val('published');
                    $('#is_public').prop('checked', false);
                    break;
                case 'report':
                    $('#status').val('published');
                    $('#is_public').prop('checked', true);
                    break;
                case 'presentation':
                    $('#status').val('draft');
                    $('#is_public').prop('checked', false);
                    break;
                case 'manual':
                    $('#status').val('published');
                    $('#is_public').prop('checked', true);
                    break;
            }
        }
    </script>
@endpush

@stop
