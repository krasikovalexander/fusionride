@extends("layouts.front")

@section("styles")
<style>
    .select2-search__field {
        border-bottom: none!important;
        height: 1em!important;
        line-height: 1em!important;
        margin: 0!important;
        box-shadow: none!important;
    }
    .select2-container--default .select2-selection--multiple {
        border: none!important;
        border-bottom-width: 1px!important;
        border-bottom-color: #aaa!important;
        border-bottom-style: solid!important;
        border-radius: 0!important;
    }
    .select2-container {
        width:100%!important;
    }
    .form-group:last-child {
        margin-top:20px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 0!important;
    }
    .airports-2, .airports-3 {
        display: none;
    }
    .airports-visible-2 .airports-2 {
        display: block;
    }
    .airports-visible-3 .airports-3, .airports-visible-3 .airports-2 {
        display: block;
    }

    .airports-visible-3 .add-airport {
        display: none;
    }
    .clear {
        clear:both;
    }
    .add-airport {
        width: 100%;
        background-color: white!important;
        color: #424242;
        border: 1px dashed #424242;
    }
</style>
@endsection

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

                            
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Provider Name</label>

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

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Provider Address</label>

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

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Owner-phone number required</label>

                                <div class="col-lg-10"><input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"> 
                                <label style="top: -20px;position: relative;display:block">*This number is only for verification and won't be sold or shown to anyone</label>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Email</label>

                                <div class="col-lg-10"><input type="text" class="form-control" name="email" value="{{ old('email') }}"> 
                                <label style="top: -20px;position: relative;display:block">*Your email entered will be used to receive ride request - NOT shown to customer</label>
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
                                            {{$type->name}}<br/>({{$type->passengers}} passengers)
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
                                            {{$type->name}}<br/>({{$type->passengers}} passengers)
                                            <input type="checkbox" {{in_array($type->id, (array)old('type')) ? "checked" : ""}} value='{{$type->id}}' name='type[]'> 
                                            <span class="lever"></span>
                                        </label>
                                    </div>  
                                    @endif         
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group airports airports-visible-{{count(array_filter((array)old('airports'))) ?: 1}}">
                                <label class="col-lg-2 control-label">Servicing airports</label>
                                <div class="col-lg-offset-2 col-lg-10 airports-1">
                                    <select class="form-control select2" id='airports' name="airports[]">
                                        <option value=''>None</option>
                                    @foreach($airports as $airport)
                                        <option value='{{$airport->id}}' {{old('airports.0') == $airport->id ? "selected" : '' }}>{{$airport->code}} ({{$airport->name}})</option>
                                    @endforeach
                                </select> 
                                </div>

                                <div class="col-lg-offset-2 col-lg-4 airports-1">
                                    <div class="switch default">
                                       <label>
                                           Pickup without restrictions
                                           <input type="checkbox" value='1' {{old('pickup_no_restriction.0') ? "checked" : '' }} name='pickup_no_restriction[0]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>
                                <div class="col-lg-offset-2 col-lg-4 airports-1">
                                    <div class="switch default">
                                       <label>
                                           Dropoff without restrictions
                                           <input type="checkbox" value='1' {{old('dropoff_no_restriction.0') ? "checked" : '' }} name='dropoff_no_restriction[0]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>

                                <div class="col-lg-offset-2 col-lg-10 airports-2">
                                    <select class="form-control select2" id='airports' name="airports[]">
                                        <option value=''>None</option>
                                    @foreach($airports as $airport)
                                        <option value='{{$airport->id}}' {{old('airports.1') == $airport->id ? "selected" : '' }}>{{$airport->code}} ({{$airport->name}})</option>
                                    @endforeach
                                </select> 
                                </div>

                                <div class="col-lg-offset-2 col-lg-4 airports-2">
                                    <div class="switch default">
                                       <label>
                                           Pickup without restrictions
                                           <input type="checkbox" value='1' {{old('pickup_no_restriction.1') ? "checked" : '' }} name='pickup_no_restriction[1]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>
                                <div class="col-lg-offset-2 col-lg-4 airports-2">
                                    <div class="switch default">
                                       <label>
                                           Dropoff without restrictions
                                           <input type="checkbox" value='1' {{old('dropoff_no_restriction.1') ? "checked" : '' }} name='dropoff_no_restriction[1]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>

                                <div class="col-lg-offset-2 col-lg-10 airports-3">
                                    <select class="form-control select2" id='airports' name="airports[]">
                                        <option value=''>None</option>
                                    @foreach($airports as $airport)
                                        <option value='{{$airport->id}}' {{old('airports.2') == $airport->id ? "selected" : '' }}>{{$airport->code}} ({{$airport->name}})</option>
                                    @endforeach
                                </select> 
                                </div>

                                <div class="col-lg-offset-2 col-lg-4 airports-3">
                                    <div class="switch default">
                                       <label>
                                           Pickup without restrictions
                                           <input type="checkbox" value='1' {{old('pickup_no_restriction.2') ? "checked" : '' }} name='pickup_no_restriction[2]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>
                                <div class="col-lg-offset-2 col-lg-4 airports-3">
                                    <div class="switch default">
                                       <label>
                                           Dropoff without restrictions
                                           <input type="checkbox" value='1' {{old('dropoff_no_restriction.2') ? "checked" : '' }} name='dropoff_no_restriction[2]'> 
                                           <span class="lever"></span>
                                       </label>
                                   </div> 
                                </div>

                                <div class="col-lg-12">
                                    <button class="btn add-airport" type="button">
                                        + Add
                                    </button>
                                </div>
                                <div class="clear"></div>
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

                $(".add-airport").click(function(){
                    if ($(".airports").hasClass("airports-visible-1")) {
                        $(".airports").removeClass("airports-visible-1").addClass("airports-visible-2");
                        return;
                    }
                    if ($(".airports").hasClass("airports-visible-2")) {
                        $(".airports").removeClass("airports-visible-2").addClass("airports-visible-3");
                        return;
                    }
                });
            });
        </script>
   @endsection