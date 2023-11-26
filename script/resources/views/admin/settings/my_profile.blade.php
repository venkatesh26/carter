
@extends('layouts.backend.app')

@push('css')
<link rel="stylesheet" href="{{ theme_asset('khana/public/css/vanillaSelectBox.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanilla-js-dropdown@2.2.0/vanilla-js-dropdown.css">
@endpush

@section('content')

<div class="card">
    <div class="card-body">
       <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger none">
              <ul id="errors">

              </ul>
          </div>
          <div class="alert alert-success none">
              <ul id="success">

              </ul>
          </div>
      </div>
      <div class="col-md-12">


        <form method="post" id="basicform" name="basicform" enctype="multipart/form-data" action="{{ route('admin.users.updateprofile') }}">
            @csrf
            <h4 class="mb-20">{{ __('Edit Genaral Settings') }}</h4>
            <div class="custom-form">
                <!-- <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter User's  Name" value="{{ $info->name }}"> 
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Email"  value="{{ $info->email }}"> 
                </div>
                <div class="form-group">
                    <label for="file">{{ __('Avatar') }}</label>
                    <input type="file" name="file" id="file" class="form-control"  accept="image/*"> 
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info">{{ __('Update') }}</button>
                </div> -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="first_name">First Name</label>
                            <input  type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $info->first_name }}" data-parsley-required>                        
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="last_name">Last Name</label>
                            <input  type="text" class="form-control"  id="last_name" name="last_name" placeholder="Last Name" value="{{ $info->last_name }}" data-parsley-required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"  placeholder="Email Address" value="{{ $info->email }}" readonly data-parsley-required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="dob">Date of Birth</label>
                            <input  type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" value="{{ $info->dob }}" data-parsley-required>                        
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="business_name">Business Name</label>
                            <input  type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name" value="{{ $info->business_name }}" readonly data-parsley-required>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <label for="business_disp_name">Business Displayname</label>
                            <input  type="text" class="form-control" id="business_disp_name" name="business_disp_name" placeholder="Business Displayname" value="{{ $info->business_disp_name }}" data-parsley-required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label class="bl">Business Logo</label>
                            <input type="file" class="form-control" name="business_logo_file">
                        </div>
                        <?php if($info->business_logo_file){ ?>
                        <p><img src="{{$info->business_logo_file}}" style="width:200px;height:100px"></p>

                        <?php } ?>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <label for="business_desc">Business Description</label>
                            <textarea class="form-control" name="business_desc" id="business_desc" placeholder="Leave a comment here" style="height: 139px" data-parsley-required>{{ $info->business_desc }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <label for="business_address_1">Business Address 1</label>
                            <input  type="text" class="form-control" id="business_address_1" name="business_address_1" placeholder="Business Address 1" value="{{ $info->business_address_1 }}" data-parsley-required>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <label for="business_address_2">Business Address 2</label>
                            <input  type="text" class="form-control" id="business_address_2" name="business_address_2" placeholder="Business Address 2" value="{{ $info->business_address_2 }}" data-parsley-required>                        
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-floating mb-3">
                            <label for="business_town">Town/City</label>
                            <input  type="text" class="form-control" id="business_town" name="business_town" placeholder="Town/City" value="{{ $info->business_town }}" data-parsley-required>                        
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-floating mb-3">
                            <label for="business_country">County</label>
                            <input  type="text" class="form-control" id="business_country" name="business_country" placeholder="County" value="{{ $info->business_country }}" data-parsley-required>                        
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-floating mb-3">
                            <label for="business_postal_code">Post Code</label>
                            <input  type="text" class="form-control" id="business_postal_code" name="business_postal_code" placeholder="Post Code" value="{{ $info->business_postal_code }}" data-parsley-required>                            
                        </div>
                    </div>

                    <?php 
                    $registered_fsa = ($info->registered_fsa) ? $info->registered_fsa : 0;
                    $hygiene_certificate = ($info->hygiene_certificate) ? $info->hygiene_certificate : 0;
                    ?>
                    <div class="col-lg-4">
                        <div class="form-group radio-input pb-19">
                            <label>Registered with fsa?</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" <?php if($registered_fsa==1) echo "checked='checked'"; ?> type="radio" id="inlineCheckbox1" name="registered_fsa" value="1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" <?php if($registered_fsa==0) echo "checked='checked'"; ?> type="radio" id="inlineCheckbox2" name="registered_fsa" value="0">
                                <label class="form-check-label" for="inlineCheckbox2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group mb-3">
                            <label>If Yes</label>
                            <input type="file" class="form-control pb-5" name="registered_fsa_file">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group radio-input pb-19">
                            <label>Food hygiene certificate?</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" <?php if($hygiene_certificate==1) echo "checked='checked'"; ?> type="radio" id="inlineCheckbox3" name="hygiene_certificate" value="1" checked>
                                <label class="form-check-label" for="inlineCheckbox3">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" <?php if($hygiene_certificate==0) echo "checked='checked'"; ?> type="radio" id="inlineCheckbox4" name="hygiene_certificate" value="0">
                                <label class="form-check-label" for="inlineCheckbox4">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group mb-3">
                            <label>If Yes</label>
                            <input  type="file" class="form-control pb-5" name="hygiene_certificate_file">
                        </div>
                    </div>

                    <div class="col-lg-4" id="hygine_rating_div">
                        <div class="form-floating mb-3">
                            <label for="hygiene_rating">Hygiene Rating</label>

                            <select class="form-control" id="hygiene_rating" name="hygiene_rating">

                                <option value="">Select Rating</option>
                                <option value="1" <?php echo ($info->hygiene_rating== 1)?"selected":"";?>>1</option>
                                <option value="2" <?php echo ($info->hygiene_rating== 2)?"selected":"";?>>2</option>
                                <option value="3" <?php echo ($info->hygiene_rating== 3)?"selected":"";?>>3</option>
                                <option value="4" <?php echo ($info->hygiene_rating== 4)?"selected":"";?>>4</option>
                                <option value="5" <?php echo ($info->hygiene_rating== 5)?"selected":"";?>>5</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 cater_fields">
                    <h5 class="ssft">Cuisine</h5>
                </div>
                <div class="col-lg-6 cater_fields">
                    <div class="form-floating">
                        <select class="form-select" id="cuisine" name="cuisine" multiple="multiple" size="4" required>
                            <!-- <option value="">Select</option> -->
                            <option value="1">Indian</option>
                            <option value="2">Sri Lanka</option>
                            <option value="3">Bangladeshi</option>
                            <option value="4">Chinese</option>
                            <option value="5">Thai</option>
                            <option value="6">Italian</option>
                            <option value="7">Japanese</option>
                            <option value="8">Korean</option>
                            <option value="9">English</option>
                            <option value="10">Caribbean</option>
                            <option value="11">Polish</option>
                            <option value="12">Others</option>
                        </select>
                        <!--<label for="floatingSelect">Works with selects</label>-->
                    </div>
                </div>
                <div class="col-lg-6 cater_fields">
                    <div class="form-floating mb-3">
                        <label for="others_specifiy">Others specify</label>
                        <input  type="text" class="form-control" id="others_specifiy" name="others_specifiy"  placeholder="Others specify">
                    </div>
                </div>
                <div class="col-lg-12">
                    <h5 class="ssft">Can you deliver</h5>
                </div>
                <?php 
                    $can_you_deliver_arr = explode(',',$info->can_you_deliver);
                    $specialities = explode(',',$info->specialities);
                ?>
                <div class="col-lg-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="radius" name="can_you_deliver[]" value="Collection and free delivery up to 3 mile radius" <?php if(in_array("Collection and free delivery up to 3 mile radius", $can_you_deliver_arr)){echo "checked";}?>>
                        <label class="form-check-label" for="radius"> Collection and free delivery up to 3 mile radius </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="collection" name="can_you_deliver[]" value="Collection only" <?php if(in_array("Collection only", $can_you_deliver_arr)){echo "checked";}?>>
                        <label class="form-check-label" for="collection"> Collection only </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cost_miles" name="can_you_deliver[]" value="£20 up to 10 miles and £___ per extra mile" <?php if(in_array("£20 up to 10 miles and £___ per extra mile", $can_you_deliver_arr)){echo "checked";}?>>
                        <label class="form-check-label" for="cost_miles"> £20 up to 10 miles and £___ per extra mile </label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h5 class="ssft">No of guests you can take</h5>
                </div>
            
                <div class="col-lg-6 cater_fields">
                    <div class="form-floating mb-3">
                        <label for="guests_max">Maximum</label>
                        <input  type="text" class="form-control" id="guests_max" name="guests_max" placeholder="Maximum" value="{{ $info->guests_max }}">
                    </div>
                </div>
            
                <div class="col-lg-6 cater_fields">
                    <div class="form-floating mb-3">
                        <label for="guests_min">Minimum</label>
                        <input  type="text" class="form-control" id="guests_min" name="guests_min" placeholder="Minimum" value="{{ $info->guests_min }}">
                    </div>
                </div>

                <div class="col-lg-12 cater_fields">
                    <h5 class="ssft">Do you have minimum order amount?</h5>
                </div>
                <div class="col-lg-4 cater_fields">
                    <div class="form-group radio-input mt-3 cpb-08">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" name="min_order" value="1" checked>
                            <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox2" name="min_order" value="0">
                            <label class="form-check-label" for="inlineCheckbox2">No</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 cater_fields">
                    <div class="form-floating mb-3">
                        <label for="min_order_amount">If Yes</label>
                        <input  type="text" class="form-control floating pb-3" id="min_order_amount" name="min_order_amount" placeholder="If Yes" value="{{$info->min_order_amount }}">
                    </div>
                </div>
                
                
                <div class="col-lg-12 d-none" >
                    <h5 class="ssft">Extra Services with cost</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service upto 20 people £___">
                        <label class="form-check-label" for="waiter"> Provide waiter service upto 20 people £___</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service upto 20 - 50 people £___">
                        <label class="form-check-label" for="waiter"> Provide waiter service upto 20 - 50 people £___</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service 50+ £___">
                        <label class="form-check-label" for="waiter"> Provide waiter service 50+ £___</label>
                    </div>
                </div>
            
                <div class="col-lg-12">
                    <h5 class="ssft">Specialities</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wedding" name="specialities[]" value="Wedding catering-delivery is must" <?php if(in_array("Wedding catering-delivery is must", $specialities)){echo "checked";}?>>
                        <label class="form-check-label" for="wedding"> Wedding catering-delivery is must </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cooks" name="specialities[]" value="Home cooks" <?php if(in_array("Home cooks", $specialities)){echo "checked";}?>>
                        <label class="form-check-label" for="cooks"> Home cooks </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="catering" name="specialities[]" value="Corporate catering - delivery is must" <?php if(in_array("Corporate catering - delivery is must", $specialities)){echo "checked";}?>>
                        <label class="form-check-label" for="catering"> Corporate catering - delivery is must </label>
                    </div>
                </div>
            </div>

            

            <div class="col-lg-12 bottom-btn mt-2">
                <div>
                    <!-- <a href="{{ route('restaurant.register_step_2') }}"><button type="button" class="btn btn-danger">{{ __('Back') }}</button></a> -->
                    <button type="submit" id="step3_submit" class="btn btn-danger">{{ __('Update') }}</button>
                </div>
            </div>
        </form>

    </div>
    <!-- <div class="col-md-6">

        <form method="post" id="basicform1" action="{{ route('admin.users.passup') }}">
            @csrf
            <h4 class="mb-20">{{ __('Change Password') }}</h4>
            <div class="custom-form">
                <div class="form-group">
                    <label for="oldpassword">{{ __('Old Password') }}</label>
                    <input type="password" name="current" id="oldpassword" class="form-control"  placeholder="Enter Old Password" required> 
                </div>
                <div class="form-group">
                    <label for="password">{{ __('New Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control"  placeholder="Enter New Password" required> 
                </div>
                <div class="form-group">
                    <label for="password1">{{ __('Enter Again Password') }}</label>
                    <input type="password" name="password_confirmation" id="password1" class="form-control"  placeholder="Enter Again" required> 
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Change') }}</button>
                </div>
            </div>
        </form>
    </div> -->

</div>
</div>
</div>

@endsection

@push('js')

<script src="{{ asset('admin/js/profileupdate.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/vanillaSelectBox.js') }}"></script>

@endpush


@section('script')
<script src="{{ theme_asset('khana/public/js/jquery.validate.min.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/vanillaSelectBox.js') }}"></script>
<script type="text/javascript">
    "use strict";
    function success(res){
        $('.alert-danger').hide();
        $('.alert-success').show();
        $("#success").html("<li class='text-white'>"+res+"</li>");
    }
    function errosresponse(xhr){
        $('.alert-success').hide();
        $('.alert-danger').show();
        $('#errors').append("<li class='text-white'>"+xhr.responseJSON.message+"</li>")
        
    }
    $(document).ready(function () {
        // alert();
        let mySelect = new vanillaSelectBox("#cuisine",{
            // maxWidth: 500,
            // maxHeight: 400,
            // window:600
        });
    });
    $("form[name='basicform']").validate({
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
               required: "Postal code is required",
                alphanumeric: "Please enter valid Postal code"
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
            if (element.attr("type") == "radio" || element.attr("name") == "phone") {
                error.insertAfter($(element).parent().parent());
            } else {
                error.insertAfter(element);
            }
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
</script>
@endsection
