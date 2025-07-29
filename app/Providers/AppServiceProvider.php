<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


use Illuminate\Support\Facades\View;
use App\Models\AppNotification;



class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();


          view()->composer('*', function ($view) {
        $teacherID = session('teacherID');

        if ($teacherID) {
            $unreadCount = AppNotification::where('teacherID', $teacherID)
                ->where('is_read', false)
                ->count();

            $notifications = AppNotification::where('teacherID', $teacherID)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        } else {
            $unreadCount = 0;
            $notifications = [];
        }

        $view->with('unreadCount', $unreadCount)->with('notifications', $notifications);
    });

    }
}
