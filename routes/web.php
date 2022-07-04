<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\casosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

/*Route::get('/cuadro', function () {
    return view('cuadro');
});*/

//Route::get('/cuadro',[casosController::class, 'casos_covid']);
Route::get("/consolidadocasos/",[casosController::class, "casos_consolidado_solo"]);
Route::get("/cuadro/",[casosController::class, "casos_consolidado_reporte"]);
