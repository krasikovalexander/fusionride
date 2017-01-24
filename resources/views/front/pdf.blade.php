<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
        ul {
        	list-style-type:none;
        }
        li {
        	border-bottom: 1px solid #e0e0e0;
        	margin-bottom: 40px;
        }
        .title {
        	box-sizing: border-box;
			color: rgba(0, 0, 0, 0.870588);
			display: inline;
			font-family: Roboto, sans-serif;
			font-size:16px;
			font-weight:normal;
			height:auto;
			line-height:21px;
			list-style-type:none;
			text-align:left;
			text-size-adjust:100%;
			user-select:none;
			width:auto;
			-webkit-tap-highlight-color:rgba(255, 255, 255, 0);
        }
        p {
			box-sizing:border-box;
			color:rgb(117, 117, 117);
			display:block;
			font-family:Roboto, sans-serif;
			font-size:14px;
			font-weight:normal;
			line-height:21px;
			list-style-type:none;
			text-align:left;
			text-size-adjust:100%;
			user-select:none;
			width:434.328px;
			-webkit-margin-after:14px;
			-webkit-margin-before:14px;
			-webkit-margin-end:0px;
			-webkit-margin-start:0px;
			-webkit-tap-highlight-color:rgba(255, 255, 255, 0);
        }
        </style>
        <title>FusionRide</title>
    </head>
    <body>
    	<ul>
    	<li class="collection-header"><h2>We sent your request to the following providers:</h2></li>
        @foreach($providers as $provider)
            <li class="collection-item">
              <span class="title">{{$provider->name}}</span>
              <p>
              	Address: {{$provider->address}}<br/>
              	Phone: {{$provider->phone}}<br/>
              	Site: <a href="{{$provider->site}}">{{$provider->site}}</a>	      
              </p>
            </li>
        @endforeach
       	</ul>
    </body>
</html>


