<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Add admin middleware for create, edit, delete (you can adjust this based on your auth system)
        // $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of categories with search, sort, and pagination
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        // Build query with document count
        $query = Categorie::withCount('documents');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        if ($sort === 'documents_count') {
            $query->orderBy('documents_count', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        // Paginate results
        $categories = $query->paginate(12);

        // Get statistics for dashboard
        $stats = [
            'total' => Categorie::count(),
            'with_documents' => Categorie::has('documents')->count(),
            'empty' => Categorie::doesntHave('documents')->count(),
            'total_documents' => Document::count(),
        ];

        // Keep your existing variable
        $meisthebest = "im the best";

        return view('categories.index', compact(
            'categories', 
            'stats', 
            'search', 
            'sort', 
            'direction',
            'meisthebest'
        ));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category with enhanced validation
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
        ]);

        try {
            $category = Categorie::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('categories.index')
                           ->with('success', 'Category "' . $category->name . '" created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified category with its documents
     */
    public function show(Categorie $category)
    {
        // Load document count
        $category->loadCount('documents');
        
        // Get documents in this category with pagination
        $documents = $category->documents()
                             ->with(['user', 'validation'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(12);

        return view('categories.show', compact('category', 'documents'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = Categorie::withCount('documents')->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category with enhanced validation
     */
    public function update(Request $request, $id)
    {
        $category = Categorie::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'name.max' => 'Category name cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
        ]);

        try {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('categories.show', $category)
                           ->with('success', 'Category "' . $category->name . '" updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified category with safety checks
     */
    public function destroy($id)
    {
        $category = Categorie::withCount('documents')->findOrFail($id);

        // Check if category has documents
        if ($category->documents_count > 0) {
            return redirect()->back()
                           ->with('error', 'Cannot delete category "' . $category->name . '" because it contains ' . $category->documents_count . ' document(s). Please move or delete the documents first.');
        }

        try {
            $categoryName = $category->name;
            $category->delete();

            return redirect()->route('categories.index')
                           ->with('success', 'Category "' . $categoryName . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete category. Please try again.');
        }
    }

    /**
     * Handle bulk actions for multiple categories
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $categories = Categorie::withCount('documents')
                              ->whereIn('id', $request->category_ids)
                              ->get();
        
        $deletedCount = 0;
        $errors = [];

        DB::beginTransaction();
        
        try {
            foreach ($categories as $category) {
                if ($category->documents_count > 0) {
                    $errors[] = "Category '{$category->name}' has {$category->documents_count} document(s) and cannot be deleted.";
                    continue;
                }
                
                $category->delete();
                $deletedCount++;
            }

            DB::commit();

            $message = "Successfully deleted {$deletedCount} category(ies).";
            if (!empty($errors)) {
                $message .= " However, some categories could not be deleted: " . implode(" ", $errors);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred during bulk deletion. Please try again.');
        }
    }

    /**
     * Get categories for AJAX requests (useful for dropdowns)
     */
    public function getCategories(Request $request)
    {
        $search = $request->get('search');
        
        $query = Categorie::select('id', 'name', 'description')
                          ->withCount('documents');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('name')
                           ->limit(20)
                           ->get();

        return response()->json($categories);
    }

    /**
     * Get category statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_categories' => Categorie::count(),
            'categories_with_documents' => Categorie::has('documents')->count(),
            'empty_categories' => Categorie::doesntHave('documents')->count(),
            'total_documents' => Document::count(),
            'recent_categories' => Categorie::latest()->limit(5)->get(['id', 'name', 'created_at']),
            'popular_categories' => Categorie::withCount('documents')
                                           ->orderBy('documents_count', 'desc')
                                           ->limit(5)
                                           ->get(['id', 'name', 'documents_count']),
        ];

        return response()->json($stats);
    }

    /**
     * Export categories to CSV
     */
    public function export()
    {
        $categories = Categorie::withCount('documents')->get();

        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Description', 'Documents Count', 'Created At', 'Updated At']);
            
            // Add data rows
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->description,
                    $category->documents_count,
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}