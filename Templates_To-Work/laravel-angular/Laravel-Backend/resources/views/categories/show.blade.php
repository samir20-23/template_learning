{{-- @extends('adminlte::page') --}}
@extends('layouts.stylepages')

@section('title', $category->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-folder-open"></i>
            {{ $category->name }}
        </h1>
        <div>
            @can('update', $category)
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to Categories
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Category Information -->
        <div class="col-md-8">
            <x-adminlte-card title="Category Information" theme="primary" collapsible>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td>{{ $category->description ?: 'No description available' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Documents:</strong></td>
                                <td>
                                    <span class="badge badge-primary badge-lg">
                                        {{ $category->documents_count }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td>
                                    {{ $category->created_at ? $category->created_at->format('F d, Y \a\t H:i') : 'No date' }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $category->created_at ? $category->created_at->diffForHumans() : 'No date' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>
                                    {{ $category->updated_at ? $category->updated_at->format('F d, Y \a\t H:i') : 'No date' }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $category->updated_at ? $category->updated_at->diffForHumans() : 'No date' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if ($category->documents_count > 0)
                                        <span class="badge badge-success badge-lg">Active</span>
                                    @else
                                        <span class="badge badge-warning badge-lg">Empty</span>
                                    @endif
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
                            <a href="{{ route('documents.index', ['category' => $category->id]) }}"
                                class="btn btn-primary">
                                <i class="fas fa-file"></i> View All Documents
                            </a>
                            <a href="{{ route('documents.create', ['category' => $category->id]) }}"
                                class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Document
                            </a>
                            @can('update', $category)
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Category
                                </a>
                            @endcan
                            @can('delete', $category)
                                @if ($category->documents_count == 0)
                                    <button type="button" class="btn btn-danger" onclick="deleteCategory()">
                                        <i class="fas fa-trash"></i> Delete Category
                                    </button>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Documents in this Category -->
            <x-adminlte-card title="Documents in this Category" theme="info" collapsible>
                @if ($documents->count() > 0)
                    <div class="row">
                        @foreach ($documents as $document)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $document->getFileIcon() }} fa-2x mr-3"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('documents.show', $document) }}"
                                                        class="text-decoration-none">
                                                        {{ Str::limit($document->title, 30) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $document->getFormattedFileSize() }} •
                                                    {{ $category->created_at ? $category->created_at->format('M d, Y') : 'No date' }}

                                                </small>
                                                <br>
                                                <span class="badge {{ $document->getStatusBadgeClass() }}">
                                                    {{ ucfirst($document->status) }}
                                                </span>
                                                <span class="badge {{ $document->getValidationBadgeClass() }}">
                                                    {{ $document->getValidationStatus() }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('documents.show', $document) }}" class="btn btn-info"
                                                    title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('documents.download', $document) }}"
                                                    class="btn btn-success" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
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
                    <div class="text-center py-4">
                        <i class="fas fa-file fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No documents in this category</h5>
                        <p class="text-muted">Start by uploading your first document to this category.</p>
                        <a href="{{ route('documents.create', ['category' => $category->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Upload Document
                        </a>
                    </div>
                @endif
            </x-adminlte-card>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Category Stats -->
            <x-adminlte-card title="Category Statistics" theme="success" collapsible>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-right">
                            <h4 class="text-primary">{{ $category->documents_count }}</h4>
                            <small class="text-muted">Total Documents</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">   {{ $category->created_at ? $category->created_at->diffForHumans() : 'No date' }}</h4>
                        <small class="text-muted">Created</small>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Quick Actions -->
            <x-adminlte-card title="Quick Actions" theme="warning" collapsible>
                <div class="btn-group-vertical w-100">
                    <a href="{{ route('documents.create', ['category' => $category->id]) }}"
                        class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add New Document
                    </a>
                    <a href="{{ route('documents.index', ['category' => $category->id]) }}" class="btn btn-outline-info">
                        <i class="fas fa-list"></i> View All Documents
                    </a>
                    <a href="{{ route('documents.index', ['category' => $category->id, 'status' => 'draft']) }}"
                        class="btn btn-outline-warning">
                        <i class="fas fa-edit"></i> View Draft Documents
                    </a>
                    <a href="{{ route('validations.index', ['category' => $category->id]) }}"
                        class="btn btn-outline-secondary">
                        <i class="fas fa-check-circle"></i> View Validations
                    </a>
                </div>
            </x-adminlte-card>

            <!-- Related Categories -->
            <x-adminlte-card title="Other Categories" theme="secondary" collapsible>
                @php
                    $otherCategories = \App\Models\Categorie::where('id', '!=', $category->id)
                        ->withCount('documents')
                        ->orderBy('documents_count', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @foreach ($otherCategories as $otherCategory)
                    <div class="d-flex align-items-center mb-2 p-2 border rounded">
                        <i class="fas fa-folder fa-2x mr-3 text-primary"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('categories.show', $otherCategory) }}" class="text-decoration-none">
                                    {{ Str::limit($otherCategory->name, 20) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $otherCategory->documents_count }}
                                {{ Str::plural('document', $otherCategory->documents_count) }}
                            </small>
                        </div>
                    </div>
                @endforeach

                <div class="text-center">
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
                        View All Categories
                    </a>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning!</strong> This action cannot be undone.
                    </div>
                    <p>Are you sure you want to delete this category?</p>
                    <p><strong>Category:</strong> {{ $category->name }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        function deleteCategory() {
            $('#deleteModal').modal('show');
        }
    </script>
@endpush
