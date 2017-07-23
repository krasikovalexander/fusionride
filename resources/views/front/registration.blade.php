@extends("layouts.front")

@section("content")
        <div class="valign-wrapper subscription-page" style='min-height: 100vh'>

          <div class="valign" style='width:100%'>
            <div class="row">
                <div class="col s12 m8 l5" style='margin: auto; float: none'>
                  <div class="card z-depth-5">
                    <div class="card-content">
                      <span class="card-title">Registration</span>
                      <hr>
                      @if ( session()->has('notifications') )
                        @foreach(session()->get('notifications') as $type => $notification)
                          <div class="card-panel z-depth-1 {{['warning'=> 'orange', 'success'=>'blue'][$type]}}">{{$notification}}</div>
                        @endforeach
                      @endif

                      <p>
                        <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" id='provider-edit' action="">
                            {{ csrf_field() }}

                            
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Name</label>

                                <div class="col-lg-10"><input type="text" class="form-control" name="name" value="{{ old('name')}}"> 
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('state_id') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">State</label>

                                <div class="col-lg-10">
                                <select class="form-control" id='state' name="state_id">
                                    @foreach($states as $state)
                                        <option value='{{$state->id}}' {{$state->id == old('state_id') ? 'selected': ''}}>{{$state->state}}</option>
                                    @endforeach
                                </select> 
                                @if ($errors->has('state_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state_id') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">City</label>

                                <div class="col-lg-10"><input type="text" id='city' class="form-control" name="city" value="{{ old('city') }}"> 
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Address</label>

                                <div class="col-lg-10"><input type="text" class="form-control" name="address" value="{{ old('address') }}"> 
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Accepted payment types</label>
                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="switch default">
                                        <label>
                                            Visa
                                            <input type="checkbox" value='1' name='accept_visa' {{old('accept_visa') ? "checked" : ""}}> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>            
                                </div>

                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="switch default">
                                        <label>
                                            MasterCard
                                            <input type="checkbox" value='1' name='accept_mc' {{old('accept_mc') ? "checked" : ""}}> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>            
                                </div>


                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="switch default">
                                        <label>
                                            Discover
                                            <input type="checkbox" value='1' name='accept_discover' {{old('accept_discover') ? "checked" : ""}}> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>            
                                </div>


                                <div class="col-lg-offset-2 col-lg-10">
                                   <div class="switch default">
                                       <label>
                                           Amex
                                           <input type="checkbox" value='1' name='accept_amex' {{old('accept_amex') ? "checked" : ""}}> 
                                           <span class="lever"></span>
                                       </label>
                                   </div>            
                                </div>

                                <div class="col-lg-offset-2 col-lg-10">
                                    <div class="switch default">
                                        <label>
                                            Cash
                                            <input type="checkbox" value='1' name='accept_cash' {{old('accept_cash') ? "checked" : ""}}> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>            
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Site</label>

                                <div class="col-lg-10"><input type="text" placeholder="http://" class="form-control" name="site" value="{{ old('site') }}"> 
                                @if ($errors->has('site'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('site') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Phone</label>

                                <div class="col-lg-10"><input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"> 
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Email</label>

                                <div class="col-lg-10"><input type="text" class="form-control" name="email" value="{{ old('email') }}"> 
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Car types</label>
                                @foreach($types as $type)
                                <div class="col-lg-offset-2 col-lg-10">
                                    @if($type->protected)
                                    <div class="switch default">
                                        <label>
                                            {{$type->name}} ({{$type->passengers}}<br/>passengers)
                                            @if (in_array($type->id, (array)old('type')))
                                                <input type="hidden" name="type[]" value="{{$type->id}}">
                                                <span class="pull-right" style="margin-right: 20px;">Yes</span>
                                            @else
                                                <span class="pull-right" style="margin-right: 20px;">No</span>
                                            @endif
                                        </label>
                                        <div class="note" style="padding: 5px 0px; font-size:0.8rem; color:#777">
                                            <a href="mailto:610allrave@gmail.com">Contact us</a> in order to {{in_array($type->id, (array)old('type')) ? 'disable' : 'enable'}} this type of car
                                        </div>
                                    </div>        
                                    @else
                                    <div class="switch default">
                                        <label>
                                            {{$type->name}} ({{$type->passengers}}<br/>passengers)
                                            <input type="checkbox" {{in_array($type->id, (array)old('type')) ? "checked" : ""}} value='{{$type->id}}' name='type[]'> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>  
                                    @endif         
                                </div>
                                @endforeach
                            </div>

                            @if ( !session()->has('completed') )
                            <div class="form-group">
                                <div class="center">
                                    <button class="btn btn-primary" type="submit" name="action" value="save">
                                        Register
                                    </button>
                                </div>
                            </div>
                            @endif
                        </form>
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

        <script>
            $(function(){
                $('select').material_select();
                $("#phone").mask("(999) 999-9999");
            });
        </script>
   @endsection