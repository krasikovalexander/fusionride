@extends('layouts.mail')
@section('content')
<p>
    <a href="http://www.fusionride.net">FusionRide.Net</a> is offering free referal service to limo and bus companies all over the USA.<br/> 
    FYI you have every right to cancel your free subscription anytime likewise,<br/>
    FusionRide.Net reserves the right to discontinue sending free leads to your email without your consent.<br/>
    <strong>Fusion Ride&trade; Provider Emails will not be sold or shown to customers when they use Fusion Ride&trade;.</strong>
</p>

<p style='text-align: center'>
    <a href="{{route('front.provider.subscribe', ['hash' => $provider->subscription_key])}}" style="-moz-box-shadow:inset -1px 1px 0px 0px #97c4fe;-webkit-box-shadow:inset -1px 1px 0px 0px #97c4fe;box-shadow:inset -1px 1px 0px 0px #97c4fe;background-color:#3d94f6;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;display:inline-block;cursor:pointer;color:#ffffff;font-family:Arial;font-size:28px;font-weight:bold;padding:6px 24px;text-decoration:none;text-shadow:0px 1px 0px #1570cd; margin: 20px">Click to activate</a>
</p>
<p>
    Click here to review contact info & vehicles used and enjoy the benefits of truly free service in less than 30 seconds.
</p> 

<p>
    Thank you for considering your customers pains in making it easier to find limo and bus companies all over the USA in one easy form.
</p>
@endsection