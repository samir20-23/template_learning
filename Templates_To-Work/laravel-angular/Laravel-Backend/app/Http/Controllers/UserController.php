<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only admins can manage users (you can adjust this based on your needs)
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        })->except(['show', 'profile', 'updateProfile']);
    }

    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        // Build query with document and validation counts
        $query = User::withCount(['documents', 'validations']);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($role && in_array($role, ['admin', 'user','Formateur'])) {
            $query->where('role', $role);
        }

        // Apply sorting
        if (in_array($sort, ['documents_count', 'validations_count'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $users = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'Formateurs' => User::where('role', 'Formateur')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'total_documents' => Document::count(),
            'total_validations' => Validation::count(),
            'recent_users' => User::latest()->limit(5)->count(),
        ];

        return view('users.index', compact(
            'users',
            'stats',
            'search',
            'role',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,User,Formateur',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email_verified_at' => now(), // Auto-verify admin created users
            ]);

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user. Please try again.');
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        // Load relationships with counts
        $user->loadCount(['documents', 'validations']);

        // Get user's recent documents
        $recentDocuments = $user->documents()
            ->with(['categorie', 'validation'])
            ->latest()
            ->limit(10)
            ->get();

        // Get user's recent validations (if admin)
        $recentValidations = collect();
        if ($user->isAdmin() || $user->isFormateur()) {
            $recentValidations = $user->validations()
                ->with(['document', 'document.user'])
                ->latest()
                ->limit(10)
                ->get();
        }

        // Get user statistics
        $userStats = [
            'documents_by_status' => $user->documents()
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'validations_by_status' => $user->validations()
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
        ];

        return view('users.show', compact(
            'user',
            'recentDocuments',
            'recentValidations',
            'userStats'
        ));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $user->loadCount(['documents', 'validations']);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,User,Formateur',
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('users.show', $user)
                ->with('success', 'User "' . $user->name . '" updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current user
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        // Check if user has documents
        if ($user->documents()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete user "' . $user->name . '" because they have ' . $user->documents()->count() . ' document(s). Please reassign or delete the documents first.');
        }

        try {
            $userName = $user->name;
            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'User "' . $userName . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete user. Please try again.');
        }
    }

    /**
     * Handle bulk actions for multiple users
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,make_admin,make_Formateur,make_user',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Remove current user from bulk actions
        $userIds = array_filter($request->user_ids, function ($id) {
            return $id != Auth::id();
        });

        if (empty($userIds)) {
            return redirect()->back()->with('error', 'No valid users selected for bulk action.');
        }

        $users = User::whereIn('id', $userIds)->get();
        $count = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($users as $user ) {
                switch ($request->action) {
                    case 'delete':
                        if ($user->documents()->count() > 0) {
                            $errors[] = "User '{$user->name}' has documents and cannot be deleted.";
                            continue 2;
                        }
                        $user->delete();
                        break;

                    case 'make_admin':
                        $user->update(['role' => 'admin']);
                        break;
                    case 'make_Formateur':
                        $user->update(['role' => 'Formateur']);
                        break;
                          case 'make_user':
                        $user->update(['role' => 'user']);
                        break;
                }
                $count++;
            }

            DB::commit();

            $actionName = str_replace('_', ' ', $request->action);
            $message = "Successfully performed '{$actionName}' on {$count} user(s).";

            if (!empty($errors)) {
                $message .= " However, some actions failed: " . implode(" ", $errors);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred during bulk action. Please try again.');
        }
    }

    /**
     * Show user profile (for current user)
     */
    public function profile()
    {
        $user = Auth::user();
        $user->loadCount(['documents', 'validations']);

        // Get user's recent documents
        $recentDocuments = $user->documents()
            ->with(['categorie', 'validation'])
            ->latest()
            ->limit(5)
            ->get();

        return view('users.profile', compact('user', 'recentDocuments'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => 'required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verify current password if changing password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            return redirect()->route('users.profile')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        $users = User::withCount(['documents', 'validations'])->get();

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Documents Count', 'Validations Count', 'Created At', 'Email Verified']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->documents_count,
                    $user->validations_count,
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->email_verified_at ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
