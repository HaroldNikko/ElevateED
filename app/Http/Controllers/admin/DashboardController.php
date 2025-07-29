<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\EvaluatorInfo;
use App\Models\UploadPosition;
use App\Models\BasicInfo;
use App\Models\AssignedEvaluator;
use App\Models\criteria;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard cards
        $teacherCount = Info::count();
        $evaluatorCount = EvaluatorInfo::count();
        $positionCount = UploadPosition::count();
        $applicationCount = BasicInfo::count();
        $approvedCount = BasicInfo::where('Status', 'Approved')->count();

        // Applications over time (last 30 days)
        $appsOverTime = BasicInfo::selectRaw('DATE(submitDate) as date, COUNT(*) as count')
            ->whereNotNull('submitDate')
            ->where('submitDate', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Applications by status
        $appsByStatus = BasicInfo::selectRaw('Status, COUNT(*) as count')
            ->groupBy('Status')
            ->pluck('count', 'Status');

        // Applications by Teacher Rank (CurrentPosition)
        $appsByRank = BasicInfo::selectRaw('CurrentPosition, COUNT(*) as count')
            ->groupBy('CurrentPosition')
            ->pluck('count', 'CurrentPosition');

        // Evaluator workload (number of assignments per evaluator)
        $workload = AssignedEvaluator::selectRaw('evaluatorID, COUNT(*) as count')
            ->groupBy('evaluatorID')
            ->pluck('count', 'evaluatorID');

        return view('admin.dashboard', compact(
            'teacherCount', 'evaluatorCount', 'positionCount', 'applicationCount', 'approvedCount',
            'appsOverTime', 'appsByStatus', 'appsByRank', 'workload'
        ));
    }
}
