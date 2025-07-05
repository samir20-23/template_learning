@extends('layouts.stylepages')

@section('title', 'Create Category')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="font-weight-bold text-dark">
            <i class="fas fa-plus"></i>
            Create New Category
        </h1>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> Back to Categories
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Create Form -->
        <div class="col-md-8">
            <x-adminlte-card title="Category Information" theme="primary" collapsible>
                <form action="{{ route('categories.store') }}" method="POST" id="createForm">
                    @csrf

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-tag"></i>
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required 
                               placeholder="Enter category name...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Choose a descriptive name for this category.
                        </small>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-align-left"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Enter category description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Provide a brief description of what documents belong in this category.
                        </small>
                    </div>

                    <!-- Submit Buttons -->
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Create Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>
        </div>

        <!-- Guidelines -->
        <div class="col-md-4">
            <x-adminlte-card title="Category Guidelines" theme="info" collapsible>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Best Practices:</strong>
                </div>
                
                <h6><i class="fas fa-check-circle text-success"></i> Good Category Names:</h6>
                <ul>
                    <li>Legal Documents</li>
                    <li>Financial Reports</li>
                    <li>HR Policies</li>
                    <li>Technical Manuals</li>
                    <li>Marketing Materials</li>
                </ul>

                <h6><i class="fas fa-lightbulb text-warning"></i> Tips:</h6>
                <ul>
                    <li>Use clear, descriptive names</li>
                    <li>Keep names concise but meaningful</li>
                    <li>Avoid special characters</li>
                    <li>Think about document organization</li>
                    <li>Consider future scalability</li>
                </ul>

                <h6><i class="fas fa-exclamation-triangle text-danger"></i> Avoid:</h6>
                <ul>
                    <li>Vague names like "Misc" or "Other"</li>
                    <li>Overly long names</li>
                    <li>Duplicate categories</li>
                    <li>Too many subcategories</li>
                </ul>
            </x-adminlte-card>

            <!-- Category Preview -->
            <x-adminlte-card title="Preview" theme="secondary" collapsible>
                <div class="text-center">
                    <i class="fas fa-folder fa-4x text-primary mb-3"></i>
                    <h5 id="previewName">Category Name</h5>
                    <p id="previewDescription" class="text-muted">Category description will appear here...</p>
                    
                    <div class="alert alert-success">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            This is how your category will appear in the system.
                        </small>
                    </div>
                </div>
            </x-adminlte-card>

            <!-- Quick Templates -->
            <x-adminlte-card title="Quick Templates" theme="success" collapsible>
                <div class="btn-group-vertical w-100">
                    <button type="button" class="btn btn-outline-primary" onclick="setTemplate('legal')">
                        <i class="fas fa-gavel"></i> Legal Documents
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="setTemplate('financial')">
                        <i class="fas fa-chart-line"></i> Financial Reports
                    </button>
                    <button type="button" class="btn btn-outline-info" onclick="setTemplate('hr')">
                        <i class="fas fa-users"></i> HR Documents
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="setTemplate('technical')">
                        <i class="fas fa-cogs"></i> Technical Manuals
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="setTemplate('marketing')">
                        <i class="fas fa-bullhorn"></i> Marketing Materials
                    </button>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
$(document).ready(function() {
    // Live preview
    $('#name').on('input', function() {
        const name = $(this).val() || 'Category Name';
        $('#previewName').text(name);
    });

    $('#description').on('input', function() {
        const description = $(this).val() || 'Category description will appear here...';
        $('#previewDescription').text(description);
    });
});

function setTemplate(type) {
    const templates = {
        legal: {
            name: 'Legal Documents',
            description: 'Legal contracts, agreements, policies, and compliance documents.'
        },
        financial: {
            name: 'Financial Reports',
            description: 'Financial statements, budgets, invoices, and accounting documents.'
        },
        hr: {
            name: 'HR Documents',
            description: 'Human resources policies, employee handbooks, and personnel documents.'
        },
        technical: {
            name: 'Technical Manuals',
            description: 'Technical documentation, user manuals, and system guides.'
        },
        marketing: {
            name: 'Marketing Materials',
            description: 'Marketing campaigns, brochures, presentations, and promotional content.'
        }
    };

    if (templates[type]) {
        $('#name').val(templates[type].name).trigger('input');
        $('#description').val(templates[type].description).trigger('input');
    }
}
</script>
@endpush