<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;

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

// Country Routes
Route::post("/countries", [CountryController::class, "store"])->name("CountryControllerStore");
Route::get("/countries", [CountryController::class, "index"])->name("CountryControllerIndex");
Route::get("/countries/{countryId}", [CountryController::class, "show"])->name("CountryControllerShow")->whereUuid("countryId");
Route::put("/countries/{countryId}", [CountryController::class, "update"])->name("CountryControllerUpdate")->whereUuid("countryId");
Route::delete("/countries/{countryId}", [CountryController::class, "destroy"])->name("CountryControllerDestroy")->whereUuid("countryId");

// City Routes
Route::post("/countries/{countryId}/cities", [CityController::class, "store"])->name("CityControllerStore")->whereUuid("countryId");
Route::get("/countries/{countryId}/cities", [CityController::class, "index"])->name("CityControllerIndex")->whereUuid("countryId");
Route::get("/countries/{countryId}/cities/{cityId}", [CityController::class, "show"])->name("CityControllerShow")->whereUuid("countryId")->whereUuid("cityId");
Route::put("/countries/{countryId}/cities/{cityId}", [CityController::class, "update"])->name("CityControllerUpdate")->whereUuid("countryId")->whereUuid("cityId");
Route::delete("/countries/{countryId}/cities/{cityId}", [CityController::class, "destroy"])->name("CityControllerDestroy")->whereUuid("countryId")->whereUuid("cityId");
