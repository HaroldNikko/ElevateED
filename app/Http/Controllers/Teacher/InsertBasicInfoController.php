<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UploadPosition;
use App\Models\BasicInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\DocumentEvaluation;
use App\Models\TotalPoint;

class InsertBasicInfoController extends Controller
{
    public function submitApplication(Request $request)
{
    Log::info("📝 Submitting Application");

    $step1     = session('step1');
    $teacherID = session('teacherID');
    $uploadID  = session('uploadID');

    Log::info('Session step1:', $step1 ?? []);
    Log::info('Session teacherID: ' . $teacherID);
    Log::info('Session uploadID: ' . $uploadID);

    if (!$step1 || !$teacherID || !$uploadID) {
        Log::error("❌ Missing session data for application submission");
        return back()->with('error', 'Incomplete session data.');
    }

    // ✅ Check if already submitted
    $alreadySubmitted = \App\Models\TotalPoint::where('teacherID', $teacherID)
                        ->where('uploadID', $uploadID)
                        ->exists();

    if ($alreadySubmitted) {
        Log::warning("⚠️ Application already submitted by teacherID: $teacherID and uploadID: $uploadID");
        return back()->with('error', 'You have already submitted your application for this position.');
    }

    // ✅ Proceed with inserting if not yet submitted
    \App\Models\BasicInfo::create([
    'teacherID'       => $teacherID,
    'uploadID'        => $uploadID,
    'ApplicantID'     => $step1['applicant_code'],
    'Firstname'       => explode(' ', $step1['full_name'])[0] ?? '',
    'MiddleName'      => explode(' ', $step1['full_name'])[1] ?? '',
    'LastName'        => explode(' ', $step1['full_name'])[2] ?? '',
    'CurrentPosition' => $step1['current_position'],
    'email'           => $step1['email'],
    'contactnumber'   => $step1['contact_number'],
    'schoolname'      => $step1['school_name'],
    'schooladdress'   => $step1['school_address'],
    'Address'         => $step1['address'], // ✅ Added here
    'Status'          => 'Pending',
    'submitDate'      => now(),
]);


    $drafts = collect(session("drafts_{$teacherID}_{$uploadID}", []));
    $totalPoints = 0;

foreach ($drafts as $draft) {
    // ✅ Fetch QualityLevelID based on selected level and criteriaID
    $qualityLevelID = \App\Models\QualificationLevel::where('CriteriaID', $draft['criteriaID'])
                        ->where('Level', $draft['qualification_level'])
                        ->value('QualityLevelID');

    $score = $draft['faculty_score'] ?? 0;
    $totalPoints += $score;

    \App\Models\DocumentEvaluation::create([
        'teacherID'         => $teacherID,
        'uploadID'          => $uploadID,
        'criteriaID'        => $draft['criteriaID'],
        'title'             => $draft['title'],
        'description'       => $draft['description'] ?? null,
        'date_presented'    => $draft['date_presented'],
        'upload_file'       => $draft['upload_file'],
        'faculty_score'     => $score,
        'StatusOfDocument'  => 'Pending',
        'Comment'           => '',
        'QualityLevelID'    => $qualityLevelID,
    ]);
}

    \App\Models\TotalPoint::create([
        'teacherID'     => $teacherID,
        'uploadID'      => $uploadID,
        'total_points'  => $totalPoints,
    ]);

    Log::info("✅ Total Points Saved: $totalPoints");

    // Clear session
    Session::forget("drafts_{$teacherID}_{$uploadID}");
    Session::forget('step1');

    return redirect()->back()->with('step', 3)->with('success', 'Application submitted successfully!');
}


}
