<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;

// Default auth routes (login, register, etc.)
Auth::routes();

// Public Home

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    // Common routes
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('profile', [UserController::class, 'profile'])->name('users.profile');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('users.profile.update');

    // Public viewing
    Route::get('document/{document}', [HomeController::class, 'show'])->name('document.show');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('document/{document}/download', [HomeController::class, 'download'])->name('document.download');

    Route::get('category/{categorie}', [HomeController::class, 'category'])->name('category.show');

    // Allow any authenticated user to create/upload documents
    Route::get('documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('my-documents', [DocumentController::class, 'myDocuments'])->name('documents.my-documents');
    Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
 

    Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::get('categories/{categorie}/edit', [CategorieController::class, 'edit'])->name('categories.edit');
    Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::get('validations/{validation}/edit', [ValidationController::class, 'edit'])->name('validations.edit');
    // Admin & formateur routes
    Route::middleware([CheckRole::class . ':admin,formateur'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Categories CRUD
        Route::resource('categories', CategorieController::class)
            ->parameters(['categories' => 'categorie']);
        Route::post('categories/bulk-action', [CategorieController::class, 'bulkAction'])->name('categories.bulk-action');
        Route::get('categories-api/search', [CategorieController::class, 'getCategories'])->name('categories.api.search');
        Route::get('categories-api/stats', [CategorieController::class, 'getStats'])->name('categories.api.stats');
        Route::get('categories/export/csv', [CategorieController::class, 'export'])->name('categories.export');

        // Documents CRUD except create/store (those are in auth group)
        // Route::resource('documents', DocumentController::class)->except(['create', 'store']);
        Route::resource('documents', DocumentController::class)->except(['create', 'store', 'show']);
        Route::get('documents/{document}/view', [DocumentController::class, 'view'])->name('documents.view');
        Route::post('documents/bulk-action', [DocumentController::class, 'bulkAction'])->name('documents.bulk-action');

        // Validations
        Route::resource('validations', ValidationController::class);
        Route::get('validations-pending', [ValidationController::class, 'pending'])->name('validations.pending');
        Route::post('validations/{validation}/approve', [ValidationController::class, 'approve'])->name('validations.approve');
        Route::post('validations/{validation}/reject', [ValidationController::class, 'reject'])->name('validations.reject');
        Route::post('validations/bulk-action', [ValidationController::class, 'bulkAction'])->name('validations.bulk-action');
        Route::get('validations/document/{document}/download', [ValidationController::class, 'downloadDocument'])->name('validations.download-document');
        Route::get('validations/document/{document}/view', [ValidationController::class, 'viewDocument'])->name('validations.view-document');
        Route::get('documents/{document}/validations/create', [ValidationController::class, 'create'])->name('validations.create');
        Route::post('documents/{document}/validations', [ValidationController::class, 'store'])->name('validations.store');
        Route::get('documents/{document}/validation-exists', function ($document) {
            $doc = \App\Models\Document::findOrFail($document);
            $validation = $doc->validation;
            return response()->json([
                'exists' => $validation !== null,
                'validation_id' => $validation?->id,
            ]);
        })->name('validations.exists');
    });

    // Admin-only user management
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::get('users/export/csv', [UserController::class, 'export'])->name('users.export');
    });
});
