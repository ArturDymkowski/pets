<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'pets', 'as' => 'pets'], function(){
    Route::get('/{id}', [PetController::class, 'index'])->name('.index')->where('id', '[0-9]+');
    Route::any('/edit/{id}', [PetController::class, 'edit'])->name('.edit')->where('id', '[0-9]+');
});
