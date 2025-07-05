@extends('layouts.stylepages')

@section('title', $document->title)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="{{ $document->getFileIcon() }}"></i>
            {{ $document->title }}
        </h1>
        <div>
            @can('update', $document)
                <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Document Information -->
        <div class="col-md-8">
            <x-adminlte-card title="Document Details" theme="primary" collapsible>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>{{ $document->title }}</td>
                            </tr> 
                             <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    <span class="badge badge-info badge-lg">
                                        {{ $document->type }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="badge badge-info badge-lg">
                                        {{ $document->categorie->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge {{ $document->getStatusBadgeClass() }} badge-lg">
                                        <i class="{{ $document->getStatusIcon() }}"></i>
                                        {{ ucfirst($document->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Visibility:</strong></td>
                                <td>
                                    @if ($document->is_public)
                                        <span class="badge badge-success">
                                            <i class="fas fa-globe"></i> Public
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-lock"></i> Private
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>File Type:</strong></td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ strtoupper($document->type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>File Size:</strong></td>
                                <td>{{ $document->getFormattedFileSize() }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Uploaded By:</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user mr-2 text-primary"></i>
                                        {{ $document->user->name }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Upload Date:</strong></td>
                                <td>
                                    <i class="fas fa-calendar mr-2 text-info"></i>
                                    {{ $document->created_at ? $document->created_at->format('F d, Y \a\t H:i') : 'No Date' }}

                                    <br>
                                    <small class="text-muted">
                                        {{ $document->created_at ? $document->created_at->diffForHumans() : 'No Date' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>
                                    <i class="fas fa-clock mr-2 text-success"></i>
                                    {{ $document->created_at ? $document->created_at->format('F d, Y \a\t H:i') : 'No Date' }}

                                    <br>
                                    <small class="text-muted">
                                        {{ $document->created_at ? $document->created_at->diffForHumans() : 'No Date' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Downloads:</strong></td>
                                <td>
                                    <span class="badge badge-info badge-lg">
                                        <i class="fas fa-download"></i>
                                        {{ $document->download_count }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Validation Status:</strong></td>
                                <td>
                                    <span class="badge {{ $document->getValidationBadgeClass() }} badge-lg">
                                        @if ($document->validation)
                                            <i class="{{ $document->validation->getStatusIcon() }}"></i>
                                        @endif
                                        {{ $document->getValidationStatus() }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($document->description)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-info-circle"></i> Description</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $document->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-tools"></i> Actions</h6>
                        <div class="btn-group">
                            <a href="{{ $document->getDownloadUrl() }}" class="btn btn-success" title="Download">
                                <i class="fas fa-download"></i>
                            </a>

                            @if (in_array($document->mime_type, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif']))
                                <a href="{{ $document->fileUrl() }}" class="btn btn-info" target="_blank">
                                    <i class="fas fa-eye"></i> View in Browser
                                </a>
                            @endif
                            @can('update', $document)
                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Document
                                </a>
                            @endcan
                            @if ($document->needsValidation() && auth()->user()->isAdmin() || auth()->user()->isFormateur())
                                <a href="{{ route('validations.create', $document) }}" class="btn btn-primary">
                                    <i class="fas fa-check-circle"></i> Validate Document
                                </a>
                            @endif
                            @can('delete', $document)
                                <button type="button" class="btn btn-danger" onclick="deleteDocument()">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Validation Information -->
            @if ($document->validation)
                <x-adminlte-card title="Validation Information" theme="info" collapsible>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge {{ $document->validation->getStatusBadgeClass() }} badge-lg">
                                            <i class="{{ $document->validation->getStatusIcon() }}"></i>
                                            {{ $document->validation->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Validated By:</strong></td>
                                    <td>
                                        @if ($document->validation->validator)
                                            {{ $document->validation->validator->name }}
                                        @else
                                            <span class="text-muted">Not yet validated</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Validation Date:</strong></td>
                                    <td>
                                        @if ($document->validation->validated_at)
                                            {{ $document->validation->validated_at->format('F d, Y \a\t H:i') }}
                                            {{ $document->validation->validated_at ? $document->validation->validated_at->format('F d, Y \a\t H:i') : 'No Date' }}

                                            <br>
                                            <small class="text-muted">
                                                {{ $document->validation->validated_at ? $document->validation->validated_at->diffForHumans() : 'No Date' }}
                                            </small>
                                        @else
                                            <span class="text-muted">Pending validation</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if ($document->validation->commentaire)
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-comment"></i>
                                            Validation Comment
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $document->validation->commentaire }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('validations.show', $document->validation) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Full Validation Details
                        </a>
                    </div>
                </x-adminlte-card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- File Preview -->
            <x-adminlte-card title="File Preview" theme="secondary" collapsible>
                <div class="text-center">
                    @if ($document->isImage())
                        {{-- Show image thumbnail --}}

                        @if ($document->fileExists())
                            <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">
                                <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                                {{-- <img src="{{ $document->fileUrl() }}" alt="{{ $document->title }}"
                                                        class="img-fluid mb-2" style="max-height:150px;"> --}}
                            </a>
                        @else
                            <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">
                                <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener noreferrer">
                            <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                        </a>
                    @endif
                    <h5>{{ $document->original_name ?? $document->title }}</h5>
                    <p class="text-muted">{{ $document->getFormattedFileSize() }}</p>

                    @if ($document->fileExists())
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            File is available
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            File not found
                        </div>
                    @endif
                </div>
            </x-adminlte-card>

            <!-- Quick Stats -->
            <x-adminlte-card title="Quick Stats" theme="info" collapsible>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-primary">{{ $document->download_count }}</h4>
                            <small class="text-muted">Downloads</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">
                            {{ $document->created_at ? $document->created_at->diffForHumans() : 'No Date' }}
                        </h4>
                        <small class="text-muted">Uploaded</small>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Related Documents -->
            @if ($relatedDocuments->count() > 0)
                <x-adminlte-card title="Related Documents" theme="success" collapsible>
                    @foreach ($relatedDocuments as $related)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <i class="{{ $related->getFileIcon() }} fa-2x mr-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('documents.show', $related) }}" class="text-decoration-none">
                                        {{ Str::limit($related->title, 25) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $related->getFormattedFileSize() }} •
                                    {{ $related->created_at ? $related->created_at->format('M d, Y') : 'No date' }}
                                </small>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-center">
                        <a href="{{ route('documents.index', ['category' => $document->categorie_id]) }}"
                            class="btn btn-sm btn-outline-success">
                            View All in {{ $document->categorie->name }}
                        </a>
                    </div>
                </x-adminlte-card>
            @endif

            <!-- Document History -->
            <x-adminlte-card title="Document History" theme="dark" collapsible>
                <div class="timeline timeline-sm">
                    <div class="time-label">
                        <span class="bg-success">
                            {{ $document->created_at ? $document->created_at->format('M d, Y') : 'No date' }}
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-upload bg-primary"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i>
                                {{ $document->created_at ? $document->created_at->format('H:i') : 'No date' }}
                            </span>
                            <h3 class="timeline-header">Document Uploaded</h3>
                            <div class="timeline-body">
                                Document was uploaded by {{ $document->user->name }}
                            </div>
                        </div>
                    </div>

                    @if ($document->created_at != $document->updated_at)
                        <div class="time-label">
                            <span class="bg-warning">
                                {{ $document->updated_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div>
                            <i class="fas fa-edit bg-warning"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="fas fa-clock"></i> {{ $document->updated_at->format('H:i') }}
                                </span>
                                <h3 class="timeline-header">Document Updated</h3>
                                <div class="timeline-body">
                                    Document information was modified
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($document->validation)
                        <div class="time-label">
                            <span
                                class="bg-{{ $document->validation->isApproved() ? 'success' : ($document->validation->isRejected() ? 'danger' : 'warning') }}">
                                {{ $document->validation->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div>
                            <i
                                class="fas {{ $document->validation->getStatusIcon() }} bg-{{ $document->validation->isApproved() ? 'success' : ($document->validation->isRejected() ? 'danger' : 'warning') }}"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="fas fa-clock"></i> {{ $document->validation->created_at->format('H:i') }}
                                </span>
                                <h3 class="timeline-header">Validation: {{ $document->validation->status }}</h3>
                                <div class="timeline-body">
                                    @if ($document->validation->validator)
                                        Validated by {{ $document->validation->validator->name }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

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

@push('css')
    <style>
        .badge-lg {
            font-size: 1em;
            padding: 0.5em 0.75em;
        }

        .timeline {
            position: relative;
            margin: 0 0 30px 0;
            padding: 0;
            list-style: none;
        }

        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 31px;
            margin: 0;
            border-radius: 2px;
        }

        .timeline>div {
            margin-bottom: 15px;
            position: relative;
        }

        .timeline>div>.timeline-item {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 60px;
            margin-right: 15px;
            padding: 0;
            position: relative;
        }

        .timeline>div>.fas {
            width: 30px;
            height: 30px;
            font-size: 15px;
            line-height: 30px;
            position: absolute;
            color: #666;
            background: #d2d6de;
            border-radius: 50%;
            text-align: center;
            left: 18px;
            top: 0;
        }

        .timeline>.time-label>span {
            font-weight: 600;
            color: #fff;
            font-size: 12px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 4px;
        }

        .timeline-header {
            margin: 0;
            color: #555;
            border-bottom: 1px solid #f4f4f4;
            padding: 10px;
            font-weight: 600;
            font-size: 16px;
        }

        .timeline-body {
            padding: 10px;
            font-size: 14px;
        }

        .time {
            color: #999;
            float: right;
            padding: 10px;
            font-size: 12px;
        }
    </style>
@endpush

@push('js')
    <script>
        function deleteDocument() {
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
