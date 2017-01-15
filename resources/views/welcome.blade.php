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
            <form role="form" id="form" novalidate method="GET" action="{{route('front.requestForm')}}">
            <div class="row state">
              <div class="input-field col s12">
                <select name='state' id='state' required>
                    <option value='' disabled selected>Select state</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
                <label>State</label>
              </div>
            </div>
            <div class='row city'>
              <div class="input-field col s12">
                <label>City</label>
                <input type="text" placeholder="Type city name here" name='city' id='city' required>
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
            });
        });
    </script>
@endsection
