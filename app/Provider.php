<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class Provider extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'state_id', 'city', 'address', 'site', 'phone', 'status', 'note', 'draft', 'email', 'phone_numbers', 'subscription_status', 'subscription_key'
    ];

    protected $appends = ['googleReviewsLink'];

    public function types()
    {
        return $this->belongsToMany('App\Type');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function scopeActive($q)
    {
        return $q->whereDraft(0)->whereStatus('active')->where('subscription_status', 'subscribed');
    }

    public function getCarsAttribute()
    {
        return $this->types->pluck('id')->toArray();
    }

    public function getDuplicatesAttribute()
    {
        return Provider::where(function ($q) {
            $q->where(DB::raw("lower(name)"), strtolower($this->name))
            ->orWhere(DB::raw("lower(site)"), strtolower($this->site))
            ->orWhere(DB::raw("phone_numbers"), $this->phone_numbers);
        })
        ->where('id', '!=', $this->id)
        ->get();
    }

    public function geocode($update = false)
    {
        if ($this->address) {
            $coords = $this->getCoordsByAddress($this->address);
            $this->lat = $coords["lat"];
            $this->lng = $coords["lng"];
            $this->geocoded = $coords["lat"] && $coords["lng"];
            $this->google_place_id = $this->getPlaceIdByAddressName($this->address, $this->name);
            if ($this->google_place_id) {
                $this->google_review_rating = $this->getGoogleRatingByPlaceID($this->google_place_id);
            }
        } else {
            $this->lat = null;
            $this->lng = null;
            $this->geocoded = false;
            $this->google_place_id = null;
            $this->google_review_rating = null;
        }
        if ($update) {
            $this->save();
        }
    }

    public function getGoogleRatingByPlaceID($place_id)
    {
        if ($place_id) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id&key=".config()->get(("services.google.maps.api_key")));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data);
            Log::info(print_r($data, true));
            if (isset($data->status) && $data->status == 'OK') {
                return isset($data->result->rating) ? $data->result->rating : null;
            }
            return null;
        }
        return null;
    }

    public function getCoordsByAddress($address)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);
        Log::info(print_r($data, true));
        if (isset($data->status) && $data->status == 'OK') {
            if (count($data->results)) {
                return [
                    "lat" => $data->results[0]->geometry->location->lat,
                    "lng" => $data->results[0]->geometry->location->lng
                ];
            }
        }
        return ["lat" => null, "lng" => null];
    }

    public function getPlaceIdByAddressName($address, $name)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/place/textsearch/json?query=".urlencode("$name $address")."&key=".config()->get("services.google.maps.api_key"));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);

        if (isset($data->status) && $data->status == 'OK') {
            if (count($data->results)) {
                return $data->results[0]->place_id;
            }
        }
        return null;
    }

    public function scopeInArea($query, $lat, $lng, $dist)
    {
        $lngMin = $lng - $dist/(abs(cos(deg2rad($lng)))*69);
        $lngMax = $lng + $dist/(abs(cos(deg2rad($lng)))*69);
        $latMin = $lat - $dist/69;
        $latMax = $lat + $dist/69;

        $condition = "(3959 * acos( cos( radians( {$lat} ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( {$lng} ) ) + sin(radians({$lat})) * sin(radians(lat)) ))";


        $query->whereGeocoded(1)
            ->whereBetween('lat', [$latMin, $latMax])
            ->whereBetween('lng', [$lngMin, $lngMax])
            ->whereRaw("$condition <= $dist");

        return $query;
    }

    public function getGoogleReviewsLinkAttribute()
    {
        if ($this->google_place_id) {
            return "https://search.google.com/local/reviews?placeid=".$this->google_place_id;
        }
        return null;
    }
}
