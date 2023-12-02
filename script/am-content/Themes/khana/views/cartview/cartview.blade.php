@extends('theme::layouts.app')

@push('css')
<!-- <link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap-datetimepicker.min.css') }}"> -->
<style>
/*body{
    background: #ddd;
    min-height: 100vh;
    vertical-align: middle;
    display: flex;
    font-family: sans-serif;
    font-size: 0.8rem;
    font-weight: bold;
}*/
.title{
    margin-bottom: 5vh;
}
.card{
    margin: auto;
    /*max-width: 950px;
    width: 90%;*/
    box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border-radius: 1rem;
    border: transparent;
}
@media(max-width:767px){
    .card{
        margin: 3vh auto;
    }
}
.cart{
    background-color: #fff;
    padding: 4vh 5vh;
    border-bottom-left-radius: 1rem;
    border-top-left-radius: 1rem;
}
@media(max-width:767px){
    .cart{
        padding: 4vh;
        border-bottom-left-radius: unset;
        border-top-right-radius: 1rem;
    }
}
.summary{
    background-color: #ddd;
    border-top-right-radius: 1rem;
    border-bottom-right-radius: 1rem;
    padding: 4vh;
    color: rgb(65, 65, 65);
}
@media(max-width:767px){
    .summary{
    border-top-right-radius: unset;
    border-bottom-left-radius: 1rem;
    }
}
.summary .col-2{
    padding: 0;
}
.summary .col-10
{
    padding: 0;
}.row{
    margin: 0;
}
.title b{
    font-size: 1.5rem;
}
.main{
    margin: 0;
    padding: 2vh 0;
    width: 100%;
}
.col-2, .col{
    padding: 0 1vh;
}
a{
    padding: 0 1vh;
}
.close{
    margin-left: auto;
    font-size: 0.7rem;
}
.cartimg img{
    width: 3.5rem;
}
.back-to-shop{
    margin-top: 4.5rem;
}
h5{
    margin-top: 4vh;
}
hr{
    margin-top: 1.25rem;
}
form{
    padding: 2vh 0;
}
select{
    border: 1px solid rgba(0, 0, 0, 0.137);
    padding: 1.5vh 1vh;
    margin-bottom: 4vh;
    outline: none;
    width: 100%;
    background-color: rgb(247, 247, 247);
}
input{
    border: 1px solid rgba(0, 0, 0, 0.137);
    padding: 1vh;
    margin-bottom: 4vh;
    outline: none;
    width: 100%;
    background-color: rgb(247, 247, 247);
}
input:focus::-webkit-input-placeholder
{
      color:transparent;
}
/*.btn{
    background-color: #000;
    border-color: #000;
    color: white;
    width: 100%;
    font-size: 0.7rem;
    margin-top: 4vh;
    padding: 1vh;
    border-radius: 0;
}
.btn:focus{
    box-shadow: none;
    outline: none;
    box-shadow: none;
    color: white;
    -webkit-box-shadow: none;
    -webkit-user-select: none;
    transition: none;
}
.btn:hover{
    color: white;
}*/
a{
    color: black;
}
a:hover{
    color: black;
    text-decoration: none;
}
 #code{
    background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253) , rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
    background-repeat: no-repeat;
    background-position-x: 95%;
    background-position-y: center;
}
.close {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
}
</style>
@endpush

@section('content')
@php
$currency=\App\Options::where('key','currency_name')->select('value')->first();
@endphp

<!-- success-alert start -->
<div class="alert-message-area">
	<div class="alert-content">
		<h4 class="ale">{{ __('Your Settings Successfully Updated') }}</h4>
	</div>
</div>
<!-- success-alert end -->

<!-- error-alert start -->
<div class="error-message-area">
	<div class="error-content">
		<h4 class="error-msg"></h4>
	</div>
</div>
<!-- error-alert end -->

<!-- modal area start -->
<section>
	<div class="modal-area d-none">
		<div class="modal-main-content">

		</div>
	</div>
</section>
<!-- modal area end -->
<input type="hidden" id="gallery_url" value="{{ route('store.gallery') }}">
<!-- <section> -->
	<div class="store-area  single-caters">
		<div class="container-fluid">
		</div>
	</div>
	<div class="container">
		<div class="card">
	        <div class="row">
	            <div class="col-md-8 cart">
	                <div class="title">
	                    <div class="row">
	                        <div class="col"><h4><b>Shopping Cart</b></h4></div>
	                        <div class="col align-self-center text-right text-muted">{{ $package_count }} items</div>
	                    </div>
	                </div>

                    @php
                        $sno = 1;
                    @endphp
                    @if(isset($packages) && count($packages) )
                        @foreach($packages as $packRow)
                            @foreach($packRow as $customPackage)
                            <div class="row border-top border-bottom">
        	                    <div class="row main align-items-center cartimg">
        	                        <div class="col-2" style="min-height: 100px;background-color: #EE5E53;color: #fff;border-radius: 15px;display: flex;justify-content: center;align-items: center;">
        	                        	 <div class="row ">{{$customPackage["name"]}}</div>
        	                        </div>
        	                        <div class="col-2">
                                        <!-- <span class="close">&#10005;</span>  -->
                                        &euro;  {{$customPackage["price"]}}
                                        <!-- <span class="close">&#10005;</span> -->
                                        <input id="package_price_{{ $sno }}" type="hidden" value='{{$customPackage["price"]}}' /></div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="button" class="dec" id="dec" name="dec" value="-" data-sno="{{ $sno }}" data-packageid='{{$customPackage["id"]}}' />
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="quantity_{{ $sno }}" id="quantity_{{ $sno }}" onfocusout="quantity_direct_change({{$customPackage['id']}},{{ $sno }});" value='{{$customPackage["qty"]}}' maxlength="5" max="10" size="1" data-packageid='{{$customPackage["id"]}}' id="number" style="text-align: center;" />
                                            </div>
                                            <div class="col-3 text-end">
                                                <input type="button" class="inc" id="inc" name="inc" value="+" data-sno="{{ $sno }}" data-packageid='{{$customPackage["id"]}}' />
                                            </div>
                                        </div>
        	                        </div>
                                    <div class="col-3 text-end">&euro;
                                        <!-- <span class="close">&#10005;</span> -->
                                        <span id="total_package_price_{{ $sno }}">{{$customPackage["total_price"]}}</span>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button class="btn removepackage" data-packageid='{{$customPackage["id"]}}'><i class="ti ti-trash"></i></button>
                                    </div>
        	                    </div>
        	                </div>
                            @php
                                $sno++;
                            @endphp
                            @endforeach
                        @endforeach
                    @endif

                    @if($addon_total_amount > 0)
    	                <div class="row">
    	                    <div class="row main align-items-center cartimg">
    	                        <div class="col-2" style="min-height: 100px;background-color: #EE5E53;color: #fff;border-radius: 15px;display: flex;justify-content: center;align-items: center;">
    	                        	 <div class="row ">Add-on</div>
    	                        </div>

    	                        <div class="col">
    	                        </div>
    	                        <div class="col">&euro; {{number_format($addon_total_amount,2,'.',',')}} <span class="close">&#10005;</span></div>
    	                    </div>
    	                </div>
                    @endif
	                <!-- <div class="row border-top border-bottom">
	                    <div class="row main align-items-center cartimg">
	                        <div class="col-2" style="min-height: 100px;background-color: #EE5E53;color: #fff;border-radius: 15px;display: flex;justify-content: center;align-items: center;">
	                        	 <div class="row ">Shirt</div>
	                        </div>

	                        <div class="col">
	                        </div>
	                        <div class="col">&euro; 44.00 <span class="close">&#10005;</span></div>
	                    </div>
	                </div>  -->
	                <div class="back-to-shop">
                        @php
                            $previousUrl = url()->previous();
                            $secondPreviousUrl = redirect()->back()->header('Referer', url()->previous(-2))->getTargetUrl();
                            $baseUrl = Str::beforeLast($secondPreviousUrl, '/')."?view=same";
                        @endphp    
                        <a href="{{ $baseUrl }}"> &leftarrow;<span class="text-muted">Back to shop</span></a></div>
	            </div>
	            <div class="col-md-4 summary">
	                <div><h5><b>Summary</b></h5></div>
	                <hr>
	                <div class="row">
	                    <div class="col" style="padding-left:0;">SUB TOTAL</div>
	                    <div class="col text-right">&euro; {{ Cart::subtotal() }}</div>
	                </div>

                    <div class="row">
	                    <div class="col" style="padding-left:0;">TAX (VAT Included) </div>
	                    <div class="col text-right">&euro; {{ Cart::tax() }}</div>
	                </div>

	                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
	                    <div class="col">TOTAL PRICE</div>
	                    <div class="col text-right">&euro; {{ Cart::total() }}</div>
	                </div>
                    <div class="row text-center">
	                   <a href="{{ route('checkout.index') }}"><button class="btn">CHECKOUT</button></a>
                    </div>
	            </div>
	        </div>
	    </div>
    </div>
<!-- </section> -->
<!-- store area end -->
<br><br>

@endsection

@push('js')
<!--
<script src="{{ theme_asset('khana/public/js/bootstrap-datetimepicker.min.js') }}"></script>
-->
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function decrementValue(){
    var sno = $('#dec').attr('data-sno');
    var qty = $('#quantity_'+sno+'').val();
    var new_qty = parseInt(qty) - 1;
    if(parseInt(new_qty) < 1){
        return false;
    }else{
        $('#quantity_'+sno+'').val(new_qty);
        var package_price = $('#package_price_'+sno+'').val();
        var total_package_price = parseFloat(package_price) * parseFloat(new_qty);
        $('#total_package_price_'+sno+'').empty().html(total_package_price);
    }
}
function incrementValue(){
    var sno = $('#dec').attr('data-sno');
    var qty = $('#quantity_'+sno+'').val();
    var new_qty = parseInt(qty) + 1;
    $('#quantity_'+sno+'').val(new_qty);
    var package_price = $('#package_price_'+sno+'').val();
    console.log('sno',sno);
    var total_package_price = parseFloat(package_price) * parseFloat(new_qty);
    $('#total_package_price_'+sno+'').empty().html(total_package_price);
}

var baseurl= "{{ route('cart.calculatecart') }}";
function quantity_direct_change(data_packageid_val,sno){
    var qty_value = $('#quantity_'+sno+'').val(); 
    if(qty_value != ""){
        $.ajax({
            method: 'POST',
            url: baseurl,
            data:{
                "_token": "{{ csrf_token() }}",
                "package_id":data_packageid_val,
                "qty_value":qty_value,
                "type":"quantity_direct_change"
            },
            success: function(data) {
                // alert();return false;
                window.location.reload();
            },
            error: function(data){
                console.log("request failed");
            }
        });
    }    
}
jQuery(".inc").on("click", function(){
    var sno =jQuery(this).attr("data-sno");
    var packageid =jQuery(this).attr("data-packageid");
    $.ajax({
        method: 'POST',
        url: baseurl,
        data:{
            "_token": "{{ csrf_token() }}",
            "package_id":packageid,
            "type":"add"
        },
        success: function(data) {
            // alert();return false;
            window.location.reload();
        },
        error: function(data){
            console.log("request failed");
        }
    });
});
jQuery(".dec").on("click", function(){
    var sno =jQuery(this).attr("data-sno");
    var packageid =jQuery(this).attr("data-packageid");
    $.ajax({
        method: 'POST',
        url: baseurl,
        data:{
            "_token": "{{ csrf_token() }}",
            "package_id":packageid,
            "type":"sub"
        },
        success: function(data) {
            // alert();return false;
            window.location.reload();
        },
        error: function(data){
            console.log("request failed");
        }
    });
});

jQuery(".removepackage").on("click", function(){
    var sno =jQuery(this).attr("data-sno");
    var packageid =jQuery(this).attr("data-packageid");
    $.ajax({
        method: 'POST',
        url: baseurl,
        data:{
            "_token": "{{ csrf_token() }}",
            "package_id":packageid,
            "type":"remove"
        },
        success: function(data) {
            // alert();return false;
            window.location.reload();
        },
        error: function(data){
            console.log("request failed");
        }
    });
});

</script>

@endpush
