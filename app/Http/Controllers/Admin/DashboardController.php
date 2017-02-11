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
            'top' => [
                'requests' => [
                    'success' => Request::whereFailed(0)
                                    ->groupBy('city')
                                    ->groupBy('state')
                                    ->addSelect(DB::raw('city, state, COUNT(*) as cnt'))
                                    ->orderBy('cnt', 'desc')
                                    ->take(10)
                                ->get(),
                    'fail' => Request::whereFailed(1)
                                    ->groupBy('city')
                                    ->groupBy('state')
                                    ->addSelect(DB::raw('city, state, COUNT(*) as cnt'))
                                    ->orderBy('cnt', 'desc')
                                    ->take(10)
                                ->get(),
                ],
                'subscriptions' => [
                    'fail' => Subscription::whereNotified(0)
                                    ->groupBy('city')
                                    ->groupBy('state_id')
                                    ->addSelect(DB::raw('city, state_id, COUNT(*) as cnt'))
                                    ->orderBy('cnt', 'desc')
                                    ->take(20)
                                ->get(),
                ]
            ],
            'mail' => [
                'queued' => Job::all()->count(),
                'last'   => Job::orderBy('created_at', 'DESC')->first(),
                'retries' => Job::where('attempts', '>', 0)->count(),
                'failed' => FailedJob::all()->count(),
            ]
        ]);
    }
}
