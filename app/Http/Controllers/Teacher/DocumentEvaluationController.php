<?php


namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentEvaluation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DocumentEvaluationController extends Controller
{

public function store(Request $request)
{
    try {
        \Log::info('Incoming DocumentEvaluation Request', $request->all());

        $request->validate([
            'uploadID' => 'required|numeric',
            'criteriaID' => 'required|numeric',
            'title' => 'required|string|max:255',
            'achievement_cat' => 'required|string',
            'date_presented' => 'required|date',
            'upload_file' => 'required|file|mimes:pdf|max:20480',
        ]);

        $teacherID = session('teacherID'); // ✅ Secure way

        if (!$teacherID) {
            return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
        }

        $scoreMap = ['Local' => 3, 'National' => 7, 'International' => 10];
        $score = $scoreMap[$request->achievement_cat] ?? 0;

        $originalName = $request->file('upload_file')->getClientOriginalName();
        $path = $request->file('upload_file')->storeAs('uploads', $originalName, 'public');

        $doc = DocumentEvaluation::create([
            'uploadID' => $request->uploadID,
            'teacherID' => $teacherID, // ✅ from session
            'criteriaID' => $request->criteriaID,
            'title' => $request->title,
            'achievement_cat' => $request->achievement_cat,
            'date_presented' => $request->date_presented,
            'upload_file' => $originalName,
            'faculty_score' => $score,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $doc->documentID,
                'title' => $doc->title,
                'date' => \Carbon\Carbon::parse($doc->date_presented)->format('F d, Y'),
                'category' => $doc->achievement_cat,
                'score' => $doc->faculty_score,
                'filename' => $doc->upload_file,
                'file_url' => asset('storage/uploads/' . $doc->upload_file),
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error('DocumentEvaluation Store Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error.'], 500);
    }
}



}