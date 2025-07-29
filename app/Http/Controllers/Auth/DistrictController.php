// <?php

// namespace App\Http\Controllers\admin;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\Models\District;
// use App\Models\DistrictSupervisor;

// class DistrictController extends Controller
// {
//     public function index()
//     {
//         $districts = District::withCount('supervisors')->get();
//         return view('admin.manageaccount', compact('districts'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'district_name' => 'required|string|max:255',
//         ]);

//         DB::table('district')->insert([
//             'Districtname' => $request->district_name,
//         ]);

//         return redirect()->back()->with('success', 'District added successfully!');
//     }

//     public function viewSupervisors($id)
//     {
//         $district = District::findOrFail($id);
//         $supervisors = DistrictSupervisor::where('districtID', $id)->with('district')->get();

//         if ($supervisors->isEmpty()) {
//             return view('admin.no_supervisors', compact('district'));
//         }

//         return view('admin.supervisors_by_district', compact('district', 'supervisors'));
//     }
// }
