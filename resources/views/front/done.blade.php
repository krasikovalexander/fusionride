@extends('layouts.front')
@section('content')
@if(count($providers)) 
	<div class='container container-request'>
        <div class='row main'>
        	<div class="col s12 m8 offset-m2 l6 offset-l3 result-form done">
        		<a href="{{route('front.pdf', ['_' => base64_encode(implode(',', $providers->pluck('id')->all()))])}}"><div class="pdf"></div></a>
	        	<div class='card-panel z-depth-5'>
	        		<ul class="collection with-header">

	        		<li class="collection-header"><h4>That's all!</h4></li>
	        		
	        		<li class="collection-item">
	        			<form method='post' action="{{route('front.approve')}}">
	        				{{ csrf_field() }}
	        				<input type='hidden' name='hash' value="{{$request->hashkey}}">
	        				<div class="title center-align">Multiple offers will be on the way via email and/or phone.</div>
	        				<div class="center-align">
	        					<p class="center-align">We built simple <b>FREE</b> tool to help you <b>easily</b> record and compare responses from service providers.</p>
	        					<p class="title center-align"><b>Sign up not required!</b></p>
	        					<p class="center-align">Just obtain <b>private</b> link to get access anytime, anywhere.</p>
  							</div>

	        				<div class="center-align getlink">
	        					<button class="waves-effect waves-light btn"><i class="material-icons left">verified_user</i>Click now and keep your bids in one place</button> 
	        					<!--<a class='no' href="{{route("home")}}">No, thanks</a>-->
	        				</div>
	        			</form>
	        			
	        			<div class="center" style="margin-top: 20px; margin-bottom: -10px;">
  							<a href="mailto:610allrave@gmail.com">Contact us</a>  if you have any comment or concern.
  						</div>
  						
	        		</li>

	        		<li class="collection-item">
	        			<h5>We sent your request to the following providers:</h5>
	        			<div style="font-weight:bold; color:red">
	        				If a provider isn't listed please let them know to contact us at 610-255-7283
	        			</div>
	        		</li>
	        		@foreach($providers as $provider)
					    <li class="collection-item">
					    <span class="title">{{$provider->name}}</span>
					    @if($provider->google_place_id)
					    <br/>
					    <div class="rating" style="display:inline">
                            <div class='rate'>{{(double)$provider->google_review_rating}}</div> <span class="rating-static rating-{{10*round($provider->google_review_rating*2)/2}}"></span>
                            </div>
                        <a target="_blank"  href="{{$provider->googleReviewsLink}}">Reviews</a>
					    @endif
					      <p>
					      	Address: {{$provider->address}}<br/>
					      	Phone: {{$provider->phone}}
					      	@if($provider->site)
					      	<br/>
					      	Site: <a href="{{$provider->site}}">{{$provider->site}}</a>	
					      	@endif	  
					      	<br/> 
					      	Payment types:  {{$provider->accept_visa ? "Visa, " : ""}}
                                            {{$provider->accept_mc ? "MasterCard, " : ""}}
                                            {{$provider->accept_discover ? "Discover, " : ""}}
                                            {{$provider->accept_amex ? "Amex, " : ""}}
                                            {{$provider->accept_cash ? "Cash" : ""}}
					      </p>
					    </li>
	        		@endforeach
	        		
	        		
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
	              	We could not find any suitable provider in selected area.<br/>
          			Please choose another vehicle type or make it special request.
          		  </p>
	            </div>
	            <div class="card-action">
	              <a href="{{route('front.requestForm', ['lat' => $lat, 'lng' => $lng, 'r' => $r])}}">Try again</a>
	            </div>
	          </div>
	        </div>
	    </div>
	  	
	  </div>
	</div>
@endif

@endsection