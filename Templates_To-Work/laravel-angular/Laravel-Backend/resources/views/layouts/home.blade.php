@extends('layouts.stylepages')

@section('title', 'Document Library - ' . config('app.name'))

@section('content')
<div class="home-container">
    {{-- Hero Section --}}
    <div class="hero-section" data-aos="fade-up">
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Document Library</h1>
            <p class="hero-subtitle">Discover, download, and share educational resources and documents</p>
            
            {{-- Search Bar --}}
            <div class="hero-search">
                <form action="{{ route('home') }}" method="GET" class="search-form">
                    <div class="search-input-group">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Search documents, categories, or file types..." 
                               class="search-input">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Stats Cards --}}
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($stats['total_documents']) }}</h3>
                    <p class="stat-label">Total Documents</p>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($stats['total_categories']) }}</h3>
                    <p class="stat-label">Categories</p>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($stats['user_uploads']) }}</h3>
                    <p class="stat-label">Your Uploads</p>
                </div>
            </div>
            
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($stats['recent_uploads']) }}</h3>
                    <p class="stat-label">This Week</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="content-grid">
            {{-- Sidebar --}}
            <aside class="sidebar" data-aos="fade-right">
                {{-- Categories --}}
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-folder me-2"></i>Popular Categories
                    </h3>
                    <div class="category-list">
                        @foreach($popularCategories as $category)
                        <a href="{{ route('category.show', $category) }}" class="category-item">
                            <span class="category-name">{{ $category->name }}</span>
                            <span class="category-count">{{ $category->documents_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Documents --}}
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-clock me-2"></i>Recent Documents
                    </h3>
                    <div class="recent-list">
                        @foreach($recentDocuments as $doc)
                        <a href="{{ route('document.show', $doc) }}" class="recent-item">
                            <div class="recent-icon">
                                <i class="fas fa-file-{{ $doc->type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                            </div>
                            <div class="recent-content">
                                <p class="recent-title">{{ Str::limit($doc->title, 30) }}</p>
                                <small class="recent-date">{{ $doc->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Upload --}}
                <div class="sidebar-section">
                    <div class="quick-upload-card">
                        <h4 class="quick-upload-title">Share a Document</h4>
                        <p class="quick-upload-text">Upload and share your educational resources</p>
                        <a href="{{ route('documents.create') }}" class="quick-upload-btn">
                            <i class="fas fa-plus me-2"></i>Upload Document
                        </a>
                    </div>
                </div>
            </aside>

            {{-- Main Documents Area --}}
            <main class="documents-area">
                {{-- Filters --}}
                <div class="filters-section" data-aos="fade-up">
                    <div class="filters-header">
                        <h2 class="filters-title">Browse Documents</h2>
                        <div class="filters-actions">
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="grid">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-btn" data-view="list">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('home') }}" method="GET" class="filters-form">
                        <input type="hidden" name="search" value="{{ $search }}">
                        
                        <div class="filter-group">
                            <select name="category" class="filter-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <select name="type" class="filter-select">
                                <option value="">All Types</option>
                                @foreach($documentTypes as $docType)
                                <option value="{{ $docType }}" {{ $type == $docType ? 'selected' : '' }}>
                                    {{ ucfirst($docType) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <select name="sort_by" class="filter-select">
                                <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Date</option>
                                <option value="title" {{ $sortBy == 'title' ? 'selected' : '' }}>Title</option>
                                <option value="type" {{ $sortBy == 'type' ? 'selected' : '' }}>Type</option>
                                <option value="download_count" {{ $sortBy == 'download_count' ? 'selected' : '' }}>Downloads</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <select name="sort_order" class="filter-select">
                                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Newest First</option>
                                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>

                        <button type="submit" class="filter-apply-btn">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>

                        @if($search || $categoryId || $type)
                        <a href="{{ route('home') }}" class="filter-clear-btn">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                        @endif
                    </form>
                </div>

                {{-- Documents Grid --}}
                <div class="documents-grid" id="documentsContainer" data-aos="fade-up" data-aos-delay="200">
                    @forelse($documents as $document)
                    <div class="document-card">
                        <div class="document-header">
                            <div class="document-type-badge">
                                <i class="fas fa-file-{{ $document->type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                                {{ strtoupper($document->type) }}
                            </div>
                            <div class="document-actions">
                                <button class="action-btn" onclick="toggleFavorite({{ $document->id }})">
                                    <i class="far fa-heart"></i>
                                </button>
                                <div class="dropdown">
                                    <button class="action-btn dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('document.show', $document) }}">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('document.download', $document) }}">
                                            <i class="fas fa-download me-2"></i>Download
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="document-content">
                            <h3 class="document-title">
                                <a href="{{ route('document.show', $document) }}">{{ $document->title }}</a>
                            </h3>
                            
                            @if($document->description)
                            <p class="document-description">{{ Str::limit($document->description, 100) }}</p>
                            @endif
                            
                            <div class="document-meta">
                                <span class="document-category">
                                    <i class="fas fa-folder me-1"></i>
                                    <a href="{{ route('category.show', $document->categorie) }}">
                                        {{ $document->categorie->name }}
                                    </a>
                                </span>
                                <span class="document-date">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $document->created_at->format('M d, Y') }}
                                </span>
                                <span class="document-size">
                                    <i class="fas fa-file me-1"></i>
                                    {{ $document->formatted_file_size }}
                                </span>
                                <span class="document-downloads">
                                    <i class="fas fa-download me-1"></i>
                                    {{ number_format($document->download_count) }} downloads
                                </span>
                            </div>
                        </div>

                        <div class="document-footer">
                            <a href="{{ route('document.show', $document) }}" class="btn-view">
                                <i class="fas fa-eye me-2"></i>View
                            </a>
                            <a href="{{ route('document.download', $document) }}" class="btn-download">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="no-documents">
                        <div class="no-documents-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="no-documents-title">No documents found</h3>
                        <p class="no-documents-text">Try adjusting your search criteria or browse different categories.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-2"></i>Reset Filters
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($documents->hasPages())
                <div class="pagination-wrapper" data-aos="fade-up">
                    {{ $documents->links() }}
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Home Container */
    .home-container {
        min-height: 100vh;
        background: var(--gradient-bg);
    }

    /* Hero Section */
    .hero-section {
        background: var(--gradient-card);
        padding: 4rem 2rem;
        border-radius: 0 0 2rem 2rem;
        margin-bottom: 3rem;
        border: 1px solid var(--border-color);
    }

    .hero-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 3rem;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
        font-weight: 500;
    }

    /* Search Bar */
    .hero-search {
        max-width: 600px;
        margin: 0 auto;
    }

    .search-form {
        position: relative;
    }

    .search-input-group {
        position: relative;
        display: flex;
        align-items: center;
        background: var(--bg-card);
        border: 2px solid var(--border-color);
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .search-input-group:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .search-icon {
        color: var(--text-muted);
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .search-input::placeholder {
        color: var(--text-muted);
    }

    .search-btn {
        background: var(--gradient-primary);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 1rem;
    }

    .search-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient-primary);
        color: white;
        font-size: 1.25rem;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
    }

    .stat-label {
        color: var(--text-secondary);
        font-weight: 600;
        margin: 0;
    }

    /* Main Content */
    .main-content {
        padding: 0 2rem 3rem;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 3rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Sidebar */
    .sidebar {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 2rem;
        height: fit-content;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 2rem;
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    /* Category List */
    .category-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--text-secondary);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .category-item:hover {
        background: var(--bg-secondary);
        color: var(--primary-color);
        border-color: var(--border-color);
    }

    .category-name {
        font-weight: 500;
    }

    .category-count {
        background: var(--bg-secondary);
        color: var(--text-muted);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Recent List */
    .recent-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .recent-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .recent-item:hover {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }

    .recent-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-secondary);
        color: var(--primary-color);
        flex-shrink: 0;
    }

    .recent-title {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 0.25rem;
        font-size: 0.875rem;
    }

    .recent-date {
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    /* Quick Upload */
    .quick-upload-card {
        background: var(--gradient-primary);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        color: white;
    }

    .quick-upload-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .quick-upload-text {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .quick-upload-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .quick-upload-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    /* Documents Area */
    .documents-area {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
    }

    /* Filters Section */
    .filters-section {
        margin-bottom: 2rem;
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .filters-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-btn.active,
    .view-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .filters-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .filter-apply-btn,
    .filter-clear-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .filter-apply-btn {
        background: var(--gradient-primary);
        color: white;
    }

    .filter-apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .filter-clear-btn {
        background: var(--bg-secondary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .filter-clear-btn:hover {
        background: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }

    /* Documents Grid */
    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .document-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-color);
    }

    .document-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--border-light);
    }

    .document-type-badge {
        background: var(--gradient-primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .document-content {
        padding: 1rem;
    }

    .document-title {
        margin: 0 0 0.5rem;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .document-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .document-title a:hover {
        color: var(--primary-color);
    }

    .document-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .document-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .document-category,
    .document-date,
    .document-size,
    .document-downloads {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .document-category a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .document-footer {
        display: flex;
        gap: 0.75rem;
        padding: 1rem;
        border-top: 1px solid var(--border-light);
    }

    .btn-view,
    .btn-download {
        flex: 1;
        padding: 0.75rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-view:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-download {
        background: var(--gradient-primary);
        color: white;
        border: 1px solid var(--primary-color);
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* No Documents */
    .no-documents {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-documents-icon {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .no-documents-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .no-documents-text {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .content-grid {
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .sidebar {
            position: static;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 2rem 1rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .main-content {
            padding: 0 1rem 2rem;
        }

        .documents-grid {
            grid-template-columns: 1fr;
        }

        .filters-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            min-width: auto;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // View toggle functionality
    const viewBtns = document.querySelectorAll('.view-btn');
    const documentsContainer = document.getElementById('documentsContainer');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            if (view === 'list') {
                documentsContainer.classList.add('list-view');
            } else {
                documentsContainer.classList.remove('list-view');
            }
        });
    });

    // Favorite toggle functionality
    window.toggleFavorite = function(documentId) {
        const btn = event.target.closest('.action-btn');
        const icon = btn.querySelector('i');
        
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btn.style.color = '#ef4444';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            btn.style.color = '';
        }
    };

    // Auto-submit filters on change
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endpush
