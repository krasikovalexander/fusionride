<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use Artisan;
use Validator;
use App\Provider;
use App\Mail\MassMail;
use Mail;

class MailController extends Controller
{
    public function retry()
    {
        $exitCode = Artisan::call('queue:retry', ['id' => 'all']);
        return redirect()->route('admin.dashboard')->with("notifications", ['success' => "Retry finished. Response: $exitCode"]);
    }

    public function restart()
    {
        $exitCode = Artisan::call('queue:restart', []);
        return redirect()->route('admin.dashboard')->with("notifications", ['success' => "Restarting daemon..."]);
    }

    public function send(HttpRequest $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'subject' => 'required',
                'body' => 'required',
                'statuses' => 'required|array|min:1',
                'subscription_statuses' => 'required|array|min:1',
                'drafts'  => 'required|array|min:1',
            ]);

            $validator->after(function ($validator) use ($request) {
                if (trim(strip_tags($request->get('body'))) == '') {
                    $validator->errors()->add('body', 'The body field is required.');
                }
            });

            $this->validateWith($validator);

            $providers = Provider::whereNotNull('email')
                ->whereIn('status', $request->get('statuses'))
                ->whereIn('subscription_status', $request->get('subscription_statuses'))
                ->whereIn('draft', $request->get('drafts'));
            $providers = $providers->get();
            $sent = [];
            foreach ($providers as $provider) {
                if (!in_array($provider->email, $sent)) {
                    Mail::to($provider->email)
                       ->queue(new MassMail($provider, $request->get('subject'), $request->get('body')));
                    $sent[] = $provider->email;
                }
            }
            return redirect()->back()->with("notifications", ['success' => "Emails sent"]);
        }
        return view('admin.mail.send');
    }
}
