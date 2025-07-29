<?php

namespace App\Http\Controllers;

use App\Models\DocumentEvaluation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\TotalPoint;

class ApplicantResultController extends Controller
{
    public function showForm(Request $request)
    {
        $preFillID = $request->query('applicantID');
        return view('results.enter_applicant_id', compact('preFillID'));
    }

    public function generatePDF(Request $request)
{
    $request->validate([
        'applicantID' => 'required|string|exists:info,applicantID',
    ]);

    $applicantID = $request->input('applicantID');

    // 🔎 Hanapin ang teacher record sa Info table gamit ang applicant ID
    $teacherInfo = \App\Models\Info::where('applicantID', $applicantID)->first();

    if (!$teacherInfo) {
        return back()->withErrors(['applicantID' => 'Applicant not found.']);
    }

    // 🔎 Hanapin ang evaluations gamit ang Info.id na siyang ginagamit sa document_evaluations.teacherID
  $evaluations = \App\Models\DocumentEvaluation::with(['criteria', 'qualificationLevel'])
    ->where('teacherID', $teacherInfo->id)
    ->get();


    if ($evaluations->isEmpty()) {
        return back()->withErrors(['applicantID' => 'No evaluations found for this applicant ID.']);
    }

    // 🔎 Hanapin ang basic info record para sa uploadID
    $basicInfo = \App\Models\BasicInfo::where('teacherID', $teacherInfo->id)->first();
    if (!$basicInfo) {
        return back()->withErrors(['applicantID' => 'Applicant basic info not found.']);
    }

    // 🔎 Hanapin ang kabuuang puntos ng applicant
    $totalPoints = \App\Models\TotalPoint::where('teacherID', $teacherInfo->id)
        ->where('uploadID', $basicInfo->uploadID)
        ->first();

    if (!$totalPoints) {
        return back()->withErrors(['applicantID' => 'Total points not found for this applicant.']);
    }

    // 🔎 Hanapin lahat ng total points para sa parehong uploadID
    $allPoints = \App\Models\TotalPoint::where('uploadID', $basicInfo->uploadID)
        ->orderByDesc('total_points')
        ->get();

    // 🔎 Tukuyin ang rank
    $rank = 1;
    foreach ($allPoints as $tp) {
        if ($tp->teacherID == $teacherInfo->id) {
            break;
        }
        $rank++;
    }

    // 🔎 Kunin lahat ng criteria para siguradong maipapakita lahat sa PDF
    $criteria = \App\Models\Criteria::orderBy('criteriaID')->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('results.evaluation_pdf', [
        'evaluations' => $evaluations,
        'criteria' => $criteria, // ← ipasa lahat ng criteria
        'applicant' => $teacherInfo,
        'totalPoints' => $totalPoints->total_points,
        'rank' => $rank,
    ]);

    return $pdf->download("EvaluationResults_{$applicantID}.pdf");
}


}
