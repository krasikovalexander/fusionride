<table class="footable table table-stripped" data-page-size="20" data-filter-min="2" data-filter-ignore-case="false" data-filter=#filter>
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
        <th data-hide="phone">Taxi</th>
        <th data-hide="phone">Subscription</th>
        <th data-hide="phone">Google Rating</th>
        <th data-hide="phone,tablet">Note</th>
        <th data-hide="phone,tablet">Coords</th>
        <th data-hide="all">Reviews</th>
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
        <td>{{$provider->is_taxi ? "Yes" : ""}}</td>
        <td>{{ucwords($provider->subscription_status)}}</td>
        <td>{{$provider->google_review_rating}}</td>
        <td>{{$provider->note}}</td>
        <td><span style="font-weight: bold; color: red">{{$provider->geocoded ? "" : "!"}}</span></td>
        <td>
            @if($provider->google_place_id) 
                    <div class="rating ">
                        <div class='rate'>{{(double)$provider->google_review_rating}}</div> <span class="rating-static rating-{{10*round($provider->google_review_rating*2)/2}}"></span>
                    </div>
                    <a target="_blank"  href="{{$provider->googleReviewsLink}}">Reviews</a>
            @elseif ($provider->id && $provider->address)
                    Not available (<a target="blank" href="https://www.google.ru/search?q={{urlencode($provider->address)}}">check address</a>)
            </div>
            @endif
        </td>
        <td>
            <a href="{{route('admin.providers.edit', ['id'=>$provider->id])}}" class='btn btn-xs btn-info'><i class="fa fa-pencil"></i></a>
            @if ($provider->subscription_status != 'subscribed' && $provider->email)
            <a href="{{route('admin.providers.invite', ['id'=>$provider->id])}}" class='btn btn-xs btn-warning'><i class="fa fa-paper-plane-o"></i></a>
            @endif
            @if ($provider->trashed())
            <a href="{{route('admin.providers.restore', ['id'=>$provider->id])}}" class='btn btn-xs btn-info'><i class="fa fa-undo"></i></a>   
            @else
             <a href="{{route('admin.providers.delete', ['id'=>$provider->id])}}" class='btn btn-xs btn-info btn-danger'><i class="fa fa-trash"></i></a>   
            @endif
        </td>
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