<table class="footable table table-stripped" data-page-size="20" data-filter=#filter>
    <thead>
    <tr>
        <th>Name</th>
        <th>State</th>
        <th data-hide="phone">City</th>
        <th data-hide="all">Address</th>
        <th data-hide="all">Site</th>
        <th data-hide="phone">Phone</th>
        <th data-hide="all">Email</th>
        <th data-hide="phone">Status</th>
        <th data-hide="phone,tablet">Note</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($providers as $provider)
    <tr>
        <td>{{$provider->name}}</td>
        <td>{{$provider->state->code}}</td>
        <td>{{$provider->city}}</td>
        <td>{{$provider->address}}</td>
        <td>{{$provider->site}}</td>
        <td>{{$provider->phone}}</td>
        <td><a href="mailto:{{$provider->email}}">{{$provider->email}}</a></td>
        <td>{{ucwords($provider->status)}}</td>
        <td>{{$provider->note}}</td>
        <td><a href="{{route('admin.providers.edit', ['id'=>$provider->id])}}" class='btn btn-xs btn-info'><i class="fa fa-pencil"></i></a></td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="9">
            <ul class="pagination pull-right"></ul>
        </td>
    </tr>
    </tfoot>
</table>