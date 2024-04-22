<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//All listings
Route::get("/", [ListingController::class, "index"]);



// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware("auth");


//Store listing data
Route::post("/listings", [ListingController::class, 'store'])->middleware("auth");

//Show edit form
Route::get("/listings/{listing}/edit", [ListingController::class, 'edit'])->middleware("auth");

//Update a listing
Route::put("/listings/{listing}", [ListingController::class, 'update'])->middleware("auth");

//Delete a listing
Route::delete("/listings/{listing}", [ListingController::class, 'destroy'])->middleware("auth");

//Manage listings
Route::get("/listings/manage", [ListingController::class, "manage"])->middleware("auth");


//Show Single listing
Route::get("/listings/{listing}", [ListingController::class, 'show']);


//Show register create form
Route::get("/register", [UserController::class, 'create'])->middleware("guest");

//Create new user
Route::post("/users", [UserController::class, 'store']);

//Logout user
Route::post("/logout", [UserController::class, 'logout'])->middleware("auth");

//Show login form
Route::get("/login", [UserController::class, 'login'])->name('login')->middleware("guest");

//Login user
Route::post("/users/authenticate", [UserController::class, 'authenticate']);




//2.57