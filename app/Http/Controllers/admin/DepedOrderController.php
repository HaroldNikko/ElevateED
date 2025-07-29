<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepedOrder;
use App\Models\Criteria;
use App\Models\QualificationLevel;

class DepedOrderController extends Controller
{
    public function index()
    {
        $orders = DepedOrder::orderBy('year', 'desc')->get();
        return view('admin.depedorder.depedorder', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:200',
            'year' => 'required|digits:4'
        ]);

        DepedOrder::create([
            'filename' => $request->filename,
            'year' => $request->year
        ]);

        return redirect()->route('admin.depedorder.depedorder')->with('success', 'DepEd Order added!');
    }

    public function update(Request $request)
{
    $request->validate([
        'filename' => 'required',
        'year' => 'required|digits:4',
    ]);

    DepedOrder::where('DepedID', $request->id)->update([
        'filename' => $request->filename,
        'year' => $request->year
    ]);

    return redirect()->route('admin.depedorder.depedorder')->with('success', 'Updated successfully!');
}

public function delete(Request $request)
{
    DepedOrder::where('DepedID', $request->id)->delete();
    return redirect()->route('admin.depedorder.depedorder')->with('success', 'Deleted successfully!');
}


  public function show20($id)
    {
        $order = DepedOrder::findOrFail($id);
        $criteriaList = Criteria::where('DepedID', $id)->get();

        return view('admin.depedorder.depedorder_20', compact('order', 'criteriaList'));
    }

public function show19($id)
{
    $order = DepedOrder::findOrFail($id);
    $qualityStandards = \App\Models\QualityStandard::where('DepedID', $id)->with(['criteria', 'teacherRank'])->get();

    return view('admin.depedorder.depedorder_19', compact('order', 'qualityStandards'));
}

public function showLevels($id)
{
    $criteria = \App\Models\Criteria::with('depedOrder')->findOrFail($id);
    $levels = \App\Models\QualificationLevel::where('CriteriaID', $id)->get();

    return view('admin.depedorder.criteria_levels', compact('criteria', 'levels'));
}


}
