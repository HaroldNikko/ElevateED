<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistrictSupervisor;
use App\Models\Login;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DistrictSupervisorController extends Controller
{
    public function store(Request $request)
    {
       $validated = $request->validate([
    'firstname' => 'required',
    'middlename' => 'nullable',
    'lastname' => 'required',
    'email' => 'required|email|unique:district_supervisors,email',
    'phonenumber' => 'required',
    'gender' => 'required|in:Male,Female',
    'district_id' => 'required',
    'municipality_id' => 'required',
    'province_id' => 'required', // ✅ added
]);


        // Generate default credentials
        $username = strtolower(Str::slug($request->firstname . $request->lastname));
        $password = 'password123'; // default password
        $role = 'districtsupervisor';

        // Create login account
        $login = Login::create([
            'username' => $username,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        // Save district supervisor
        DistrictSupervisor::create([
    'firstname' => $validated['firstname'],
    'middlename' => $validated['middlename'],
    'lastname' => $validated['lastname'],
    'email' => $validated['email'],
    'phone_number' => $validated['phonenumber'],
    'gender' => $validated['gender'],
    'district_id' => $validated['district_id'],
    'municipality_id' => $validated['municipality_id'],
    'province_id' => $validated['province_id'], // ✅ now included
    'Login_id' => $login->Login_id,
    'date_assigned' => now(),
]);


        return redirect()->back()->with('success', 'District Supervisor added with default login!');
    }
}
