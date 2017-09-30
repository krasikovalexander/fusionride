<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Provider;
use App\State;
use App\Type;
use Hash;
use App\ProviderAirportSettings;

use App\Mail\Registration;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'city' => 'required',
                'state_id' => 'required|exists:states,id',
                'email' => 'required|email',
                'address' => 'required',
                'phone' => 'required',
                'site' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
            ]);

            $data = $request->all();
            $data['draft'] = true;
            $data['is_taxi'] = $request->has('is_taxi');
            $data['phone_numbers'] = preg_replace("/[^0-9]/", "", $request->get('phone', ""));
            $data['subscription_key'] = base64_encode(Hash::make(str_random(64)));
            $data['subscription_status'] = 'subscribed';

            if ($request->has('_')) {
                $referralKey = $request->get("_");
                $referrer = Provider::whereReferralKey($referralKey)->first();
                if ($referrer) {
                    $data['referred_by'] = $referrer->id;
                } 
            }

            $provider = Provider::create($data);
            $provider->geocode();
            $provider->save();

            $provider->types()->sync((array)$request->get('type'));

            $airports = $request->get('airports',[]);
            $pickup   = $request->get('pickup_no_restriction',[]);
            $dropoff  = $request->get('dropoff_no_restriction',[]);

            foreach ($airports as $index => $airport) {
                if ( $airport) {
                    $settings = new ProviderAirportSettings;
                    $settings->provider_id = $provider->id;
                    $settings->airport_id = $airport;
                    $settings->pickup = isset($pickup[$index]);
                    $settings->dropoff = isset($dropoff[$index]);
                    $settings->save();
                }
            }


            Mail::to('610allrave@gmail.com')
                        ->queue(new Registration($provider));
           
            return redirect()->back()->with("completed", true)->withInput()->with("notifications", ['success' => "Registration completed! Your application is being reviewed."]);
        }
        return view('front.registration', ['states' => State::all(), 'types' => Type::all(), 'airports' => \App\Airport::all()]);
    }
}
