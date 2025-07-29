<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Info;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Barangay;


class ProfileController extends Controller
{
    public function show()
    {
        $loginId = session('Login_id');
        $info = Info::where('Login_id', $loginId)->first();

        if (!$info) {
            return back()->with('error', 'Profile not found.');
        }

        $provinces = \App\Models\Province::all();
    return view('teacher.profile_teacher', compact('provinces'));
    }

    public function update(Request $request)
    {
        $loginId = session('Login_id');
        $info = Info::where('Login_id', $loginId)->first();

        if (!$info) {
            return back()->with('error', 'Profile not found.');
        }

        $request->validate([
            'firstname'      => 'required|string|max:255',
            'lastname'       => 'required|string|max:255',
            'middlename'     => 'nullable|string|max:255',
            'profile'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'province_id'    => 'required|exists:table_province,province_id',
            'municipality_id'=> 'required|exists:table_municipality,municipality_id',
            'barangay_id'    => 'required|exists:table_barangay,barangay_id',
        ]);

        // Update personal info
        $info->firstname = $request->firstname;
        $info->middlename = $request->middlename;
        $info->lastname = $request->lastname;

        // Get address from selected IDs
        $province = Province::find($request->province_id);
        $municipality = Municipality::find($request->municipality_id);
        $barangay = Barangay::find($request->barangay_id);

        $fullAddress = $barangay->barangay_name . ', ' . $municipality->municipality_name . ', ' . $province->province_name;
        $info->Address = $fullAddress;

        // Handle image upload
        if ($request->hasFile('profile')) {
            $filename = time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('img'), $filename);
            $info->profile = $filename;
            session(['profile' => $filename]);
        }

        $info->save();

        // Update session
        session([
            'firstname'    => $info->firstname,
            'middlename'   => $info->middlename,
            'lastname'     => $info->lastname,
            'Address'      => $info->Address,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

 
public function getMunicipalities($province_id)
{
    Log::info("🔍 Fetching municipalities for province_id: {$province_id}");

    $municipalities = Municipality::where('province_id', $province_id)
        ->get(['municipality_id as id', 'municipality_name as name']);

    Log::info("✅ Found municipalities:", $municipalities->toArray());

    return response()->json($municipalities);
}

public function getBarangays($municipality_id)
{
    Log::info("🔍 Fetching barangays for municipality_id: {$municipality_id}");

    $barangays = Barangay::where('municipality_id', $municipality_id)
        ->get(['barangay_id as id', 'barangay_name as name']);

    Log::info("✅ Found barangays:", $barangays->toArray());

    return response()->json($barangays);
}

}
