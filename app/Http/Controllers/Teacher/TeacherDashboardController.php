<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\AppNotification;
use App\Models\DocumentEvaluation;
use App\Models\criteria;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherID = session('info_id');

        if (!$teacherID) {
            \Log::warning('TeacherDashboardController: teacherID missing from session.');
            return redirect('/login')->with('error', 'Session expired. Please log in again.');
        }

        // Metrics: only for this teacher
        $totalApplications = BasicInfo::where('teacherID', $teacherID)->count();
        $approvedApplications = BasicInfo::where('teacherID', $teacherID)
            ->where('Status', 'Approved')
            ->count();
        $pendingApplications = BasicInfo::where('teacherID', $teacherID)
            ->where('Status', 'Pending')
            ->count();

        \Log::info('TeacherDashboardController Metrics', [
            'teacherID' => $teacherID,
            'totalApplications' => $totalApplications,
            'approvedApplications' => $approvedApplications,
            'pendingApplications' => $pendingApplications,
        ]);

        // Timeline Chart (this teacher only)
        $timelineData = BasicInfo::selectRaw('MONTHNAME(submitDate) as month, COUNT(*) as total')
            ->whereYear('submitDate', now()->year)
            ->where('teacherID', $teacherID)
            ->groupBy('month')
            ->orderByRaw('MONTH(submitDate)')
            ->pluck('total', 'month')
            ->toArray();

        \Log::info('TeacherDashboardController TimelineData', $timelineData);

        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $timelineLabels = [];
        $timelineValues = [];
        foreach ($months as $month) {
            $timelineLabels[] = $month;
            $timelineValues[] = $timelineData[$month] ?? 0;
        }

        $timelineChart = [
            'labels' => $timelineLabels,
            'datasets' => [
                [
                    'label' => 'Applications',
                    'data' => $timelineValues,
                    'borderColor' => '#b41f28',
                    'backgroundColor' => 'rgba(180,31,40,0.1)',
                ]
            ],
        ];

        // Notifications Chart (this teacher only)
        $read = AppNotification::where('teacherID', $teacherID)->where('is_read', 1)->count();
        $unread = AppNotification::where('teacherID', $teacherID)->where('is_read', 0)->count();

        \Log::info('TeacherDashboardController Notifications', [
            'read' => $read,
            'unread' => $unread,
        ]);

        $notificationsChart = [
            'labels' => ['Unread', 'Read'],
            'datasets' => [[
                'data' => [$unread, $read],
                'backgroundColor' => ['#00008B', '#B41F28'], // dark blue, red
            ]],
        ];


        // Evaluation Progress Chart (this teacher only)
        $criteria = criteria::pluck('criteriaDetail', 'criteriaID')->toArray();

        \Log::info('TeacherDashboardController Criteria', $criteria);

        $progress = DocumentEvaluation::where('teacherID', $teacherID)
            ->selectRaw('criteriaID, SUM(faculty_score) as total')
            ->groupBy('criteriaID')
            ->pluck('total', 'criteriaID')
            ->toArray();

        \Log::info('TeacherDashboardController Progress', $progress);

        $evaluationLabels = [];
        $evaluationValues = [];
        foreach ($criteria as $id => $detail) {
            $evaluationLabels[] = $detail;
            $evaluationValues[] = $progress[$id] ?? 0;
        }

        $evaluationChart = [
            'labels' => $evaluationLabels,
            'datasets' => [[
                'label' => 'Points Scored',
                'data' => $evaluationValues,
                'backgroundColor' => '#b41f28',
            ]],
        ];

        \Log::info('TeacherDashboardController Finished preparing data.');

       return view('teacher.dashboard_teacher', compact(
            'totalApplications', 'approvedApplications', 'pendingApplications',
            'timelineChart', 'notificationsChart', 'evaluationChart',
            'unread', 'read' // ← ADD THESE TWO!
        ));

    }
}
