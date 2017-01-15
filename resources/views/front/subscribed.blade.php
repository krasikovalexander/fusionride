@extends('layouts.front')
@section('content')
<div class="valign-wrapper" style='min-height: 100vh'>

  <div class="valign" style='width:100%'>
  	<div class="row">
        <div class="col s12 m8 l5" style='margin: auto; float: none'>
          <div class="card z-depth-5">
            <div class="card-content">
              <span class="card-title">Thank you!</span>
              <p>Email <b>{{request()->email}}</b> sucessfully subscribed.</p>
              
            </div>
            <div class="card-action">
              <a href="{{route('home')}}">Back</a>
            </div>
          </div>
        </div>
    </div>
  	
  </div>
</div>
	
@endsection