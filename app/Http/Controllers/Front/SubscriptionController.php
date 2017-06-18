<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provider;
use App\State;
use App\Type;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, $hash)
    {
        $provider = Provider::where('subscription_key', $hash)->first();
        return view('front.provider.subscribe', [
            'provider' => $provider,
            'states' => State::all(),
            'types' => Type::all()
        ]);
    }

    public function update(Request $request, $hash)
    {
        $provider = Provider::where('subscription_key', $hash)->first();
        
        if (!$provider) {
            return back()->with("notifications", ["warning" => 'Not found']);
        }

        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'state_id' => 'required|exists:states,id',
            'email' => 'required|email',
            'site' => 'active_url'
        ]);

        $data = $request->all();
        $provider->fill($data);
        $provider->phone_numbers = $provider->phone ? preg_replace("/[^0-9]/", "", $provider->phone) : "";
        if (in_array($provider->subscription_status, ['pending', 'unsubscribed'])) {
            $provider->subscription_status = 'subscribed';
            $provider->status = 'active';
            $provider->draft = false;
            $provider->geocode();
        }
        $provider->save();
        $provider->types()->sync((array)$request->get('type'));

        return back()->with("notifications", ["success" => 'Profile updated']);
    }

    public function unsubscribe(Request $request, $hash)
    {

        $provider = Provider::where('subscription_key', $hash)->first();

        if (!$provider) {
            return back()->with("notifications", ["warning" => 'Not found']);
        }

        if ($provider->subscription_status != 'subscribed') {
            return view('front.provider.unsubscribe', [
                'provider' => $provider,
            ]);
        }

        if ($request->isMethod('post')) {
            $provider->subscription_status = 'unsubscribed';
            $provider->save();
            return view('front.provider.unsubscribe', [
                'provider' => $provider,
            ])->with("notifications", ["success" => 'Unsubscribed successfully!']);
        }


        return view('front.provider.unsubscribe', [
            'provider' => $provider,
        ]);
    }
}
