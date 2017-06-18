<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'id', 'drive', 'pickup', 'pickup_date', 'pickup_time', 'dropoff', 'dropoff_date', 'dropoff_time', 'type', 'car', 'custom_passengers_min', 'custom_passengers_max', 'custom_type', 'black', 'white', 'red', 'yellow', 'green', 'blue', 'alcohol', 'event', 'description', 'email', 'phone', 'pickup_address', 'dropoff_address', 'lat', 'lng', 'r', 'note', 'name'
    ];

    public function typeRelation()
    {
        return $this->belongsTo('App\Type', 'car', 'id');
    }

    public function tracks()
    {
        return $this->hasMany('App\Track');
    }
}
