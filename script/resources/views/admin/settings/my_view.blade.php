@extends('layouts.backend.app')

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
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
            </div>

        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('admin/js/form.js') }}"></script>
<script type="text/javascript">
    "use strict";

    function success(res) {
        $('.alert-danger').hide();
        $('.alert-success').show();
        $("#success").html("<li class='text-white'>" + res + "</li>");
    }

    function errosresponse(xhr) {
        $('.alert-success').hide();
        $('.alert-danger').show();
        $('#errors').append("<li class='text-white'>" + xhr.responseJSON.message + "</li>")

    }
</script>
@endsection