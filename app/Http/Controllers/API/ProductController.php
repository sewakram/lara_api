<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
     public function index()
    {
        $products = Product::get();
    return $this->sendResponse($products,'Products Retrieved Successfully.');
    }

    public function create()
    {
        
    } 
    
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->save();
   
        return $this->sendResponse($product, 'Product Created Successfully.');
        
    }

     public function show($id)
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse($product, 'Product Retrieved Successfully.');
    }

     public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            // 'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product = Product::find($id); 

        $product->name = is_null($request->name) ? $product->name : $input['name'];
        $product->detail = is_null($request->detail) ? $product->detail : $input['detail'];
        $product->save();
   
        return $this->sendResponse($product, 'Product Updated Successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if(!is_null($product)){
        $product->delete();
        return $this->sendResponse([], 'Product Deleted Successfully.');
        }else{
            return $this->sendError('Product not found.'); 
        }
        
    }
}
