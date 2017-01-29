@extends('layouts.front')
@section('content')
	<div class='container container-request'>
        <div class='row main'>
        	<div class="col s12 m8 offset-m2 l6 offset-l3 result-form done">
        		
	        	<div class='card-panel z-depth-5'>
	        		<ul class="collection with-header">
	        		<li class="collection-header">
	        			@if (isset($firstTime))
	        				<h5>Done!</h5>
	        				<p>This is you personal tracking page. Bookmark this page or save link to be able access it later.</p>
	        			@else
	        				<h5>Providers</h5>
	        			@endif
	        			@if (isset($isSaved)) 
	        				<p class='success'>Information updated!</p>
	        			@endif
	        		</li>
	        		@foreach($tracks as $i => $track)
					    <li class="collection-item">
					      	<span class="title">{{$track->provider->name}}</span>
					      	<p>
					      		Address: {{$track->provider->address}}<br/>
					      		Phone: {{$track->provider->phone}}<br/>
					      		Site: <a href="{{$track->provider->site}}">{{$track->provider->site}}</a>		      
					      	</p>
					      	<div class="row tracking-form">
						      <form method='post' action="{{route('front.tracking.update', ['hash' => $hash])}}" class="col s12">
	        					{{ csrf_field() }}
	        					<input type='hidden' name='track' value="{{$track->id}}">
						        <div class="row">
						          <div class="input-field col s8">
						            <select name='result' id='result{{$i}}'>
						            	<option value='No response' {{$track->result == 'No response' ? 'selected' : '' }}>No response</option>
						            	<option value='Yes' {{$track->result == 'Yes' ? 'selected' : '' }}>Yes</option>
						            	<option value='No' {{$track->result == 'No' ? 'selected' : '' }}>No</option>
						            	<option value='May be' {{$track->result == 'May be' ? 'selected' : '' }}>Maybe</option>
                                	</select>		
                                	<label for="result{{$i}}">Result</label>				            
						          </div>
						          <div class="input-field col s4">
						          	<label for="price{{$i}}">Price</label>
						            <input id="price{{$i}}" name='price' class='price' type="text" value="{{$track->price}}">
						          </div>
						        </div>
						        <div class="row">
						          <div class="input-field col s12">
						            <label for="notes{{$i}}">Notes</label>
						            <textarea id='notes{{$i}}' name='notes' class="materialize-textarea" maxlength="200" data-length="200">{{$track->notes}}</textarea>
						          </div>
						        </div>
						        <div class="row">
						          <div class="col s12 center">
						          <button class="waves-effect waves-light btn"><i class="material-icons left">done</i>Save</button>
						          </div>
						        </div>
						      </form>
					    	</div>
					    </li>
	        		@endforeach
	        		
	        		</ul>
	        	</div>
	        </div>
        </div>
    </div>


@endsection

@section('scripts')
	<script>
		  $(document).ready(function() {
		    $('.materialize-textarea').characterCounter();
		    $('select').material_select();
		    $(".price").mask("99999", {placeholder:" "});
		  });
	</script>
@endsection