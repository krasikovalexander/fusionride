<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    public function provider() {
    	return $this->belongsTo('App\Provider');
    }

    public function request() {
    	return $this->belongsTo('App\Request');
    }
}
