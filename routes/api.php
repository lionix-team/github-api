<?php

use App\Http\Controllers\Api\CommitsController;
use Illuminate\Support\Facades\Route;

Route::get('repos/{repo}', [CommitsController::class, 'index']);
Route::get('repos/{repo}/authors/{author}', [CommitsController::class, 'commits']);
