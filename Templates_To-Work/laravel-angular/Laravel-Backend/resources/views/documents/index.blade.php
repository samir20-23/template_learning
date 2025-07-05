@extends('layouts.stylepages')


@section('title', 'Documents')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-folder-open"></i>
            Document Management
        </h1>
        <div>
            <a href="{{ route('documents.my-documents') }}" class="btn btn-info">
                <i class="fas fa-user"></i> My Documents
            </a>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload Document
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Documents</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file"></i>
                </div>
                <a href="{{ route('documents.index') }}" class="small-box-footer">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['published'] }}</h3>
                    <p>Published</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('documents.index', ['status' => 'published']) }}" class="small-box-footer">
                    View Published <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['draft'] }}</h3>
                    <p>Drafts</p>
                </div>
                <div class="icon">
                    <i class="fas fa-edit"></i>
                </div>
                <a href="{{ route('documents.index', ['status' => 'draft']) }}" class="small-box-footer">
                    View Drafts <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['needs_validation'] }}</h3>
                    <p>Needs Validation</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('validations.pending') }}" class="small-box-footer">
                    View Pending <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <x-adminlte-card title="Document Library" theme="primary" collapsible>
        <form method="GET" action="{{ route('documents.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search documents..."
                        value="{{ $search }}">
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="user" class="form-control">
                        <option value="">All Users</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ $user == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-control">
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Date Created</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="download_count" {{ $sort === 'download_count' ? 'selected' : '' }}>Downloads
                        </option>
                        <option value="file_size" {{ $sort === 'file_size' ? 'selected' : '' }}>File Size</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form id="bulkActionForm" method="POST" action="{{ route('documents.bulk-action') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" onclick="bulkAction('publish')">
                            <i class="fas fa-check"></i> Publish Selected
                        </button>
                        <button type="button" class="btn btn-warning" onclick="bulkAction('draft')">
                            <i class="fas fa-edit"></i> Set as Draft
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="bulkAction('archive')">
                            <i class="fas fa-archive"></i> Archive Selected
                        </button>
                        <button type="button" class="btn btn-danger" onclick="bulkAction('delete')">
                            <i class="fas fa-trash"></i> Delete Selected
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <span id="selectedCount" class="badge badge-info">0 selected</span>
                </div>
            </div>

            <!-- Documents Grid -->
            @if ($documents->count() > 0)
                <div class="row">
                    @foreach ($documents as $document)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm document-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="document_ids[]" value="{{ $document->id }}"
                                            class="custom-control-input document-checkbox" id="doc{{ $document->id }}">
                                        <label class="custom-control-label" for="doc{{ $document->id }}"></label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $document->getStatusBadgeClass() }} mr-2">
                                            <i class="{{ $document->getStatusIcon() }}"></i>
                                            {{ ucfirst($document->status) }}
                                        </span>
                                        @if ($document->is_public)
                                            <i class="fas fa-globe text-info" title="Public Document"></i>
                                        @else
                                            <i class="fas fa-lock text-warning" title="Private Document"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        @if ($document->isImage())
                                            {{-- Show image thumbnail --}}

                                            @if ($document->fileExists())
                                                <a href="{{ $document->fileUrl() }}">
                                                    <a href="{{ $document->fileUrl() }}" target="_blank"
                                                        rel="noopener noreferrer">

                                                        <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                                                        {{-- <img src="{{ $document->fileUrl() }}" alt="{{ $document->title }}"
                                                        class="img-fluid mb-2" style="max-height:150px;"> --}}
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
                                                <a href="{{ $document->fileUrl() }}" target="_blank"
                                                    rel="noopener noreferrer">

                                                    <i class="{{ $document->getFileIcon() }} fa-3x mb-2"></i>
                                                </a>
                                        @endif

                                        <h6 class="card-title">{{ Str::limit($document->title, 30) }}</h6>
                                        <p class="text-muted small">{{ $document->getFormattedFileSize() }}</p>
                                    </div>
                                    <div>
                                        <strong>Type:</strong>
                                        <span class="badge badge-secondary">{{ $document->type }}</span>
                                        </td>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Category:</strong>
                                        <span class="badge badge-info">{{ $document->categorie->name }}</span>
                                    </div>

                                    <div class="mb-2">
                                        <strong>Uploaded by:</strong>
                                        <br>{{ $document->user->name }}
                                    </div>

                                    <div class="mb-2">
                                        <strong>Date:</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $document->created_at ? $document->created_at->format('M d, Y') : 'No Date' }}
                                        </small>

                                    </div>

                                    <div class="mb-2">
                                        <strong>Downloads:</strong>
                                        <span class="badge badge-secondary">{{ $document->download_count }}</span>
                                    </div>

                                    <div class="mb-2">
                                        <strong>Validation:</strong>
                                        <span class="badge {{ $document->getValidationBadgeClass() }}">
                                            {{ $document->getValidationStatus() }}
                                        </span>
                                    </div>

                                    @if ($document->description)
                                        <div class="mb-2">
                                            <small
                                                class="text-muted">{{ Str::limit($document->description, 100) }}</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group btn-group-sm w-100">
                                        <a href="{{ route('documents.show', $document) }}" class="btn btn-info"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ $document->getDownloadUrl() }}" class="btn btn-success"
                                            title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>


                                        </a>
                                        @can('update', $document)
                                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @if ($document->needsValidation())
                                            <a href="{{ route('validations.create', $document) }}"
                                                class="btn btn-primary" title="Validate">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-5x text-muted mb-3"></i>
                    <h4 class="text-muted">No documents found</h4>
                    <p class="text-muted">Try adjusting your search criteria or upload a new document.</p>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload Document
                    </a>
                </div>
            @endif
        </form>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $documents->appends(request()->query())->links() }}
        </div>

    </x-adminlte-card>

@stop

@push('css')
    <style>
        .document-card {
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .badge {
            font-size: 0.75em;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Select all functionality
            $('#selectAll').change(function() {
                $('.document-checkbox').prop('checked', this.checked);
                updateSelectedCount();
            });

            $('.document-checkbox').change(function() {
                updateSelectedCount();
            });

            function updateSelectedCount() {
                const count = $('.document-checkbox:checked').length;
                $('#selectedCount').text(count + ' selected');
            }
        });

        function bulkAction(action) {
            const selectedIds = $('.document-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Please select at least one document.');
                return;
            }

            const actionText = action === 'delete' ? 'delete' :
                action === 'publish' ? 'publish' :
                action === 'archive' ? 'archive' : 'set as draft';

            if (confirm(`Are you sure you want to ${actionText} ${selectedIds.length} document(s)?`)) {
                // Add hidden input to form
                $('#bulkActionForm').find('input[name="action"]').remove();
                $('#bulkActionForm').append(`<input type="hidden" name="action" value="${action}">`);

                $('#bulkActionForm').submit();
            }
        }
    </script>
@endpush
