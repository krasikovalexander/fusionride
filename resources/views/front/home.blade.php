@extends('layouts.front')
@section('styles')
    <style>
        html, body {
            background-image: url(../img/bg.jpg);
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .splash .top {
            color: #ffffff;
            font-size: 50px;
        }

        .slogan .card-panel {
            min-height: 90px;
            font-size: 20px;
            line-height: 60px;
            text-align: left;
        }

        .row.slogan .col {
            padding: 0;
        }

        .bottom .card-panel {
            padding: 15px;
            padding-top: 30px;
            margin:10px;
        }
        .text {
            color: #ffffff;
            font-size: 1.3rem;
        }
        .row {
            margin-bottom: 10px;
        }
        @media (min-height:510px) {
            body {
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container splash center-align">
        <div class='row top  animated fadeInDown'>
            <div class='col s12'>Fusion Ride</div>
        </div>
        <div class='row slogan'>

            <div class='col l6 offset-l3  hide-on-med-and-down animated slideInLeft'>
                <div class="card-panel hoverable light-blue">
                  <div class="white-text"><i class="medium material-icons left">query_builder</i>Request date time you would like service</div>
                </div> 
            </div>

            <div class='col l6 offset-l3  hide-on-med-and-down  animated slideInRight'>
                <div class="card-panel hoverable light-blue">
                    <div class="white-text"><i class="medium material-icons left">view_carousel</i>Pick your vehicle type</div>
                </div>
            </div>

            <div class='col l6 offset-l3 hide-on-med-and-down  animated slideInLeft'>
                <div class="card-panel hoverable light-blue">
                    <div class="white-text"><i class="medium material-icons left">done</i> Submit a request for quote and availability</div>
                </div>
            </div>

            <div class='col s12 hide-on-large-only text'>
                Submit a request for quote and availability.<br/><br/>
            </div>
        </div>
        <div class='row bottom'>
            <div class='card-panel hoverable col l6 offset-l3 s12 z-depth-1  animated fadeInUp'>
            <form autocomplete='off' role="form" id="form" novalidate method="GET" action="{{route('front.requestForm')}}">
            <div class="row state">
              <div class="input-field col s12">
                <label for="state">State</label>
                <input type="text" id="state" placeholder="Type state" class="autocomplete">
                <input type='hidden' id='state-code' name='state'>
                
              </div>
            </div>
            <div class='row city'>
              <div class="input-field col s12">
                <label for="city">City</label>
                <input type="text" name='city' placeholder="Type city" id='city'>
                
              </div>
            </div>
            <div class='row continue'>
              <div class="input-field col s12">
                <button type="submit" class="btn waves-effect waves-light light-blue">Continue <i class="material-icons right">send</i></button>
                <div class='error-msg'>Please fill correctly all <span class='error-color'><b>marked</b></span> fields</div>
              </div>
            </div>
            </form>
            </div>
        </div>
        <div class='row bottom'>
            <div class='col s12 text'>
                Multiple offers will be on the way via email and/or phone.
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('select').material_select();

            var states = {!!$states!!};

            _.map(states, function(state){
                return state.state = state.state.toLowerCase();
            });

            var validate = function() {
                var valid = true;
                var required = ['city', 'state'];

                for(r in required) {
                    var field = required[r];
                    if (!$("#"+field).val()) {
                        $(".row."+field).addClass('invalid');
                        valid = false;
                    } else {
                       $(".row."+field).removeClass('invalid');
                    }
                }

                field = 'state';
                if (!_.where(states, {state: $('#state').val().toLowerCase()}).length) {
                    $(".row."+field).addClass('invalid');
                    valid = false;
                } else {
                    $(".row."+field).removeClass('invalid');
                }

                return valid;
            };

            var validateField = function(input) {

                var required = ['city', 'state'];

                var field = $(input).attr("id");
                if (required.indexOf(field) >= 0) {
                    if (!$(input).val()) {
                        $(".row."+field).addClass('invalid');
                    } else {
                       $(".row."+field).removeClass('invalid');
                    }
                }
                if (field == 'state') {
                    if (!_.where(states, {state: $(input).val().toLowerCase()}).length) {
                        $(".row."+field).addClass('invalid');
                    } else {
                       $(".row."+field).removeClass('invalid');
                    }
                }
            };

            $("select, input").change(function(){
                validateField(this);
            });

            $("#form").on('submit', function(e){
                var valid = validate();
                if (!valid) {
                    $('.error-msg').addClass('visible');
                    setTimeout(function(){
                        $('.error-msg').removeClass('visible');
                    }, 3000);
                    e.preventDefault();
                }
                $("#state-code").val(_.where(states, {state: $("#state").val().toLowerCase()})[0].code);
            });

            $('#state').autocomplete({
                data: {
                   @foreach ($states as $state)
                       "{{$state->state}}": null,
                   @endforeach
                },
                limit: 5, 
              });
                    
        });
    </script>
@endsection
