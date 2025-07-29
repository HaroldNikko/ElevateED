<?php

namespace App\Http\Controllers\Evaluator;

use App\Http\Controllers\Controller;
use App\Models\AssignedEvaluator;
use App\Models\TotalPoint;
use App\Models\DocumentEvaluation;
use App\Models\Criteria;

class EvaluatorDashboardController extends Controller
{
    public function index()
{
    $evaluatorID = session('EvaluatorID');

    $assignedUploadIDs = AssignedEvaluator::where('EvaluatorID', $evaluatorID)
        ->pluck('uploadID');

    $totalAssignedWithPoints = TotalPoint::whereIn('uploadID', $assignedUploadIDs)
        ->count();

    // Fetch ALL criteria
    $criteria = Criteria::pluck('criteriaDetail', 'criteriaID')->toArray();

    // Get counts per criteria (only those with data)
    $evaluations = DocumentEvaluation::whereIn('uploadID', $assignedUploadIDs)
        ->select('criteriaID')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('criteriaID')
        ->pluck('count', 'criteriaID')
        ->toArray();

    // Build complete bar chart data (show all criteria, zero if no count)
    $barChartLabels = [];
    $barChartData = [];

    foreach ($criteria as $criteriaID => $criteriaDetail) {
        $barChartLabels[] = $criteriaDetail;
        $barChartData[] = $evaluations[$criteriaID] ?? 0;
    }

    return view('evaluator.evaluator_dashboard', [
        'totalAssigned' => $totalAssignedWithPoints,
        'barChartLabels' => $barChartLabels,
        'barChartData' => $barChartData,
    ]);
}
}
