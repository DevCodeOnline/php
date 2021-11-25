<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\CalcController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\ZipController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\View\Components\CartData;
use App\View\Components\CartForm;
use App\View\Components\CartList;
use App\View\Components\Categories;
use App\View\Components\DeliveryMethods;
use App\View\Components\Listing;
use App\View\Components\Search;
use Illuminate\Support\Facades\Artisan;
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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::resource('/categories', '\App\Http\Controllers\Admin\CategoryController');
    Route::get('/products/image/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destoryImage'])->name('products.destroy.image');
    Route::get('/products/images/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destoryImages'])->name('products.destroy.images');
    Route::get('/products/search', [\App\Http\Controllers\Admin\ProductController::class, 'search'])->name('products.search');
    Route::get('/products/search/id', [\App\Http\Controllers\Admin\ProductController::class, 'searchId'])->name('products.search.id');
    Route::resource('/products', '\App\Http\Controllers\Admin\ProductController');
    Route::resource('/payments', '\App\Http\Controllers\Admin\PaymentController');
    Route::resource('/users', '\App\Http\Controllers\Admin\UserController')->middleware('admin.user');
    Route::resource('/informations', '\App\Http\Controllers\Admin\InformationController')->middleware('admin.user');
    Route::post('/calc', [CalcController::class, 'index'])->name('admin.calc');
    Route::post('/calc/delivery', [CalcController::class, 'delivery'])->name('admin.calc.delivery');
    Route::resource('/deliveries', '\App\Http\Controllers\Admin\DeliveryController');
    Route::resource('/regions', '\App\Http\Controllers\Admin\RegionController');
    Route::get('/refresh', function () {
        Artisan::call("queue:work --stop-when-empty");
        return redirect()->back()->with('success', 'Очередь обновлена');
    })->name('admin.refresh');
    Route::post('/zip-other', [ZipController::class, 'other'])->name('zip.other');
    Route::post('/zip-data', [ZipController::class, 'data'])->name('zip.data');
    Route::post('/zip-category', [ZipController::class, 'category'])->name('zip.category');
    Route::post('/zip-product', [ZipController::class, 'product'])->name('zip.product');
    Route::post('/zip-update-product', [ZipController::class, 'updateProduct'])->name('zip.update.product');
    Route::post('/zip-update-product-image', [ZipController::class, 'updateProductImage'])->name('zip.update.product.image');
});

Route::group(['prefix' => 'excel', 'namespace' => 'Excel'], function () {
    Route::post('/category/import', ['\App\Http\Controllers\Import\CategoryController', 'import'])->name('category.import');
    Route::post('/product/import', ['\App\Http\Controllers\Import\ProductController', 'import'])->name('product.import');
    Route::post('/main/import', ['\App\Http\Controllers\Import\MainPageController', 'import'])->name('main.page.import');
    Route::post('/delivery/import', ['\App\Http\Controllers\Import\DeliveryController', 'import'])->name('delivery.import');
    Route::post('/not-delivery/import', ['\App\Http\Controllers\Import\NotDeliveryController', 'import'])->name('not.delivery.import');
    Route::post('/information/import', ['\App\Http\Controllers\Import\InformationController', 'import'])->name('information.import');
    Route::post('/other/import', ['\App\Http\Controllers\Import\ImageOtherController', 'import'])->name('other.import');
    Route::post('/product/update', ['\App\Http\Controllers\Update\ProductController', 'import'])->name('product.update');
    Route::post('/product/image/update', ['\App\Http\Controllers\Update\ProductImageController', 'import'])->name('product.image.update');
    Route::post('/product/title/update', ['\App\Http\Controllers\Update\ProductTitleController', 'import'])->name('product.title.update');
    Route::post('/product/quantity/update', ['\App\Http\Controllers\Update\ProductQuantityController', 'import'])->name('product.quantity.update');
    Route::post('/product/price/update', ['\App\Http\Controllers\Update\ProductPriceController', 'import'])->name('product.price.update');
    Route::post('/product/description/update', ['\App\Http\Controllers\Update\ProductDescriptionController', 'import'])->name('product.description.update');
    Route::post('/product/comment/update', ['\App\Http\Controllers\Update\ProductCommentController', 'import'])->name('product.comment.update');
    Route::post('/product/category/update', ['\App\Http\Controllers\Update\ProductCategoryController', 'import'])->name('product.category.update');
    Route::post('/product/best/update', ['\App\Http\Controllers\Update\ProductBestController', 'import'])->name('product.best.update');
    Route::get('/product/export', ['\App\Http\Controllers\Export\ProductController', 'export'])->name('product.export');
    Route::get('/quantity/export', ['\App\Http\Controllers\Export\ProductQuantityController', 'export'])->name('quantity.export');
    Route::get('/price/export', ['\App\Http\Controllers\Export\ProductPriceController', 'export'])->name('price.export');
    Route::get('/main/export', ['\App\Http\Controllers\Export\MainController', 'export'])->name('main.export');
    Route::get('/delivery/export', ['\App\Http\Controllers\Export\DeliveryController', 'export'])->name('delivery.export');
    Route::get('/delivery/not/export', ['\App\Http\Controllers\Export\DeliveryNotController', 'export'])->name('delivery.not.export');
    Route::get('/category/export', ['\App\Http\Controllers\Export\CategoryController', 'export'])->name('category.export');
    Route::get('/other/export', ['\App\Http\Controllers\Export\ImageOtherController', 'export'])->name('other.export');
    Route::post('/product/delete', ['\App\Http\Controllers\Delete\ProductController', 'import'])->name('product.delete');

});

Route::get('/login', [UserController::class, 'loginForm'])->name('login.create');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [Listing::class, 'update'])->name('listing');

Route::get('/category/{slug?}', [CategoryController::class, 'index'])->name('category');
Route::post('/category/{slug?}', [Categories::class, 'update'])->name('categories');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/{id}', [CartController::class, 'addCart'])->name('cart.add');
Route::post('/cart/order', [CartController::class, 'order'])->name('order');
Route::get('/cart/destroy/{id}', [CartList::class, 'destroy'])->name('cart.destroy');
Route::get('/count', [CartController::class, 'countCart'])->name('cart.count');
Route::get('/deliveries', [DeliveryMethods::class, 'updateDelivery'])->name('delivery.update');
Route::get('/cart_form', [CartForm::class, 'update'])->name('cart.form.update');

Route::get('/cart_city', [CartData::class, 'update'])->name('cart.city.update');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/search', [Search::class, 'update'])->name('sear');

Route::get('/product/{slug}', [ProductController::class, 'index'])->name('product');
Route::post('/product/review', [ProductController::class, 'review'])->name('product.review');
