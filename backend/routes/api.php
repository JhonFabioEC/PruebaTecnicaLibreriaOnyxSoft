<?php

use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/v1/books', BookController::class);