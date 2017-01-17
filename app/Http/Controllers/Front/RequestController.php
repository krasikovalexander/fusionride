<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\State;
use App\Type;
use App\Request;
use App\Provider;
use App\Subscription;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use App\Mail\RequestToProvider;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    public function index(HttpRequest $request) {

    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'city' => 'required',
		        'pickup' => 'required',
		        'pickup_date' => 'required',
		        'pickup_time' => 'required',
		        'phone' => 'required',
		        'state' => 'required|exists:states,id',
                'email' => 'required|email'
		    ]);

    		$data = $request->all();
    		
    		$rideRequest = new Request;
    		$rideRequest->fill($data);
    		$rideRequest->save();

    		$providers = Provider::where('state_id', $data['state'])
    			->active()
    			->whereCity($data['city']);

			//filter by car type
    		if (!$request->has('type')) {
    			$providers->whereHas('types', function($q) use ($data){
    				$q->whereId($data['car']);
    			});
    		}
    		$providers = $providers->get();

    		//send email
    		if (count($providers)) {
    			$providers->each(function($provider) use ($rideRequest){
					Mail::to($provider->email)
                        ->queue(new RequestToProvider($provider, $rideRequest));
    			});
    		} else {
                $rideRequest->failed = true;
                $rideRequest->save();
            }

    		return redirect()->route('front.'.(count($providers) ? 'done' : 'fail'), [
    				'state' => State::find($request->get("state"))->code, 
    				'city' => $request->get("city")
    			])->with(['providers' => $providers]);
    	}

    	

    	$states = State::whereHas('providers', function($q){
    		$q->active();
    	})->orderBy('state', 'asc')->get();

    	$types = Type::whereActive(1)->orderBy('sort', 'ASC')->get();
    	$state = State::whereCode($request->get("state"))->first();
    	$city = null;

    	if ($request->has("city")) {
    		$provider = Provider::active()
    			->where('state_id', $state->id)
    			->where(DB::raw("LOWER(city)"), strtolower($request->get("city")))
    		->first();

    		if (!$provider) {
    			return redirect()->route('front.nocity', [
    				'state' => $request->get("state"), 
    				'city' => $request->get("city")
    			]);//FOR GA
    		}
    		$city = $provider->city;
    	}

        return view('front.form', [
        	'states' => $states, 
        	'selectedState' => $state ? $state->id : null, 
        	'selectedCity' => $city, 
        	'types' => $types,
        	'state' => $request->get("state"), 
			'city' => $request->get("city")
        ]);
    }

    public function nocity(HttpRequest $request) {
    	return view('front.nocity', [
			'state' => $request->get("state"), 
			'city' => $request->get("city")
    	]);
    }

    public function done(HttpRequest $request) {
    	if (session()->has('providers')) {
    		return view('front.done', ['providers' => session()->pull('providers'),'state' => $request->get("state"), 'city' => $request->get("city")]);
    	} else {
    		return redirect()->route('front.requestForm');
    	}
    }

    public function subscribe(HttpRequest $request) {

    	$this->validate($request, [
	        'city' => 'required',
	        'state' => 'required|exists:states,code',
            'email' => 'required|email'
	    ]);

    	Subscription::firstOrCreate([
    		'email' => $request->get('email'),
    		'city' => $request->get('city'),
    		'state_id' => State::whereCode($request->get("state"))->first()->id,
    	]);

    	return view('front.subscribed');
    }
}