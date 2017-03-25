@extends("layouts.front")

@section("content")
    @if ($provider)
        <div class="valign-wrapper subscription-page" style='min-height: 100vh'>

          <div class="valign" style='width:100%'>
            <div class="row">
                <div class="col s12 m8 l5" style='margin: auto; float: none'>
                  <div class="card z-depth-5">
                    <div class="card-content">
                      <span class="card-title">Unsubscribe</span>
                      <hr>
                      @if ( session()->has('notifications') )
                        @foreach(session()->get('notifications') as $type => $notification)
                          <div class="{{$type}}">{{$notification}}</div>
                        @endforeach
                      @endif

                      <div class='row flow-text'>
                        @if ($provider->subscription_status == 'subscribed')
                        Click below to unsubscribe from receiving free leads. You can always re-activate your subscription from <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">Provider profile</a> page.
                        @elseif ($provider->subscription_status == 'unsubscribed')
                        You are unsubscribed from receiving free leads. You can always re-activate your subscription from <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">Provider profile</a> page.
                        @elseif ($provider->subscription_status == 'none')
                        You are not subscribed for receiving free leads yet.
                        @elseif ($provider->subscription_status == 'pending')
                        You are not subscribed for receiving free leads yet. Visit <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">Provider profile</a> page to activate your subscription.
                        @endif
                      </div>

                      <p>
                        <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" id='provider-edit' action="">
                            {{ csrf_field() }}

                            
                            
                            <div class="form-group">
                                <div class="center">
                                    @if ($provider->subscription_status == 'subscribed')
                                        <button class="btn btn-primary" type="submit" name="action" value="save">
                                            Unsubscribe
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                      </p>
                    </div>
                    <div class="card-action">
                      <a href="{{route('home')}}">Home</a>
                      <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}">Profile</a>
                    </div>
                  </div>
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
                        Unsubscribe link is outdated or broken!
                      </p>
                    </div>
                    <div class="card-action">
                      <a href="{{route('home')}}">Home</a>
                    </div>
                  </div>
                </div>
            </div>
            
          </div>
        </div>
    @endif
@endsection