<?php

namespace App\Http\Controllers\DistrictSupervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignedEvaluator;
use App\Models\UploadPosition;
use App\Models\Login;

class EvaluatorAssignmentController extends Controller
{
    // Method to show the evaluator form
public function showEvaluatorForm(Request $request)
{
    // Fetch distinct track_codes from the UploadPosition model
    $trackCodes = UploadPosition::select('track_code')->distinct()->get();

    // Fetch evaluators from the Info model where role is 'evaluator'
    $evaluators = \App\Models\Login::where('role', 'evaluator')
        ->join('info', 'login.Login_id', '=', 'info.Login_id')
        ->get(['info.firstname', 'info.lastname', 'info.middlename', 'login.Login_id']);

    // Default values for schoolName and teacherRank
    $schoolName = '';
    $teacherRank = '';

    // Default empty assignedEvaluators
    $assignedEvaluators = [];

    // If a track_code is selected, fetch the school name, teacher rank and assigned evaluators
    if ($request->has('trackCode')) {
        $trackCode = $request->input('trackCode');

        // Get assigned evaluators for the selected trackCode
        $assignedEvaluators = AssignedEvaluator::with(['evaluator', 'uploadPosition'])
            ->whereHas('uploadPosition', function($query) use ($trackCode) {
                $query->where('track_code', $trackCode);
            })
            ->get();

        $uploadPosition = UploadPosition::where('track_code', $trackCode)
                                        ->with(['school', 'teacherRank'])
                                        ->first();

        if ($uploadPosition) {
            $schoolName = $uploadPosition->school ? $uploadPosition->school->Schoolname : '';
            $teacherRank = $uploadPosition->teacherRank ? $uploadPosition->teacherRank->teacherRank : '';
        }
    }
    

    // Pass evaluators, trackCodes, assignedEvaluators, schoolName, and teacherRank to the view
    return view('districtsupervisor.evaluator', compact('evaluators', 'trackCodes', 'assignedEvaluators', 'schoolName', 'teacherRank'));
}



    // AJAX method to fetch school name and teacher rank based on track code
    public function fetchSchoolAndTeacherRank(Request $request)
    {
        if ($request->ajax()) {
            $trackCode = $request->input('trackCode');
            $uploadPosition = UploadPosition::where('track_code', $trackCode)
                                            ->with(['school', 'teacherRank'])
                                            ->first();

            if ($uploadPosition) {
                return response()->json([
                    'school' => $uploadPosition->school ? $uploadPosition->school->Schoolname : '',
                    'teacherRank' => $uploadPosition->teacherRank ? $uploadPosition->teacherRank->teacherRank : ''
                ]);
            } else {
                return response()->json(['school' => '', 'teacherRank' => '']);
            }
        }
    }
}
