<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ValidationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Add admin middleware if you have role-based access
        // $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of validations
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');
      
        $query = Validation::with(['document.categorie', 'document.user', 'validator'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        switch ($filter) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved();
                break;
            case 'rejected':
                $query->rejected();
                break;
        }

        // Apply search
        if ($search) {
            $query->whereHas('document', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $validations = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => Validation::count(),
            'pending' => Validation::pending()->count(),
            'approved' => Validation::approved()->count(),
            'rejected' => Validation::rejected()->count(),
        ];

        return view('validations.index', compact('validations', 'stats', 'filter', 'search'));
    }

    /**
     * Show documents that need validation
     */
    public function pending()
    {
        $documents = Document::with(['categorie', 'user', 'validation'])
            ->needsValidation()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('validations.pending', compact('documents'));
    }

    /**
     * Show the form for creating a new validation
     */
    public function create(Document $document)
    {
        // Check if document already has a validation
        if ($document->validation) {
            return redirect()->route('validations.show', $document->validation)
                ->with('info', 'This document already has a validation record.');
        }

        return view('validations.create', compact('document'));
    }

    /**
     * Store a newly created validation
     */
    public function store(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Check if validation already exists
        if ($document->validation) {
            return redirect()->route('validations.show', $document->validation)
                ->with('error', 'This document already has a validation record.');
        }

        $validation = Validation::create([
            'document_id' => $document->id,
            'validated_by' => Auth::id(),
            'status' => $request->status,
            'commentaire' => $request->commentaire,
            'validated_at' => $request->status !== 'Pending' ? now() : null,
        ]);

        $message = match ($request->status) {
            'Approved' => 'Document has been approved successfully!',
            'Rejected' => 'Document has been rejected.',
            'Pending' => 'Document validation is now pending.',
        };

        return redirect()->route('validations.show', $validation)
            ->with('success', $message);
    }

    /**
     * Display the specified validation
     */
    public function show(Validation $validation)
    {
        $validation->load(['document.categorie', 'document.user', 'validator']);
         
        return view('validations.show', compact('validation'));
    }

    /**
     * Show the form for editing the specified validation
     */
    public function edit(Validation $validation)
    {
        $validation->load(['document.categorie', 'document.user']);

        return view('validations.edit', compact('validation'));
    }

    /**
     * Update the specified validation
     */
    public function update(Request $request, Validation $validation)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $validation->status;

        $validation->update([
            'status' => $request->status,
            'commentaire' => $request->commentaire,
            'validated_by' => Auth::id(),
            'validated_at' => $request->status !== 'Pending' ? now() : null,
        ]);

        $message = match ($request->status) {
            'Approved' => 'Document has been approved successfully!',
            'Rejected' => 'Document has been rejected.',
            'Pending' => 'Document validation is now pending.',
        };

        return redirect()->route('validations.show', $validation)
            ->with('success', $message);
    }

    /**
     * Quick validation actions
     */
    public function approve(Validation $validation)
    {
        $validation->update([
            'status' => 'Approved',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document approved successfully!',
            'status' => 'Approved'
        ]);
    }

    public function reject(Request $request, Validation $validation)
    {
        $request->validate([
            'commentaire' => 'required|string|max:1000',
        ]);

        $validation->update([
            'status' => 'Rejected',
            'commentaire' => $request->commentaire,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document rejected successfully!',
            'status' => 'Rejected'
        ]);
    }

    /**
     * Bulk validation actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,pending',
            'validation_ids' => 'required|array',
            'validation_ids.*' => 'exists:validations,id',
            'commentaire' => 'required_if:action,reject|string|max:1000',
        ]);

        $validations = Validation::whereIn('id', $request->validation_ids)->get();

        $status = match ($request->action) {
            'approve' => 'Approved',
            'reject' => 'Rejected',
            'pending' => 'Pending',
        };

        foreach ($validations as $validation) {
            $validation->update([
                'status' => $status,
                'commentaire' => $request->commentaire ?? $validation->commentaire,
                'validated_by' => Auth::id(),
                'validated_at' => $status !== 'Pending' ? now() : null,
            ]);
        }

        $count = $validations->count();
        $message = "Successfully {$request->action}d {$count} document(s).";

        return redirect()->back()->with('success', $message);
    }

    /**
     * Download document for validation
     */

    // In ValidationController.php
    public function downloadDocument(Document $document)
    {
        if (!Storage::exists($document->chemin_fichier)) {
            return redirect()->back()->with('error', 'File not found.');
        }
        return Storage::download($document->chemin_fichier, $document->title);
    }

    /**
     * View document for validation
     */
    public function viewDocument(Document $document)
    {
        if (!Storage::exists($document->chemin_fichier)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = Storage::path($document->chemin_fichier);
        $mimeType = Storage::mimeType($document->chemin_fichier);

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->title . '"'
        ]);
    }

    /**
     * Remove the specified validation
     */
    public function destroy(Validation $validation)
    {
        $validation->delete();

        return redirect()->route('validations.index')
            ->with('success', 'Validation record deleted successfully.');
    }
}
