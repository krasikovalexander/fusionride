@extends('layouts.mail')
@section('content')

<p>Hello,</p>
<p>We've got a new availability request for you:</p>
<table cellpadding="10" cellspacing="0" border="0">
	<tr>
		<td>Type</td>
		<td>{{$request->drive ? 'Hourly rent' : 'Drive to location'}}</td>
	</tr>
	<!--<tr>
		<td>Pick up location type</td>
		<td>{{ucwords($request->pickup)}}</td>
	</tr>-->
	<tr>
		<td>Pick up address</td>
		<td>{{$request->pickup_address}}</td>
	</tr>
	<tr>
		<td>Pick up date/time</td>
		<td>{{$request->pickup_date}} {{$request->pickup_time}}</td>
	</tr>

	@if ($request->drive == 0)
	<!--<tr>
		<td>Drop off location type</td>
		<td>{{ucwords($request->dropoff)}}</td>
	</tr>-->
	<tr>
		<td>Drop off address</td>
		<td>{{$request->dropoff_address}}</td>
	</tr>
	@else
	<tr>
		<td>Drop off date/time</td>
		<td>{{$request->dropoff_date}} {{$request->dropoff_time}}</td>
	</tr>
	@endif

	@if ($request->type == 0)
	<tr>
		<td>Vehicle type</td>
		<td>{{$request->typeRelation->name}}</td>
	</tr>
	<tr>
		<td>Passengers</td>
		<td>{{$request->typeRelation->passengers}}</td>
	</tr>
	@else
	<tr>
		<td>Vehicle type</td>
		<td>Custom</td>
	</tr>
	<tr>
		<td>Passengers</td>
		<td>{{$request->custom_passengers_min}}-{{$request->custom_passengers_max}}</td>
	</tr>
	<tr>
		<td>Description</td>
		<td>{{$request->custom_type}}</td>
	</tr>
	@endif

	<!--
	<tr>
		<td>Preferred colors</td>
		<td>
			{{$request->black ? 'black ' : ''}}
			{{$request->white ? 'white ' : ''}}
			{{$request->red ? 'red ' : ''}}
			{{$request->yellow ? 'yellow ' : ''}}
			{{$request->green ? 'green ' : ''}}
			{{$request->blue ? 'blue' : ''}}
		</td>
	</tr>
	-->

	<tr>
		<td>Alcohol</td>
		<td>
			{{$request->alcohol ? 'Yes' : 'No'}}
		</td>
	</tr>


	<tr>
		<td>Event</td>
		<td>
			{{ucwords($request->event)}}
		</td>
	</tr>
	@if($request->event == 'other')
	<tr>
		<td>Other/description</td>
		<td>
			{{$request->description}}
		</td>
	</tr>
	@endif

	<tr>
		<td>Email</td>
		<td>
			<a href='mailto:{{$request->email}}'>{{$request->email}}</a>
		</td>
	</tr>

	<tr>
		<td>Phone</td>
		<td>
			{{$request->phone}}
		</td>
	</tr>

	<tr>
		<td></td>
		<td>
			<a href="{{route('front.provider.quote.show', ['hash' => $track->hash])}}"><button style="background: #ff0af7;background-image: -webkit-linear-gradient(top, #ff0af7, #ce00d9);background-image: -moz-linear-gradient(top, #ff0af7, #ce00d9);background-image: -ms-linear-gradient(top, #ff0af7, #ce00d9);background-image: -o-linear-gradient(top, #ff0af7, #ce00d9);background-image: linear-gradient(to bottom, #ff0af7, #ce00d9);-webkit-border-radius: 5;-moz-border-radius: 5;border-radius: 5px;text-shadow: 1px 1px 3px #1c1c1c;font-family: Arial;color: #ffffff;font-size: 20px;padding: 10px 20px 10px 20px;text-decoration: none;" type="button">Bid your price</button></a>
		</td>
	</tr>
	
</table>
	
@endsection
@section('footer')
<div>
	You received this email because you subscribed to a free <a href="http://FusionRide.net">FusionRide.net</a> service.
	<br/>
	Visit you <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">profile</a> page to update settings.
	<br/>
	If you do not wish to receive further communications like this, please <a href="{{route('front.provider.unsubscribe', ['hash' => $provider->subscription_key])}}">click here to unsubscribe</a>.
</div>
<div style="clear:both"></div>
@endsection