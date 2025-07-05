@extends('layouts.stylepages')


@section('title', 'Validation Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-eye"></i>
            Validation Details
        </h1>
        <div>
            <a href="{{ route('validations.edit', $validation) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Validation
            </a>
            <a href="{{ route('validations.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to List
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Validation Information -->
        <div class="col-md-8">
            <x-adminlte-card title="Validation Information" theme="primary" collapsible>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-lg {{ $validation->getStatusBadgeClass() }}">
                                        <i class="{{ $validation->getStatusIcon() }}"></i>
                                        {{ $validation->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Validated By:</strong></td>
                                <td>
                                    @if ($validation->validator)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-check mr-2 text-primary"></i>
                                            {{ $validation->validator->name }}
                                        </div>
                                    @else
                                        <span class="text-muted">Not yet validated</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Validation Date:</strong></td>
                                <td>
                                    @if ($validation->validated_at)
                                        <i class="fas fa-calendar mr-2 text-success"></i>
                                        {{ $validation->validated_at->format('F d, Y \a\t H:i') }}
                                        <br>
                                        <small class="text-muted">{{ $validation->validated_at->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Pending validation</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Submitted:</strong></td>
                                <td>
                                    <i class="fas fa-clock mr-2 text-info"></i>
                                    {{ $validation->created_at->format('F d, Y \a\t H:i') }}
                                    <br>
                                    <small class="text-muted">{{ $validation->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if ($validation->commentaire)
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-comment"></i>
                                        Validation Comment
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $validation->commentaire }}</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                No comment provided for this validation.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                @if ($validation->isPending())
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-bolt"></i> Quick Actions</h6>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" onclick="quickApprove()">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button type="button" class="btn btn-danger" onclick="quickReject()">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                                <a href="{{ route('validations.edit', $validation) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </x-adminlte-card>
        </div>

        <!-- Document Information -->
        <div class="col-md-4">
            <x-adminlte-card title="Document Information" theme="info" collapsible>
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
                                    <a href="{{ $validation->document->fileUrl() }}" target="_blank" rel="noopener noreferrer">

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
                </div>

                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Type:</strong></td>
                        <td><span class="badge badge-secondary">{{ $validation->document->type }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td><span class="badge badge-info">{{ $validation->document->categorie->name }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Uploaded By:</strong></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user mr-2"></i>
                                {{ $validation->document->user->name }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Upload Date:</strong></td>
                        <td>
                            <small class="text-muted">
                                @if ($validation->document && $validation->document->created_at)
                                    {{ $validation->document->created_at->format('M d, Y') }}
                                @else
                                    No Date
                                @endif
                            </small>
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="btn-group btn-group-sm w-100">
                    <a href="{{ $validation->document->getDownloadUrl() }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="{{ route('validations.view-document', $validation->document) }}" class="btn btn-info"
                        target="_blank">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('documents.show', $validation->document) }}" class="btn btn-secondary">
                        <i class="fas fa-info"></i> Details
                    </a>
                </div>
            </x-adminlte-card>

            <!-- Validation History -->
            @if ($validation->document->validations->count() > 1)
                <x-adminlte-card title="Validation History" theme="secondary" collapsible>
                    <div class="timeline">
                        @foreach ($validation->document->validations->sortByDesc('created_at') as $hist)
                            <div class="time-label">
                                <span
                                    class="bg-{{ $hist->isApproved() ? 'success' : ($hist->isRejected() ? 'danger' : 'warning') }}">
                                    {{ $hist->created_at->format('M d, Y') ?? 'No Date' }}

                                </span>
                            </div>
                            <div>
                                <i
                                    class="fas {{ $hist->getStatusIcon() }} bg-{{ $hist->isApproved() ? 'success' : ($hist->isRejected() ? 'danger' : 'warning') }}"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="fas fa-clock"></i> {{ $hist->created_at->format('H:i') }}
                                    </span>
                                    <h3 class="timeline-header">
                                        Status: <strong>{{ $hist->status }}</strong>
                                    </h3>
                                    <div class="timeline-body">
                                        @if ($hist->validator)
                                            <strong>By:</strong> {{ $hist->validator->name }}<br>
                                        @endif
                                        @if ($hist->commentaire)
                                            <strong>Comment:</strong> {{ $hist->commentaire }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </x-adminlte-card>
            @endif
        </div>
    </div>

    <!-- Quick Reject Modal -->
    <div class="modal fade" id="quickRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Document</h5>
                    <button type="button" class="close"  style="opacity: 0;"  data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="quickRejectForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            You are about to reject this document. Please provide a reason.
                        </div>
                        <div class="form-group">
                            <label for="rejectComment">Reason for rejection:</label>
                            <textarea id="rejectComment" name="commentaire" class="form-control" rows="4" required
                                placeholder="Please provide a detailed reason for rejecting this document..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  style="opacity: 0;"  data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Reject Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
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

        .badge-lg {
            font-size: 1em;
            padding: 0.5em 0.75em;
        }
    </style>
@endpush

@push('js')
    <script>
        function quickApprove() {
            if (confirm('Are you sure you want to approve this document?')) {
                $.ajax({
                    url: '{{ route('validations.update', $validation) }}',
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 'Approved',
                        commentaire: 'Quick approval'
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function() {
                        alert('Error occurred while approving the document.');
                    }
                });
            }
        }

        function quickReject() {
            $('#quickRejectModal').modal('show');
        }

        $('#quickRejectForm').submit(function(e) {
            e.preventDefault();

            const comment = $('#rejectComment').val();

            $.ajax({
                url: '{{ route('validations.update', $validation) }}',
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: 'Rejected',
                    commentaire: comment
                },
                success: function(response) {
                    $('#quickRejectModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Error occurred while rejecting the document.');
                }
            });
        });
    </script>
@endpush
