@extends('layouts.stylepages')

@section('title', 'My Documents')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-folder-open"></i>
            My Documents
        </h1>
        <div>
            <a href="{{ route('documents.create') }}" class="btn btn-success">
                <i class="fas fa-upload"></i> Upload New
            </a>
            @if (auth()->user()->isAdmin() || auth()->user()->isFormateur())
                <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Documents
                </a>
            @endif
        </div>
    </div>
@stop

@section('content')
    <div class="row mb-3">
        <!-- Stats Cards -->
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $stats['total'] }}" text="Total" icon="fas fa-file" theme="info" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $stats['published'] }}" text="Published" icon="fas fa-check-circle"
                theme="success" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $stats['draft'] }}" text="Draft" icon="fas fa-edit" theme="warning" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $stats['archived'] }}" text="Archived" icon="fas fa-archive"
                theme="secondary" />
        </div>
    </div>

    <!-- Filters -->
    <x-adminlte-card title="Filter Documents" theme="primary" collapsible>
        <form method="GET" action="{{ route('documents.my-documents') }}" class="form-inline">
            <div class="form-group mb-2 mr-2">
                <input type="text" name="search" class="form-control" placeholder="Search title..."
                    value="{{ old('search', $search) }}">
            </div>
            <div class="form-group mb-2 mr-2">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @if ($category == $cat->id) selected @endif>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2 mr-2">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="published" @if ($status == 'published') selected @endif>Published</option>
                    <option value="draft" @if ($status == 'draft') selected @endif>Draft</option>
                    <option value="archived" @if ($status == 'archived') selected @endif>Archived</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">
                <i class="fas fa-filter"></i> Apply
            </button>
            <a href="{{ route('documents.my-documents') }}" class="btn btn-outline-secondary mb-2 ml-2">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </form>
    </x-adminlte-card>

    <!-- Documents Table -->
    <x-adminlte-card title="Document List" theme="light" collapsible>
        @if ($documents->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Uploaded At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $doc)
                            <tr>
                                <td>{{ $doc->title }}</td>
                                <td>{{ $doc->categorie?->name }}</td>
                                <td>
                                    @if ($doc->status === 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($doc->status === 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @elseif($doc->status === 'archived')
                                        <span class="badge badge-secondary">Archived</span>
                                    @else
                                        <span class="badge badge-light">{{ $doc->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $doc->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('documents.show', $doc) }}" class="btn btn-sm btn-primary"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (auth()->user()->isAdmin() || auth()->user()->isFormateur())
                                        <a href="{{ route('documents.edit', $doc) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('documents.destroy', $doc) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Delete this document?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $documents->appends([
                        'search' => $search,
                        'category' => $category,
                        'status' => $status,
                    ])->links() }}
            </div>
        @else
            <p class="text-center text-muted">You have no documents matching the criteria.</p>
        @endif
    </x-adminlte-card>
@stop
