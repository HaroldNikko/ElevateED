<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\Barangay;

class LocationController extends Controller
{
    public function getMunicipalities($province_id)
    {
        $municipalities = Municipality::where('province_id', $province_id)
            ->orderBy('municipality_name')
            ->get(['municipality_id', 'municipality_name']);

        return response()->json($municipalities);
    }

    public function getBarangays($municipality_id)
    {
        $barangays = Barangay::where('municipality_id', $municipality_id)
            ->orderBy('barangay_name')
            ->get(['barangay_id', 'barangay_name']);

        return response()->json($barangays);
    }
}
