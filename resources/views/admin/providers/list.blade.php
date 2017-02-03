@extends('layouts.admin')
@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>{{$drafts ? "Drafts": "Providers"}}</h5>
    </div>
    <div class="ibox-content">
        <div class='col-xs-4'>
            <a class="btn btn-info" href="{{route('admin.providers.create')}}"><i class="fa fa-plus"></i> Create</a>
        </div>
        <div class='col-xs-8'>
            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                   placeholder="Search in table">
        </div>

        @include('admin.providers.table')
    </div>
</div>
@endsection
