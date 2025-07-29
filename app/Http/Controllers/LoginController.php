<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Login;
use App\Models\Info;
use App\Models\TeacherInfo;
use App\Models\DistrictSupervisor;
use App\Models\UserDesignation;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

   public function authenticate(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Login::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        $info = Info::where('Login_id', $user->Login_id)->first();

        if (!$info) {
            \Log::warning('Login attempted with missing Info record', [
                'Login_id' => $user->Login_id,
                'username' => $user->username,
            ]);
            return back()->with('error', 'Account information is incomplete.');
        }

        // Save the teacher ID in session
        session(['teacherID' => $info->id]);
        session(['EvaluatorID' => $info->id]);
        // Base session from info
        session([
            'Login_id'      => $user->Login_id,
            'role'          => $user->role,
            'info_id'       => $info->id,
            'firstname'     => $info->firstname ?? '',
            'middlename'    => $info->middlename ?? '',
            'lastname'      => $info->lastname ?? '',
            'email'         => $info->email ?? '',
            'phonenumber'   => $info->phonenumber ?? '',
            'Address'       => $info->Address ?? '',
            'profile'       => $info->profile ?? 'user_prof.png',
        ]);

        // Add UserDesignation data to session
        $userDesignation = UserDesignation::where('id', $info->id)->first();
        if ($userDesignation) {
            session([
                'region_id'      => $userDesignation->region_id ?? '',
                'province_id'    => $userDesignation->province_id ?? '',
                'district_id'    => $userDesignation->district_id ?? '',
                'municipality_id'=> $userDesignation->municipality_id ?? '',
                'schoolID'       => $userDesignation->schoolID ?? '',
                'designationID'  => $userDesignation->designationID ?? '',
            ]);
        }

        // Role-specific session
        if ($user->role === 'teacher') {
            $teacher = TeacherInfo::where('id', $info->id)->first();
            if ($teacher) {
                session([
                    'applicantID' => $teacher->applicantID ?? '',
                    'currentrank' => $teacher->currentrank ?? '',
                    'currentyear' => $teacher->currentyear ?? '',
                    'endyear'     => $teacher->endyear ?? '',
                ]);
            }
        }

        if ($user->role === 'District Supervisor') {
            $supervisor = DistrictSupervisor::where('id', $info->id)->first();
            if ($supervisor) {
                session([
                    'district_name' => $supervisor->DistrictName ?? '',
                    'title_name'    => $supervisor->TitleName ?? '',
                ]);
            }
        }

        logSystemActivity('Logged in', 'Authentication');

        // Redirect by role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.systemsetup');
            case 'District Supervisor':
                return redirect()->route('districtsupervisor.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'evaluator':
                return redirect()->route('evaluator.dashboard');
            default:
                return redirect('/login')->with('error', 'Unauthorized role.');
        }
    }

    return back()->with('error', 'Invalid credentials.');
}



    public function logout()
    {
        logSystemActivity('Logged out', 'Authentication');
        Session::flush();
        return redirect('/login');
    }
}
