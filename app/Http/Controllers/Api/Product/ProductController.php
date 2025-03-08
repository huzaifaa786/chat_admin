<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Api::setResponse('products', $products);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $product = Product::create($data);
        return Api::setResponse('product', $product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return Api::setResponse('product', $product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return Api::setResponse('product', $product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return Api::setMessage('Product deleted successfully');
    }
}
