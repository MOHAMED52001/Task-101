<?php

use App\Http\Controllers\API\V1\Categories\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Posts\PostController;






// Posts Routes
Route::resource('posts', PostController::class);
// End Posts Routes

// Categories Routes
Route::resource('categories', CategoryController::class);
// End Categories Routes
