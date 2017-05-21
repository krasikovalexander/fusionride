@extends('layouts.admin')
@section('content')

<div class="ibox float-e-margins">
	<div class="ibox-title">
	    <h5>{!!($provider->id ? "Edit provider: <b>$provider->name</b>" : "Create new provider")!!}</h5>
	</div>
	<div class="ibox-content">
	    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" id='provider-edit' action="{{route($provider->id ? 'admin.providers.edit':'admin.providers.create', ['id'=>$provider->id])}}">
	   		{{ csrf_field() }}

			
	        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Name</label>

	            <div class="col-lg-10"><input type="text" class="form-control" name="name" value="{{ old('name', $provider->name)}}"> 
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
	            		<option value='{{$state->id}}' {{$state->id == old('state_id', $provider->state_id) ? 'selected': ''}}>{{$state->state}}</option>
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

	            <div class="col-lg-10"><input type="text" id='city' class="form-control" name="city" value="{{ old('city', $provider->city) }}"> 
	            @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Address</label>

	            <div class="col-lg-10"><input type="text" class="form-control" name="address" value="{{ old('address', $provider->address) }}"> 
	            @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
                @if ($provider->geocoded) 
                <div id="map" style="height: 250px"></div>
                @endif
	            </div>
	        </div>

           

	       	<div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Site</label>

	            <div class="col-lg-10"><input type="text" class="form-control" name="site" value="{{ old('site', $provider->site) }}"> 
	            @if ($errors->has('site'))
                    <span class="help-block">
                        <strong>{{ $errors->first('site') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Phone</label>

	            <div class="col-lg-10"><input type="text" class="form-control" name="phone" value="{{ old('phone', $provider->phone) }}"> 
	            @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Email</label>

	            <div class="col-lg-10"><input type="text" class="form-control" name="email" value="{{ old('email', $provider->email) }}"> 
	            @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

			@php
				$statuses = ['pending','active','suspended','not interested','call back later'];
			@endphp
	        
	        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Status</label>

	            <div class="col-lg-10">
	            <select class="form-control" name="status">
	            	@foreach($statuses as $status)
	            		<option value='{{$status}}' {{$status == old('status', $provider->status) ? 'selected': ''}}>{{ucwords($status)}}</option>
	            	@endforeach
	            </select> 
	            @if ($errors->has('status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Note</label>

	            <div class="col-lg-10"><textarea class="form-control" name="note">{{ old('note', $provider->note) }}</textarea>
	            @if ($errors->has('note'))
                    <span class="help-block">
                        <strong>{{ $errors->first('note') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

			<div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <label> <input type="checkbox" class="i-checks" name='draft' {{ old('draft', $provider->draft) ? "checked" : ""}}> Draft </label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <label> <input type="checkbox" class="i-checks" name='is_taxi' {{ old('is_taxi', $provider->is_taxi) ? "checked" : ""}}> Taxi </label>
                </div>
            </div>


            <div class="form-group">
            	<label class="col-lg-2 control-label">Car types</label>
            	@foreach($types as $type)
                <div class="col-lg-offset-2 col-lg-10">
                    <label> <input type="checkbox" class="i-checks" name='type[]' {{in_array($type->id, (array)old('type', $provider->cars)) ? "checked" : ""}} value='{{$type->id}}'> {{$type->name}} </label>                
                </div>
            	@endforeach
            </div>

	        <div class="form-group">
	            <div class="col-lg-offset-2 col-lg-10">
	             	<a class="btn btn-default" href="{{!old('draft', $provider->draft) ? route('admin.providers') : route('admin.drafts')}}">Cancel</a>
	                <button class="btn btn-primary" type="submit" name="action" value="save">Save</button>
	                @if ($provider->id)
	                <button class="btn btn-danger" style="margin-left:100px" type="submit" name="action" value="clone">Save as New</button>
	                @endif
	            </div>
	        </div>
	    </form>
	</div>
</div>

@if ($provider->id)
<div class="ibox float-e-margins">
	<div class="ibox-title">
	    <h5>Possible duplicates</h5>
	</div>
	<div class="ibox-content">
	    @include('admin.providers.table')
	</div>
</div>
@endif
@endsection

@section('scripts')
<script>
	$(document).ready(function() {
		$("#state").select2();
		$("#city").bootcomplete({
			url:'{{route('admin.providers.search')}}',
			minLength: 1,
			dataParams: {
				field: 'city',
			},
			formParams: {
				state: $("#state")
			}
		});
	});
</script>

@if ($provider->geocoded) 
<script>
      function initMap() {
        var place = {lat: {{$provider->lat}}, lng: {{$provider->lng}}};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: place
        });
        var marker = new google.maps.Marker({
          position: place,
          map: map
        });
      }
    </script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{config("services.google.maps.api_key")}}&callback=initMap">
    </script>
@endif

@endsection