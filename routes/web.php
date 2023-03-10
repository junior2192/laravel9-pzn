<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pzn', function (){
   return "Programmer Zaman Now";
});

Route::redirect('/youtube', '/pzn');

//membuat view 404 sendiri
Route::fallback(function (){
   return "404 by Programmer Zaman Now";
});

Route::view('/hello', 'hello', ['name' => 'Eko']);
Route::get('/hello-again', function(){
    return view('hello', ['name' => 'Eko']);
});

Route::get('/hello-world', function (){
    return view('hello.world', ['name' => 'Eko']);
});

//Route Paramaeter
Route::get('/products/{id}', function ($productId){
   return "Product $productId";
})->name('product.detail');
Route::get('/products/{product}/items/{item}', function ($productId, $itemId){
    return "Product $productId, Item $itemId";
})->name('product.item,detail');

//route parameter regular expression
//hanya menerima id angka saja
Route::get('/categories/{id}',function ($categoryId){
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

//Route parameter optional
//wajib tambah default closure function nya
Route::get('/users/{id?}', function ($userId = "404"){
   return "Users $userId";
})->name('user.detail');

//Route Conflict
Route::get('conflict/eko', function (){
    return "Conflict Eko Khannedy";
});

Route::get('conflict/{name}', function ($name){
   return "Conflict $name";
});

//tes nnamed Route
Route::get('/produk/{id}', function ($id){
   $link = route('product.detail', ['id' => $id]);
   return "Link $link";
});

Route::get('produk-redirect/{id}', function ($id){
   return redirect()->route('product.detail', ['id'=> $id]);
});

//controller
Route::get('/controller/hello/request', [\App\Http\Controllers\HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [\App\Http\Controllers\HelloController::class, 'hello']);

Route::get('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);

Route::post('/input/hello/first', [\App\Http\Controllers\InputController::class, 'helloFirstName']);

//mengambil semua inputan
Route::post('/input/hello/input', [\App\Http\Controllers\InputController::class, 'helloInput']);
