$("form[name='step1_form']").validate({
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
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr("type") == "radio" || element.attr("name") == "phone") {
            error.insertAfter($(element).parent().parent());
        } else {
            error.insertAfter(element);
        }
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

$("form[name='step2_form']").validate({
    errorElement: 'span',
    rules: {
        business_name: {
            required: true
        },
        business_disp_name: {
            required: true
        },
        business_logo_file: {
            required: true
        },
        business_logo_file: {
            required: true
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
            number: true
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
    },
    messages: {
        business_name: {
            required: "Business name is required"
        },
        business_disp_name: {
            required: "Business display name is required"
        },
        business_logo_file: {
            required: "Business logo name is required"
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
            number: "Please enter valid Postal code"
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

$("form[name='step3_form']").validate({
    errorElement: 'span',
    rules: {
        'can_you_deliver[]': {
            required: true,
        },
        guests_max: {
            required: true
        },
        guests_min: {
            required: true
        },
        min_order: {
            required: true,
        },
        min_order_amount: {
            minordervalue: true,
            number: true
        },
        cuisine: {
            required: true,
        },
        others_specifiy: {
            cuisineothers: true,
        },
        'extra_serivices[]': {
            required: true,
        },
        'specialities[]': {
            required: true,
        }
    },
    messages: {
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
        if (element.attr("name") == "can_you_deliver[]" || element.attr("name") == "extra_serivices[]" || element.attr("name") == "specialities[]") {
            error.insertAfter($(element).parent().parent());
        } else if (element.attr("type") == "radio") {
            error.insertAfter($(element).parent().parent());
        } else if (element.attr("name") == "cuisine[]") {
            error.insertAfter($(element).parent().parent());
        } else {
            error.insertAfter(element);
        }
    }
});
