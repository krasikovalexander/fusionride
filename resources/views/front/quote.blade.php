@extends('layouts.front')
@section('styles')
    <style>
        .form-group {
            margin-top: 15px;
        }
    </style>
@endsection
@section('content')
        <div class="valign-wrapper subscription-page" style='min-height: 100vh'>
        
          <div class="valign" style='width:100%'>
            <div class="row">
                <div class="col s12 m8 l5" style='margin: auto; float: none'>
                  <div class="card z-depth-5">
                    <div class="card-content">
                        <span class="card-title">Request details</span>
                        <form method="POST" id='quote' action="">
                        <div class="form-group"><label>Type</label>
                            <div>{{$request->drive ? 'Hourly rent' : 'Drive to location'}}</div>
                        </div>

                        <div class="form-group"><label>Pick up address</label>
                            <div>{{$request->pickup_address}}</div>
                        </div>

                        <div class="form-group"><label>Pick up date/time</label>
                            <div>{{$request->pickup_date}} {{$request->pickup_time}}</div>
                        </div>

                        @if ($request->drive == 0)
                        <div class="form-group"><label>Drop off address</label>
                            <div>{{$request->dropoff_address}}</div>
                        </div>
                        @else
                        <div class="form-group"><label>Drop off date/time</label>
                            <div>{{$request->dropoff_date}} {{$request->dropoff_time}}</div>
                        </div>
                        @endif

                        @if ($request->type == 0)
                        <div class="form-group"><label>Vehicle type</label>
                            <div>{{$request->typeRelation->name}}</div>
                        </div>

                        <div class="form-group"><label>Passengers</label>
                            <div>{{$request->typeRelation->passengers}}</div>
                        </div>
                        @else
                        <div class="form-group"><label>Vehicle type</label>
                            <div>Custom</div>
                        </div>
                        <div class="form-group"><label>Passengers</label>
                            <div>{{$request->custom_passengers_min}}-{{$request->custom_passengers_max}}</div>
                        </div>
                        <div class="form-group"><label>Description</label>
                            <div>{{$request->custom_type}}</div>
                        </div>
                        @endif

                        <div class="form-group"><label>Alcohol</label>
                            <div>{{$request->alcohol ? 'Yes' : 'No'}}</div>
                        </div>

                        <div class="form-group"><label>Event</label>
                            <div>{{ucwords($request->event)}}</div>
                        </div>


                        @if($request->event == 'other')
                        <div class="form-group"><label>Other/description</label>
                            <div>{{$request->description}}</div>
                        </div>
                        @endif

                        <!--<div class="form-group"><label>Email</label>
                            <div><a href='mailto:{{$request->email}}'>{{$request->email}}</a></div>
                        </div>


                        <div class="form-group"><label>Phone</label>
                            <div>{{$request->phone}}</div>
                        </div>-->
                        <div class="form-group"><label>Name</label>
                            <div>{{$request->name}}</div>
                        </div>

                        @if($request->note)
                        <div class="form-group"><label>Notes</label>
                            <div>{{$request->note}}</div>
                        </div>
                        @endif


                        @if($track->quote)
                        <div class="form-group"><label>Quote</label>
                            <div>{{$track->quote}}</div>
                        </div>
                        @else
                        <div class="form-group{{ $errors->has('quote') ? ' has-error' : '' }}"><label>Quote</label>

                            <div>
                                <input type="text" name="quote" placeholder="Type your quote here" value="{{ old('quote', $track->quote) }}"> 
                            @if ($errors->has('quote'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quote') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>

                        {{ csrf_field() }}
                        <div class="form-group">
                                <div class="center">
                                    <button class="btn btn-primary" type="submit" name="action" value="save">
                                        Submit
                                    </button>
                                </div>
                        </div>
                        @endif

                        @if ( session()->has('notifications') )
                            @foreach(session()->get('notifications') as $type => $notification)
                                <div class="card-panel z-depth-1 {{['error'=> 'red', 'success'=>'green'][$type]}}">{{$notification}}</div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-action">
                      <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">Profile</a>
                    </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>

        </div>
@endsection