<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Voyage;

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
Route::post('/vessels', [C_Vessel::class, 'create']);
Route::put('/vessels/{id}', [C_Vessel::class, 'update']);
Route::get('  /vessels/{id}/financial-report', [C_Vessel::class, 'get_vessel_report']);

Route::post('/voyages', [C_Voyage::class, 'create']);
Route::put('/voyages/{id}', [C_Voyage::class, 'update']);

Route::post(' /vessels/{id}/vessel-opex', [C_Vessel_Opex::class, 'create']);


//Route::get('/voyages', function (Request $request){ dd('here');});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});
