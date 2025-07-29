<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Login;
use App\Models\Info;
use App\Models\SchoolDetail;
use App\Models\UserDesignation;
use App\Models\Designation;
use App\Models\TeacherInfo;

class TeacherImportController extends Controller
{
    public function checkEmails(Request $request)
    {
        $emails = $request->emails ?? [];

        $existing = Info::whereIn('email', $emails)->pluck('email')->toArray();

        return response()->json($existing);
    }

    public function ajaxImport(Request $request, $schoolID)
    {
        Log::info('Starting teacher import for school ID: ' . $schoolID);

        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $school = SchoolDetail::findOrFail($schoolID);
        Log::info('Fetched school: ' . $school->Schoolname);

        $designation = Designation::whereRaw('LOWER(designation_name) = ?', ['teacher'])->first();
        $designationID = $designation ? $designation->designationID : null;
        Log::info('Using designation ID: ' . $designationID);

        $rawContent = str_replace("\xEF\xBB\xBF", '', file_get_contents($request->file('csv_file')));
        $rows = array_map('str_getcsv', explode("\n", $rawContent));
        $header = array_map('strtolower', array_map('trim', $rows[0]));
        unset($rows[0]);

        Log::info('CSV Header: ', $header);

        $required = ['applicantid', 'firstname', 'middlename', 'lastname', 'email', 'phonenumber', 'gender', 'currentrank'];
        foreach ($required as $field) {
            if (!in_array($field, $header)) {
                Log::error("Missing required column: $field");
                return response()->json(['message' => "Missing required column: $field"], 422);
            }
        }

        $total = count($rows);
        $imported = 0;
        $currentYear = now()->year;
        $nextYear = $currentYear + 1;

        foreach ($rows as $index => $row) {
            try {
                if (count($row) < count($header)) {
                    Log::warning("Skipping incomplete row at index $index: ", $row);
                    continue;
                }

                $data = array_combine($header, $row);
                Log::info("Processing row: ", $data);

                $username = trim($data['email']);
                $defaultPassword = Str::random(8);
                $titleName = strtolower(trim($data['gender'])) === 'male' ? 'Sir' : 'Ma\'am';

                $existingLogin = Login::where('username', $username)->first();

                if ($existingLogin) {
                    Log::info("Existing login found for $username");

                    $info = Info::updateOrCreate(
                        ['Login_id' => $existingLogin->Login_id],
                        [
                            'firstname'   => $data['firstname'],
                            'middlename'  => $data['middlename'],
                            'lastname'    => $data['lastname'],
                            'email'       => $data['email'],
                            'phonenumber' => $data['phonenumber'],
                            'Address'     => '',
                            'profile'     => 'user_prof.png'
                        ]
                    );
                } else {
                    Log::info("Creating new login for $username");

                    $existingLogin = Login::create([
                        'username' => $username,
                        'password' => bcrypt($defaultPassword),
                        'role'     => 'teacher'
                    ]);

                    $info = Info::create([
                        'Login_id'    => $existingLogin->Login_id,
                        'firstname'   => $data['firstname'],
                        'middlename'  => $data['middlename'],
                        'lastname'    => $data['lastname'],
                        'email'       => $data['email'],
                        'phonenumber' => $data['phonenumber'],
                        'Address'     => '',
                        'profile'     => 'user_prof.png'
                    ]);

                    Mail::send('emails.teacher_credentials', [
                        'email' => $data['email'],
                        'password' => $defaultPassword
                    ], function ($message) use ($data) {
                        $message->to($data['email'])->subject('Your ElevateEd Login Credentials');
                    });

                    Log::info("Email sent to: " . $data['email']);
                }

                // Assign designation
                UserDesignation::updateOrCreate(
                    ['id' => $info->id],
                    [
                        'region_id'       => $school->region_id,
                        'province_id'     => $school->province_id,
                        'district_id'     => $school->district_id,
                        'municipality_id' => $school->municipality_id,
                        'schoolID'        => $schoolID,
                        'designationID'   => $designationID
                    ]
                );

                // Save TeacherInfo
                TeacherInfo::updateOrCreate(
                    ['id' => $info->id],
                    [
                        'TeacherID'    => $info->id,
                        'applicantID'  => $data['applicantid'],
                        'TitleName'    => $titleName,
                        'currentrank'  => $data['currentrank'],
                        'currentyear'  => $currentYear,
                        'endyear'      => $nextYear
                    ]
                );

                $imported++;
            } catch (\Throwable $e) {
                Log::error("Error processing row index $index: " . $e->getMessage(), ['row' => $row]);
            }
        }

        Log::info("Import complete. Imported $imported of $total rows.");
        session()->flash('success', "Successfully imported $imported of $total teachers.");
        return response()->json(['redirect' => route('admin.school.show', $schoolID)]);
    }
}
