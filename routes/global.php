<?php

use App\Http\Controllers\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/{hash}', [RouteController::class, 'redirectToUrl'])->where('hash', '^[A-Za-z0-9]{6}$');
