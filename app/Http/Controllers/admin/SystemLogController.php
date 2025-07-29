<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\system_log;
use App\Models\Login;

class SystemLogController extends Controller
{

public function index(Request $request)
{
    $search = $request->search;
    $logs = system_log::with(['login', 'login.info'])
        ->when($search, function ($query) use ($search) {
            $query->whereHas('login', function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                ->orWhereHas('info', function ($iq) use ($search) {
                    $iq->where('email', 'like', "%{$search}%");
                });
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();


    return view('admin.system_log', compact('logs'));
}

}
