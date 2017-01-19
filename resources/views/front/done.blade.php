@extends('layouts.front')
@section('content')
@if(count($providers)) 
	<div class='container container-request'>
        <div class='row main'>
        	<div class="col s12 m8 offset-m2 l6 offset-l3 result-form">
	        	<div class='card-panel z-depth-5'>
	        		<ul class="collection with-header">
	        		<li class="collection-header"><h4>That's all!</h4> <h5>We sent your request to the following providers:</h5></li>
	        		@foreach($providers as $provider)
					    <li class="collection-item">
					      <span class="title">{{$provider->name}}</span>
					      <p>
					      	Address: {{$provider->address}}<br/>
					      	Phone: {{$provider->phone}}<br/>
					      	Site: <a href="{{$provider->site}}">{{$provider->site}}</a>		      
					      </p>
					    </li>
	        		@endforeach
	        		<li class="collection-item"><span class="title center-align">Multiple offers will be on the way via email and/or phone.</span></li>
	        		</ul>
	        	</div>
	        			    </div>
        </div>
    </div>
@else
	<div class="valign-wrapper" style='min-height: 100vh'>

	  <div class="valign" style='width:100%'>
	  	<div class="row">
	        <div class="col s12 m8 l5" style='margin: auto; float: none'>
	          <div class="card z-depth-5">
	            <div class="card-content">
	              <span class="card-title">Oops!</span>
	              <p>
	              	We could not find any suitable provider in {{$city}}.<br/>
          			Please choose another vehicle type or make it special request.
          		  </p>
	            </div>
	            <div class="card-action">
	              <a href="{{route('front.requestForm', ['state' => $state, 'city' => $city])}}">Try again</a>
	            </div>
	          </div>
	        </div>
	    </div>
	  	
	  </div>
	</div>
@endif

@endsection