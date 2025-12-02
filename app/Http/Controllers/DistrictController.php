<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    public function getDistricts($region_id)
    {
        $districts = District::where('region_id', $region_id)->get();

        return response()->json($districts);
    }
}

