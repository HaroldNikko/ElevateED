<?php

// namespace App\Http\Controllers\admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Mail;
// use App\Models\DistrictSupervisor;
// use App\Models\District;
// use App\Models\Login;

// class DistrictCSVController extends Controller
// {

// public function importSupervisors(Request $request)
// {
//     $request->validate([
//         'csv_file' => 'required|mimes:csv,txt',
//     ]);

//     $csv = str_replace("\xEF\xBB\xBF", '', file_get_contents($request->file('csv_file')));
//     $rows = array_map('str_getcsv', explode("\n", $csv));
//     $headers = array_map('strtolower', array_map('trim', $rows[0]));
//     unset($rows[0]);

//     $manualDistrictID = $request->input('district_id');

//     foreach ($rows as $row) {
//         if (count($row) < count($headers)) continue;

//         $data = array_combine($headers, $row);

//         // Case A: Use hidden input if present
//         if ($manualDistrictID) {
//             $district = District::findOrFail($manualDistrictID);
//         }
//         // Case B: Fallback to CSV "district" column
//         elseif (isset($data['district'])) {
//             $district = District::firstOrCreate(['Districtname' => trim($data['district'])]);
//         } else {
//             continue; // Skip if no district info
//         }

//         $password = Str::random(8);
//         $login = Login::create([
//             'username' => $data['email'],
//             'password' => bcrypt($password),
//             'role' => 'District Supervisor',
//         ]);

//         DistrictSupervisor::create([
//             'firstname'     => $data['firstname'] ?? '',
//             'middlename'    => $data['middlename'] ?? '',
//             'lastname'      => $data['lastname'] ?? '',
//             'email'         => $data['email'] ?? '',
//             'phone_number'  => $data['phonenumber'] ?? '',
//             'province'      => $data['province'] ?? '',
//             'municipality'  => $data['municipality'] ?? '',
//             'gender'        => $data['gender'] ?? '',
//             'date_assigned' => now(),
//             'Login_id'      => $login->Login_id,
//             'districtID'    => $district->districtID,
//         ]);

//         Mail::raw("Welcome to ElevateEd!\n\nUsername: {$data['email']}\nPassword: $password\nRole: District Supervisor", function ($msg) use ($data) {
//             $msg->to($data['email'])->subject('Your Login Credentials');
//         });
//     }

//     return redirect()->back()->with('success', 'Supervisors imported successfully.');
// }

// }