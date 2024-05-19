<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//Ruta para la busqueda de un Pokemon
Route::post('/buscar',[PokemonController::class,'buscar']);
