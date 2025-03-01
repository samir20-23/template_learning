<?php

namespace App\Http\Controllers;

use App\Models\article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import Http Facade

class ArticleController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/data');

        if ($response->successful()) {
            $data = $response->json();
            // Use null coalescing operator to avoid undefined index issues
            $message = $data['message'] ?? 'No message returned from API';
        } else {
            $message = 'Failed to fetch data from Express.';
        }

        return view('welcome', ['message' => $message]);
    }

    // ... Other methods
}
