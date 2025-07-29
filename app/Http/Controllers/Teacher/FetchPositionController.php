<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UploadPosition;
use App\Models\SchoolDetail;
use Carbon\Carbon;


class FetchPositionController extends Controller
{
    public function paginate(Request $request)
{
    $search = $request->input('search');

    $positions = UploadPosition::with(['teacherRank', 'school.district'])
    ->when($search, function ($query, $search) {
        $query->whereHas('teacherRank', function ($q) use ($search) {
            $q->where('teacherRank', 'like', "%$search%");
        });
    })
    ->paginate(6);


    return view('teacher.applicant', compact('positions'));
}


}
