<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderAirportSettings extends Model
{
    public function airport()
    {
        return $this->belongsTo('App\Airport');
    }
}
