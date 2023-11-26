$(document).ready(function() {
    var business_type = $("#role_id").val();
    if(business_type == 3){
        $('.cater_fields').show();
    }else if(business_type == 5){
        $('.cater_fields').hide();
    }

    // let mySelect = new vanillaSelectBox("#cuisine",{
    //     // maxWidth: 500,
    //     // maxHeight: 400,
    //     // window:600
    // });


});


var form = $("#main_form");
form.validate({
    errorElement: 'span',
    rules: {
        first_name: {
            required: true
        },
        last_name: {
            required: true
        },
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
        },
        c_password: {
            required: true,
            equalTo : "#password"
        },
        dob: {
            required: true
        },
        gender: {
            required: true
        },
        phone: {
            required: true,
            number: true
        },
        business_type:{
            valueNotEquals: ""
        },
        business_name: {
            required: true
        },
        business_disp_name: {
            required: true
        },
        business_logo_file: {
            required: true,
            extension: "jpg|jpeg|png",
            filesize : 500000
        },
        business_desc: {
            required: true
        },
        business_address_2: {
            required: true,
        },
        business_town: {
            required: true,
        },
        business_country: {
            required: true,
        },
        business_postal_code: {
            required: true,
            alphanumeric: true
        },
        registered_fsa: {
            required: true,
        },
        registered_fsa_file: {
            fsafile: true,
        },
        hygiene_certificate: {
            required: true,
        },
        hygiene_certificate_file: {
            fhc: true,
        },
        hygiene_rating: {
            number: true
        },
        'can_you_deliver[]': {
            required: true,
        },
        guests_max: {
            // required: true
            number: true,
            hideguestmaxbaker:1,
        },
        guests_min: {
            // required: true,
            number: true,
            hideguestminbaker:1,
        },
        min_order: {
            // required: true,
            hideminorderonbaker:1,
        },
        min_order_amount: {
            // minordervalue: true,
            number: true,
            hideminorderamountonbaker:1,
            // number: true
        },
        cuisine: {
            // required: true,
            hidecusineonbaker:1,
        },
        others_specifiy: {
            cuisineothers: true,
            // hideothersonbaker:1,
        },
        'specialities[]': {
            required: true,
        }
    },
    messages: {
        first_name: {
            required: "First name is required"
        },
        last_name: {
            required: "Last name is required"
        },
        email: {
            required: "Email is required",
            email: "Please enter valid email"
        },
        password: {
            required: "Password is required",
        },
        c_password: {
            required: "Confirm password is required",
            equalTo : "Password and Confirm password should be same"
        },
        dob: {
            required: "Date of birth is required",
        },
        gender: {
            required: "Gender is required",
        },
        phone: {
            required: "Phone number is required",
            number: "Please enter valid Phone number",
        },
        business_type: {
            valueNotEquals: "Business type is required"
        },
        business_name: {
            required: "Business name is required"
        },
        business_disp_name: {
            required: "Business display name is required"
        },
        business_logo_file: {
            required: "Business logo name is required",
            filesize: "Max file size is 500 KB"
        },
        business_desc: {
            required: "Business Description name is required"
        },
        business_address_1: {
            required: "Address line 1 is required"
        },
        business_address_1: {
            required: "Address line 2 is required"
        },
        business_town: {
            required: "City is required",
        },
        business_country: {
            required: "Country is required",
        },
        business_postal_code: {
            required: "Postal code is required",
            alphanumeric: "Please enter valid Postal code"
        },
        registered_fsa: {
            required: "Fsa is required",
        },
        registered_fsa_file: {
            fsafile: "Fsa certificate is required",
        },
        hygiene_certificate: {
            required: "Food hygiene certificate is required",
        },
        hygiene_certificate_file: {
            fhc: "Food hygiene certificate is required",
        },
        hygiene_rating: {
            number: "Please enter valid rating",
        },
        'can_you_deliver[]': {
            required: "Please select atlease one",
        },
        guests_max: {
            required: "Maximum is required",
        },
        guests_min: {
            required: "Minimum is required",
        },
        min_order: {
            required: "Minimum order is required",
        },
        min_order_amount: {
            minordervalue: "Minimum order amount is required",
            number: "Please enter Minimum order amount",
        },
        cuisine: {
            required: "Cuisine is required",
        },
        others_specifiy: {
            cuisineothers: "Cuisine others is required",
        },
        'extra_serivices[]': {
            required: "Please select atlease one",
        },
        'specialities[]': {
            required: "Please select atlease one",
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("type") == "radio" || element.attr("name") == "phone" || element.attr("name") == "cuisine[]") {
            error.insertAfter($(element).parent().parent());
        }else if (element.attr("name") == "can_you_deliver[]" || element.attr("name") == "extra_serivices[]" || element.attr("name") == "specialities[]") {
            error.insertAfter($(element).parent().parent());
        }  else {
            error.insertAfter(element);
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        form.submit();
    }
});



jQuery.validator.addMethod("fsafile", function (value, element) {
    if ($("input[name='registered_fsa']:checked").val() == "1" && $('input[name="registered_fsa_file"]')[0].files.length <= 0) {
        return false;
    }
    return true;
}, "This field is required.");

jQuery.validator.addMethod("fhc", function (value, element) {
    if ($("input[name='hygiene_certificate']:checked").val() == "1" && $('input[name="hygiene_certificate_file"]')[0].files.length <= 0) {
        return false;
    }
    return true;
}, "This field is required.");



jQuery.validator.addMethod("minordervalue", function (value, element) {
    if ($("input[name='min_order']:checked").val() == "1" && isNaN(parseInt($("input[name='min_order_amount']").val()))) {
        return false;
    }
    return true;
}, "This field is required.");

jQuery.validator.addMethod("cuisineothers", function (value, element) {
    if ($("#cuisine option:selected").text().toLowerCase() == "others" ) {
        return false;
    }
    return true;
}, "This field is required.");

$.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg !== value;
}, "Value must not equal arg.");

$.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0} KB');

$(document).on("change", "input[name=hygiene_certificate]", function () {
    var hygine_checked_status = $("input[name=hygiene_certificate]:checked").val();
    if(hygine_checked_status == 1){
        $('#hygine_rating_div').show();
    }else{
        $('#hygine_rating_div').hide();
    }
});


jQuery.validator.addMethod("hideguestmaxbaker", function (value, element) {
    var role_id = $('#role_id').val();
    if (role_id == "3" && value == '' ) {
        return false;
    }
    return true;
}, "Maximum is required");
jQuery.validator.addMethod("hideguestminbaker", function (value, element) {
    var role_id = $('#role_id').val();
    if (role_id == "3" && value == '') {
        return false;
    }
    return true;
}, "Minimum is required.");
jQuery.validator.addMethod("hideminorderonbaker", function (value, element) {
    var role_id = $('#role_id').val();
    if (role_id == "3" && value == '' ) {
        return false;
    }
    return true;
}, "Minimum order is required");
jQuery.validator.addMethod("hideminorderamountonbaker", function (value, element) {
    var role_id = $('#role_id').val();
    if (role_id == "3") {
        if($("input[name='min_order']:checked").val() == "1" && value == ''){
            return false;
        }
    }
    return true;
}, "Minimum order amount is required");
jQuery.validator.addMethod("hidecusineonbaker", function (value, element) {
    // var cuisine = $("#cuisine").val();
    var role_id = $('#role_id').val();
    if (role_id == "3" && value == '') {
        return false;
    }
    return true;
}, "Cuisine is required");




 $(function () {
    "use strict";
     //lazy load
      // $(".lazy").unveil(200, function() {
      //     $(this).load(function() {
      //       this.style.opacity = 1;
      //   });
      // });
    var origin, destination, map;
    if (localStorage.getItem('location') != '') {
        var location= localStorage.getItem('location');
        var city= localStorage.getItem('city');

        $('#location_input').val(location);
        $('#city').val(city);
        $('#business_town').val(city);

        $('#lat').val(localStorage.getItem('lat'));
        $('#long').val(localStorage.getItem('long'));
    }

    LocationInput();
});

    // get current Position
    $('#locationIcon').on('click',function(){
        GetMyCurrentLocation();

    });

    function GetMyCurrentLocation(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(setCurrentPosition);
        } else {
            alert("Geolocation is not supported by this browser.")
        }
    }

    function LocationInput() {
     var to_places = new google.maps.places.Autocomplete(document.getElementById('business_address_1'), { types: ['(regions)'] });
     var place = to_places.getPlace();


     google.maps.event.addListener(to_places, 'place_changed', function () {
        // console.log("place", place);
        //  console.log("Test",to_places.getPlace().address_components[7]);

        // console.log("to_places",to_places);
        var to_place = to_places.getPlace();
        var to_address = to_place.formatted_address;


        $('#business_address_1').val(to_address);
        $('#district').val(to_places.getPlace().address_components[2]['long_name'])
        localStorage.setItem('location',to_address);
        localStorage.setItem('district',to_places.getPlace().address_components[2]['long_name']);
        var place = to_places.getPlace();


        localStorage.setItem('lat',place.geometry.location.lat());
        localStorage.setItem('long',place.geometry.location.lng());

        $('#lat').val(place.geometry.location.lat());
        $('#long').val(place.geometry.location.lng());

        if(to_places.getPlace().address_components[7]){
            $("#business_postal_code").val(to_places.getPlace().address_components[7].short_name);
        }
        var geocoder = new google.maps.Geocoder();
        var latlng = {lat: parseFloat(place.geometry.location.lat()), lng: parseFloat(place.geometry.location.lng())};
        setcity(latlng);

    });
 }


    // get formatted address based on current position and set it to input
    function setCurrentPosition(pos) {
        var geocoder = new google.maps.Geocoder();
        var latlng = {lat: parseFloat(pos.coords.latitude), lng: parseFloat(pos.coords.longitude)};

        localStorage.setItem('lat',latlng.lat);
        localStorage.setItem('long',latlng.lng);

        geocoder.geocode({ 'location' :latlng  }, function (responses) {

            if (responses && responses.length > 0) {
                // console.log("responses",responses);
               $('#business_address_1').val(responses[0].formatted_address)
               $('#district').val(responses[1].address_components[3]['long_name'])
               localStorage.setItem('location',responses[0].formatted_address);
               localStorage.setItem('district',responses[1].address_components[3]['long_name']);

               $('#lat').val(latlng.lat);
               $('#long').val(latlng.lng);
               setcity(latlng);

           } else {
            alert("Cannot determine address at this location.")
        }
    });
    }


    function setcity(latlng,lat=false) {
       new google.maps.Geocoder().geocode({'latLng' : latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                var country = null, countryCode = null, city = null, cityAlt = null;
                var c, lc, component;
                for (var r = 0, rl = results.length; r < rl; r += 1) {
                    var result = results[r];

                    if (!city && result.types[0] === 'locality') {
                        for (c = 0, lc = result.address_components.length; c < lc; c += 1) {
                            component = result.address_components[c];

                            if (component.types[0] === 'locality') {
                                city = component.long_name;
                                break;
                            }
                        }
                    }
                    else if (!city && !cityAlt && result.types[0] === 'administrative_area_level_1') {
                        for (c = 0, lc = result.address_components.length; c < lc; c += 1) {
                            component = result.address_components[c];

                            if (component.types[0] === 'administrative_area_level_1') {
                                cityAlt = component.long_name;
                                break;
                            }
                        }
                    } else if (!country && result.types[0] === 'country') {
                        country = result.address_components[0].long_name;
                        countryCode = result.address_components[0].short_name;
                    }

                    if (city && country) {
                        break;
                    }
                }
                $('#city').val(city);
                $('#business_town').val(city);
                localStorage.setItem('city',city);

            }
        }
    });
   }
