<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'pets', 'as' => 'pets'], function(){
    Route::get('/{pet}', [PetController::class, 'index'])->name('.index');
});
