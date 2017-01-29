<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\State;
use App\Type;
use App\Request;
use App\Provider;
use App\Track;
use App\Subscription;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use App\Mail\RequestToProvider;
use Illuminate\Support\Facades\Mail;
use PDF;
use Hash;

class RequestController extends Controller
{
    public function index(HttpRequest $request) {

    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'city' => 'required',
		        //'pickup' => 'required',
		        'pickup_date' => 'required',
		        'pickup_time' => 'required',
                'pickup_address' => 'required',
		        'phone' => 'required',
		        'state' => 'required|exists:states,id',
                'email' => 'required|email'
		    ]);

    		$data = $request->all();
    		
    		$rideRequest = new Request;
    		$rideRequest->fill($data);
            $rideRequest->hashkey = base64_encode(Hash::make(str_random(64)));
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
                    
                    $track = new Track();
                    $track->request_id = $rideRequest->id;
                    $track->provider_id = $provider->id;
                    $track->save(); 
    			});

    		} else {
                $rideRequest->failed = true;
                $rideRequest->save();
            }

    		return redirect()->route('front.'.(count($providers) ? 'done' : 'fail'), [
    				'state' => State::find($request->get("state"))->code, 
    				'city' => $request->get("city")
    			])->with(['providers' => $providers, 'request' => $rideRequest]);
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
			'city' => $request->get("city"),
            'allStates' => State::all(),
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
    		return view('front.done', [
                'providers' => session()->pull('providers'), 
                'request' => session()->pull('request'), 
                'state' => $request->get("state"), 
                'city' => $request->get("city")
            ]);
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

    public function pdf(HttpRequest $request) {
        $ids = explode(',', base64_decode($request->get("_")));
        $providers = Provider::whereIn('id', $ids)->get();
        $pdf = PDF::loadView('front.pdf', ['providers' => $providers]);
        return $pdf->download('providers.pdf');
    }

    public function home(HttpRequest $request) {
        return view('front.home', [
            'states' => State::all()
        ]);
    }

    public function approve(HttpRequest $request) {
        $rideRequest = Request::whereHashkey($request->get('hash'))->first();
        if (!$rideRequest) {
            return redirect()->route('home');
        }
        $rideRequest->key_access_agreed = true;
        $rideRequest->save();
        return redirect()->route('front.tracking', ['hash' => $rideRequest->hashkey])->with(['firstTime' => true]);
    }

    public function tracking(HttpRequest $request, $hash) {
        $rideRequest = Request::whereHashkey($hash)->whereKeyAccessAgreed(true)->first();
        if (!$rideRequest) {
            return redirect()->route('home');
        }
        return view('front.tracking', [
            'request' => $rideRequest,
            'firstTime' => session()->pull('firstTime'), 
            'tracks' => $rideRequest->tracks()->with(['provider'])->get(),
            'hash' => $hash,
            'isSaved' =>  session()->pull('isSaved'),
        ]);
    }

    public function update(HttpRequest $request, $hash) {
        $rideRequest = Request::whereHashkey($hash)->whereKeyAccessAgreed(true)->first();
        if (!$rideRequest) {
            return redirect()->route('home');
        }
        $track = $rideRequest->tracks()->whereId($request->get('track'))->first();
        if (!$track) {
            return redirect()->route('home');
        }
        $track->price = $request->get('price');
        $track->result = $request->get('result');
        $track->notes = $request->get('notes');
        $track->save();
        return redirect()->route('front.tracking', ['hash' => $hash])->with(['isSaved' => true]);
    }
}