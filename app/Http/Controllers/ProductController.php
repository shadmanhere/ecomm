<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(){
        $categories = Category::all()->pluck('category_name','category_name');
        return view('admin.addProduct')->with('categories', $categories);
    }

    public function products(){
        $products = Product::All();

        return view('admin.products')->with('products', $products);
    }

    public function saveProduct(Request $request){
        $this->validate($request, [ 'product_name' => 'required',
                                    'product_price' => 'required',
                                    'product_category' => 'required',
                                    'product_image' => 'image|nullable|max:1999' ]);

        if($request->hasFile('product_image')){
            // !: get file name with exts
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //3: get just file extension
            $extension = $request->file('product_image')->getClientOriginalExtension();
            //4: file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // upload image
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStore;

        $product->save();

        return back()->with('status', 'The Product has been successfully saved !!');
    }

    public function edit_product($id){
        $product = Product::find($id);
        $categories = Category::all()->pluck('category_name','category_name');
        return view('admin.editproduct')->with('product',$product)->with('categories', $categories);
    }

    public function updateProduct(Request $request){

        $this->validate($request, [ 'product_name' => 'required',
                                    'product_price' => 'required',
                                    'product_category' => 'required',
                                    'product_image' => 'image|nullable|max:1999' ]);
        $product = Product::find($request->input('id'));
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        
        if($request->hasFile('product_image')){
            // !: get file name with exts
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //3: get just file extension
            $extension = $request->file('product_image')->getClientOriginalExtension();
            //4: file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // upload image
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);
            if($product->product_image != 'noimage.jpg'){
                Storage::delete('public/product_images/'.$product->product_image);
            }
            $product->product_image = $fileNameToStore;
        }
        
        $product->update();
        return redirect('/products')->with('status', 'The Product has been successfully updated !!');
                                
    }
}
