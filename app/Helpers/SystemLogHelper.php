<?php

use App\Models\system_log;

if (!function_exists('logSystemActivity')) {
    function logSystemActivity($action, $section = null)
    {
        system_log::create([
            'Login_id' => session('Login_id'), // or use Auth::user()->login_id if applicable
            'action' => $action,
            'section' => $section,
            'ip' => request()->ip(),
        ]);
    }
}
