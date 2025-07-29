<?php namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UploadPosition;
use App\Models\BasicInfo;
use App\Models\TotalPoint;
use App\Models\DocumentEvaluation;
use App\Models\Criteria;

class TeacherController extends Controller
{
    public function updateStatus(Request $request)
    {
        \Log::debug('updateStatus() called', [
            'selected_applicants' => $request->input('selected_applicants'),
            'status' => $request->input('status'),
        ]);

        $teacherIDs = $request->input('selected_applicants', []);
        $newStatus = $request->input('status');

        if (empty($teacherIDs) || !$newStatus) {
            \Log::warning('updateStatus(): missing applicants or status.', [
                'teacherIDs' => $teacherIDs,
                'status' => $newStatus,
            ]);
            return response()->json(['success' => false, 'message' => 'No applicants selected or status missing.'], 400);
        }

        DB::table('basic_info')
            ->whereIn('teacherID', $teacherIDs)
            ->update(['Status' => $newStatus]);

        \Log::info('updateStatus(): successfully updated.', [
            'updated_teacherIDs' => $teacherIDs,
            'newStatus' => $newStatus,
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated to ' . $newStatus]);
    }

    public function updateDocumentStatus(Request $request)
        {
            $documentID = $request->input('documentID');
            $status = $request->input('status');
            $comment = $request->input('comment', null);

            if (!$documentID || !$status) {
                return response()->json(['success' => false, 'message' => 'Missing required data.'], 400);
            }

            DocumentEvaluation::where('documentID', $documentID)->update([
                'StatusOfDocument' => $status,
                'Comment' => $comment, // will save null if no comment is given
            ]);

            return response()->json(['success' => true, 'message' => 'Document status updated successfully.']);
        }


    public function showTeacherInfo($uploadID)
    {
        $uploadPosition = UploadPosition::with('school', 'teacherRank')->find($uploadID);

        if (!$uploadPosition) {
            return redirect()->route('home')->with('error', 'Upload position not found.');
        }

        $applicants = BasicInfo::where('uploadID', $uploadID)
            ->with(['teacher', 'position'])
            ->get()
            ->map(function ($applicant) use ($uploadID) {
                $score = TotalPoint::where('teacherID', $applicant->teacherID)
                    ->where('uploadID', $uploadID)
                    ->value('total_points');

                $applicant->score = $score ?? '0';
                return $applicant;
            });

        return view('evaluator.teacher_info', compact('uploadPosition', 'applicants'));
    }

    public function showApplicantDocuments($teacherID, $uploadID, Request $request)
    {
        $criteriaList = Criteria::all();
        $activeCriteriaID = $request->query('criteriaID', $criteriaList->first()?->criteriaID);

        $activeCriteria = Criteria::find($activeCriteriaID);

        $documents = DocumentEvaluation::where('teacherID', $teacherID)
            ->where('uploadID', $uploadID)
            ->where('criteriaID', $activeCriteriaID)
            ->get();

        return view('evaluator.final_review_doc', compact(
            'criteriaList', 'documents', 'activeCriteria', 'teacherID', 'uploadID'
        ));
    }
}
