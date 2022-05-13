<?php

use App\CustomClass\PerformanceComercial;
use App\Http\Controllers\PerformanceComercialController;
use Illuminate\Support\Facades\Route;

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

Route::get('/under_construction', function () {
    return view('under_construction');
});

Route::get('/test', [PerformanceComercialController::class, 'test']);
Route::get('/con_desempenho', [PerformanceComercialController::class, 'performanceComercialHome']);
Route::post('/con_desempenho_res', [PerformanceComercialController::class, 'performanceComercialReport']);
Route::post('/con_desempenho_graf', [PerformanceComercialController::class, 'generateBarChart']);
Route::post('/con_desempenho_pie', [PerformanceComercialController::class, 'generatePieChart']);