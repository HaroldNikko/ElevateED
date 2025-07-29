<?php


namespace App\Http\Controllers\DistrictSupervisor;
use App\Http\Controllers\Controller;

use App\Models\UploadPosition;
use App\Models\Criteria;
use App\Models\DocumentEvaluation;


class ReviewDocumentController extends Controller
{


public function showUploadForm($uploadID, $criteriaID, $teacherID)
{
    $position = UploadPosition::with(['school.district', 'teacherRank'])->findOrFail($uploadID);
    $criteria = Criteria::orderBy('criteriaID')->get();
    $activeCriteriaID = $criteriaID;

    $documents = DocumentEvaluation::where('uploadID', $uploadID)
        ->where('teacherID', $teacherID)
        ->get()
        ->groupBy('criteriaID');

    return view('districtsupervisor.review_documents', compact('position', 'criteria', 'activeCriteriaID', 'documents'));
}

}