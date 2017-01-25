@extends('layouts.mail')
@section('content')

<p>Hello,</p>
<p>we've got a new availability request for you:</p>
<table cellpadding="10" cellspacing="0" border="0">
	<tr>
		<td>State</td>
		<td>{{$request->stateRelation->state}}</td>
	</tr>
	<tr>
		<td>City</td>
		<td>{{$request->city}}</td>
	</tr>
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
	
</table>
@endsection