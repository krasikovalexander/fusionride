@extends('layouts.admin')
@section('content')
	<div class='row'>

		<div class='col-lg-4'>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Mail status</h5>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				<div class="ibox-content">
				    Status <span class="label label-default pull-right">{{$mail['status']}}</span>
				</div>
				<div class="ibox-content">
				    Queued <span class="label label-primary pull-right">{{$mail['queued']}}</span>
				</div>
				<div class="ibox-content">
				    Last time <span class="label label-default pull-right">{{$mail['last'] ? $mail['last']->created_at->diffForHumans() : '-'}}</span>
				</div>
				<div class="ibox-content">
				    With retries <span class="label label-warning pull-right">{{$mail['retries']}}</span>
				</div>
				<div class="ibox-content">
					Failed <span class="label label-danger pull-right">{{$mail['failed']}}</span>
				</div>
				<div class="ibox-content text-right">
					<a href='{{route('admin.mail.retry')}}' class='btn btn-default {{$mail['failed'] ? '' : 'disabled'}}'>Retry failed</a>
					<a href='{{route('admin.mail.restart')}}' class='btn btn-danger'>Restart daemon</a>
				</div>
			</div>
		</div>


		<div class='col-lg-4'>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Requests</h5>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				<div class="ibox-content text-center">
				    <span sparkType="pie" sparkHeight=150 class="sparklines">{{$requests['success']}},{{$requests['fail']}}</span>
				</div>
				<div class="ibox-content">
				    <div class='row'>
				    	<div class='col-xs-4'>
				    		<small class="stats-label">Sucess</small>
                            <h4>{{$requests['success']}}</h4>
				        </div>
				        <div class='col-xs-4'>
				    		<small class="stats-label">Fail</small>
                            <h4>{{$requests['fail']}}</h4>
				        </div>
				        <div class='col-xs-4'>
				    		<small class="stats-label">Total</small>
                            <h4>{{$requests['success']+$requests['fail']}}</h4>
				        </div>
				    </div>
				</div>
			</div>

			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Top-10</h5> <span class="label label-primary">Success</span>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				@foreach($top['requests']['success'] as $request)
					<div class="ibox-content">
					   {{$request->city}}, {{$request->stateRelation->code}} <span class="label label-info pull-right">{{round($request->cnt*100/$requests['success'])}}%</span>
					</div>
				@endforeach
			</div>

			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Top-10</h5> <span class="label label-warning">Fail</span>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				@foreach($top['requests']['fail'] as $request)
					<div class="ibox-content">
					   {{$request->city}}, {{$request->stateRelation->code}} <span class="label label-info pull-right">{{round($request->cnt*100/$requests['fail'])}}%</span>
					</div>
				@endforeach
			</div>
		</div>

		<div class='col-lg-4'>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Subscriptions</h5></span>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				<div class="ibox-content text-center">
				    <span sparkType="pie" sparkHeight=150 class="sparklines">{{$subscriptions['success']}},{{$subscriptions['fail']}}</span>
				</div>
				<div class="ibox-content">
				    <div class='row'>
				    	<div class='col-xs-4'>
				    		<small class="stats-label">Available</small>
                            <h4>{{$subscriptions['success']}}</h4>
				        </div>
				        <div class='col-xs-4'>
				    		<small class="stats-label">Not&nbsp;available</small>
                            <h4>{{$subscriptions['fail']}}</h4>
				        </div>
				        <div class='col-xs-4'>
				    		<small class="stats-label">Total</small>
                            <h4>{{$subscriptions['success']+$subscriptions['fail']}}</h4>
				        </div>
				    </div>
				</div>
			</div>

			<div class="ibox float-e-margins">
				<div class="ibox-title">
				    <h5>Top-20</h5> <span class="label label-warning">Not available</span>
				    <div class="ibox-tools">
				        <a class="collapse-link">
				            <i class="fa fa-chevron-up"></i>
				        </a>
				        <a class="close-link">
				            <i class="fa fa-times"></i>
				        </a>
				    </div>
				</div>
				@foreach($top['subscriptions']['fail'] as $subscription)
					<div class="ibox-content">
					   {{$subscription->city}}, {{$subscription->state->code}} <span class="label label-info pull-right">{{round($subscription->cnt*100/$subscriptions['fail'])}}%</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			$('.sparklines').sparkline('html', { enableTagOptions: true , sliceColors: ['#1ab394', '#b3b3b3', '#e4f0fb']});
		});
	</script>
@endsection