<?php

namespace App\Http\Controllers\DistrictSupervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UploadPosition;
use App\Models\SchoolDetail;
use Carbon\Carbon;
use App\Models\AppNotification;
use App\Models\Login;
use App\Models\Info;
use App\Models\TotalPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\BasicInfo;

class UploadPositionController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request (removed district as it's not needed)
        $request->validate([
            'position' => 'required',
            'schoolname' => 'required',
            'deadline' => 'required|date',
        ]);

        // Find the school by its name (no need to check district now)
        $school = SchoolDetail::where('Schoolname', $request->schoolname)->first();

        if (!$school) {
            return response()->json(['error' => 'School not found!'], 404);
        }

        // Generate a unique tracking code
        $trackCode = 'TRK-' . strtoupper(uniqid());

        // ✅ Get info_id from session
        $infoID = session('info_id');

        // Check if info_id is available in session
        if (!$infoID) {
            return response()->json(['error' => 'Session expired. Please log in again.'], 403);
        }

        // Create a new UploadPosition record
        UploadPosition::create([
            'teacher_rankID' => $request->position,
            'schoolID' => $school->schoolID,
            'track_code' => $trackCode,
            'start_date' => now()->toDateString(), // Set start date to today
            'end_date' => $request->deadline, // Deadline from the form
            'DistrictSupervisorID' => $infoID, // Store the District Supervisor's info ID
        ]);

        // Notify all teachers about the new available position
        $teachers = Login::where('role', 'teacher')->get();

        foreach ($teachers as $teacher) {
            if ($teacher->info) {
                AppNotification::create([
                    'teacherID' => $teacher->info->id,
                    'message' => '🆕 A new available position has been uploaded. Explore the opportunity now.',
                    'is_read' => false,
                ]);
            }
        }

        // Return success response
        return response()->json(['success' => true, 'message' => 'Vacancy uploaded successfully!']);
    }

    public function index()
    {
        // ✅ Use session instead of Auth to get the logged-in supervisor's info ID
        $infoID = session('info_id');

        // If session expired or no info_id, show error
        if (!$infoID) {
            abort(403, 'Session expired. Please log in again.');
        }

        // Fetch all vacancies uploaded by the current District Supervisor
        $vacancies = UploadPosition::with(['teacherRank', 'school.district'])
            ->where('DistrictSupervisorID', $infoID)
            ->get()
            ->map(function ($vacancy) {
                // Count the total number of applicants for each vacancy
                $count = TotalPoint::where('uploadID', $vacancy->uploadID)
                    ->distinct('teacherID')
                    ->count('teacherID');
                $vacancy->total_applicants = $count;
                return $vacancy;
            });

        // Fetch available ranks and schools
        $ranks = \App\Models\TeacherRank::all();
        $schools = \App\Models\SchoolDetail::with('district')->get();

        // Return the view with vacancies, ranks, and schools
        return view('districtsupervisor.position', compact('vacancies', 'ranks', 'schools'));
    }

    public function viewApplicants($uploadID)
    {
        // Fetch the vacancy and related details
        $vacancy = UploadPosition::with('teacherRank', 'school.district')->findOrFail($uploadID);

        // Fetch the applicants for this vacancy
        $applicants = BasicInfo::with('teacher')
            ->where('uploadID', $uploadID)
            ->get();

        // Return the view with vacancy and applicants data
        return view('districtsupervisor.result_application', compact('vacancy', 'applicants'));
    }
}
