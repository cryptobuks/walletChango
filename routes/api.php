<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['group' => 'API\GroupController']);


/*--------------------------------------------------------*/
//            Payment routes
/*--------------------------------------------------------*/
Route::apiResources(['payment' => 'API\PaymentsController']);
Route::get('payment/group/{group}', 'API\PaymentsController@show');


/*--------------------------------------------------------*/
//            Projects routes
/*--------------------------------------------------------*/
Route::apiResources(['project' => 'API\ProjectsController']);


/*--------------------------------------------------------*/
//            Wallet routes
/*--------------------------------------------------------*/
Route::apiResources(['wallet' => 'API\WalletController']);
Route::post('user/deposit', 'API\WalletController@deposit_amount');


/*--------------------------------------------------------*/
//            User routes
/*--------------------------------------------------------*/
Route::apiResources(['user' => 'API\UserController']);
Route::post('user/login', 'API\UserController@login');


/*--------------------------------------------------------*/
//            Transaction routes
/*--------------------------------------------------------*/
Route::apiResources(['transaction' => 'API\TransactionController']);
