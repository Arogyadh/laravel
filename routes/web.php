<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

//All listings
Route::get("/", [ListingController::class, "index"]);



// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create']);


//Store listing data
Route::post("/listings", [ListingController::class, 'store']);

//Show edit form
Route::get("/listings/{listing}/edit", [ListingController::class, 'edit']);

//Update a listing
Route::put("/listings/{listing}", [ListingController::class, 'update']);

//Delete a listing
Route::delete("/listings/{listing}", [ListingController::class, 'destroy']);


//Show Single listing
Route::get("/listings/{listing}", [ListingController::class, 'show']);


//Show register create form
Route::get("/register", [UserController::class, 'create']);

//Create new user
Route::post("/users", [UserController::class, 'store']);

//Logout user
Route::post("/logout", [UserController::class, 'logout']);

//Show login form
Route::get("/login", [UserController::class, 'login']);

//Login user
Route::post("/users/authenticate", [UserController::class, 'authenticate']);


//2.57