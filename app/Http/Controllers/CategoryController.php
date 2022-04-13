<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function addCategory(){
        return view('admin.addcategory');
    }

    public function categories(){
        $categories = Category::All();
        return view('admin.categories')->with('categories', $categories);
    }

    public function saveCategory(Request $request){
        $this->validate($request, ['category_name' => 'required|unique:categories']);

        $category = new Category();
        $category -> category_name = $request->input('category_name');
        $category -> save();

        return back()->with('status', 'The category name has been successfully saved !!');
    }

    public function edit_category($id){
        $category = Category::find($id);
        return view('admin.editcategory')->with('category', $category);
    }

    public function updateCategory(Request $request){


        $this->validate($request, ['category_name' => 'required']);

        $category = Category::find($request->input('id'));
        $category->category_name = $request->input('category_name');
        $category->update();
        return redirect('/categories')->with('status', 'The category name has been successfully updated !!');
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();
        return back()->with('status', 'The category name has been successfully deleted !!');
    }
}
