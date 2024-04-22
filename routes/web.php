<?php

use App\Http\Controllers\ListingController;
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


//Single listing
Route::get("/listings/{listing}", [ListingController::class, 'show']);



//2.57