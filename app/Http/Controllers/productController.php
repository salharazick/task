<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
     /**
     * Display a listing of the products.
     */

    function index()
    {
        $products = product::all();

        return response()->json($products);
    }


    /**
     * Store a newly created product in storage.
     */

    function store(Request $request)
    {
        $validator= validator::make( $request->all(),
        [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ],

        );
        
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        else{

        $product = new product();

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;

        $product->save();

        return response()->json($product);
        
        }
    }

    /**
     * Display the specified product.
     */

    function show($id)
    {
        $products = product::find($id);
        if (!$products) {
            return response()->json(['message' => 'product not found'], 404);
        }
        return response()->json($products);
    }

   
    /**
     * Update the specified product from storage.
     *
     */

    function update(Request $request, $id)
    {
        $products = product::find($id);

        $products->name = $request->input('name');
        $products->price = $request->input('price');

        $products->save();

        return response()->json($products);

    }

    /**
     * Remove the specified product from storage.
     */

    function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json(['message' => 'deleted successfully']);
    }
    
     /**
     * display total product count.
     */

    function countProducts()
    {
        $count = product::count();

        return response()->json($count);
    }

}
