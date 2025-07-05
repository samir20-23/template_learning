@extends('layouts.stylepages')


@section('title', 'Document Validations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">Document Validations</h1>
        <a href="{{ route('validations.pending') }}" class="btn btn-primary">
            <i class="fas fa-clock"></i> Pending Validations
        </a>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    {{-- <div class="row mb-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Validations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>
                <a href="{{ route('validations.index') }}" class="small-box-footer">
                    View All <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>  
    <div class="col-md-3">
        <div class="small-box bg-warning p-2" style="min-height: 100px;">
            <div class="inner" style="padding: 5px;">
                <h5 class="mb-1">{{ $stats['pending'] }}</h5>
                <p class="mb-1" style="font-size: 12px;">Pending</p>
            </div>
            <div class="icon" style="top: 10px; right: 10px; font-size: 20px;">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('validations.index', ['filter' => 'pending']) }}" class="small-box-footer"
                style="font-size: 12px; padding: 4px;">
                View <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
 
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['approved'] }}</h3>
                    <p>Approved</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('validations.index', ['filter' => 'approved']) }}" class="small-box-footer">
                    View Approved <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['rejected'] }}</h3>
                    <p>Rejected</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{ route('validations.index', ['filter' => 'rejected']) }}" class="small-box-footer">
                    View Rejected <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div> --}}

    <!-- Filters and Search -->
    <x-adminlte-card title="Validation Management" theme="primary" collapsible>
        <form method="GET" action="{{ route('validations.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="filter" class="form-control" onchange="this.form.submit()">
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All Validations</option>
                        <option value="pending" {{ $filter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $filter === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $filter === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by document title..."
                        value="{{ $search }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form id="bulkActionForm" method="POST" action="{{ route('validations.bulk-action') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" onclick="bulkAction('approve')">
                            <i class="fas fa-check"></i> Approve Selected
                        </button>
                        <button type="button" class="btn btn-danger" onclick="bulkAction('reject')">
                            <i class="fas fa-times"></i> Reject Selected
                        </button>
                        <button type="button" class="btn btn-warning" onclick="bulkAction('pending')">
                            <i class="fas fa-clock"></i> Set Pending
                        </button>
                    </div>
                </div>

                <div class="col-md-4 text-right">
                    <a href="{{ route('validations.index', ['filter' => 'pending']) }}"
                        class="badge badge-warning p-2 text-white text-decoration-none">
                        <i class="fas fa-clock mr-1"></i>
                        View Pending <i class="fas fa-arrow-circle-right ml-1"></i>
                    </a>

                    <span id="selectedCount" class="badge badge-info ml-2">0 selected</span>
                </div>

            </div>

            <!-- Validations Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Document</th>
                            <th>Category</th>
                            <th>Submitted By</th>
                            <th>Status</th>
                            <th>Validated By</th>
                            <th>Validated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($validations as $validation)
                            <tr>
                                <td>
                                    <input type="checkbox" name="validation_ids[]" value="{{ $validation->id }}"
                                        class="form-check-input validation-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file mr-2 text-primary"></i>
                                        <div>
                                            <strong
                                                style="text-shadow:0 0 2px white; color:rgb(0, 0, 0);">{{ $validation->document->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $validation->document->type }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $validation->document->categorie->name }}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $validation->document->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            @if ($validation->document && $validation->document->created_at)
                                                {{ $validation->document->created_at->format('M d, Y') }}
                                            @else
                                                No Date
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $validation->getStatusBadgeClass() }}">
                                        <i class="{{ $validation->getStatusIcon() }}"></i>
                                        {{ $validation->status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($validation->validator)
                                        {{ $validation->validator->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($validation->validated_at)
                                        {{ $validation->validated_at->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('validations.show', $validation) }}" class="btn btn-info"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('validations.edit', $validation) }}" class="btn btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($validation->isPending())
                                            <button type="button" class="btn btn-success"
                                                onclick="quickApprove({{ $validation->id }})" title="Quick Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No validations found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $validations->appends(request()->query())->links() }}
        </div>
    </x-adminlte-card>

    <!-- Quick Reject Modal -->
    <div class="modal fade" id="quickRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Document</h5>
                    <button type="button" class="close" style="opacity: 0;" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="quickRejectForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejectComment">Reason for rejection:</label>
                            <textarea id="rejectComment" name="commentaire" class="form-control" rows="3" required
                                placeholder="Please provide a reason for rejecting this document..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Document</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Reject Modal -->
    <div class="modal fade" id="bulkRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Reject Documents</h5>
                    <button type="button" class="close" style="opacity: 0;" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulkRejectComment">Reason for rejection:</label>
                        <textarea id="bulkRejectComment" name="commentaire" class="form-control" rows="3" required
                            placeholder="Please provide a reason for rejecting these documents..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="submitBulkReject()">Reject Selected</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 1) DOM‐ready block for checkboxes & quick‐reject form binding
        $(document).ready(function() {
            // Select all checkbox functionality
            $('#selectAll').change(function() {
                $('.validation-checkbox').prop('checked', this.checked);
                updateSelectedCount();
            });

            $('.validation-checkbox').change(function() {
                updateSelectedCount();

                // Update select‐all checkbox
                const totalCheckboxes = $('.validation-checkbox').length;
                const checkedCheckboxes = $('.validation-checkbox:checked').length;
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            function updateSelectedCount() {
                const count = $('.validation-checkbox:checked').length;
                $('#selectedCount').text(count + ' selected');
            }

            // Bind quick‐reject form submission
            $('#quickRejectForm').submit(function(e) {
                e.preventDefault();
                const comment = $('#rejectComment').val();

                $.ajax({
                    url: `/validations/${currentValidationId}/reject`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        commentaire: comment
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#quickRejectModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Error occurred while rejecting the document.');
                    }
                });
            });
        });

        // 2) Quick‐approve function (global)
        function quickApprove(validationId) {

            if (confirm('Are you sure you want to approve this document?')) {
                $.ajax({
                    url: `/validations/${validationId}/approve`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Error occurred while approving the document.');
                    }
                });
            }
        }

        // 3) Quick‐reject variables & function (global)
        let currentValidationId = null;

        // 4) Bulk‐action functions (global)
        function bulkAction(action) {

            const selectedIds = $('.validation-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Please select at least one validation.');
                return;
            }

            if (action === 'reject') {
                $('#bulkRejectModal').modal('show');
                return;
            }

            const actionText = action === 'approve' ? 'approve' : 'set as pending';
            if (confirm(`Are you sure you want to ${actionText} ${selectedIds.length} document(s)?`)) {
                $('#bulkActionForm').find('input[name="action"]').remove();
                $('#bulkActionForm').append(`<input type="hidden" name="action" value="${action}">`);
                $('#bulkActionForm').submit();
            }
        }

        function submitBulkReject() {
            const comment = $('#bulkRejectComment').val();
            if (!comment.trim()) {
                alert('Please provide a reason for rejection.');
                return;
            }

            $('#bulkActionForm').find('input[name="action"]').remove();
            $('#bulkActionForm').find('input[name="commentaire"]').remove();
            $('#bulkActionForm').append(`<input type="hidden" name="action" value="reject">`);
            $('#bulkActionForm').append(`<input type="hidden" name="commentaire" value="${comment}">`);

            $('#bulkRejectModal').modal('hide');
            $('#bulkActionForm').submit();
        }
    </script>


@stop
