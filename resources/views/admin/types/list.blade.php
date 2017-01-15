@extends('layouts.admin')
@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Car types available for request</h5>
    </div>
    <div class="ibox-content">
        <div class='col-xs-4'>
            <a class="btn btn-info" href="{{route('admin.types.create')}}"><i class="fa fa-plus"></i> Create</a>
        </div>
        <div class='col-xs-8'>
            <input type="text" class="form-control input-sm m-b-xs" id="filter"
                   placeholder="Search in table">
        </div>


        <table class="footable table table-stripped types-table" data-page-size="10" data-filter=#filter>
            <thead>
            <tr>
                <th data-sortable="false" data-hide="phone">Image</th>
                <th>Name</th>
                <th data-hide="phone">Passengers</th>
                <th>Active</th>
                <th data-sortable="false">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
            <tr>
                <td><img src="{{$type->img ? $type->img : '/img/notype.png'}}" class="responsive"/></td>
                <td>{{$type->name}}</td>
                <td>{{$type->passengers}}</td>
                <td>{{$type->active ? 'Active' : 'Disabled'}}</td>
                <td><a href="{{route('admin.types.edit', ['id'=>$type->id])}}" class='btn btn-xs btn-info'><i class="fa fa-pencil"></i></a></td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <ul class="pagination pull-right"></ul>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
