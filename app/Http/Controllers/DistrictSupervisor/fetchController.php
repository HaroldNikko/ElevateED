<?php


namespace App\Http\Controllers\DistrictSupervisor;
use App\Http\Controllers\Controller;

use App\Models\SchoolDetail;
use App\Models\TeacherRank;
use App\Models\UploadPosition;


class fetchController extends Controller
{
  


public function showUploadModal()
{
    $vacancies = UploadPosition::with(['teacherRank', 'school'])->get();
    $ranks = TeacherRank::all();
    $schools = SchoolDetail::all();

    return view('districtsupervisor.position', compact('ranks', 'schools', 'vacancies'));
}

}
