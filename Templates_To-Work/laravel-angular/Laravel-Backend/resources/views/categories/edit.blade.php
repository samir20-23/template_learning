@extends('layouts.stylepages')

@section('title', 'Edit Category')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-edit"></i>
            Edit Category
        </h1>
        <div>
            <a href="{{ route('categories.show', $category) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> View Category
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Edit Category Information" theme="warning" collapsible>
                <form action="{{ route('categories.update', $category) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Current Info -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Current Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}<br>
                                <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Documents:</strong> {{ $category->documents_count }}<br>
                                <strong>Status:</strong> 
                                @if($category->documents_count > 0)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-warning">Empty</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-tag"></i>
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name) }}" required 
                               placeholder="Enter category name...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Warning for categories with documents -->
                    @if($category->documents_count > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Note:</strong> This category contains {{ $category->documents_count }} 
                            {{ Str::plural('document', $category->documents_count) }}. 
                            Changes will affect how these documents are categorized.
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                        <div>
                            @if($category->documents_count == 0)
                                <button type="button" class="btn btn-outline-danger" onclick="deleteCategory()">
                                    <i class="fas fa-trash"></i> Delete Category
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-secondary" disabled title="Cannot delete - has documents">
                                    <i class="fas fa-lock"></i> Cannot Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Category Info Sidebar -->
        <div class="col-md-4">
            <!-- Current Category Preview -->
            <x-adminlte-card title="Category Preview" theme="info" collapsible>
                <div class="text-center">
                    <i class="fas fa-folder fa-4x text-primary mb-3"></i>
                    <h5 id="previewName">{{ $category->name }}</h5>
                    <p id="previewDescription" class="text-muted">
                        {{ $category->description ?: 'No description available' }}
                    </p>
                </div>
            </x-adminlte-card>

            <!-- Category Statistics -->
            <x-adminlte-card title="Category Statistics" theme="success" collapsible>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Documents:</strong></td>
                        <td>
                            <span class="badge badge-primary">{{ $category->documents_count }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $category->created_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $category->updated_at->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Age:</strong></td>
                        <td>{{ $category->created_at->diffForHumans() }}</td>
                    </tr>
                </table>

                @if($category->documents_count > 0)
                    <div class="text-center">
                        <a href="{{ route('documents.index', ['category' => $category->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-file"></i> View Documents
                        </a>
                    </div>
                @endif
            </x-adminlte-card>

            <!-- Recent Activity -->
            <x-adminlte-card title="Recent Activity" theme="dark" collapsible>
                <div class="timeline timeline-sm">
                    <div class="time-label">
                        <span class="bg-primary">
                            {{ $category->updated_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-edit bg-warning"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $category->updated_at->format('H:i') }}
                            </span>
                            <h3 class="timeline-header">Last Modified</h3>
                            <div class="timeline-body">
                                Category was last updated {{ $category->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-plus bg-success"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $category->created_at->format('H:i') }}
                            </span>
                            <h3 class="timeline-header">Category Created</h3>
                            <div class="timeline-body">
                                Category was created {{ $category->created_at->diffForHumans() }}
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
$(document).ready(function() {
    // Live preview
    $('#name').on('input', function() {
        const name = $(this).val() || '{{ $category->name }}';
        $('#previewName').text(name);
    });

    $('#description').on('input', function() {
        const description = $(this).val() || 'No description available';
        $('#previewDescription').text(description);
    });
});

function deleteCategory() {
    $('#deleteModal').modal('show');
}
</script>
@endpush