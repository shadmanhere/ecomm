<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ClientController::class, 'home']);
Route::get('/shop', [ClientController::class, 'shop']);
Route::get('/checkout', [ClientController::class, 'checkout']);
Route::get('/addtocart/{id}', [ClientController::class, 'addtocart']);
Route::post('/update_qty/{id}', [ClientController::class, 'update_qty']);
Route::get('/remove_from_cart/{id}', [ClientController::class, 'remove_from_cart']);
Route::get('/cart', [ClientController::class, 'cart']);
Route::get('/login', [ClientController::class, 'login']);
Route::get('/signup', [ClientController::class, 'signup']);
Route::get('/orders', [ClientController::class, 'orders']);

// admin routes
Route::get('/admin', [AdminController::class, 'admin']);


Route::get('/addcategory', [CategoryController::class, 'addcategory']);
Route::get('/categories', [CategoryController::class, 'categories']);
Route::post('/savecategory', [CategoryController::class, 'saveCategory']);
Route::get('/edit_category/{id}', [CategoryController::class, 'edit_category']);
Route::post('/updateCategory', [CategoryController::class, 'updateCategory']);
Route::get('/delete_category/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('/addslider', [SliderController::class, 'addslider']);
Route::get('/sliders', [SliderController::class, 'sliders']);
Route::post('/saveslider', [SliderController::class, 'saveSlider']);
Route::post('/updateslider', [SliderController::class, 'updateSlider']);
Route::get('/edit_slider/{id}', [SliderController::class, 'editSlider']);
Route::get('/delete_slider/{id}', [SliderController::class, 'deleteSlider']);
Route::get('/activate_slider/{id}', [SliderController::class, 'activate_slider']);
Route::get('/unactivate_slider/{id}', [SliderController::class, 'unactivate_slider']);

Route::get('/addproduct', [ProductController::class, 'addproduct']);
Route::get('/products', [ProductController::class, 'products']);
Route::post('/saveProduct', [ProductController::class, 'saveProduct']);
Route::post('/updateproduct', [ProductController::class, 'updateProduct']);
Route::get('/delete_product/{id}', [ProductController::class, 'deleteProduct']);
Route::get('/edit_product/{id}', [ProductController::class, 'edit_product']);
Route::get('/activate_product/{id}', [ProductController::class, 'activate_product']);
Route::get('/unactivate_product/{id}', [ProductController::class, 'unactivate_product']);
Route::get('/view_product_by_category/{category_name}', [ProductController::class, 'view_product_by_category']);



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
