<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolDetail;
use App\Models\Info;
use App\Models\Region;
use App\Models\Province;
use App\Models\LegislativeDistrict;
use App\Models\Municipality;
use Illuminate\Pagination\LengthAwarePaginator;

class SchoolCountController extends Controller
{
    // Show all schools with teacher count
    public function index()
    {
        $schools = SchoolDetail::withCount([
            'teachers as teacher_count' => function ($query) {
                $query->whereHas('login', function ($q) {
                    $q->where('role', 'teacher');
                });
            }
        ])->get();

        return view('admin.school', compact('schools'));
    }

    // Show schools filtered by municipality and district
    public function filteredSchools($municipality_id, $district_id)
    {
        $schools = SchoolDetail::withCount([
            'teachers as teacher_count' => function ($query) {
                $query->whereHas('login', function ($q) {
                    $q->where('role', 'teacher');
                });
            }
        ])
        ->where('municipality_id', $municipality_id)
        ->where('district_id', $district_id)
        ->get();

        return view('admin.school', compact('schools'));
    }

    // Show region selection
    public function selectRegion()
    {
        $regions = Region::paginate(9);
        return view('admin.select_region', compact('regions'));
    }

    // Show provinces (divisions) under region
    public function selectDivision($id)
    {
        $region = Region::findOrFail($id);
        $provinces = Province::where('region_id', $id)->paginate(9);
        return view('admin.select_division', compact('region', 'provinces'));
    }

    // Show districts and municipalities under a province (paginated)
    public function selectMunicipalities($province_id)
    {
        $province = Province::findOrFail($province_id);

        $districts = LegislativeDistrict::with('municipalities')
                        ->where('province_id', $province_id)
                        ->get();

        $flat = collect();
        foreach ($districts as $district) {
            foreach ($district->municipalities as $municipality) {
                $flat->push([
                    'district_name' => $district->district_name,
                    'municipality_name' => $municipality->municipality_name,
                    'district_id' => $district->district_id,
                    'municipality_id' => $municipality->municipality_id,
                ]);
            }
        }

        $page = request()->get('page', 1);
        $perPage = 9;
        $paged = new LengthAwarePaginator(
            $flat->forPage($page, $perPage),
            $flat->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.select_mun_district', [
            'province' => $province,
            'municipalityData' => $paged
        ]);
    }

    public function show($id)
{
    $school = SchoolDetail::findOrFail($id);

$teachers = \App\Models\Info::whereHas('login', function ($q) {
        $q->where('role', 'teacher');
    })
    ->whereHas('userdesignation', function ($q) use ($id) {
        $q->where('schoolID', $id);
    })
    ->with('login')
    ->get();

return view('admin.school-show', compact('school', 'teachers'));

}


    // Show no-teacher page
    public function noTeacher($id)
    {
        $school = SchoolDetail::findOrFail($id);
        return view('admin.no-teacher', compact('school'));
    }
  
public function showCsvImport($id)
{
    $school = SchoolDetail::findOrFail($id);
    return view('admin.csv-import', compact('school'));
}

}
