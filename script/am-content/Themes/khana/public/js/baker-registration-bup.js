$( "form[name='step1_form']" ).validate({
    rules: {
        fname: {
            required: true
        },
        lname: {
            required: true
        },
        email: {
            required: true,
            email: true
        },
        dob: {
            required: true
        },
        gender: {
            required: true
        },
        phone_number: {
            required: true,
            number: true
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("type") == "radio" || element.attr("name") == "phone_number") {
            error.insertAfter($(element).parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});

jQuery.validator.addMethod("fsafile", function (value, element) {
    if ($("input[name='fsa']:checked").val() == "yes" && $('input[name="fas_file"]')[0].files.length <= 0) {
        return false;
    }
    return true;
}, "This field is required.");

jQuery.validator.addMethod("fhc", function (value, element) {
    if ($("input[name='food_hygiene_certificate']:checked").val() == "yes" && $('input[name="food_hygiene_certificate_file"]')[0].files.length <= 0) {
        return false;
    }
    return true;
}, "This field is required.");

$( "form[name='step2_form']" ).validate({
    rules: {
        business_name: {
            required: true
        },
        display_name: {
            required: true
        },
        password: {
            required: true,
        },
        address_l1: {
            required: true
        },
        address_l2: {
            required: true,
        },
        city: {
            required: true,
        },
        postcode: {
            required: true,
            number: true
        },
        country: {
            required: true,
        },
        fsa: {
            required: true,
        },
        fas_file: {
            fsafile: true,
        },
        food_hygiene_certificate: {
            required: true,
        },
        food_hygiene_certificate_file: {
            fhc: true,
        },
        hygiene_rating: {
            required: true,
            number: true
        },
    },
    errorPlacement: function (error, element) {
        if (element.attr("type") == "radio") {
            error.insertAfter($(element).parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});

jQuery.validator.addMethod("minordervalue", function (value, element) {
    if ($("input[name='min_order']:checked").val() == "yes" && isNaN(parseInt($("input[name='min_order_value']").val()))) {
        return false;
    }
    return true;
}, "This field is required.");

$( "form[name='step3_form']" ).validate({
    rules: {
        'delivery_type[]': {
            required: true,
        },
        'specialities[]': {
            required: true,
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "delivery_type[]" || element.attr("name") == "specialities[]") {
            error.insertAfter($(element).parent().parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});
