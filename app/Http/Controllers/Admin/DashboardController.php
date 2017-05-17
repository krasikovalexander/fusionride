<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Request;
use App\Subscription;
use Illuminate\Support\Facades\DB;
use App\Job;
use App\FailedJob;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'requests' => [
                'success' => Request::whereFailed(0)->count(),
                'fail' => Request::whereFailed(1)->count(),
            ],
            'subscriptions' => [
                'success' => Subscription::whereNotified(1)->count(),
                'fail' => Subscription::whereNotified(0)->count(),
            ],
            'mail' => [
                'status' => exec('ps aux | grep [q]ueue') == "" ? "Stopped" : "Running",
                'queued' => Job::all()->count(),
                'last'   => Job::orderBy('created_at', 'DESC')->first(),
                'retries' => Job::where('attempts', '>', 0)->count(),
                'failed' => FailedJob::all()->count(),
            ]
        ]);
    }
}
