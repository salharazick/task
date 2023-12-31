<?php

namespace App\Http\Controllers;

use App\Http\Requests\categoryStoreRequest;
use App\Http\Requests\productUpdateRequest;
use App\Http\Resources\categoryResource;
use App\Models\category;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = category::paginate(2);
        return response()->json(categoryResource::collection($category));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categoryStoreRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category = category::create($request->validated());

        return response()->json(new categoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        return response()->json(new categoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(productUpdateRequest $request, category $category)
    {
        $category->update($request->validated());

        return response()->json(new categoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        $category->delete();

        return response()->json(['message'=>'delete success'], 204);
    }
}
