<?php

namespace App\Http\Controllers;

use App\Http\Requests\productStoreRequest;
use App\Http\Requests\productUpdateRequest;
use App\Http\Resources\productResource;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $category = $request->query('category_id');
        $perPage = $request->query('paginate');

        $query = Product::query();

        if ($category) {
            $query->where('category_id', $category);
        }

        $products = $query->paginate($perPage);

       
        $nextPageUrl = $products->appends($request->query())->nextPageUrl();

        return response()->json([
            'data' => productResource::collection($products),
            'next_page_url' => $nextPageUrl,
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(productStoreRequest $request)
     {
        try {
            $validator = Validator::make($request->all(), $request->rules());
     
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
             
            $product = product::create($request->validated());
     
            return response()->json(new productResource($product), 201);
            } 

        catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors()
            ], 422);
            }

        catch (\Exception $exception) {
            Log::error($exception);
            return response()->json(['error' => 'An error occurred while storing the product.'], 500);
        }

    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        return response()->json(new productResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(productUpdateRequest $request, product $product)
    {

    try {
        $product->update($request->validated());
        return response()->json(new productResource($product));
        }

    catch (\Exception $exception)
        {
        Log::error($exception);
        return response()->json(['error' => 'An error occurred during the update.'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        $product->delete();

        return response()->json(['message'=>'delete success'], 204);
    }
}
