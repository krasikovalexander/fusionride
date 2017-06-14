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
use App\Mail\Quoted;
use Illuminate\Support\Facades\Mail;
use PDF;
use Hash;
use Validator;

class RequestController extends Controller
{
    public function index(HttpRequest $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'pickup_date' => 'required',
                'pickup_time' => 'required',
                'pickup_address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'lat' => 'required',
                'lng' => 'required',
                'r' => 'required',
            ]);

            $data = $request->all();
            
            $rideRequest = new Request;
            $rideRequest->fill($data);
            $rideRequest->hashkey = base64_encode(Hash::make(str_random(64)));
            $rideRequest->save();

            $providers = Provider::active()->inArea($request->get('lat'), $request->get('lng'), $request->get('r'));

            //filter by car type
            if (!$request->has('type')) {
                $providers->whereHas('types', function ($q) use ($data) {
                    $q->whereId($data['car']);
                });
            }
            $providers = $providers->get();

            //send email
            if (count($providers)) {
                $providers->each(function ($provider) use ($rideRequest) {
                    $track = new Track();
                    $track->request_id = $rideRequest->id;
                    $track->provider_id = $provider->id;
                    $track->hash = base64_encode(Hash::make(str_random(64)));
                    $track->save();

                    Mail::to($provider->email)
                        ->queue(new RequestToProvider($provider, $rideRequest, $track));
                });
            } else {
                $rideRequest->failed = true;
                $rideRequest->save();
            }

            return redirect()->route('front.'.(count($providers) ? 'done' : 'fail'), [
                    'lat' => $request->get('lat'),
                    'lng' => $request->get('lng'),
                    'r' => $request->get('r'),
                ])->with(['providers' => $providers, 'request' => $rideRequest]);
        } else {
            $validator = Validator::make($request->all(), [
                'lat' => 'required',
                'lng' => 'required',
                'r' => 'required',
            ]);
         
            if ($validator->fails()) {
                return redirect()->route('home');
            }
        }

        $types = Type::whereActive(1)->orderBy('sort', 'ASC')->get();
        DB::enableQueryLog();

        $provider = Provider::active()->inArea($request->get('lat'), $request->get('lng'), $request->get('r'))
            ->exists();

        if (!$provider) {
            return redirect()->route('front.nocity', $request->all());
        }
  
        return view('front.form', [
            'types' => $types,
        ]);
    }

    public function nocity(HttpRequest $request)
    {
        return view('front.nocity', ['params' => $request->all()]);
    }

    public function done(HttpRequest $request)
    {
        if (session()->has('providers')) {
            return view('front.done', [
                'providers' => session()->pull('providers'),
                'request' => session()->pull('request'),
                'lat' => $request->get("lat"),
                'lng' => $request->get("lng"),
                'r' => $request->get("r"),
            ]);
        } else {
            return redirect()->route('front.requestForm');
        }
    }

    public function subscribe(HttpRequest $request)
    {
        $this->validate($request, [
            'lat' => 'required',
            'lng' => 'required',
            'r' => 'required',
            'email' => 'required|email'
        ]);

        Subscription::firstOrCreate([
            'email' => $request->get('email'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'r' => $request->get('r'),
        ]);

        return view('front.subscribed');
    }

    public function pdf(HttpRequest $request)
    {
        $ids = explode(',', base64_decode($request->get("_")));
        $providers = Provider::whereIn('id', $ids)->get();
        $pdf = PDF::loadView('front.pdf', ['providers' => $providers]);
        return $pdf->download('providers.pdf');
    }

    public function home(HttpRequest $request)
    {
        return view('front.home');
    }

    public function approve(HttpRequest $request)
    {
        $rideRequest = Request::whereHashkey($request->get('hash'))->first();
        if (!$rideRequest) {
            return redirect()->route('home');
        }
        $rideRequest->key_access_agreed = true;
        $rideRequest->save();
        return redirect()->route('front.tracking', ['hash' => $rideRequest->hashkey])->with(['firstTime' => true]);
    }

    public function tracking(HttpRequest $request, $hash)
    {
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

    public function update(HttpRequest $request, $hash)
    {
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

    public function quote(HttpRequest $request, $hash)
    {
        $track = Track::whereHash($hash)->with(['request', 'provider'])->first();
        
        if (!$track) {
            return back()->with("notifications", ["warning" => 'Not found']);
        }

        if ($request->isMethod('post')) {
            if ($track->quote) {
                return redirect()->route('front.provider.quote.store')->with("notifications", ["error" => 'Quote already saved!']);
            }

            $this->validate($request, [
                'quote' => 'required'
            ]);

            $track->quote = $request->get('quote');
            $track->save();

            Mail::to($track->request->email)
                ->queue(new Quoted($track));
            
            return redirect()->route('front.provider.quote.store', ['hash'=>$track->provider->subscription_key])->with("notifications", ["success" => 'Quote saved!']);
        }

        return view("front.quote", ['track' => $track, 'request' => $track->request, 'provider' => $track->provider]);
    }
}
