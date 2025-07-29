<?php namespace App\Http\Controllers\evaluator;

use App\Http\Controllers\Controller;
use App\Models\AssignedEvaluator;
use App\Models\BasicInfo;
use App\Models\SchoolDetail;
use Illuminate\Support\Facades\Log; // Import the Log facade

class DocumentReviewController extends Controller
{
    public function showEvaluatorDetails()
    {
        // Retrieve the evaluatorID from the session
        $evaluatorID = session('EvaluatorID');

        // Check if evaluatorID exists in the session
        if (!$evaluatorID) {
            return redirect()->route('login')->with('error', 'You must be logged in as an evaluator.');
        }

        // Fetch all assigned evaluators for the current evaluator using the evaluatorID
        $assignedEvaluators = AssignedEvaluator::with([
                'evaluator', 
                'uploadPosition.school', 
                'uploadPosition.teacherRank'
            ])
            ->where('evaluatorID', $evaluatorID) // Use the evaluatorID from session
            ->get();

        // For each assigned evaluator, count the total applicants for that uploadID
        foreach ($assignedEvaluators as $assignedEvaluator) {
            $assignedEvaluator->totalApplicants = BasicInfo::where('uploadID', $assignedEvaluator->uploadID)->count();
        }

        // Log the retrieved data for debugging
        Log::debug('Assigned Evaluators:', ['assignedEvaluators' => $assignedEvaluators]);

        return view('evaluator.rev_doc', compact('assignedEvaluators'));
    }
}
