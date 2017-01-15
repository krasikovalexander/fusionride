@extends('layouts.admin')
@section('content')

<div class="ibox float-e-margins">
	<div class="ibox-title">
	    <h5>{!!($type->id ? "Edit car type: <b>$type->name</b>" : "Create new car type")!!}</h5>
	</div>
	<div class="ibox-content">
	    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" id='type-edit' action="{{route($type->id ? 'admin.types.edit':'admin.types.create', ['id'=>$type->id])}}">
	   		{{ csrf_field() }}

			<div class="form-group"><label class="col-lg-2 control-label">Image</label>
				<div class="col-lg-5">
	            	<img class='dz-message preview' src="{{$type->img ? $type->img : '/img/notype.png'}}"><br>
	            	<input type="file" name="img"/>
	            </div>
	        </div>

	        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Name</label>

	            <div class="col-lg-10"><input type="text" placeholder="Name" class="form-control" name="name" value="{{ $type->name }}"> 
	            @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>


	        <div class="form-group{{ $errors->has('passengers') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Passengers</label>

	            <div class="col-lg-10"><input type="text" placeholder="Number of passengers" class="form-control" name="passengers" value="{{ $type->passengers }}"> 
	            @if ($errors->has('passengers'))
                    <span class="help-block">
                        <strong>{{ $errors->first('passengers') }}</strong>
                    </span>
                @endif
	            </div>
	        </div>

			<div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <label> <input type="checkbox" class="i-checks" name='active' {{$type->active ? "checked" : ""}}> Active </label>
                </div>
            </div>

	        <div class="form-group">
	            <div class="col-lg-offset-2 col-lg-10">
	             	<a class="btn btn-default" href="{{route('admin.types')}}">Cancel</a>
	                <button class="btn btn-primary" type="submit">Save</button>
	            </div>
	        </div>
	    </form>
	</div>
</div>
@endsection
