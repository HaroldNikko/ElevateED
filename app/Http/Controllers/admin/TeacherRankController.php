<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherRank;
use App\Models\Region;
use App\Models\Province;
use App\Models\LegislativeDistrict;
use App\Models\Municipality;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Barangay;
use App\Models\SchoolDetail;


class TeacherRankController extends Controller
{
    // Display Teacher Ranks and Regions
    public function index()
    {
        $ranks = TeacherRank::paginate(7);
        $regions = Region::paginate(7);

        return view('admin.systemsetup.systemsetup', compact('ranks', 'regions'));
    }

    // Show all Provinces under a Region
    public function showDivision($id)
    {
        $region = Region::findOrFail($id);
        $provinces = Province::where('region_id', $id)->paginate(10);

        return view('admin.systemsetup.show_provinces', compact('region', 'provinces'));
    }

    // Show all Municipalities + Districts under a Province
    public function showMunDistrict($province_id)
    {
        $province = Province::with('region')->findOrFail($province_id);

        $districts = LegislativeDistrict::with('municipalities')
            ->where('province_id', $province_id)
            ->get();

        $merged = new Collection();

        foreach ($districts as $district) {
            foreach ($district->municipalities as $municipality) {
                $merged->push([
                    'district_name' => $district->district_name,
                    'municipality_name' => $municipality->municipality_name
                ]);
            }
        }

        $perPage = 7;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($currentItems, $merged->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        // ✅ Define region and province names
        $regionName = $province->region->region_name ?? 'N/A';
        $provinceName = $province->province_name ?? 'N/A';

        return view('admin.systemsetup.show_mun_district', compact('paginated', 'regionName', 'provinceName'));
    }

    // Show Add School Interface
    public function addSchool(Request $request)
{
    $region = $request->input('region');
    $province = $request->input('province');
    $district = $request->input('district');
    $municipality = $request->input('municipality');

    $schools = SchoolDetail::with(['region', 'province', 'district', 'municipality', 'barangay'])->get();

    return view('admin.systemsetup.addschool', compact(
        'region',
        'province',
        'district',
        'municipality',
        'schools' // ✅ pass the schools to fix the error
    ));
}

    public function getBarangays($municipality)
{
    $barangays = Barangay::where('municipality_id', $municipality)->get(['barangay_id', 'barangay_name']);

    return response()->json($barangays);
}


public function saveSchool(Request $request)
{
    $validated = $request->validate([
        'schoolname' => 'required|string',
        'Basic_education' => 'required|string',
        'region' => 'required|string',
        'province' => 'required|string',
        'district' => 'required|string',
        'municipality' => 'required|string',
        'barangay' => 'required|string',
    ]);

    // Get matching IDs
    $region_id = \App\Models\Region::where('region_name', $validated['region'])->value('region_id');
    $province_id = \App\Models\Province::where('province_name', $validated['province'])->value('province_id');
    $district_id = \App\Models\LegislativeDistrict::where('district_name', $validated['district'])->value('district_id');
    $municipality_id = \App\Models\Municipality::where('municipality_name', $validated['municipality'])->value('municipality_id');
    $barangay_id = \App\Models\Barangay::where('barangay_name', $validated['barangay'])->value('barangay_id');

    SchoolDetail::create([
        'Schoolname' => $validated['schoolname'],
        'Basic_education' => $validated['Basic_education'],
        'region_id' => $region_id,
        'province_id' => $province_id,
        'district_id' => $district_id,
        'municipality_id' => $municipality_id,
        'barangay_id' => $barangay_id,
    ]);

    return response()->json(['success' => true, 'message' => 'School added successfully!']);
}

public function deleteSchool($id)
{
    $school = SchoolDetail::findOrFail($id);
    $school->delete();
    return redirect()->back()->with('deleted', 'School deleted.');
}

public function getSchool($id)
{
    $school = SchoolDetail::with(['region', 'province', 'district', 'municipality', 'barangay'])->findOrFail($id);
    return response()->json($school);
}

// Update school record
public function updateSchool(Request $request, $id)
{
    $school = SchoolDetail::findOrFail($id);

    $school->update([
        'Schoolname' => $request->schoolname,
        'Basic_education' => $request->Basic_education,
        'region_id' => Region::where('region_name', $request->region)->value('region_id'),
        'province_id' => Province::where('province_name', $request->province)->value('province_id'),
        'district_id' => LegislativeDistrict::where('district_name', $request->district)->value('district_id'),
        'municipality_id' => Municipality::where('municipality_name', $request->municipality)->value('municipality_id'),
        'barangay_id' => Barangay::where('barangay_name', $request->barangay)->value('barangay_id'),
    ]);

    return response()->json(['success' => true, 'message' => 'School updated successfully.']);
}

    // Store a new Teacher Rank
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacherRank' => 'required|string|max:255',
            'Salary_grade' => 'required|string|max:10'
        ]);

        TeacherRank::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Added Successfully!'
        ]);
    }

    // Update an existing Teacher Rank
    public function updateRank(Request $request)
    {
        $rank = TeacherRank::find($request->teacherrank_id);

        if ($rank) {
            $rank->update([
                'teacherRank' => $request->teacherRank,
                'Salary_grade' => $request->Salary_grade
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Rank not found.']);
    }

    // Delete a Teacher Rank
    public function deleteRank(Request $request)
    {
        $rank = TeacherRank::find($request->id);

        if ($rank) {
            $rank->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Rank not found.']);
    }
}
