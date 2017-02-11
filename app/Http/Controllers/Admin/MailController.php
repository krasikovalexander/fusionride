<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class MailController extends Controller
{
    public function retry()
    {
        $exitCode = Artisan::call('queue:retry', ['all']);
        return redirect()->route('admin.dashboard')->with("notifications", ['success' => "Retry finished. Response: $exitCode"]);
    }

    public function restart()
    {
        $exitCode = Artisan::call('queue:restart', []);
        return redirect()->route('admin.dashboard')->with("notifications", ['success' => "Restarting daemon..."]);
    }
}
