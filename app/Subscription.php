<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $fillable = [
		'state_id', 'city', 'email'
	];

    public function state() {
    	return $this->belongsTo('App\State')->orderBy('state', 'asc');
    }
}
