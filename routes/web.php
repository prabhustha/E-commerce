<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
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



Route::controller(HomeController::class)->group(function(){
Route::get('/', 'Index')->name('home');
});
Route::controller(ClientController::class)->group(function(){
    Route::get('/category/{id}/{slug}','CategoryPage')->name('category');
    Route::get('/product-details/{id}/{slug}','SingleProduct')->name('singleproduct');
    

    Route::get('/new-release','NewRelease')->name('newrelease');

    
});

Route::middleware(['auth', 'role:user'])->group(function(){
    Route::controller(ClientController::class)->group(function(){
        Route::get('/add-to-cart','AddToCart')->name('addtocart');
        Route::post('/add-product-to-cart','AddProductToCart')->name('addproducttocart');
        Route::get('/shipping-address','GetShippingAddress')->name('shippingaddress');
        Route::post('/add-shipping-address','AddShippingAddress')->name('addshippingaddress');
        Route::post('/place-order','PlaceOrder')->name('placeorder');
        Route::get('/delete-product-item/{id}','DeleteItem')->name('deleteitem');
        Route::get('/check-out','CheckOut')->name('checkout');
        Route::get('/user-profile','UserProfile')->name('userprofile');
        Route::get('/user-profile/pending-orders', 'PendingOrders')->name('pendingorders');
        Route::get('/user-profile/history', 'History')->name('history');
      
        Route::get('/todays-deal','TodaysDeal')->name('todaysdeal');
        Route::get('/customer-service','CustomerService')->name('customerservice');
        
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','role:admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/userprofile',[DashboardController::class, 'Index']);

Route::middleware(['auth','role:admin'])->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/admin/dashboard','index')->name('admindashboard');
        
    });
    Route::controller(CategoryController::class)->group(function(){
        Route::get('admin/all-category', 'index')->name('allcategory');
        Route::get('admin/add-category','Addcategory')->name('addcategory');
        Route::post('/admin/store-category','StoreCategory')->name('storecategory');
        Route::get('/admin/edit-category/{id}','EditCategory')->name('editcategory');
        Route::post('/admin/update-category','UpdateCategory')->name('updatecategory');
        Route::get('/admin/delete-category/{id}','DeleteCategory')->name('deletecategory');
    });
    Route::controller(SubCategoryController::class)->group(function(){
        Route::get('admin/all-subcategory', 'index')->name('allsubcategory');
        Route::get('admin/add-subcategory','AddSubcategory')->name('addsubcategory');
        Route::post('/admin/store-subcategory', 'StoreSubCategory')->name('storesubcategory');
        Route::get('/admin/edit-subcategory/{id}','EditSubCategory')->name('editsubcategory');
        Route::post('/admin/update-subcategory','UpdateCategory')->name('updatesubcategory');
        Route::get('admin/delete-subcategory/{id?}/{catid?}','DeleteSubCategory')->name('deletesubcategory');
    });
    Route::controller(ProductController::class)->group(function(){
        Route::get('admin/all-product', 'index')->name('allproducts');
        Route::get('admin/add-product','AddProduct')->name('addproduct');
        Route::post('admin/store-product','StoreProduct')->name('storeproduct');
        Route::get('admin/edit-product-img/{id}','EditProductImg')->name('editproductimg');
        Route::post('admin/upate-product-img','UpdateProductImg')->name('upadetproductimg');
        Route::get('admin/edit-product/{id}','EditProduct')->name('editproduct');
        Route::post('admin/update-product','UpdateProduct')->name('updateproduct');
        Route::get('admin/delete-product/{id}/{catid}/{subcatid}','DeleteProduct')->name('deleteproduct');
    });
    Route::controller(OrderController::class)->group(function(){
        Route::get('admin/pending-order', 'index')->name('pendingorder');
    });
});
require __DIR__.'/auth.php';
