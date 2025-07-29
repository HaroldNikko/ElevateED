<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    /**
     * Display the list of designations.
     */
    public function index()
{
    $designations = Designation::paginate(10); // or any number per page
    return view('admin.designation', compact('designations'));
}


    /**
     * Store a newly created designation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string|max:200',
            'access' => 'required|string|max:200',
        ]);

        Designation::create([
            'designation_name' => $request->designation_name,
            'access' => $request->access,
        ]);

        return redirect()->route('admin.designation.index')->with('success', 'Designation added successfully.');
    }
}
