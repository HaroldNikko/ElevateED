<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppNotification;

class NotificationController extends Controller
{
   public function markAsRead(Request $request)
{
    $teacherID = session('teacherID');

    AppNotification::where('teacherID', $teacherID)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['status' => 'success']);
}

}
