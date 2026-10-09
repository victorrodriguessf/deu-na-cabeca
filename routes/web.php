<?php

use App\Http\Controllers\ResultsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResultsController::class, 'index']);
