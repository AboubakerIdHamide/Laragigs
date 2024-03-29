<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//  Testing The Api
// Route::get("/posts", function(){
//     return response()->json([
//         ["id"=> 1, "name"=>"Post 1", "content"=> "content 1"],
//         ["id"=> 2, "name"=>"Post 2", "content"=> "content 2"],
//         ["id"=> 3, "name"=>"Post 3", "content"=> "content 3"],
//     ]);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
