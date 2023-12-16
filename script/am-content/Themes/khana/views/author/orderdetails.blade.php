@extends('theme::layouts.app') @push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}"> @endpush @section('content') @php $currency=\App\Options::where('key','currency_icon')->select('value')->first(); $customerInfo=json_decode($info->data); @endphp <div class="order-details-area mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <!--<table class="table table-hover text-center"><thead><tr><th scope="col">{{ __('Item Name') }}</th><th scope="col">{{ __('Quantity') }}</th></tr></thead><tbody>
									 @foreach($orderdetails as $key => $itemrow)
					                  <tr><th class="text-left">{{ $itemrow["product_name"] ?? '' }}</th><th class="text-center">{{ $itemrow["qty"] ?? '' }}</th></tr>
					                @endforeach

									 @php
									$subtotal=0;
									@endphp
									@foreach($info->orderlist as $key => $itemrow)
									@php
									$total= $itemrow->total*$itemrow->qty+$subtotal;
									$subtotal = $total;
									@endphp
									<tr><td>{{ $itemrow->products->title ?? '' }}</td><td>{{ $itemrow->qty ?? '' }}</td><td>{{ strtoupper($currency->value) }}{{ $itemrow->total*$itemrow->qty }}</td></tr>
									@endforeach
								</tbody></table>-->
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
										foreach($itemrow["orderItems"] as $key1 => $itemrow1){
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
                  </div> @endforeach <div class="card-header text-center">
                    <h4>Delivery Details</h4>
                  </div>
                  <div class="profile-widget-description delivery-section">
                    <div class="profile-widget-name"> {{ __('Event Date') }}
                      <div class="text-muted d-inline font-weight-normal" style="float:right"> {{ $customerInfo->event_date ?? '' }}</div>
                    </div>
                  </div>
                  <div class="card-header text-center">
                    <h4>Billing Details</h4>
                  </div>
                  <div class="profile-widget-description price-section">
                     <div class="profile-widget-name" style="border-bottom:1px solid #ddd"> {{ __('Grand Total') }}
                      <div class="text-muted d-inline font-weight-normal" style="float:right">{{ strtoupper($currency->value) }} {{ $info->grand_total ?? '' }}</div>
                    </div>
                     @if($info->coupon_id != null)
                       <div class="profile-widget-name" style="border-bottom:1px solid #ddd"> {{ __('Discount') }}
                        <div class="text-muted d-inline font-weight-normal" style="float:right">{{ strtoupper($currency->value) }} {{ $info->discount ?? '' }}</div>
                      </div>
                    @endif
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
          </div>
        </div>
        <div class="card mt-20">
          <div class="card-header">
            <div class="row">
              <div class="col-sm-6">
                <h5 class="text-dark">{{ __('Order Log') }}</h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
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
                  </div> @foreach($info->orderlog ?? [] as $key => $row) <div class="activity">
                    <div class="activity-icon bg-primary text-white shadow-primary"> @if($row->status == 3) <i class="fas fa-comment-alt"></i> @elseif($row->status == 2) <i class="far fa-paper-plane"></i> @elseif($row->status == 1) <i class="far fa-check-square"></i> @elseif($row->status == 0) <i class="fas fa-ban"></i> @endif </div>
                    <div class="activity-detail">
                      <div class="mb-2">
                        <span class="text-job text-primary">{{ $row->created_at->diffForHumans() }}</span>
                      </div> @if($row->status == 3) <p class="text-warning">{{ __('Order Accepted') }} </p> @elseif($row->status == 2) <p class="text-primary">{{ __('Order Created') }} </p> @elseif($row->status == 1) <p class="text-success">{{ __('Order Completed') }} </p> @elseif($row->status == 0) <p class="text-danger">{{ __('Order Cancelled') }} </p> @endif
                    </div>
                  </div> @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card">
          <div class="card-body">
            <div class="profile-widget">
              <div class="profile-widget-header">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">{{ __('Amount') }}</div>
                    <div class="profile-widget-item-value">{{ strtoupper($currency->value) }} {{ $total_amount ?? '' }}</div>
                  </div>
                  <!-- <div class="profile-widget-item"><div class="profile-widget-item-label">{{ __('Shipping') }}</div><div class="profile-widget-item-value">{{ strtoupper($currency->value) }}{{ $info->shipping }}</div></div> -->
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">{{ __('Payment Mode') }}</div>
                    <div class="profile-widget-item-value">{{ strtoupper($info->payment_method) }}</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">{{ __('Payment Status') }}</div>
                    <div class="profile-widget-item-value">@if($info->payment_status == 0) <span class="text-danger">{{ __('pending') }}</span> @elseif($info->payment_status == 1) <span class="text-success">{{ __('Completed') }}</span> @endif </div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">{{ __('Order Status') }}</div>
                    <div class="profile-widget-item-value"> @if($info->status == 0) <span class="text-danger">{{ __('Cancelled') }}</span> @elseif($info->status == 2) <span class="text-warning">{{ __('Pending') }}</span> @elseif($info->status == 3) <span class="text-primary">{{ __('Accepted') }}</span> @elseif($info->status == 1) <span class="text-success">{{ __('Completed') }}</span> @endif </div>
                  </div>
                </div>
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name">{{ __('Name') }}: <div class="text-muted d-inline font-weight-normal"> {{ $customerInfo->name }}</div>
                </div>
                <div class="profile-widget-name">{{ __('Phone') }}: <div class="text-muted d-inline font-weight-normal"> {{ $customerInfo->phone }}</div>
                </div> @if($info->order_type == 1) <div class="profile-widget-name">{{ __(' Delevery Address') }}: <div class="text-muted d-inline font-weight-normal"> {{ $customerInfo->address }}</div>
                </div> @endif <div class="font-weight-bold mb-2">{{ __('Order Note') }}</div>
                <p>{{ $customerInfo->note }}</p>
              </div>
            </div>
          </div>
        </div> @if(!empty($info->vendorinfo->info->content)) @php $json = json_decode($info->vendorinfo->info->content); @endphp <div class="card mt-4">
          <div class="card-header text-center">
            <h4>{{ __('Restaurant Information') }}</h4>
          </div>
          <div class="card-body"> @if(!empty($info->vendorinfo)) <p>{{ __('Restaurant Name') }} : {{ $info->vendorinfo->business_name }}</p>
            <p>{{ __('Phone') }} : {{ $json->phone1 }}</p>
            <!-- <p>{{ __('Phone2') }} : {{ $json->phone2 }}</p> -->
            <p>{{ __('Address') }} : {{ $json->full_address }}</p> @endif
          </div>
        </div> @endif
      </div>
    </div>
  </div>
</div>
<br>
<br>
<br>
<br> @endsection @if($info->order_type == 1 && $info->status==3 && !empty($info->liveorder)) @push('js') @php $customerInfo=json_decode($info->data); @endphp <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&sensor=false&callback=initialise"></script>
<script>
  "use strict";
  var resturent_lat = {
    {
      $info - > vendorinfo - > location - > latitude
    }
  };
  var resturent_long = {
    {
      $info - > vendorinfo - > location - > longitude
    }
  };
  var customer_lat = {
    {
      $customerInfo - > latitude
    }
  };
  var customer_long = {
    {
      $customerInfo - > longitude
    }
  };
  var resturent_icon = '{{ asset('
  uploads / resturent.png ') }}';
  var user_icon = '{{ asset('
  uploads / userpin.png ') }}';
  var my_icon = '{{ asset('
  uploads / delivery.png ') }}';
  var customer_name = '{{ $customerInfo->name }}';
  var resturent_name = '{{ $info->vendorinfo->name }}';
  var mylat = {
    {
      $info - > liveorder - > latitute
    }
  };
  var mylng = {
    {
      $info - > liveorder - > longlatitute
    }
  };
</script>
<script src="{{ theme_asset('khana/public/js/frontend/order.js') }}"></script> @endpush @endif