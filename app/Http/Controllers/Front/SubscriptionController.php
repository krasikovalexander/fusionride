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
        if (!$provider) {
            abort(404);
        }
        if ($provider->is_taxi) {
            $types = Type::where('taxi_available', 1)->get();
        } else {
            $types = Type::all();
        }
        return view('front.provider.subscribe', [
            'provider' => $provider,
            'states' => State::all(),
            'types' => $types
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

        $data['accept_visa'] = $request->has('accept_visa');
        $data['accept_mc'] = $request->has('accept_mc');
        $data['accept_amex'] = $request->has('accept_amex');
        $data['accept_discover'] = $request->has('accept_discover');
        $data['accept_cash'] = $request->has('accept_cash');


        $oldAddress = $provider->address;
        $provider->fill($data);
        $provider->phone_numbers = $provider->phone ? preg_replace("/[^0-9]/", "", $provider->phone) : "";
        if (in_array($provider->subscription_status, ['pending', 'unsubscribed'])) {
            $provider->subscription_status = 'subscribed';
            $provider->status = 'active';
            $provider->draft = false;
            if ($provider->address != $oldAddress) {
                $provider->geocode();
            }
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
