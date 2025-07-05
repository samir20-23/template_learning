<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Categorie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        // Allow guests to browse home, show, download, category, search
        $this->middleware('auth')->except(['index', 'show', 'download', 'category', 'search']);
    }

    /**
     * Show the application home page with filters, stats, sidebar data.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get filter parameters
        $search = $request->get('search');
        $categoryId = $request->get('category');
        $type = $request->get('type');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = strtolower($request->get('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Base query: published, public, approved validations
        $documentsQuery = Document::with(['categorie', 'user'])
            ->where('status', 'published')
            ->where('is_public', true);

        //  $documentsQuery = Document::with(['categorie', 'validations', 'user'])
        // ->where('status', 'published')
        // ->where('is_public', true)
        // ->whereHas('validations', function ($q) {
        //     $q->where('status', 'Approved');
        // });

        // Apply search
        if ($search) {
            $documentsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categoryId) {
            $documentsQuery->where('categorie_id', $categoryId);
        }

        // Type filter
        if ($type) {
            $documentsQuery->where('type', $type);
        }

        // Validate sortBy
        $allowedSorts = ['created_at', 'title', 'type'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $documentsQuery->orderBy($sortBy, $sortOrder);

        // Paginate
        $documents = $documentsQuery->paginate(12)->withQueryString();

        // All categories for filter dropdown
        $categories = Categorie::orderBy('name')->get();

        // Document types for filter dropdown (distinct types among public/published)
        $documentTypes = Document::select('type')
            ->distinct()
            ->whereNotNull('type')
            ->where('status', 'published')
            ->where('is_public', true)
            ->orderBy('type')
            ->pluck('type');

        // Recent documents for sidebar (last 5 public/published/approved)
        $recentDocuments = Document::with(['categorie', 'validations', 'user'])
            ->where('status', 'published')
            ->where('is_public', true)
            ->whereHas('validations', function ($q) {
                $q->where('status', 'Approved');
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Popular categories: count public/published/approved documents
        $popularCategories = Categorie::withCount([
            'documents' => function ($q) {
                $q->where('status', 'published')
                    ->where('is_public', true)
                    ->whereHas('validations', function ($q2) {
                        $q2->where('status', 'Approved');
                    });
            }
        ])
            ->orderByDesc('documents_count')
            ->limit(6)
            ->get();

        // Stats
        $stats = [
            'total_documents' => Document::where('status', 'published')
                ->where('is_public', true)
                ->whereHas('validations', function ($q) {
                    $q->where('status', 'Approved');
                })->count(),
            'total_categories' => Categorie::count(),
            'user_uploads' => Auth::check()
                ? Document::where('user_id', Auth::id())->count()
                : 0,
            'recent_uploads' => Auth::check()
                ? Document::where('user_id', Auth::id())
                    ->where('created_at', '>=', now()->subDays(7))
                    ->count()
                : 0,
        ];

        return view('home', compact(
            'documents',
            'categories',
            'documentTypes',
            'recentDocuments',
            'popularCategories',
            'stats',
            'search',
            'categoryId',
            'type',
            'sortBy',
            'sortOrder'
        ));
    }

    /**
     * Show document details (public).
     */
    public function show(Document $document)
    {
        // Only published/public/approved
        if (
            $document->status !== 'published'
            || !$document->is_public
            || !$document->validations()->where('status', 'Approved')->exists()
        ) {
            return redirect()->route('home')->with('error', 'This document is not available.');
        }

        $document->load(['categorie', 'validations.user', 'user']);

        // Related documents
        $relatedDocuments = Document::with(['categorie', 'validations', 'user'])
            ->where('categorie_id', $document->categorie_id)
            ->where('id', '!=', $document->id)
            ->where('status', 'published')
            ->where('is_public', true)
            ->whereHas('validations', function ($q) {
                $q->where('status', 'Approved');
            })
            ->limit(4)
            ->get();

        return view('documents.show', compact('document', 'relatedDocuments'));
    }

    /**
     * Download a document (public).
     */
    public function download(Document $document)
    {
        // if (
        //     $document->status !== 'published'
        //     || !$document->is_public
        //     || !$document->validations()->where('status', 'Approved')->exists()
        // ) {
        //     return redirect()->route('home')->with('error', 'This document is not available for download.');
        // }
        if (
            $document->status !== 'published'
            || !$document->is_public
        ) {
            return redirect()->route('home')
                ->with('error', 'This document is not available for download.');
        }


        // Check file on public disk
        if (!Storage::disk('public')->exists($document->chemin_fichier)) {
            return redirect()->route('home')->with('error', 'File not found.');
        }

        $document->increment('download_count');

        $filename = $document->original_name ?: ($document->title . '.' . $document->type);
        return Storage::disk('public')->download($document->chemin_fichier, $filename);
    }

    /**
     * Browse documents by category (public).
     */
    public function category(Categorie $categorie, Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = strtolower($request->get('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Base: published/public/approved in this category
        $documentsQuery = $categorie->documents()
            ->with(['validations', 'user'])
            ->where('status', 'published')
            ->where('is_public', true)
            ->whereHas('validations', function ($q) {
                $q->where('status', 'Approved');
            });

        if ($search) {
            $documentsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $documentsQuery->where('type', $type);
        }

        // Validate sortBy
        $allowedSorts = ['created_at', 'title', 'type'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $documentsQuery->orderBy($sortBy, $sortOrder);

        $documents = $documentsQuery->paginate(12)->withQueryString();

        // Document types in this category
        $documentTypes = $categorie->documents()
            ->select('type')
            ->distinct()
            ->whereNotNull('type')
            ->where('status', 'published')
            ->where('is_public', true)
            ->orderBy('type')
            ->pluck('type');

        // Reuse other sidebar/stats if needed; for simplicity, pass only necessary:
        return view('categories.public-show', compact(
            'categorie',
            'documents',
            'documentTypes',
            'search',
            'type',
            'sortBy',
            'sortOrder'
        ));
    }

    /**
     * Search documents (public).
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        if (!$query) {
            return redirect()->route('home');
        }

        $documents = Document::with(['categorie', 'validations', 'user'])
            ->where('status', 'published')
            ->where('is_public', true)
            ->whereHas('validations', function ($q) {
                $q->where('status', 'Approved');
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('type', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhereHas('categorie', function ($cq) use ($query) {
                        $cq->where('name', 'like', "%{$query}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('search-results', compact('documents', 'query'));
    }
}
