@extends('layouts.backend.app')
@section('content')
@php $currency=\App\Options::where('key','currency_icon')->select('value')->first(); $customerInfo=json_decode($info->data); @endphp 
<div class="section-body">
 <div class="row">
  <div class="col-12 col-md-12 col-lg-7">
    <div class="card">

      <div class="card-header">
        <h4>{{ __('Orders') }}</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!--<table class="table table-hover text-center">
            <thead>
              <tr>

                <th scope="col">{{ __('Item Name') }}</th>
                <th scope="col">{{ __('Quantity') }}</th>

              </tr>
            </thead>
            <tbody>

              @php
              $subtotal=0;
              $total=0;
              @endphp
              @foreach($orderdetails as $key => $itemrow)

              <?php

                // print_r($itemrow);
              ?>
              <tr>

                <td>{{ $itemrow["product_name"] ?? '' }}</td>
                <td>{{ $itemrow["qty"] ?? '' }}</td>


              </tr>
              @endforeach
            </tbody>
          </table>-->
             <div class="profile-widget package-info">
                <div class="card-header text-center">
                  <h4>Package Information</h4>
                </div>
                <div class="profile-widget-header"> <?php 
                  $total_amount = $info->total;
                  $dueAmount = 0;

                  $dueAmount = (env('DEPOSIT_PERCENT') / 100) * $info->total;

                  $balanceAmount = $info->total - $dueAmount;

                ?> @foreach($info["orderlistpack"] as $key => $itemrow) <?php
                    $item_list=[];
                    foreach($itemrow["packages"]["orderItems"] as $key1 => $itemrow1){
                      array_push($item_list, $itemrow1["product_name"]);
                    }
                    $item_list_str = implode(',', $item_list);
                  ?> <div class="profile-widget-description">
                    <div class="profile-widget-name">
                      <i class='fa fa-gift'></i> {{ __('Package Name') }}: <div class="text-muted d-inline font-weight-normal">{{ $itemrow["packages"]["name"] ?? '' }}</div>
                    </div>
                    <div class="profile-widget-name">
                      <i class="fa fa-bars" aria-hidden="true"></i> {{ __('Items') }}: <div class="text-muted d-inline font-weight-normal">
                        {{ $item_list_str ?? '' }}
                      </div>
                    </div>
                    <div class="profile-widget-name">
                      <i class='fa fa-user'></i> {{ __('Total Quantity') }}: <div class="text-muted d-inline font-weight-normal">{{ $itemrow["qty"] ?? '' }}</div>
                    </div>
                  </div> @endforeach 

                  <div class="card-header text-center">
                    <h4>Billing Details</h4>
                  </div>
                  <div class="profile-widget-description price-section">
                    <div class="profile-widget-name" style="border-bottom:1px solid #ddd"> {{ __('Amount Due') }}
                      <div class="text-muted d-inline font-weight-normal" style="float:right">{{ strtoupper($currency->value) }} {{ $balanceAmount ?? '' }}</div>
                    </div>
                    <div class="profile-widget-name" style="border-bottom:1px solid #ddd"> {{ __('Amount Paid') }}
                      <div class="text-muted d-inline font-weight-normal" style="float:right">{{ strtoupper($currency->value) }} {{ $dueAmount ?? '' }}</div>
                    </div>
                    <div class="profile-widget-name" style="border-bottom:1px solid #ddd"> {{ __('Total Amount') }}
                      <div class="text-muted d-inline font-weight-normal" style="float:right">{{ strtoupper($currency->value) }} {{ $total_amount ?? '' }}</div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="text-left">
          <!-- <p><b>Subtotal: </b>  {{ $subtotal }}</p> -->
         <!--  @if($info->coupon_id != null)
          <p><b>Discount Code: </b>  {{ $info->coupon->title ?? '' }}</p>
          <p><b>Discount: </b>  {{ $info->discount ?? '' }}</p>
          @endif -->
          <p><b>Total: </b>  {{ $info->total }}</p>
        </div>
      </div>
      @if($info->status != 0 && $info->status != 1)
      <div class="card-footer">
        <form method="post" id="basicform" action="{{ route('store.order.update',$info->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
           <!--  @if($info->order_type == 1)
            @if(empty($info->rider_id)) -->
            <!-- <div class="form-group col-lg-6">
              <label>{{ __('Select Rider') }}</label>
              <select class="form-control" name="rider">
                @foreach($riders  as $row)
                <option value="{{ $row->user_id }}">{{ $row->riders->name }} (#{{ $row->user_id }})</option>
                @endforeach
              </select>
            </div> -->
           <!--  @endif
            @endif -->
            @if($info->order_type == 1)
            <div class="form-group col-lg-6">
             @elseif(empty($info->rider_id))
             <div class="form-group col-lg-12">
               @else
               <div class="form-group col-lg-12">
                @endif
                <label>{{ __('Order Status') }}</label>
                <select class="form-control" name="status">
                  <option value="2" >{{ __('Order Pending') }}</option>
                  <option value="3" >{{ __('Accept Order') }}</option>
                  <option value="1">{{ __('Order Complete') }}</option>
                  <option value="0">{{ __('Decline Order') }}</option>
                  <!--
                  <option value="3">Accept Order</option>
                  <option value="0">Decline Order</option>
                  <option value="1">Order Complete</option> -->
                </select>
              </div>
            </div>

            <button type="submit" class="btn btn-primary col-12 submit-btn">{{ __('Processed') }}</button>

          </form>



        </div>
        @endif
      </div>

      <div class="card">
        <div class="card-header">
          <h5 class="text-primary text-center">{{ __('Order Log') }}</h5>
        </div>
        <div class="card-body">

          <div class="activities">

            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="far fa-paper-plane"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job text-primary">{{ $info->created_at->diffForHumans() }}</span>
                  <span class="bullet"></span>

                </div>
                <p>{{ __('Order Created') }}</p>
              </div>
            </div>

            @foreach($info->orderlog ?? []  as $key => $row)

            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
               @if($row->status == 3)
               <i class="fas fa-comment-alt"></i>
               @elseif($row->status == 2)
               <i class="far fa-paper-plane"></i>
               @elseif($row->status == 1)
               <i class="far fa-check-square"></i>
               @elseif($row->status == 0)
               <i class="fas fa-ban"></i>
               @endif
             </div>
             <div class="activity-detail">
              <div class="mb-2">
                <span class="text-job text-primary">{{ $row->created_at->diffForHumans() }}</span>
              </div>
              @if($row->status == 3)
              <p class="text-warning">{{ __('Order Accepted') }} </p>
              @elseif($row->status == 2)
              <p class="text-primary">{{ __('Order Created') }} </p>
              @elseif($row->status == 1)
              <p class="text-success">{{ __('Order Completed') }} </p>
              @elseif($row->status == 0)
              <p class="text-danger">{{ __('Order Cancelled') }} </p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
   <!--  <div class="card">
      <div class="card-header">
        <h5 class="text-primary text-center">{{ __('Rider Log') }}</h5>
      </div>
      <div class="card-body">

        <div class="activities">

      </div>
    </div>
  </div> -->
</div>
<div class="col-12 col-md-12 col-lg-5">
  <div class="card">

    <div class="card-body">

      <div class="profile-widget">

        <div class="profile-widget-header">

          <div class="profile-widget-items">
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">{{ __('Amount') }}</div>
              <div class="profile-widget-item-value">{{ number_format($total - $info->discount,2) }}</div>
            </div>
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">{{ __('Payment Mode') }}</div>
              <div class="profile-widget-item-value">{{ strtoupper($info->payment_method) }}</div>
            </div>
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">{{ __('Payment Status') }}</div>
              <div class="profile-widget-item-value">@if($info->payment_status == 0)
               <span class="text-danger">{{ __('Pending') }}</span>
               @elseif($info->payment_status == 1) <span class="text-success">{{ __('Completed') }}</span> @endif</div>

             </div>
             <div class="profile-widget-item">
              <div class="profile-widget-item-label">{{ __('Order Status') }}</div>
              <div class="profile-widget-item-value">@if($info->status == 0)
               <span class="text-danger">{{ __('Cancelled') }}</span>
               @elseif($info->status == 2) <span class="text-warning">{{ __('Pending') }}</span>
               @elseif($info->status == 3) <span class="text-primary">{{ __('Accepted') }}</span>
               @elseif($info->status == 1) <span class="text-success">{{ __('Completed') }}</span>
               @endif
             </div>

           </div>
         </div>
       </div>

       <div class="profile-widget-description">
        <div class="profile-widget-name">{{ __('Event Date') }}:
          @if(isset($customerInfo->event_date)):
          <div class="text-muted d-inline font-weight-normal"> {{ date('d-m-Y h:i A', strtotime($customerInfo->event_date)) }}</div>
          @endif
        </div>

        <div class="profile-widget-name">{{ __('Customer Name') }}:
          <div class="text-muted d-inline font-weight-normal"> {{ $customerInfo->name }}</div>
        </div>
        <div class="profile-widget-name">{{ __('Customer Phone') }}:
          <div class="text-muted d-inline font-weight-normal"> {{ $customerInfo->phone }}</div>
        </div>
        <?php
            //print_r($customerInfo);
        ?>
        @if($info->order_type == 1)
        <div class="profile-widget-name">{{ __(' Delivery Address') }}: <div class="text-muted d-inline font-weight-normal">{{ $customerInfo->flatno ?? '' }}<br>{{ $customerInfo->address ?? '' }}</div></div>
        @endif
        <div class="font-weight-bold mb-2">{{ __('Order Note') }}</div>
        {{ $customerInfo->note }}
      </div>
      @if($info->order_type == 1)

      <div class="card-footer text-center">
        <!-- <div class="font-weight-bold mb-2">{{ __('Order Location') }}</div>
        <div class="map_area" id="map"> -->

        </div>
         @if(!empty($info->riderinfo))
        <div class="card mt-4">
          <div class="card-header text-center">
            <h4>{{ __('Rider Information') }}</h4>
          </div>
          <div class="card-body">
           <img alt="image" src="{{ asset($info->riderinfo->avatar) }}"  height="100">
            @if(!empty($info->riderinfo->info))
            @php
            $data=json_decode($info->riderinfo->info->content);
            @endphp
            <p>{{ __('Name') }} : {{ $info->riderinfo->name }}</p>
            <p>{{ __('Phone1') }} : {{ $data->phone1 }}</p>
            <p>{{ __('Phone2') }} : {{ $data->phone2 }}</p>
            <p>{{ __('Address') }} : {{ $data->full_address }}</p>
            @endif
          </div>
        </div>
        @endif
      </div>

      @endif

    </div>
  </div>
</div>
</div>

</div>

@endsection
@section('script')
<script src="{{ asset('admin/js/form.js') }}"></script>

@if($info->order_type == 1)
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&sensor=false&callback=initialise"></script>
<script>
  "use strict";

  //if order type home delivery
   var resturent_lat = {{ $info->vendorinfo->location->latitude }};
   var resturent_long  = {{ $info->vendorinfo->location->longitude }};

   var customer_lat = {{ $customerInfo->latitude }};
   var customer_long = {{ $customerInfo->longitude }};

   var resturent_icon= '{{ asset('uploads/resturent.png') }}';
   var user_icon= '{{ asset('uploads/userpin.png') }}';

   var customer_name= '{{ $customerInfo->name }}';
   var resturent_name= '{{ $info->vendorinfo->name }}';
   var mainUrl= "{{ url('/') }}";

   //response will assign this function
   function success(res){
    $('.submit-btn').remove();
  }

</script>
<!-- google map api -->
<script src="{{ theme_asset('khana/public/js/store/storeorderdetails.js') }}"></script>
@else

<script type="text/javascript">
   "use strict";
   //response will assign this function
   function success(res){
    $('.submit-btn').remove();
  }

</script>
@endif


@endsection
