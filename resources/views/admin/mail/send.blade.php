@extends('layouts.admin')
@section('content')
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Mass mail</h5>
    </div>
    <div class="ibox-content">
        <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{route('admin.mail.send')}}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Subject</label>
                <div class="col-lg-10"><input type="text" class="form-control" name="subject" value="{{ old('subject', '') }}"> 
                @if ($errors->has('subject'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Body</label>
                <div class="col-lg-10"><textarea name="body" class='summernote'>{{ old('body', '') }}</textarea> 
                @if ($errors->has('body'))
                    <span class="help-block">
                        <strong>{{ $errors->first('body') }}</strong>
                    </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('statuses') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Statuses</label>
                <div class="col-lg-10">
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='statuses[]' value="pending" {{ in_array('pending', old('statuses', [])) ? "checked" : ""}}> Pending
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='statuses[]' value="active" {{ in_array('active', old('statuses', [])) ? "checked" : ""}}> Active
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='statuses[]' value="suspended" {{ in_array('suspended', old('statuses', [])) ? "checked" : ""}}> Suspended
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='statuses[]' value="not interested" {{ in_array('not interested', old('statuses', [])) ? "checked" : ""}}> Not interested
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='statuses[]' value="call back later" {{ in_array('call back later', old('statuses', [])) ? "checked" : ""}}> Call back later
                        </label>
                    </div>
                    @if ($errors->has('statuses'))
                        <span class="help-block">
                            <strong>{{ $errors->first('statuses') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('subscription_statuses') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Subscription statuses</label>
                <div class="col-lg-10">
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='subscription_statuses[]' value="none" {{ in_array('none', old('subscription_statuses', [])) ? "checked" : ""}}> None
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='subscription_statuses[]' value="pending" {{ in_array('pending', old('subscription_statuses', [])) ? "checked" : ""}}> Pending
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='subscription_statuses[]' value="subscribed" {{ in_array('subscribed', old('subscription_statuses', [])) ? "checked" : ""}}> Subscribed
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='subscription_statuses[]' value="unsubscribed" {{ in_array('unsubscribed', old('subscription_statuses', [])) ? "checked" : ""}}> Unsubscribed
                        </label>
                    </div>
                    @if ($errors->has('subscription_statuses'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subscription_statuses') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('drafts') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Drafts</label>
                <div class="col-lg-10">
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='drafts[]' value="1" {{ in_array('1', old('drafts', [])) ? "checked" : ""}}> Draft
                        </label>
                    </div>
                    <div class="i-checks">
                        <label> 
                            <input type="checkbox" class="i-checks" name='drafts[]' value="0" {{ in_array('0', old('drafts', [])) ? "checked" : ""}}> Not draft
                        </label>
                    </div>
                    

                @if ($errors->has('drafts'))
                    <span class="help-block">
                        <strong>{{ $errors->first('drafts') }}</strong>
                    </span>
                @endif
                </div>
            </div>
        

            <div class="form-group">
                <div class="col-lg-2"></div>
                <div class='col-lg-10'>
                    <button type="submit" class="btn btn-info" onclick="send()"><i class="fa fa-send"></i> Send</button><br/>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function send() {
            console.log($('.summernote').summernote('code'));
        }

        $(document).ready(function() {
          $('.summernote').summernote({height: 300,});
        });
    </script>
@endsection
