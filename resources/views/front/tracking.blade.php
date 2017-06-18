@extends('layouts.front')

@section('styles')
	<link href="/css/footable.standalone.min.css" rel="stylesheet">
@endsection

@section('scripts')
	<script src="/js/footable.min.js"></script>
	<script>
		var save;
		$(document).ready(function() {
		    $('table').footable();
		   	$(".price").mask("?99999", {placeholder:" "});

		   	save = function (row) {
		   		var notes = "";
				if ($('.notes', row).length) {
					notes = $('.notes', row).val();
				} else {
					notes = $('.notes', $(row).next()).val();
				}

			  	$('#form')
			  		.addHidden('result', $('select[name="result"]', row).val())
			  		.addHidden('price', $('input[name="price"]', row).val())
			  		.addHidden('notes', notes)
			  		.addHidden('track', $('input[name="track"]', row).val())
			  		.submit();
			}
		});

    	jQuery.fn.addHidden = function (name, value) {
		    return this.each(function () {
		        var input = $("<input>").attr("type", "hidden").attr("name", name).val(value);
		        $(this).append($(input));
		    });
		};

	</script>
@endsection

@section('content')
	<div class='container container-request'>
        <div class='row main'>
        	<div class="col s12 result-form done">
        		
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
	   
	           		<form method='post' action="{{route('front.tracking.update', ['hash' => $hash])}}" id='form'>
	        			{{ csrf_field() }}
        			</form>

					    <li class="collection-item">
					    	<div class="row tracking-form">		     	
        						<table class='table' data-filtering="false" data-sorting="true">
        							<thead>
	        							<tr>
		        							<th>Name</th>
		        							<th data-sortable="false" data-breakpoints="all">Address</th>
                                            <th data-sortable="false" data-breakpoints="all">Reviews</th>
		        							<th data-sortable="false" data-breakpoints="xs sm">Phone</th>
		        							<th data-sortable="false" data-breakpoints="xs sm md">Site</th>
		        							<th>Result</th>
		        							<th>Price</th>
                                            <th data-breakpoints="xs">Quote</th>
		        							<th data-sortable="false" data-breakpoints="all">Notes</th>
		        							<th data-sortable="false" style="width:32px"></th>
		        						</tr>
		        					</thead>
        							@foreach($tracks as $i => $track)
									
        							<tr>
        								<td>{{$track->provider->name}}</td>
							      		<td>{{$track->provider->address}}</td>
                                        <td>
                                            @if($track->provider->google_place_id) 
                                                    <div class="rating ">
                                                        <div class='rate'>{{(double)$track->provider->google_review_rating}}</div> <span class="rating-static rating-{{10*round($track->provider->google_review_rating*2)/2}}"></span>
                                                    </div>
                                                    <a target="_blank"  href="{{$track->provider->googleReviewsLink}}">Reviews</a>
                                            @elseif ($track->provider->id && $track->provider->address)
                                                    Not available
                                            @endif
                                        </td>
							      		<td>{{$track->provider->phone}}</td>
							      		<td><a href="{{$track->provider->site}}">{{$track->provider->site}}</a></td>	      
	        							<td>
	        								<input type='hidden' name='track' value="{{$track->id}}">
		        							<select class='browser-default'  name='result'>
								            	<option value='No response' {{$track->result == 'No response' ? 'selected' : '' }}>No response</option>
								            	<option value='Yes' {{$track->result == 'Yes' ? 'selected' : '' }}>Yes</option>
								            	<option value='No' {{$track->result == 'No' ? 'selected' : '' }}>No</option>
								            	<option value='May be' {{$track->result == 'May be' ? 'selected' : '' }}>Maybe</option>
		                                	</select>
		                                </td>
		                                <td>
                                			<input class='browser-default price' style="width:50px; background-color: white; border: 1px solid #f2f2f2;"  name='price' type="text" value="{{$track->price}}">
                                		</td>
                                        <td>
                                            {{$track->quote ? $track->quote : "Unknown"}}
                                        </td>
                                		<td>
                                			<textarea class='browser-default notes' style="border: 1px solid #f2f2f2;"  name='notes'>{{$track->notes}}</textarea>
                                		</td>
                                		<td>
                                			<button type="button" onclick='save($(this).parent().parent())' title='Save' class="btn-floating waves-effect waves-light"><i class="material-icons">done</i></button>
                                		</td>
                                	</tr>
        							@endforeach
        						</table>
						   
					   		</div>
						</li>	
		        	</ul>
		       	</div>
		    </div>
	    </div>
	</div>


@endsection

