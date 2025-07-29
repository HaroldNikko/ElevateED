<?php

namespace App\Http\Controllers\Admin; // or whatever your namespace is

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ✅ This is the correct Request import
use App\Models\District;

class DistrictController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required|string|max:255',
        ]);

        District::create([
            'Districtname' => $request->district_name
        ]);

        return redirect()->back()->with('success', 'District added successfully!');
    }
    public function update(Request $request)
        {
            $request->validate(['districtID' => 'required', 'district_name' => 'required']);
            $district = District::findOrFail($request->districtID);
            $district->Districtname = $request->district_name;
            $district->save();

            return redirect()->back()->with('success', 'District updated.');
        }

        public function delete(Request $request)
        {
            $request->validate(['districtID' => 'required']);
            $district = District::findOrFail($request->districtID);
            $district->delete();

            return redirect()->back()->with('success', 'District deleted.');
        }
}