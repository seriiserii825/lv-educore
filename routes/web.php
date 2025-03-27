<?php

use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    redirect('/');
})->where('any', '.*');
