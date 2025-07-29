<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller; // ← ADD THIS LINE
use Illuminate\Http\Request;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::all();
        return view('admin.criteria', compact('criteria'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'criteriaDetail' => 'required|string|max:255',
                'maxpoint' => 'required|numeric|min:1',
                'date' => 'required|date'
            ]);

            Criteria::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Criteria added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request)
        {
            $criteria = Criteria::find($request->id);
            if ($criteria) {
                $criteria->update($request->only('criteriaDetail', 'maxpoint', 'date'));
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Not found']);
        }

        public function delete(Request $request)
        {
            $criteria = Criteria::find($request->id);
            if ($criteria) {
                $criteria->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Not found']);
        }

}
