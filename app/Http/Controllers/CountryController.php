<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreCountryFormRequest;
use App\Http\Requests\UpdateCountryFormRequest;
use Exception;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return response()->json([
            "message" => "Countries Returned Successfully!",
            "data" => $countries
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCountryFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryFormRequest $request)
    {
        $requestBody = $request->validated();
        try{
            $country = Country::create($requestBody);
            return response()->json([
                "message" => "Country Created Successfully!",
                "data" => $country
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($countryId)
    {
        $country = Country::find($countryId);
        if(! $country){
            return  response()->json([
                "message" => "Country Not Found!",     
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "message" => "Country Returned Successfully!",
            "data" => $country
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCountryFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryFormRequest $request, $countryId)
    {
        $requestBody = $request->validated();
        $country = Country::find($countryId);
        try {
            $country->update($requestBody);
            $country = $country->fresh();
            return response()->json([
                "message" => "Country Updated Successfully!",
                "data" => $country
            ], Response::HTTP_OK);
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
    public function destroy($countryId)
    {
        $country = Country::find($countryId);
        try {
            $country->delete();
            return response()->json([
                "message" => "Country Deleted Successfully!",
                "data" => $country
            ], Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
