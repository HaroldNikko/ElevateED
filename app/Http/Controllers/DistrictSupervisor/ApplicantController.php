<?php

namespace App\Http\Controllers\DistrictSupervisor;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\TotalPoint;
use App\Models\ResultOfApplication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationSubmittedMail;
use App\Models\Info;

class ApplicantController extends Controller
{
    /**
     * Fetch and return the leaderboard data for a specific upload ID.
     */
     public function updateStatus(Request $request): JsonResponse
    {
        $request->validate([
            'uploadID' => 'required|integer|exists:upload_position,uploadID',
            'status'   => 'required|string|in:Approved,In Progress'
        ]);

        // Update all applicants of this uploadID
        $updated = BasicInfo::where('uploadID', $request->uploadID)
            ->update(['Status' => $request->status]);

        return response()->json([
            'success' => true,
            'updated' => $updated
        ]);
    }
    
    public function leaderboards($uploadID): JsonResponse
    {
        $points = TotalPoint::with(['teacher'])
            ->where('uploadID', $uploadID)
            ->orderByDesc('total_points')
            ->get();

        $leaderboard = [];

        foreach ($points as $index => $point) {
            if (!$point->teacher) continue;

            $leaderboard[] = [
                'rank'     => $index + 1,
                'fullname' => trim("{$point->teacher->firstname} {$point->teacher->middlename} {$point->teacher->lastname}"),
                'address'  => $point->teacher->Address ?? 'N/A',
                'points'   => $point->total_points ?? 0,
            ];
        }

        return response()->json($leaderboard);
    }

    /**
     * Fetch and return detailed information for a specific teacher.
     */
    public function show($teacherID): JsonResponse
    {
        $basic = BasicInfo::where('teacherID', $teacherID)->first();

        if (!$basic) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'fullname'        => "{$basic->Firstname} {$basic->MiddleName} {$basic->LastName}",
            'applicantID'     => $basic->ApplicantID,
            'currentPosition' => $basic->CurrentPosition,
            'email'           => $basic->email,
            'contactNumber'   => $basic->contactnumber,
            'schoolName'      => $basic->schoolname,
            'schoolAddress'   => $basic->schooladdress,
        ]);
    }

    /**
     * Insert submitted results for all applicants of an upload position,
     * and send confirmation emails to each applicant.
     */
    public function submitResults(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'uploadID'      => 'required|integer|exists:upload_position,uploadID',
                'teacherIDs'    => 'required|array',
                'teacherIDs.*'  => 'integer|exists:info,id'
            ]);

            Log::info('SubmitResults request received', [
                'uploadID' => $request->uploadID,
                'teacherIDs' => $request->teacherIDs
            ]);

            foreach ($request->teacherIDs as $teacherID) {
                // Insert or update resultofapplication
                ResultOfApplication::updateOrCreate(
                    [
                        'uploadID'  => $request->uploadID,
                        'teacherID' => $teacherID
                    ],
                    []
                );

                // Corrected lookup by teacherID, not primary key
                $teacher = BasicInfo::where('teacherID', $teacherID)->first();

                if ($teacher && $teacher->email) {
                    try {
                       Mail::to($teacher->email)->send(
                            new ApplicationSubmittedMail(
                                trim("{$teacher->Firstname} {$teacher->MiddleName} {$teacher->LastName}"),
                                $teacher->ApplicantID // 🔥 gamitin tamang casing ng column mo
                            )
                        );

                        Log::info("Email successfully sent to: {$teacher->email}");
                    } catch (\Exception $mailEx) {
                        Log::error("Failed to send email to {$teacher->email}: {$mailEx->getMessage()}");
                    }
                } else {
                    Log::warning("No email found for teacherID {$teacherID}, skipping email notification.");
                }
            }

            Log::info('SubmitResults completed successfully');

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('SubmitResults failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error'   => 'Server error occurred.'
            ], 500);
        }
    }
}
