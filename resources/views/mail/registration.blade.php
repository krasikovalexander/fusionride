@extends('layouts.mail')
@section('content')
<p>
    New registration at FusionRide.net. Click <a href="{{route('admin.providers.edit',['id'=>$provider->id])}}">here</a> to review.
</p>
@endsection