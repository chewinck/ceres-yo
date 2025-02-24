<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutant', function () {
    return view('Ceres Yo up');
});
