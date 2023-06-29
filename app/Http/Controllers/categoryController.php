<?php

namespace App\Http\Controllers;

use App\Http\Requests\crudValidation;
use App\Models\category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */

    function index()
    {
        $category = category::all();

        return response()->json($category);
    }


    /**
     * Store a newly created category in storage.
     */

    function store(crudValidation $request)
    {
        $validatedData = $request->validated();
    
        $category = new category();
    
        $category->name = $validatedData['name'];

        $category->save();
    
        return response()->json($category);
    }

    /**
     * Display the specified category.
     */

    function show($id)
    {
        $category = category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    
    /**
     * Update the specified category in storage.
     */

    function update(Request $request, $id)
    {
        $category = category::find($id);

        $category->name = $request->input('name');
        $category->save();

        return response()->json($category);
    }

    /**
     * Remove the specified category from storage.
     */

    function destroy($id)
    {
        $category = category::find($id);
        $category->delete();

        return response()->json($category);
    }
}
