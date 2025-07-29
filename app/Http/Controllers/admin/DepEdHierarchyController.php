<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Province;
use App\Models\DivisionOfficerInfo;
use App\Models\LegislativeDistrict;
use Illuminate\Support\Facades\Log;

class DepEdHierarchyController extends Controller
{
    // Display all regions with pagination
    public function index()
    {
        $regions = Region::paginate(7);
        return view('admin.depedhierarchy.deped_hierarchy', compact('regions'));
    }
    public function fetchProvinces($region_id)
{
    $provinces = \App\Models\Province::where('region_id', $region_id)->get();
    return response()->json($provinces);
}

public function fetchDistricts($province_id)
{
    $districts = \App\Models\LegislativeDistrict::where('province_id', $province_id)->get();
    return response()->json($districts);
}

public function fetchMunicipalities($province_id)
{
    $municipalities = \App\Models\Municipality::where('province_id', $province_id)->get();
    return response()->json($municipalities);
}


    public function showProvinces($id)
    {
        $region = Region::with('provinces')->findOrFail($id);
        $provinces = $region->provinces;

        $provinceIds = $provinces->pluck('province_id');
        $divisionOfficers = DivisionOfficerInfo::with('province')
            ->whereIn('province_id', $provinceIds)
            ->get();

        return view('admin.depedhierarchy.province_list', compact('region', 'provinces', 'divisionOfficers'));
    }

    // ✅ Show Legislative Districts by Province
    public function showDistricts($province_id)
    {
        $province = Province::findOrFail($province_id);
        $districts = LegislativeDistrict::where('province_id', $province_id)->get();

        return view('admin.depedhierarchy.legislative_districts', compact('province', 'districts'));
    }

    // ✅ Store a new Legislative District
    public function storeDistrict(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:table_province,province_id',
            'district_name' => 'required|string|max:255',
        ]);

        LegislativeDistrict::create([
            'province_id' => $request->province_id,
            'district_name' => $request->district_name,
        ]);

        return redirect()->back()->with('success', 'District added successfully!');
    }

    // ✅ Store Region
    public function store(Request $request)
    {
        try {
            $request->validate([
                'region_name' => 'required|string|max:255',
                'region_description' => 'required|string|max:255',
            ]);

            if (Region::where('region_name', $request->region_name)->exists()) {
                return response()->json(['error' => 'Region name already exists.'], 409);
            }

            $region = Region::create([
                'region_name' => $request->region_name,
                'region_description' => $request->region_description,
            ]);

            return response()->json([
                'message' => 'Region added successfully.',
                'region' => $region
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing region: ' . $e->getMessage());
            return response()->json(['error' => 'Server error. Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $region = Region::findOrFail($id);
            return response()->json($region);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Region not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'region_name' => 'required|string|max:255',
                'region_description' => 'required|string|max:255',
            ]);

            $region = Region::findOrFail($id);

            if ($region->region_name !== $request->region_name &&
                Region::where('region_name', $request->region_name)->exists()) {
                return response()->json(['error' => 'Another region with this name already exists.'], 409);
            }

            $region->update([
                'region_name' => $request->region_name,
                'region_description' => $request->region_description,
            ]);

            return response()->json(['message' => 'Region updated successfully.', 'region' => $region]);
        } catch (\Exception $e) {
            Log::error('Error updating region: ' . $e->getMessage());
            return response()->json(['error' => 'Server error. Please try again.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $region = Region::findOrFail($id);
            $region->delete();

            return response()->json(['message' => 'Region deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting region: ' . $e->getMessage());
            return response()->json(['error' => 'Server error. Please try again.'], 500);
        }
    }

    // ✅ Province CRUD
    public function storeProvince(Request $request)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            'region_id' => 'required|exists:table_region,region_id',
        ]);

        Province::create([
            'province_name' => $request->province_name,
            'region_id' => $request->region_id,
        ]);

        return redirect()->back()->with('success', 'Province added successfully!');
    }

    public function editProvince($id)
    {
        $province = Province::findOrFail($id);
        return response()->json($province);
    }

    public function updateProvince(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required|string|max:255',
            'region_id' => 'required|exists:table_region,region_id',
        ]);

        $province = Province::findOrFail($id);
        $province->update([
            'province_name' => $request->province_name,
            'region_id' => $request->region_id,
        ]);

        return redirect()->back()->with('success', 'Province updated successfully!');
    }

    public function destroyProvince($id)
    {
        $province = Province::findOrFail($id);
        $province->delete();

        return redirect()->back()->with('success', 'Province deleted successfully!');
    }

    public function updateDistrict(Request $request, $id)
{
    $request->validate([
        'district_name' => 'required|string|max:255',
    ]);

    $district = LegislativeDistrict::findOrFail($id);
    $district->update([
        'district_name' => $request->district_name,
    ]);

    return redirect()->back()->with('success', 'District updated successfully!');
}

public function destroyDistrict($id)
{
    $district = LegislativeDistrict::findOrFail($id);
    $district->delete();

    return redirect()->back()->with('success', 'District deleted successfully!');
}


// ✅ Show Municipalities under a District
public function showMunicipalities($district_id)
{
    $district = LegislativeDistrict::with('province')->findOrFail($district_id);
    $municipalities = \App\Models\Municipality::where('district_id', $district_id)->get();

    return view('admin.depedhierarchy.municipality', compact('district', 'municipalities'));
}

// ✅ Store Municipality
public function storeMunicipality(Request $request)
{
    $request->validate([
        'municipality_name' => 'required|string|max:255',
        'province_id' => 'required|exists:table_province,province_id',
        'district_id' => 'required|exists:legislative_districts,district_id',
    ]);

    \App\Models\Municipality::create([
        'province_id' => $request->province_id,
        'district_id' => $request->district_id,
        'municipality_name' => $request->municipality_name,
    ]);

    return redirect()->back()->with('success', 'Municipality added successfully!');
}

// ✅ Update Municipality
public function updateMunicipality(Request $request, $id)
{
    $request->validate([
        'municipality_name' => 'required|string|max:255',
    ]);

    $municipality = \App\Models\Municipality::findOrFail($id);
    $municipality->update([
        'municipality_name' => $request->municipality_name,
    ]);

    return redirect()->back()->with('success', 'Municipality updated successfully!');
}

// ✅ Delete Municipality
public function destroyMunicipality($id)
{
    $municipality = \App\Models\Municipality::findOrFail($id);
    $municipality->delete();

    return redirect()->back()->with('success', 'Municipality deleted successfully!');
}


}
