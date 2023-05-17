<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
//  How To return A response
// Route::get("/hello", function(){
//     // Response(content, status)
//     // Header(Key, Value)
//     return response('<h1>Check The NetWork In The Dev Tool </h1>', 200)->header('Content-Type', 'text/json');
// });

// How To Secure URL
// Route::get("/something/{id}", function($id){
//     return "The Thing Id Is :".$id;
// })->where("id", "[0-9]+");

// Handle Invalide Links
// Route::fallback(function(){
//     // dd(message)
//     dd("die and dump test dd()");
// });

// get $_GET variables
// Route::get("/search", function(Request $req){
//     if(!empty($req->q)){
//         return "<h3>Your Search Was {$req->q}</h3>";
//     }
//     return "<h1>404</h1>";
// });
*/

// All Listings
Route::get('/', [ListingController::class, "index"]);

// Create Listings
Route::get('/listings/create', [ListingController::class, "create"])->middleware("auth");

// Manage Listings
Route::get('/listings/manage', [ListingController::class, "manage"])->middleware("auth");

// One Listing
// Route::get('/listings/{listing}', "App\Http\Controllers\ListingController@show"); // this also works
Route::get('/listings/{listing}', [ListingController::class, "show"]);

// Store Listings
Route::post('/listings', [ListingController::class, "store"])->middleware("auth");

// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, "edit"])->middleware("auth");

// Update In DB
Route::put('/listings/{listing}', [ListingController::class, "update"])->middleware("auth");

// Delete In DB
Route::delete('/listings/{listing}', [ListingController::class, "destroy"])->middleware("auth");

// Show Register Form
Route::get('/register', [UserController::class, "register"])->middleware("guest");

// Create User
Route::post('/users', [UserController::class, "store"])->middleware("guest");

// Create User
Route::post('/logout', [UserController::class, "logout"])->middleware("auth");

// Show Login Form
Route::get('/login', [UserController::class, "login"])->middleware("guest")->name("login");

// Log In User
Route::post('/users/login', [UserController::class, "authenticate"]);

// Handle Invalide Links
Route::fallback([ListingController::class, "index"]);
