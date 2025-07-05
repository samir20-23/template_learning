@extends('layouts.stylepages')


@section('title', 'Categories')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-folder"></i>
            Category Management
        </h1>
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['with_documents'] }}</h3>
                    <p>With Documents</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['empty'] }}</h3>
                    <p>Empty Categories</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder-minus"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['total_documents'] }}</h3>
                    <p>Total Documents</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file"></i>
                </div>
                <a href="{{ route('documents.index') }}" class="small-box-footer">
                    View Documents <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Management -->
    <x-adminlte-card title="Categories" theme="primary" collapsible>
        <!-- Search and Filters -->
        <form method="GET" action="{{ route('categories.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search categories..."
                        value="{{ $search }}">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-control">
                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Sort by Name</option>
                        <option value="documents_count" {{ $sort === 'documents_count' ? 'selected' : '' }}>Sort by
                            Document Count</option>
                        <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Sort by Date Created
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-control">
                        <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
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
        <form id="bulkActionForm" method="POST" action="{{ route('categories.bulk-action') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-8">
                    <button type="button" class="btn btn-danger" onclick="bulkAction('delete')">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>
                <div class="col-md-4 text-right">
                    <span id="selectedCount" class="badge badge-info">0 selected</span>
                </div>
            </div>

            <!-- Categories Grid -->
            @if ($categories->count() > 0)
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm category-card">
                                <div class="card-header d-flex justify-content-between align-items-center">

                                    @if ($category->documents_count == 0)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                                class="custom-control-input category-checkbox" id="cat{{ $category->id }}">
                                            <label class="custom-control-label" for="cat{{ $category->id }}"></label>
                                        </div>
                                    @else
                                        <div class="custom-control custom-checkbox">

                                            <button type="button" class="btn btn-secondary custom-control-input  "
                                                style="display: flex; justify-content: center;    align-items: center;    text-align: center;"
                                                disabled title="Cannot delete - has documents">
                                                <i class="fas fa-lock"></i>
                                            </button>

                                        </div>
                                    @endif
                                    <span class="badge badge-primary">
                                        {{ $category->documents_count }}
                                        {{ Str::plural('document', $category->documents_count) }}
                                    </span>
                                </div>
                                <div class="card-body text-center">
                                    <i class="fas fa-folder fa-4x text-primary mb-3"></i>
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                    @if ($category->description)
                                        <p class="card-text text-muted">
                                            {{ Str::limit($category->description, 100) }}
                                        </p>
                                    @else
                                        <p class="card-text text-muted">No description available</p>
                                    @endif

                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Created:
                                            {{ $category->created_at ? $category->created_at->format('M d, Y') : 'No date' }}

                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group btn-group-sm w-100">
                                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('documents.index', ['category' => $category->id]) }}"
                                            class="btn btn-success" title="View Documents">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($category->documents_count == 0)
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteCategory({{ $category->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary" disabled
                                                title="Cannot delete - has documents">
                                                <i class="fas fa-lock"></i>
                                            </button>
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
                    <h4 class="text-muted">No categories found</h4>
                    <p class="text-muted">Create your first category to organize documents.</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Category
                    </a>
                </div>
            @endif
        </form>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </x-adminlte-card>

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
                    <div id="categoryInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
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

@push('css')
    <style>
        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Select all functionality
            $('#selectAll').change(function() {
                $('.category-checkbox').prop('checked', this.checked);
                updateSelectedCount();
            });

            $('.category-checkbox').change(function() {
                updateSelectedCount();
            });

            function updateSelectedCount() {
                const count = $('.category-checkbox:checked').length;
                $('#selectedCount').text(count + ' selected');
            }
        });

        function deleteCategory(categoryId) {
            // Get category info
            const categoryCard = $(`#cat${categoryId}`).closest('.card');
            const categoryName = categoryCard.find('.card-title').text();

            $('#categoryInfo').html(`<strong>Category:</strong> ${categoryName}`);
            $('#deleteForm').attr('action', `/categories/${categoryId}`);
            $('#deleteModal').modal('show');
        }

        function bulkAction(action) {
            const selectedIds = $('.category-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Please select at least one category.');
                return;
            }

            if (confirm(`Are you sure you want to delete ${selectedIds.length} category(ies)?`)) {
                // Add hidden input to form
                $('#bulkActionForm').find('input[name="action"]').remove();
                $('#bulkActionForm').append(`<input type="hidden" name="action" value="${action}">`);

                $('#bulkActionForm').submit();
            }
        }
    </script>
@endpush
