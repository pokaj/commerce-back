<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request): array
    {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);

        $cleanData = [
            'name' => strip_tags($request['name']),
            'description' => strip_tags($request['description']),
            'price' => strip_tags($request['price']),
            'image' => strip_tags($request['image']),
            'quantity' => strip_tags($request['quantity']),
        ];

        Product::create($cleanData);
        return ['code' => 0, 'desc' => 'successful'];
    }


    public function getProducts(): array {
        return ['code' => 0, 'desc' => 'successful', 'data' => Product::all()];
    }

    public function retrieveProduct($id): array {
        $product = Product::find($id);
        return ['code' => 0, 'desc' => 'successful', 'data' => $product];
    }
}
