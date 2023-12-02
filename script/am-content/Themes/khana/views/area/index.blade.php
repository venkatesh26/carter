@extends('theme::layouts.app')

@section('content')
 <!-- map area start -->
    <!-- <section>
        <div class="map-area">
            <div class="container-fluid p-0">
                <div class="iframe-filter-map">
                   <div id="contact-map"></div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- map area end -->
<style>
.filter-main-area .single-restaturants {
    background-color: #ffffff;
}
</style>



    <!-- filter main area start -->
    <div class="filter-main-area" style='background-color: #F7F7F7;'>
        <div class="container">
            <div class="row pt-50">
                <div class="col-lg-6">
                    <!-- <div class="offer-title">
                        <h3><span id="total_resurent"></span> {{ __('Restaurants') }}</h3>
                    </div> -->
                </div>
                <!-- <div class="col-lg-6">
                    <div class="resturant-pagination f-right">
                        <div class="d-flex">
                            <div class="left-number">
                                <span id="from"></span> - <span id="to"></span>
                            </div>
                            <div class="center-number">
                                {{ __('of') }}
                            </div>
                            <div class="right-number" >
                                <span id="total"></span>
                            </div>
                            <div class="left-icon">
                                <a href="javascript:void(0)" id="last_page_url"><i class="fas fa-angle-left"></i></a>
                            </div>
                            <div class="right-icon">
                                <a href="javascript:void(0)" id="next_page_url"><i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="offer-dropdown f-right">
                        <div class="form-group">
                            <select class="form-control" id="order">
                                <option value="DESC">{{ __('Latest') }}</option>
                                <option value="ASC">{{ __('Old') }}</option>

                            </select>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="filter-left-section">
                        <!-- <div class="single-filter last">
                            <div class="filter-main-title">
                                <h4>{{ __('Filter By') }}</h4>
                            </div>
                        </div>
                        <div class="single-filter search-area">
                            <div class="filter-search-area">
                                <div class="form-group">
                                    <input type="text" id="restaurants_search" class="form-control" placeholder="{{ __('button_title') }}">
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="single-filter">
                            <div class="single-filter-title">
                                <span>{{ __('Select Location') }}</span>
                                <div class="sidebar-body">
                                    <div class="category-list">
                                        <nav>
                                            <ul>

                                               @php
                                                $locations=\App\Terms::where('type',2)->where('status',1)->get();
                                                $crntid=$info->id ?? 0;
                                               @endphp

                                               @foreach($locations as $key=> $row)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input @if($crntid ==$row->id) checked @endif type="radio" class="custom-control-input area" id="customCheck{{ $key }}" value="{{ $row->id }}" name="area">
                                                        <label class="custom-control-label" for="customCheck{{ $key }}">{{ $row->title }}</label>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="single-filter">
                            <div class="single-filter-title">
                                <span>Cuisine</span>
                                <div class="sidebar-body">
                                    <div class="category-list scroll">
                                        <nav>
                                            <ul>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa1" value="1" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa1">Indian</label>
                                                    </div>
                                                </li>

                                                 <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa1" value="2" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa1">Sri Lanka</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa1" value="3" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa1">Bangladeshi</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa4" value="4" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa4">Chinese</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa5" value="5" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa5">Thai</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa6" value="6" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa6">Italian</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa7" value="7" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa7">Japanese</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa8" value="8" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa8">Korean</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa9" value="9" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa9">English</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa10" value="10" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa10">Caribbean</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa11" value="11" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa11">Polish</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat" id="customCheckaa12" value="12" name="cuisine">
                                                        <label class="custom-control-label" for="customCheckaa12">Others</label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-filter">
                            <div class="single-filter-title">
                                <span>Delivery</span>
                                <div class="sidebar-body">
                                    <div class="category-list scroll">
                                        <nav>
                                            <ul>
                                               <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input delivery" value="1"  name="delivery">
                                                        <label class="custom-control-label" for="">Collection only</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input delivery" id="customCheckaa" value="2" name="delivery">
                                                        <label class="custom-control-label" >Delivery</label>
                                                    </div>
                                                    <!-- <div class="custom-control custom-checkbox">
                                                        <input  type="radio" class="custom-control-input cat"  value="3"  name="gfg">
                                                        <label class="custom-control-label" for="customCheckaa{{ $key }}">£20 up to 10miles and 50p per extra mile</label>
                                                    </div> -->
                                                </li>

                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="filter-right-section">
                        <div class="row" id="resturent_area">
                            <div class="loader-main-area d-none"><div class="loader-area"><div class="loader"></div></div></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- filter main area end -->

    <input type="hidden" id="location_slug" value="{{ $slug ?? '' }}">
    <input type="hidden" id="baseurl" value="{{ url('/') }}">
    <input type="hidden" id="location_id" value="{{ $info->id ?? 00 }}">


@endsection

@push('js')
<!-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}"></script>
<script type="text/javascript">
    "use strict";
    var current_lat= {{ $lat }};
    var current_long= {{ $long }};
    var current_zoom= {{ $zoom }};
    var default_image= '{{ asset('uploads/store.jpg') }}';
    var resturent_icon= '{{ asset('uploads/location.png') }}';
</script> -->
<script src="{{ theme_asset('khana/public/js/area.js') }}"></script>

@endpush
