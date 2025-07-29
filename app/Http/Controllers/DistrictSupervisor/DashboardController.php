<?php

namespace App\Http\Controllers\DistrictSupervisor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\SchoolDetail;
use App\Models\Info;
use App\Models\UploadPosition;
use App\Models\Login;

class DashboardController extends Controller
{
    public function index()
    {
        // Count total applications (from upload_position)
        $totalApplications = UploadPosition::count();

        // Count total evaluators (from login table where role is evaluator)
        $totalEvaluators = Login::where('role', 'evaluator')->count();

        // Example for "Promoted this Month" (set to static for now)
        $promotedThisMonth = 10;

        return view('districtsupervisor.dashboard', [
            'totalApplications' => $totalApplications,
            'totalEvaluators' => $totalEvaluators,
            'promotedThisMonth' => $promotedThisMonth,
        ]);
    }
}
