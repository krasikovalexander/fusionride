@extends('layouts.front')
@section('content')
    <div class='container container-request'>
        <div class='row main'>
            <form method="post" id='form' action="{{route('front.requestForm')}}" novalidate>
            {{ csrf_field() }}
                <div class="col s12 m10 offset-m1 l6 offset-l3 request-form">
                    <div class='card-panel z-depth-5'>
                        <div class="row state">
                            <div class="input-field col s12">
                                <select name='state' id='state'>
                                    <option value="" disabled>Choose state</option>
                                    @foreach($states as $state)
                                    <option value='{{$state->id}}' {!!$state->id == $selectedState ? "selected": ""!!}>{{$state->state}}</option>
                                    @endforeach
                                </select>
                                <label>State</label>
                            </div>
                        </div>

                        <div class="row city">
                            <div class="input-field col s12">
                                <select name='city' id='city'>
                                    <option value="" disabled>Choose city</option>
                                </select>
                                <label>City</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class='col s12'>
                                <div class="switch switch-drive">
                                    <label>
                                        <div class='left-part selected'>Drive to location</div>
                                        <input type="checkbox" type="checkbox" value='1' id="drive" name='drive'>
                                        <span class="lever"></span>
                                        <div class='right-part'>Hourly rent</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                       <!-- <div class="row pickup">
                            <div class="input-field col s12" style='display:none'>
                                <select name='pickup' id='pickup'>
                                    <option value="" disabled selected>Choose pick up location type</option>
                                    <option value="airport">Airport</option>
                                    <option value="business">Business</option>
                                    <option value="home">Home</option>
                                    <option value="apartment">Apartment/Condo</option>
                                </select>
                                <label>Pick me up at</label>
                            </div>
                        </div>-->

                        <div class="row free-text pickup_address">
                            <div class="input-field col s12">
                               <label for="pickup_address">Pick up address</label>
                               <input id="pickup_address" name='pickup_address' type="text" readonly>
                            </div>
                        </div>


                        <div class="row with-date pickup-date pickup-time">
                            <div class="input-field col s6 date ">
                               <label for="pickup-date"><i class="tiny material-icons grey-text text-lighten-2">today</i> Pick up Date</label>
                               <input id="pickup-date" name='pickup_date' class="datepicker" type="date">
                            </div>
                            <div class="input-field col s5 date">
                               <label for="pickup-time"><i class="tiny material-icons grey-text text-lighten-2">query_builder</i> Pick up Time</label>
                               <input id="pickup-time" name='pickup_time' class="timepicker" type="time">
                           </div>
                        </div>
                        
                        <!--<div class="row for-drive dropoff">
                            <div class="input-field col s12">
                                <select name='dropoff' id='dropoff'>
                                    <option value="" disabled selected>Choose drop off location type</option>
                                    <option value="airport">Airport</option>
                                    <option value="business">Business</option>
                                    <option value="home">Home</option>
                                    <option value="apartment">Apartment/Condo</option>
                                </select>
                                <label>Drop me off at</label>
                            </div>
                        </div>-->

                        <div class="row free-text for-drive dropoff_address">
                            <div class="input-field col s12">
                               <label for="dropoff_address">Drop off address</label>
                               <input id="dropoff_address" name='dropoff_address' type="text" readonly>
                            </div>
                        </div>

                        <div class="row for-rent with-date dropoff-date dropoff-time" style='display:none'>
                            <div class="input-field col s6 date">
                               <label for="dropoff-date"><i class="tiny material-icons grey-text text-lighten-2">today</i> Drop off Date</label>
                               <input id="dropoff-date" name='dropoff_date' class="datepicker" type="date">
                            </div>
                            <div class="input-field col s5 date">
                               <label for="dropoff-time"><i class="tiny material-icons grey-text text-lighten-2">query_builder</i> Drop off Time</label>
                               <input id="dropoff-time" name='dropoff_time' class="timepicker" type="time">
                           </div>
                        </div>

                    
                        <div class="row car_type">
                            <div class='col s12'>
                                <div class="switch switch-type">
                                    <label>
                                        <div class='left-part selected'>Conventional cars</div>
                                        <input type="checkbox" type="checkbox" value='1' id='type' name='type'>
                                        <span class="lever"></span>
                                        <div class='right-part'>Specialty vehicle</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='for-conventional choose-car'>Choose car type</div>
                        <div class="carousel carousel-slider center types for-conventional" data-indicators="true">
                            @foreach ($types as $type)
                            <div class="carousel-item white white-text" style="background-image: url({{$type->img ? $type->img : '/img/notype.png'}})">
                                <div class='passengers'>
                                    <i class="material-icons">perm_identity</i> <span>{{$type->passengers}} passengers</span>
                                </div>
                                <div class="title">{{$type->name}}</div>
                            </div>
                            @endforeach
                            <div class='next'><i class="fa fa-angle-right" aria-hidden="true"></i></div>
                            <div class='prev'><i class="fa fa-angle-left" aria-hidden="true"></i></div>
                        </div>
                        <input type='hidden' name='car' id='car'/>

                        <div class="row for-special with-range" style='display: none'>
                            <div class='col s12'>
                                <div id='passengers-value'>4-12</div>
                                <label>
                                    Select the number of passengers 
                                </label>
                                <div id='passengers'></div>
                                <input type='hidden' name='custom_passengers_min' id='custom_passengers_min' value='4'/>
                                <input type='hidden' name='custom_passengers_max' id='custom_passengers_max' value='12'/>
                            </div>
                        </div>

                        <div class="row for-special custom_type" style='display: none'>
                            <div class="input-field col s12">
                                <label for="custom_type">Special request vehicle</label>
                                <input type="text" id="custom_type"  name="custom_type" placeholder='Type here, what kind of car you want'/>
                            </div>
                        </div>
                        
                        <div class="row info">
                            <div class='col s1'>
                                <i class='material-icons small'>error_outline</i>
                            </div>
                            <div class='col s10 info-text'>
                            Year make and model of vehicles, including specialty vehicles will vary
                            </div>
                        </div>

                        <div class="row custom-color">
                            <div class="col s12">
                                <label>Preferred colors</label>
                                <input type="checkbox" value='1' name='black' id='color-black' /><label  class='color-black' for='color-black'></label>
                                <input type="checkbox" value='1' name='white' id='color-white' /><label class='color-white' for='color-white'></label>
                                <input type="checkbox" value='1' name='red' id='color-red' /><label class='color-red' for='color-red'></label>
                                <input type="checkbox" value='1' name='yellow' id='color-yellow' /><label class='color-yellow' for='color-yellow'></label>
                                <input type="checkbox" value='1' name='green' id='color-green' /><label class='color-green' for='color-green'></label>
                                <input type="checkbox" value='1' name='blue' id='color-blue' /><label class='color-blue' for='color-blue'></label>
                            </div>
                        </div>

                        <div class="row alcohol">
                            <div class='input-field col s12'>
                                <div class="switch default">
                                    <label>
                                        Alcohol vehicle
                                        <input type="checkbox" value='1' id="alcohol" name='alcohol'>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row event">
                            <div class="input-field col s12">
                                <select name='event' id='event'>
                                    <option value="" disabled selected>Choose event type</option>
                                    <option value="party">Party</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="meet">Meet & Great</option>
                                    <option value="tour">Tour</option>
                                    <option value="graduation">Graduation</option>
                                    <option value="sport">Sporting Event</option>
                                    <option value="holiday">Holiday Light Tour</option>
                                    <option value="other">Other</option>
                                </select>
                                <label>Event</label>
                            </div>
                        </div>

                        <div class="row free-text for-other" style='display:none'>
                            <div class="input-field col s12">
                               <label for="description">Other/Description</label>
                               <input id="description" name='description' type="text">
                            </div>
                        </div>

                        <div class="row free-text email">
                            <div class="input-field col s12">
                               <label for="email">Email</label>
                               <input id="email" name='email' type="email">
                            </div>
                        </div>

                        <div class="row free-text phone">
                            <div class="input-field col s12">
                               <label for="phone">Phone</label>
                               <input id="phone" name='phone' type="text">
                            </div>
                        </div>

                         <div class="row info last">
                            <div class="input-field col s12">
                               By submiting you are agreeing that Fusion Ride is not responsible for any service received or quoted. Transportation Insurance questions should always be checked when you select your company as we have an honor system.
                            </div>
                        </div>

                        

                        <div class="row done">
                            <button type='submit' class="col s12 waves-effect waves-light deep-purple accent-3 white-text btn-flat btn-large"><i class='material-icons medium'>done</i></button>
                            <div class='error-msg'>Please fill correctly all <span class='error-color'><b>marked</b></span> fields</div>
                        </div>

                    </div>               
                </div>
            </form>
        </div>
    </div>


    <div id="modal1" class="custom-modal modal">
                
        <div class="modal-content">
          <h5><i class="material-icons grey-text">mode_edit</i> Pick up address</h5>
          <div class='row'>
            <div class="input-field col s12">
               <label for="pick_address">Address</label>
               <input id="pick_address" name='pick_address' type="text">
            </div>
          </div>
          <div class='row'>
            <div class="input-field col s5">
                <label for="pick_state">State</label>
                <input type="text" name='pick_state' id='pick_state' class='state'>
                
            </div>
            <div class="input-field col s5">
               <label for="pick_city">City</label>
               <input id="pick_city" name='pick_city' type="text">
            </div>
            <div class="input-field col s2">
               <label for="pick_zip">Zip</label>
               <input id="pick_zip" name='pick_zip' type="text" class='zip'>
            </div>
          </div>
        </div>
        <div class="modal-footer"> 
            <div class="row done">
                <button type='button' class="modal-action modal-close col s12 waves-effect waves-light deep-purple accent-3 white-text btn-flat btn-large"><i class='material-icons medium'>done</i></button>
            </div>
        </div>

    </div>

    <div id="modal2" class="custom-modal modal">
                
        <div class="modal-content">
          <h5><i class="material-icons grey-text">mode_edit</i> Drop off address</h5>
          <div class='row'>
            <div class="input-field col s12">
               <label for="drop_address">Address</label>
               <input id="drop_address" name='drop_address' type="text">
            </div>
          </div>
          <div class='row'>
            <div class="input-field col s5">
                <label for="drop_state">State</label>
                <input type="text" name='drop_state' id='drop_state' class='state'/>
            </div>
            <div class="input-field col s5">
               <label for="drop_city">City</label>
               <input id="drop_city" name='drop_city' type="text">
            </div>
            <div class="input-field col s2">
               <label for="drop_zip">Zip</label>
               <input id="drop_zip" name='pick_zip' type="text">
            </div>
          </div>
        </div>
        <div class="modal-footer"> 
            <div class="row done">
                <button type='button' class="modal-action modal-close col s12 waves-effect waves-light deep-purple accent-3 white-text btn-flat btn-large"><i class='material-icons medium'>done</i></button>
            </div>
        </div>

    </div>

    <script>
        $(function(){
            $('#state').change(function(){
                $("#city option[value!='']").remove();
                $("#city").val('');
                @foreach ($states as $state)
                if ($(this).val() == {{$state->id}}) {
                    $.each({!!$state->cities!!}, function(key, value) {
                        $('#city').append($("<option/>", {value: value, text: value}));
                    });
                }
                @endforeach
                $('select').material_select();
            });

        @if($selectedState) 
            $('label[for="state"]').addClass('active');
        @endif

        @if($selectedCity)
            @foreach ($states as $state)
            @if ($state->id == $selectedState) 
                $.each({!!$state->cities!!}, function(key, value) {
                    $('#city').append($("<option/>", {value: value, text: value}));
                });
            @endif
            @endforeach
            $("#city").val('{{$selectedCity}}');
            $('label[for="city"]').addClass('active');
        @else
            $('#state').change();
        @endif
            
            $('#modal1').modal(
                {
                    dismissible: false,
                    opacity: .5,
                    in_duration: 100,
                    out_duration: 100, 
                    starting_top: '2%', 
                    ending_top: '2%',
                    complete: function() { 
                        var address = [];
                        if ($("#pick_address").val()) 
                            address.push($("#pick_address").val());

                        if ($("#pick_city").val())
                            address.push($("#pick_city").val());

                        if ($("#pick_state").val())
                            address.push($("#pick_state").val());

                        if ($("#pick_zip").val()) 
                            address.push($("#pick_zip").val());

                        $("#pickup_address").val(address.join(', ')).change();
                    } 
                }
            );

            $('#modal2').modal(
                {
                    dismissible: false,
                    opacity: .5,
                    in_duration: 100,
                    out_duration: 100, 
                    starting_top: '2%', 
                    ending_top: '2%',
                    complete: function() { 
                        var address = [];
                        if ($("#drop_address").val()) 
                            address.push($("#drop_address").val());

                        if ($("#drop_city").val())
                            address.push($("#drop_city").val());

                        if ($("#drop_state").val())
                            address.push($("#drop_state").val());

                        if ($("#drop_zip").val()) 
                            address.push($("#drop_zip").val());

                        $("#dropoff_address").val(address.join(', ')).change();
                    } 
                }
            );

            $("body").on('focus', "#pickup_address", function(){
                if (!$("#pickup_address").val()) {
                    if ($("#state").val()) {
                        $("#pick_state").val($("#state option:selected").text());
                        $('label[for="pick_state"]').addClass('active');
                    }
                    
                    if ($("#city").val()) {
                        $("#pick_city").val($("#city").val());
                        $('label[for="pick_city"]').addClass('active');
                    }
                }
                $('#modal1').modal('open');
                $("#pickup_address").blur();
            });

            $("body").on('focus', "#dropoff_address", function(){
                if (!$("#dropoff_address").val()) {
                    if ($("#state").val()) {
                        $("#drop_state").val($("#state option:selected").text());
                        $('label[for="drop_state"]').addClass('active');
                    }
                    
                    if ($("#city").val()) {
                        $("#drop_city").val($("#city").val());
                        $('label[for="drop_city"]').addClass('active');
                    }
                }
                $('#modal2').modal('open');
                $("#dropoff_address").blur();
            });
            
            $("body").on('change', ".switch input[type=checkbox]", function(){
                if($(this).is(':checked')) {
                    $(this).parent().find('.left-part').removeClass('selected');
                    $(this).parent().find('.right-part').addClass('selected');
                } else {
                    $(this).parent().find('.right-part').removeClass('selected');
                    $(this).parent().find('.left-part').addClass('selected');
                }
            });

            $("body").on('change', "#type", function(){
                if($(this).is(':checked')) {
                    $('.for-conventional').hide();
                    $('.for-special').fadeIn();
                } else {
                    $('.for-special').hide();
                    $('.for-conventional').fadeIn();
                }
            });

            $("#type").change();

            

            $("body").on('change', "#drive", function(){
                if($(this).is(':checked')) {
                    $('.for-drive').hide();
                    $('.for-rent').fadeIn();
                } else {
                    $('.for-rent').hide();
                    $('.for-drive').fadeIn();
                }
            });
            $("#drive").change();

            $("body").on('change', "#event", function(){
                if($(this).val() == 'other') {
                    $('.for-other').fadeIn();
                } else {
                    $('.for-other').hide();
                }
            });
            $("#event").change();

            $("#phone").mask("(999) 999-9999");
            $(".zip").mask("99999",{placeholder:" "});

            var slider = document.getElementById('passengers');
            noUiSlider.create(slider, {
                start: [4, 12],
                connect: true,
                step: 1,
                range: {
                    'min': 1,
                    'max': 40
                },
                format: wNumb({
                    decimals: 0
                })
            });

            slider.noUiSlider.on('update', function(values, handle) {
                if (values[0] == values[1]) {
                    $("#passengers-value").html(values[0]);
                } else {
                    $("#passengers-value").html(values[0]+"-"+values[1]);
                }
                $("#custom_passengers_min").val(values[0]);
                $("#custom_passengers_max").val(values[1]);
            });

            $('select').material_select();

            $('.timepicker').pickatime({
                autoclose: true,
                twelvehour: false,
                default: '12:00:00'
            });

            $('#pickup-date').pickadate({
                close: 'Done',
                format: 'd mmmm, yyyy',
                min: new Date(),
                onSet: function(context) {
                    if (context.select) {
                        dropoffPicker.set({
                            min: new Date($('#pickup-date').val())
                        });

                        if (!$("#pickup-time").val()) {
                            this.close();
                            $("#pickup-time").click();
                        }
                    }
                }
            });
            $('#pickup-date').on('focus', function(){
                $('label[for="pickup-date"]').addClass('active');
            });
            $('#dropoff-date').on('focus', function(){
                $('label[for="dropoff-date"]').addClass('active');
            });

            var pickupPicker = $('#pickup-date').pickadate('picker');

            $('#dropoff-date').pickadate({
                close: 'Done',
                format: 'd mmmm, yyyy',
                min: new Date($('#pickup-date').val()),
                onSet: function(context) {
                    if (context.select) {
                        pickupPicker.set({
                            max: new Date($('#dropoff-date').val())
                        });

                        if (!$("#dropoff-time").val()) {
                            $('#dropoff-date').focus().blur();
                            this.close();
                            $("#dropoff-time").click();
                        }
                    }
                }
            });
            var dropoffPicker = $('#dropoff-date').pickadate('picker');

            $('.carousel.carousel-slider').carousel({full_width: true});
            var types = {!!$types!!};
            setInterval(function(){
                $("#car").val(types[$('.indicators li').index($('.indicator-item.active'))].id);
            },100);

            $('.next').on('click', function(e){
                $('.carousel').carousel('next');
            });

            $('.prev').on('click', function(e){
                $('.carousel').carousel('prev');
            });

            var validate = function() {
                var valid = true;
                var required = ['city', 'state', 
                //'pickup', 
                'pickup-date', 'pickup-time', 'email', 'phone', 'pickup_address'];
                if ($("#drive").is(':checked')) {
                    required.push("dropoff-date");
                    required.push("dropoff-time");
                } else {
                    //required.push('dropoff');
                    required.push('dropoff_address');
                }

                if ($("#type").is(':checked')) {
                    required.push('custom_type');
                }

                $(".row").removeClass('invalid');

                for(r in required) {
                    var field = required[r];
                    if (!$("#"+field).val()) {
                        $(".row."+field).addClass('invalid');
                        valid = false;
                    } else {
                       $(".row."+field).removeClass('invalid');
                    }
                }
                if($("#email").val() && !$("#email").is(":valid")) {
                    $(".row.email").addClass('invalid');
                    valid = false;
                } else if ($("#email").val() && $("#email").is(":valid")){
                    $(".row.email").removeClass('invalid');
                }

                if(
                    $('#pickup-date').val() && $('#dropoff-date').val() && $('#pickup-date').val() == $('#dropoff-date').val() && 
                    $('#pickup-time').val() && $('#dropoff-date').val() && $('#pickup-time').val() >= $('#dropoff-time').val()
                ) {
                    $(".row.dropoff-time").addClass('invalid');
                    valid = false;
                } else if ($('#pickup-time').val() && $('#dropoff-date').val()) {
                    $(".row.dropoff-time").removeClass('invalid');
                }

                return valid;
            };

            var validateField = function(input) {

                var required = ['city', 'state', 
                //'pickup', 
                'pickup-date', 'pickup-time', 'email', 'phone', 'pickup_address'];
                if ($("#drive").is(':checked')) {
                    required.push("dropoff-date");
                    required.push("dropoff-time");
                } else {
                    //required.push('dropoff');
                    required.push('dropoff_address');
                }

                if ($("#type").is(':checked')) {
                    required.push('custom_type');
                }

                var field = $(input).attr("id");
                if (required.indexOf(field) >= 0) {
                    if (!$(input).val()) {
                        $(".row."+field).addClass('invalid');
                    } else {
                       $(".row."+field).removeClass('invalid');
                    }
                }
              
                if(field == 'email' && $("#email").val() && !$("#email").is(":valid")) {
                    $(".row.email").addClass('invalid');
                } else if (field == 'email' && $("#email").val() && !$("#email").is(":valid")){
                    $(".row.email").removeClass('invalid');
                }

                if(field == 'dropoff-time' && (
                        $('#pickup-date').val() && $('#dropoff-date').val() && $('#pickup-date').val() == $('#dropoff-date').val() && 
                        $('#pickup-time').val() && $('#dropoff-date').val() && $('#pickup-time').val() >= $('#dropoff-time').val()
                        )
                    ) {
                    $(".row.dropoff-time").addClass('invalid');
                } else if (field == 'dropoff-time'){
                    $(".row.dropoff-time").removeClass('invalid');
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

            $('.state').autocomplete({
                data: {
                   @foreach ($allStates as $state)
                       "{{$state->state}}": null,
                   @endforeach
                },
                limit: 5, 
              });
        });
    </script>
@endsection