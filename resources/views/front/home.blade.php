@extends('layouts.front')
@section('styles')
    <style>
        html, body {
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        #map {
            width: 100%;
            height: 100%;
            min-width: 100vw;
            min-height: 100vh;
        }
        .gmnoprint {
          display: none !important;
        }
        .controls {
          margin-top: 10px;
          border: 1px solid transparent;
          border-radius: 2px 0 0 2px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          height: 32px;
          outline: none;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
          background-color: #5e35b1;
          font-family: Roboto;
          font-size: 15px;
          text-overflow: ellipsis;
          margin-top: 10px;
          width: 90%;
          max-width:500px;
          padding: 5px;
          color: white;
          font-weight: bold;
          border-radius: 4px;
          opacity: 0.8;
        }
        body>#pac-input {
          display:none;
        }

        #pac-input:focus {
          border-color: #5e35b1;
        }

        .pac-container {
          font-family: Roboto;
        }
        body {
          background-color: #e4e4e4;
          background-image: none;
        }
        .buttons {
          position: absolute;
          bottom: 5px;
          width: 100%;
          text-align: center; 
        }
        #done {
          width: 90%;
          max-width:500px;
          opacity: 0.8;
        }
        @media (max-width: 600px) {
          #launcher {
            bottom: 60px!important;
          }
        }
    </style>
@endsection
@section('content')
    <input id="pac-input" class="controls" type="text" placeholder="Where is the service required?">
    <div id="map"></div>

    <div class='buttons'>
      <button id="done" type="button" class="waves-effect waves-light deep-purple accent-3 white-text btn-flat btn-large"><i class="material-icons">done</i>
      </button>
    </div>

    <script>
      function initMap() {
        var center = {lat: 36.7791301, lng: -99.9283838};

        var zoom = 8;
        var radius = 30*1609.34;

        var styledMapType = new google.maps.StyledMapType([{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7f75b5"},{"visibility":"on"}]}]);

        var createMap = function() {
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
            center: center,
            mapTypeControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: false,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: false,
            streetViewControl: false,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            },
            fullscreenControl: false
          });

          map.mapTypes.set('styled_map', styledMapType);
          map.setMapTypeId('styled_map');

          var marker = new google.maps.Marker({
            position: center,
            map: map
          });

          var cityCircle = new google.maps.Circle({
            strokeColor: '#5e35b1',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#5e35b1',
            fillOpacity: 0.35,
            map: map,
            center: center,
            radius: radius,
            editable: true,
          });

          google.maps.event.addListener(cityCircle, 'radius_changed', function() {
            radius = cityCircle.getRadius();
          });

          google.maps.event.addListener(cityCircle, 'center_changed', function() {
            center = cityCircle.getCenter();
            map.setCenter(center);
          });

          var input = document.getElementById('pac-input');
          var autocomplete = new google.maps.places.Autocomplete(input);
          map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

          map.addListener('bounds_changed', function() {
            autocomplete.setBounds(map.getBounds());
          });

          autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            cityCircle.setCenter(place.geometry.location);
            map.setCenter(place.geometry.location);
            center = place.geometry.location;
          });
          $("#done").show().click(function(){
            if (typeof center.lat == 'function') 
              window.location = "{{route('front.requestForm')}}?lat="+center.lat()+"&lng="+center.lng()+"&r="+Math.ceil(radius/1609.34);
            else
              window.location = "{{route('front.requestForm')}}?lat="+center.lat+"&lng="+center.lng+"&r="+Math.ceil(radius/1609.34);
          })
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position){
                center.lat = position.coords.latitude;
                center.lng = position.coords.longitude;
                zoom = 8;
                createMap();
            }, function(failure){
               createMap();
            });
        } else {
          createMap();
        }
        
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{config("services.google.maps.api_key")}}&callback=initMap&libraries=places&language=en">
    </script>
@endsection
