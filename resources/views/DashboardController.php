<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function teacher()
    {
        return view('teacher.dashboard_teacher'); // or view('teacher.dashboard')
    }

    public function districtSupervisor()
    {
        return view('districtsupervisor.dashboard');
    }

    public function evaluator()
    {
        return view('evaluator.dashboard_evaluator');
    }
}
