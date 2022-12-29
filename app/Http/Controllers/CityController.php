<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreCityFormRequest;
use App\Http\Requests\UpdateCityFormRequest;
use Exception;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index($countryId)
    {
        $country =Country::find($countryId);
        $cities = $country->cities;
        return response()->json([
            "message" => "Cities Returned Successfully!",
            "data" => $cities
        ], Response::HTTP_OK);    
    }

    /**
     * Store a newly created resource in storage.
     *@param \App\Models\Country $country
     * @param \App\Http\Requests\StoreCityFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityFormRequest $request,$countryId )
    {
        $requestBody = $request->validated();
        $country =Country::find($countryId);
        try{
            $city =  $country->cities()->create(($requestBody));
            return response()->json([
                "message" => "City Created Successfully!",
                "data" => $city
            ],Response::HTTP_CREATED);
        }catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($countryId , $cityId)
    {
        $city = City::find($cityId);
        if(! $city){
            return  response()->json([
                "message" => "City Not Found!",     
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "message" => "City Returned Successfully!",
            "data" => $city
        ],Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCityFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityFormRequest $request, $countryId , $cityId)
    {
        $requestBody = $request->validated();
        $city = City::find($cityId);
        try {
            $city->update($requestBody);
            $city =  $city->fresh();
            return response()->json([
                "message" => "City Updated Successfully!",
                "data" => $city
            ],Response::HTTP_OK); 
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($countryId , $cityId)
    {
        $city = City::find($cityId);
        try {
            $city->delete();
            return response()->json([
                "message" => "City Deleted Successfully!",
                "data" => $city
            ],Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
