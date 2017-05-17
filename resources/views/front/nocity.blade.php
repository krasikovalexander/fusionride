@extends('layouts.front')
@section('content')
<div class="valign-wrapper" style='min-height: 100vh'>

  <div class="valign" style='width:100%'>
  	<div class="row">
        <div class="col s12 m8 l5" style='margin: auto; float: none'>
          <div class="card z-depth-5">
            <div class="card-content">
              <span class="card-title">Oops!</span>
              <p>
              	We are sorry, but none of providers in selected area have yet signed up for this free service.
              	But we are working on it!<br/><br/>
              	Leave your email and we'll notify you as soon as service will be available in this area.<br/>
              </p>
              <div class="row">
                  <form novalidate action="{{route('front.subscribe', $params)}}" method='post'>
                  {{ csrf_field() }}
                  <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                      <input type='email' value='{{old('email')}}' name='email' placeholder='Type your email here'>
                      @if ($errors->has('email'))
                      <div class="help-block">
                          <strong>{{ $errors->first('email') }}</strong>
                      </div>
                      @endif
                  </div>
                  <div class="input-field col s12 center">
                       <button type="submit" class="btn waves-effect waves-light light-blue">Notify me! <i class="material-icons right">send</i></button>
                  </div>
                  </form>
              </div>
            </div>
            <div class="card-action">
              <a href="{{route('home')}}">Try again</a>
            </div>
          </div>
        </div>
    </div>
  	
  </div>
</div>
	
@endsection