<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::select('title', 'description', 'image')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "image" => "required|image"
        ]);

        $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension(); // Fixed typo in getClientOriginalExtension
        Storage::disk('public')->putFileAs('product/image', $request->image, $imageName); // Fixed disk name and putFileAs method

        Product::create($request->post() + ['image' => $imageName]); // Fixed case and image field name

        return response()->json(
            ['message' => 'Item added successfully']
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(product $product) {
        return response()->json([
         "product"=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
    }
}
