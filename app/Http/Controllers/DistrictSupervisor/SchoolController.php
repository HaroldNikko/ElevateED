<?php


namespace App\Http\Controllers\DistrictSupervisor;
use App\Http\Controllers\Controller;
use App\Models\SchoolDetail;
use Illuminate\Http\Request;


class SchoolController extends Controller
{
    public function showApplicantPage()
    {
        $schools = SchoolDetail::orderBy('Schoolname')->get();
        return view('districtsupervisor.applicant', compact('schools'));
    }
}