<?php


namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadPosition;
use App\Models\TotalPoint;
use App\Models\DocumentEvaluation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TotalPointController extends Controller
{

public function store(Request $request)
{
    try {
        $uploadID = $request->uploadID;
        $teacherID = $request->teacherID;

        // Sum all faculty_score for this teacher and uploadID
        $total = DocumentEvaluation::where('teacherID', $teacherID)
                    ->where('uploadID', $uploadID)
                    ->sum('faculty_score');

        // Check if record already exists
        $existing = TotalPoint::where('teacherID', $teacherID)
                              ->where('uploadID', $uploadID)
                              ->first();

        if ($existing) {
            $existing->update(['total_points' => $total]);
        } else {
            TotalPoint::create([
                'teacherID' => $teacherID,
                'uploadID' => $uploadID,
                'total_points' => $total
            ]);
        }

        return response()->json(['success' => true, 'total' => $total]);
    } catch (\Exception $e) {
        \Log::error('TotalPoint Store Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error.'], 500);
    }
}





}