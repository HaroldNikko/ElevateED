<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\DistrictSupervisor;
use App\Models\EvaluatorInfo;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Designation;
use App\Models\Region;
use App\Models\UserDesignation;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function index()
{
    $teachers = Info::with('login')->get();
    $designations = Designation::all();
    $regions = Region::all();

    return view('admin.usermanagement.user_list', compact('teachers', 'designations', 'regions'));
}
    public function store(Request $request)
{
    $request->validate([
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255',
        'lastname' => 'required|string|max:255',
        'gender' => 'required|string',
        'phonenumber' => 'required|string',
        'email' => 'required|email|unique:info,email|unique:login,username',
    ]);

    $generatedPassword = Str::random(8);

    // Create login
    $login = Login::create([
    'username' => $request->email,
    'password' => bcrypt($generatedPassword),
    'role' => 'none', // Use 'none' or 'unassigned' if designation comes later
]);


    // Create info
    $info = Info::create([
        'Login_id'    => $login->Login_id,
        'firstname'   => $request->firstname,
        'middlename'  => $request->middlename,
        'lastname'    => $request->lastname,
        'email'       => $request->email,
        'phonenumber' => $request->phonenumber,
        'Address'     => '',
        'profile'     => 'user_prof.png',
    ]);

    // Send credentials email
    Mail::send('emails.teacher_credentials', [
        'email' => $request->email,
        'password' => $generatedPassword
    ], function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Your ElevateEd Account Credentials');
    });

    return redirect()->back()->with('success', 'User created and email sent.');
}

public function assignDesignation(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:info,id',
        'designationID' => 'required|exists:designation,designationID',
        'region_id' => 'required',
        'province_id' => 'required',
        'district_id' => 'required',
        'municipality_id' => 'required',
        'schoolID' => 'nullable',
    ]);

    // Save to user_designation table
    UserDesignation::create([
        'id' => $request->user_id,
        'designationID' => $request->designationID,
        'region_id' => $request->region_id,
        'province_id' => $request->province_id,
        'district_id' => $request->district_id,
        'municipality_id' => $request->municipality_id,
        'schoolID' => $request->schoolID,
    ]);

    // Get the user info
    $info = Info::with('login')->find($request->user_id);

    if ($info && $info->login) {
        // Get designation role from designation table (e.g., "teacher", "districtsupervisor", etc.)
        $designationName = \App\Models\Designation::where('designationID', $request->designationID)->value('designation_name');

        // Set role based on designation
        $role = match(strtolower($designationName)) {
            'district supervisor' => 'District Supervisor',
            'evaluator' => 'evaluator',
            'teacher' => 'teacher',
            default => 'user'
        };

        // Update login role
        $info->login->update(['role' => $role]);
    }

    return redirect()->back()->with('success', 'Designation assigned and role updated.');
}

// In UserManagementController.php

public function destroy($userId)
{
    // Find the user by ID and delete
    $user = Info::find($userId);
    
    if ($user) {
        // Delete the user
        $user->delete();

        // Redirect back with success message
        return redirect()->route('admin.user.management')->with('success', 'User deleted successfully.');
    }

    return redirect()->route('admin.user.management')->with('error', 'User not found.');
}

public function showChangePasswordForm($userId)
{
    // Log when the method is called
    Log::info('Showing password change form for user ID: ' . $userId);

    // Fetch the user's information along with their login details
    $user = Info::with('login')->find($userId);

    // Check if user is found and log the result
    if ($user) {
        Log::info('User found: ' . $user->email);
    } else {
        Log::warning('User not found: ' . $userId);
    }

    // Pass the user to the view
    return view('admin.changePasswordForm', compact('user'));
}

public function updatePassword(Request $request)
{
    // Log the incoming request data
    Log::info('Updating password for user ID: ' . $request->user_id);

    // Validate the input data
    $request->validate([
        'user_id' => 'required|exists:info,id',  // Ensure user exists in the info table
        'newPassword' => 'required|min:8|confirmed', // Ensure the new password is confirmed
    ]);

    // Find the user by ID from the 'info' table
    $user = Info::find($request->user_id);

    if ($user) {
        // Log user found
        Log::info('User found: ' . $user->email);

        // Find the login record linked to the user
        $login = $user->login;

        // Log the password update process
        Log::info('Updating password for user: ' . $user->email);

        // Hash the new password and update the login table
        $login->password = bcrypt($request->newPassword); // Hash the new password
        $login->save();

        // Log successful password update
        Log::info('Password updated successfully for user ID: ' . $user->id);

        // Redirect back with success message
        return redirect()->route('admin.user.management')->with('success', 'Password updated successfully.');
    }

    // Log error if user is not found
    Log::warning('User not found: ' . $request->user_id);

    // If user is not found, return an error message
    return redirect()->route('admin.user.management')->with('error', 'User not found.');
}




}
