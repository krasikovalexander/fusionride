<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'lat', 'lng', 'r', 'email'
    ];

    public function state()
    {
        return $this->belongsTo('App\State')->orderBy('state', 'asc');
    }

    public function scopeContaining($query, $lat, $lng)
    {
        $query->whereRaw("SQRT(POW(lat - $lat , 2) + POW(lng - $lng, 2)) * 100 < r*1.60934");
        return $query;
    }
}
