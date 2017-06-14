@extends('layouts.mail')
@section('content')
<p>Hello,</p>
<p>provider <b>{{$track->provider->name}}</b> has quoted yor request:</p>

<table cellpadding="10" cellspacing="0" border="0">
    <tr>
        <td><b>Quote</b></td>
        <td>
            <b>{{$track->quote}}</b>
        </td>
    </tr>

    <tr>
        <td>Type</td>
        <td>{{$track->request->drive ? 'Hourly rent' : 'Drive to location'}}</td>
    </tr>
    <tr>
        <td>Pick up address</td>
        <td>{{$track->request->pickup_address}}</td>
    </tr>
    <tr>
        <td>Pick up date/time</td>
        <td>{{$track->request->pickup_date}} {{$track->request->pickup_time}}</td>
    </tr>

    @if ($track->request->drive == 0)
    <tr>
        <td>Drop off address</td>
        <td>{{$track->request->dropoff_address}}</td>
    </tr>
    @else
    <tr>
        <td>Drop off date/time</td>
        <td>{{$track->request->dropoff_date}} {{$track->request->dropoff_time}}</td>
    </tr>
    @endif

    @if ($track->request->type == 0)
    <tr>
        <td>Vehicle type</td>
        <td>{{$track->request->typeRelation->name}}</td>
    </tr>
    <tr>
        <td>Passengers</td>
        <td>{{$track->request->typeRelation->passengers}}</td>
    </tr>
    @else
    <tr>
        <td>Vehicle type</td>
        <td>Custom</td>
    </tr>
    <tr>
        <td>Passengers</td>
        <td>{{$track->request->custom_passengers_min}}-{{$track->request->custom_passengers_max}}</td>
    </tr>
    <tr>
        <td>Description</td>
        <td>{{$track->request->custom_type}}</td>
    </tr>
    @endif
    <tr>
        <td>Alcohol</td>
        <td>
            {{$track->request->alcohol ? 'Yes' : 'No'}}
        </td>
    </tr>


    <tr>
        <td>Event</td>
        <td>
            {{ucwords($track->request->event)}}
        </td>
    </tr>
    @if($track->request->event == 'other')
    <tr>
        <td>Other/description</td>
        <td>
            {{$track->request->description}}
        </td>
    </tr>
    @endif

</table>
@endsection

@section('footer')
@if($track->request->key_access_agreed)
<div>
    Visit <a href="{{route('front.tracking', ['hash' => $track->request->hashkey])}}">tracking</a> page to check all quotes.
</div>
<div style="clear:both"></div>
@endif
@endsection