@extends('layouts.front')
@section('content')
<div class="valign-wrapper demo" style='min-height: 100vh'>

  <div class="valign" style='width:100%'>
    <div class="row">
        <div class="col s12 m8 l5" style='margin: auto; float: none'>
          <div class="card z-depth-5">
            <div class="card-content">
              <div class="block-logo">
                <img src="/img/block-logo.jpg">
              </div>
              <p>Demo can be requested at <a href="mailto:610allrave@gmail.com">610allrave@gmail.com</a></p>
              <p class="note">*Owner phone number needed to validate inquiry.</p>
              <br/>
              <p>Want to become a provider? <a href="{{url('/registration')}}">Sign up</a></p>
            </div>
            
          </div>
        </div>
    </div>
    
  </div>
</div>
    
@endsection