<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

use App\Models\UploadPosition;
use App\Models\SchoolDetail;
use App\Models\Criteria; // ✅ Add this
use Carbon\Carbon;
use App\Models\DocumentEvaluation;
 use App\Models\Info; // ✅ don't forget to import
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\QualityStandard;
use App\Models\TeacherRank;
 use App\Models\QualificationLevel;
use Illuminate\Support\Facades\DB;


class UploadDocumentController extends Controller
{





public function showForm()
{
    session()->forget('step'); // <== This will reset to step 1
    return view('teacher.form');
}




 public function getQualificationLevel($criteriaID, $level)
{
    $record = QualificationLevel::where('CriteriaID', $criteriaID)
                ->where('Level', $level)
                ->first();

    if ($record) {
        return response()->json([
            'from' => $record->From,
            'to'   => $record->To,
        ]);
    }

    return response()->json(['error' => 'Not found'], 404);
}


    public function showUploadForm($uploadID, $criteriaID = null)
    {
        session(['uploadID' => $uploadID]);

        $position = UploadPosition::with(['school.district', 'teacherRank'])->findOrFail($uploadID);
        $criteria = Criteria::orderBy('criteriaID')->get();
        $activeCriteriaID = $criteriaID ?? $criteria->first()?->criteriaID;

        session(['activeCriteriaID' => $activeCriteriaID]);

        $teacherID = session('teacherID');
        $teacherInfo = Info::with('school')->where('id', $teacherID)->first();

        $documents = DocumentEvaluation::where('uploadID', $uploadID)
            ->where('teacherID', $teacherID)
            ->get()
            ->groupBy('criteriaID');

        $sessionDrafts = Session::get("drafts_{$teacherID}_{$uploadID}", []);
        $drafts = collect($sessionDrafts)->groupBy('criteriaID');

        $teacherRankID = $position->teacher_rankID;

        $qualityStandards = QualityStandard::where('teacher_RankID', $teacherRankID)->get()->groupBy('CriteriaID');

        $qualificationLevels = QualificationLevel::all()->groupBy('CriteriaID');

        return view('teacher.upload_document', compact(
            'position',
            'criteria',
            'activeCriteriaID',
            'documents',
            'drafts',
            'teacherInfo',
            'qualityStandards',
            'qualificationLevels'
        ));
    }


public function storeDraft(Request $request)
{
    try {
        $request->validate([
            'criteriaID' => 'required',
            'uploadID' => 'required',
            'title' => 'required|string',
            'faculty_score' => 'required|numeric|min:0|max:100',
            'date_presented' => 'nullable|date',
            'upload_file' => 'required|file|mimes:pdf',
            'qualification_level' => 'required',
            'level_from' => 'nullable|string',
            'level_to' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);
    }

    // 📂 Save uploaded file
    $filename = $request->file('upload_file')->store('uploads', 'public');

    $teacherID = session('teacherID');
    $key = "drafts_{$teacherID}_{$request->uploadID}";
    $drafts = session($key, []);

    // 🔍 Fetch QualityLevelID based on selected criteria and level
    $qualityLevelID = QualificationLevel::where('CriteriaID', $request->criteriaID)
                        ->where('Level', $request->qualification_level)
                        ->value('QualityLevelID');

    $drafts[] = [
        'criteriaID'          => $request->criteriaID,
        'title'               => $request->title,
        'date_presented'      => $request->date_presented,
        'upload_file'         => basename($filename),
        'original_name'       => $request->file('upload_file')->getClientOriginalName(),
        'qualification_level' => $request->qualification_level,
        'QualityLevelID'      => $qualityLevelID, // ✅ Save this in session
        'level_from'          => $request->level_from,
        'level_to'            => $request->level_to,
        'description'         => $request->description,
        'faculty_score'       => $request->faculty_score,
    ];

    session([$key => $drafts]);

    return response()->json(['success' => true]);
}




public function deleteDraft(Request $request)
{
    $filename = $request->filename;
    $uploadID = $request->uploadID;
    $teacherID = session('teacherID');

    $sessionKey = "drafts_{$teacherID}_{$uploadID}";
    $drafts = session()->get($sessionKey, []);

    $updatedDrafts = array_filter($drafts, function ($draft) use ($filename) {
        return $draft['upload_file'] !== $filename;
    });

    session()->put($sessionKey, array_values($updatedDrafts));

    return response()->json(['success' => true]);
}


public function saveBasicDetails(Request $request)
{
    // Get the teacher info based on the session teacherID
    $teacherID = session('teacherID');
    
    // Raw SQL query to fetch data from Info, TeacherInfo, and SchoolDetail
    $teacherInfo = DB::table('info')
        ->leftJoin('teacherinfo', 'info.id', '=', 'teacherinfo.id') // Join Info and TeacherInfo
        ->leftJoin('userdesignation', 'info.id', '=', 'userdesignation.id') // Join Info and UserDesignation
        ->leftJoin('schooldetails', 'userdesignation.schoolID', '=', 'schooldetails.schoolID') // Join UserDesignation and SchoolDetail
        ->leftJoin('table_province', 'schooldetails.province_id', '=', 'table_province.province_id') // Join Province
        ->leftJoin('table_municipality', 'schooldetails.municipality_id', '=', 'table_municipality.municipality_id') // Join Municipality
        ->leftJoin('table_barangay', 'schooldetails.barangay_id', '=', 'table_barangay.barangay_id') // Join Barangay
        ->where('info.id', $teacherID)
        ->select(
            'info.firstname', 
            'info.middlename', 
            'info.lastname', 
            'info.email', 
            'info.phonenumber', 
            'info.Address',
            'teacherinfo.applicantID', 
            'teacherinfo.currentrank', 
            'schooldetails.Schoolname',
            // Concatenate Province, Municipality, and Barangay to form schooladdress
            DB::raw("CONCAT(table_province.province_name, ', ', table_municipality.municipality_name, ', ', table_barangay.barangay_name) as schooladdress")
        )
        ->first(); // Get the first record

    // Log the teacherInfo object to check its data
    \Log::info('Teacher Info Retrieved:', ['teacherInfo' => $teacherInfo]);

    // Check if teacherInfo exists
    if (!$teacherInfo) {
        return redirect()->back()->with('error', 'Teacher info not found');
    }

    // Fetch necessary data from the query result
    $data = [
        'applicant_code'     => $teacherInfo->applicantID ?? 'APL22', // Fallback if applicantID is null
        'full_name'          => $teacherInfo->firstname . ' ' . $teacherInfo->middlename . ' ' . $teacherInfo->lastname,
        'email'              => $teacherInfo->email ?? '', // Fallback if email is null
        'contact_number'     => $teacherInfo->phonenumber ?? '', // Fallback if phone number is null
        'current_position'   => $teacherInfo->currentrank ?? 'Teacher I', // From TeacherInfo, fallback if null
        'school_name'        => $teacherInfo->Schoolname ?? '', // From SchoolDetail, fallback if null
        'school_address'     => $teacherInfo->schooladdress ?? '', // Using the dynamically fetched school address
        'address'            => $teacherInfo->Address ?? 'Pantalan Nasugbu Batngas', // Fallback if address is null
    ];

    // Save the data in the session
    session(['step1' => $data]);

    // Optionally, set the next step in the session
    session(['step' => 2]);

    // Log session data after saving
    \Log::info('Session Updated:', session()->all());

    // Redirect back to the form or next step without success message
    return redirect()->back();
}








}
