<?php

namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductsController extends Controller {
    public function list(Request $request) {
        $query = Product::query();

        $query->when($request->keywords, fn($q) => $q->where("name", "like", "%$request->keywords%"));
        $query->when($request->min_price, fn($q) => $q->where("price", ">=", $request->min_price));
        $query->when($request->max_price, fn($q) => $q->where("price", "<=", $request->max_price));
        $query->when($request->order_by, fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? "ASC"));
        
        $products = $query->get();
        return view("products.list", compact('products'));
    }

    public function edit(Request $request, Product $product = null) {
        $product = $product ?? new Product();
        return view("products.edit", compact('product'));
    }


    public function delete(Request $request, Product $product) {
        $product->delete();
        return redirect()->route('products_list');
    }

    public function save(Request $request, Product $product = null) {
        $product = $product ?? new Product();
        $product->fill($request->except('photo'));
    
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName); // Move file to public/images
            $product->photo = $fileName;
        }
    
        $product->save();
        return redirect()->route('products_list');
    }
    
    
}