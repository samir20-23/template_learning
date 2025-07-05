<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Validation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Basic counts (your existing code)
        $totalDocuments = Document::count();
        $totalCategories = Categorie::count();
        $totalUsers = User::count();
        $totalValidations = Validation::count();
        $pendingValidations = Validation::where('status', 'Pending')->count();

        // Enhanced data for charts
        $monthlyGrowth = $this->getMonthlyGrowthData();
        $documentTypes = $this->getDocumentTypesData();
        $categoryBreakdown = $this->getCategoryBreakdownData();
        $validationStats = $this->getValidationStatsData();
        $validationTrends = $this->getValidationTrendsData();

        return view('dashboard', compact(
            'totalDocuments',
            'totalCategories',
            'totalUsers',
            'totalValidations',
            'pendingValidations',
            'monthlyGrowth',
            'documentTypes',
            'categoryBreakdown',
            'validationStats',
            'validationTrends'
        ));
    }

    private function getMonthlyGrowthData()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            
            $months[] = [
                'month' => $monthName,
                'documents' => Document::whereYear('created_at', $date->year)
                                     ->whereMonth('created_at', $date->month)
                                     ->count(),
                'categories' => Categorie::whereYear('created_at', $date->year)
                                       ->whereMonth('created_at', $date->month)
                                       ->count(),
                'users' => User::whereYear('created_at', $date->year)
                              ->whereMonth('created_at', $date->month)
                              ->count(),
                'validations' => Validation::whereYear('created_at', $date->year)
                                          ->whereMonth('created_at', $date->month)
                                          ->count()
            ];
        }
        
        return $months;
    }

    private function getDocumentTypesData()
    {
        // Using your 'type' column from documents table
        $documentTypes = Document::select('type', DB::raw('count(*) as count'))
                               ->whereNotNull('type')
                               ->groupBy('type')
                               ->orderBy('count', 'desc')
                               ->get();

        // If no data exists, return sample data
        if ($documentTypes->isEmpty()) {
            return [
                ['type' => 'PDF Documents', 'count' => 0],
                ['type' => 'Word Documents', 'count' => 0],
                ['type' => 'Excel Files', 'count' => 0],
                ['type' => 'Other Files', 'count' => 0]
            ];
        }

        return $documentTypes->map(function($item) {
            return [
                'type' => $this->formatDocumentType($item->type),
                'count' => $item->count
            ];
        })->toArray();
    }

    private function getCategoryBreakdownData()
    {
        // Using your Categorie model with documents relationship
        $categories = Categorie::withCount('documents')
                             ->orderBy('documents_count', 'desc')
                             ->get();

        // If no data exists, return sample data
        if ($categories->isEmpty()) {
            return [
                ['category' => 'General', 'count' => 0],
                ['category' => 'Administrative', 'count' => 0],
                ['category' => 'Technical', 'count' => 0]
            ];
        }

        return $categories->map(function($category) {
            return [
                'category' => $category->name,
                'count' => $category->documents_count
            ];
        })->toArray();
    }

    private function getValidationStatsData()
    {
        // Using your Validation model with status field
        $validationStats = Validation::select('status', DB::raw('count(*) as count'))
                                   ->groupBy('status')
                                   ->get();

        // If no data exists, return sample data with your status values
        if ($validationStats->isEmpty()) {
            return [
                ['status' => 'Approved', 'count' => 0],
                ['status' => 'Pending', 'count' => 0],
                ['status' => 'Rejected', 'count' => 0],
                ['status' => 'Under Review', 'count' => 0]
            ];
        }

        return $validationStats->map(function($item) {
            return [
                'status' => $this->formatValidationStatus($item->status),
                'count' => $item->count
            ];
        })->toArray();
    }

    private function getValidationTrendsData()
    {
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M');
            
            // Get validations for this month grouped by status
            $monthlyValidations = Validation::whereYear('created_at', $date->year)
                                           ->whereMonth('created_at', $date->month)
                                           ->select('status', DB::raw('count(*) as count'))
                                           ->groupBy('status')
                                           ->pluck('count', 'status');
            
            $trends[] = [
                'month' => $monthName,
                'approved' => $monthlyValidations['Approved'] ?? $monthlyValidations['approved'] ?? 0,
                'pending' => $monthlyValidations['Pending'] ?? $monthlyValidations['pending'] ?? 0,
                'rejected' => $monthlyValidations['Rejected'] ?? $monthlyValidations['rejected'] ?? 0,
                'under_review' => $monthlyValidations['Under Review'] ?? $monthlyValidations['under_review'] ?? 0
            ];
        }
        
        return $trends;
    }

    private function formatDocumentType($type)
    {
        // Format document types based on your 'type' field
        $types = [
            'pdf' => 'PDF Documents',
            'doc' => 'Word Documents',
            'docx' => 'Word Documents',
            'xls' => 'Excel Files',
            'xlsx' => 'Excel Files',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
            'txt' => 'Text Files',
            'image' => 'Images',
            'video' => 'Videos'
        ];
        
        $lowerType = strtolower($type);
        return $types[$lowerType] ?? ucfirst($type) . ' Files';
    }

    private function formatValidationStatus($status)
    {
        // Format validation status to ensure consistency
        $statusMap = [
            'pending' => 'Pending',
            'Pending' => 'Pending',
            'approved' => 'Approved',
            'Approved' => 'Approved',
            'rejected' => 'Rejected',
            'Rejected' => 'Rejected',
            'under_review' => 'Under Review',
            'Under Review' => 'Under Review',
            'in_review' => 'Under Review'
        ];
        
        return $statusMap[$status] ?? ucfirst($status);
    }

    // Additional helper methods for your specific use case

    /**
     * Get documents by category for detailed analysis
     */
    public function getDocumentsByCategory()
    {
        return Categorie::with('documents')
                       ->get()
                       ->map(function($category) {
                           return [
                               'category' => $category->name,
                               'documents' => $category->documents->count(),
                               'recent_documents' => $category->documents()
                                                           ->where('created_at', '>=', Carbon::now()->subDays(30))
                                                           ->count()
                           ];
                       });
    }

    /**
     * Get user activity statistics
     */
    public function getUserActivityStats()
    {
        return User::withCount(['documents' => function($query) {
                        $query->where('created_at', '>=', Carbon::now()->subDays(30));
                    }])
                   ->orderBy('documents_count', 'desc')
                   ->limit(10)
                   ->get();
    }

    /**
     * Get validation performance metrics
     */
    public function getValidationPerformance()
    {
        $totalValidations = Validation::count();
        $approvedValidations = Validation::where('status', 'Approved')->count();
        $avgValidationTime = Validation::whereNotNull('validated_at')
                                     ->selectRaw('AVG(DATEDIFF(validated_at, created_at)) as avg_days')
                                     ->first();

        return [
            'approval_rate' => $totalValidations > 0 ? round(($approvedValidations / $totalValidations) * 100, 2) : 0,
            'avg_validation_days' => $avgValidationTime->avg_days ?? 0,
            'pending_ratio' => $totalValidations > 0 ? round((Validation::where('status', 'Pending')->count() / $totalValidations) * 100, 2) : 0
        ];
    }
}