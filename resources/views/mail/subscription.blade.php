@extends('layouts.mail')
@section('content')
<p>Hello,</p>
<p>Fusion Ride service is now available at {{$provider->city}}, {{$provider->state->code}}.</p>
@endsection