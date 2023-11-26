$("form[name='step1_form']").validate({
    errorElement: 'span',
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
    messages: {
        fname: {
            required: "First name is required"
        },
        lname: {
            required: "Last name is required"
        },
        email: {
            required: "Email is required",
            email: "Please enter valid email"
        },
        dob: {
            required: "Date of birth is required",
        },
        gender: {
            required: "Gender is required",
        },
        phone_number: {
            required: "Phone number is required",
            number: "Please enter valid Phone number",
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

$("form[name='step2_form']").validate({
    errorElement: 'span',
    rules: {
        business_name: {
            required: true
        },
        display_name: {
            required: true
        },
        // password: {
        //     required: true,
        // },
        // cpassword: {
        //     required: true,
        //     equalTo : "#password"
        // },
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
            number: true
        },
    },
    messages: {
        business_name: {
            required: "Business name is required"
        },
        display_name: {
            required: "Business display name is required"
        },
        // password: {
        //     required: "Password is required",
        // },
        // cpassword: {
        //     required: "Confirm password is required",
        //     equalTo : "Password and Confirm password should be same"
        // },
        address_l1: {
            required: "Address line 1 is required"
        },
        address_l2: {
            required: "Address line 2 is required"
        },
        city: {
            required: "City is required",
        },
        postcode: {
            required: "Postal code is required",
            number: "Please enter valid Postal code"
        },
        fsa: {
            required: "Fsa is required",
        },
        fas_file: {
            fsafile: "Fsa certificate is required",
        },
        food_hygiene_certificate: {
            required: "Food hygiene certificate is required",
        },
        food_hygiene_certificate_file: {
            fhc: "Food hygiene certificate is required",
        },
        hygiene_rating: {
            number: "Please enter valid rating",
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

$("form[name='step3_form']").validate({
    errorElement: 'span',
    rules: {
        'delivery_type[]': {
            required: true,
        },
        'specialities[]': {
            required: true,
        }
    },
    messages: {
        'delivery_type[]': {
            required: "Please select atlease one",
        },
        'specialities[]': {
            required: "Please select atlease one",
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("name") == "delivery_type[]" || element.attr("name") == "specialities[]") {
            error.insertAfter($(element).parent().parent());
        } else if (element.attr("type") == "radio") {
            error.insertAfter($(element).parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});
