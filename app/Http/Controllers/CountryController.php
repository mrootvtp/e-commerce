<?php

namespace App\Http\Controllers;
use App\Models\Country;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    
    public function index()
    {
        // Code to list countries
        $countries = Country::all();
        return response()->json($countries);

    }

    public function show($id)
    {
        // Code to show a specific country
        $country = Country::find($id);
        if ($country) {
            return response()->json($country);
        } else {
            return response()->json(['message' => 'Country not found'], 404);   
        }
    }

    public function store(Request $request)
    {
        // Code to store a new country
        $country = Country::create($request->all());
        return response()->json($country, 201); 

    }


    public function update(Request $request, $id)
    {
        // Code to update a specific country
        $country = Country::find($id);
        if ($country) {
            $country->update($request->all());
            return response()->json($country);
        } else {
            return response()->json(['message' => 'Country not found'], 404);   
        }
    }


    public function destroy($id)
    {
        // Code to delete a specific country
        $country = Country::find($id);
        if ($country) {
            $country->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Country not found'], 404);   
        }
    }





}
