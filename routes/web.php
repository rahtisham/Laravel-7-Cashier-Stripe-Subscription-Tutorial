<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\SubscriptionController;

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

// Route::group(['middleware' => 'auth'] , function(){

// Route::get('/subscription/create', ['as'=>'home','uses'=>'SubscriptionController@index'])->name('subscription.create');
// Route::post('order-post', ['as'=>'order-post','uses'=>'SubscriptionController@orderPost']);


// Route::get('/active-subscription', ['as'=>'home','uses'=>'SubscriptionController@showStripe'])->name('subscription.showStripe');

// // Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// });  // End of middleware 
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');

    //Routes for create Plan
    Route::get('create/plan', 'SubscriptionController@createPlan')->name('create.plan');
    Route::post('store/plan', 'SubscriptionController@storePlan')->name('store.plan');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
