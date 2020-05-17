<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('reports/import', 'ReportController@importExcel');
    Route::get('reports/categories/{category}', 'ReportController@reportsByCategory');
    Route::get('reports/categories/innovations/{category}', 'ReportController@reportsByInnovationCategory');
    Route::resource('reports', 'ReportController');
});
