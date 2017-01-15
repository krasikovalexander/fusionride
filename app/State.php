<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function providers() {
    	return $this->hasMany('App\Provider');
    }

    public function getCitiesAttribute() {
    	return $this->Providers()->distinct('city')->orderBy('city', 'asc')->pluck('city');
    }
}
