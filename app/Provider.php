<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $fillable = [
		'name', 'state_id', 'city', 'address', 'site', 'phone', 'status', 'note', 'draft', 'email'
	];

    public function types() {
    	return $this->belongsToMany('App\Type');
    }

    public function state() {
    	return $this->belongsTo('App\State');
    }

    public function scopeActive($q) {
    	return $q->whereDraft(0)->whereStatus('active');
    }

    public function getCarsAttribute() {
        return $this->types->pluck('id')->toArray();
    } 
}
