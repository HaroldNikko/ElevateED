<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SchoolDetail;
use App\Models\Province;
use App\Models\District;

class SchoolDetailController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Store School Request', $request->all());

            $validated = $request->validate([
                'Schoolname'     => 'required|string|max:255',
                'schooladdress'  => 'required|string|max:255',
                'Basic_education'   => 'required|string|max:255',
                'districtID'     => 'required|exists:district,districtID',
            ]);

            SchoolDetail::create($validated);

            Log::info('School created successfully.');

            return response()->json([
                'success' => true,
                'message' => 'School saved successfully!',
            ]);
        } catch (\Throwable $e) {
            Log::error('School Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request)
    {
        Log::info('Update School Request', $request->all());

            $request->validate([
            'schoolID'         => 'required|exists:schooldetails,schoolID',
            'Schoolname'       => 'required|string|max:255',
            'schooladdress'    => 'required|string|max:255',
            'Basic_education'  => 'required|string|max:255',
            'districtID'       => 'required|exists:district,districtID',
        ]);


        $school = SchoolDetail::findOrFail($request->schoolID);
        $school->update($request->only('Schoolname', 'schooladdress', 'Basic_education', 'districtID'));


        Log::info('School updated successfully.', ['schoolID' => $request->schoolID]);

        return redirect()->back()->with('success', 'School updated successfully!');
    }

    public function delete(Request $request)
    {
        Log::info('Delete School Request', $request->all());

        $request->validate(['schoolID' => 'required|exists:schooldetails,schoolID']);
        SchoolDetail::destroy($request->schoolID);

        Log::info('School deleted.', ['schoolID' => $request->schoolID]);

        return redirect()->back()->with('success', 'School deleted successfully!');
    }

}
