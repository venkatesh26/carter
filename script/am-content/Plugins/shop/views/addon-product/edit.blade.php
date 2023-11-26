@extends('layouts.backend.app')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="alert alert-danger none errorarea">
          <ul id="errors">

          </ul>
        </div>
        <h4>{{ __('Edit Addon Product') }}</h4>
        <form method="post" id="basicform" action="{{ route('store.addon-product.update',$info->id) }}">
          @csrf
          @method('PUT')
          <div class="custom-form pt-20">
            <!-- <div class="form-group">
              <label for="price">Price</label>
              <input type="number" step="any" placeholder="Product Price" name="price" class="form-control" id="price" required="" value="{{ $info->price }}" autocomplete="off">
            </div> -->

            <div class="row">
              <div class="col-md-4">
                <div class="form-group mb-0">
                  <label>Addon Name</label>
                  <input type="text" class="form-control item-name" name="item[1][name][1]" data-parsley-required maxlength="100" value="{{ $info->name }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group ">
                  <label>Addon Description</label>
                  <textarea type="text" class="form-control item-name" name="item[1][description][1]" data-parsley-required > {{ $info->description }} </textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group mb-0">
                  <label>Price</label>
                  <input type="text" class="form-control item-price" name="item[1][price][1]" data-parsley-required data-parsley-type="number" min="1" maxlength="5" value="{{ $info->price }}">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="btn-publish">
                  <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> {{ __('Save') }}</button>
                </div>
              </div>
            </div>

          </div>
      </div>
    </div>

  </div>
  <!-- <div class="col-lg-3">
    <div class="single-area">
      <div class="card">
        <div class="card-body">
          <h5>{{ __('Publish') }}</h5>
          <hr>
          <div class="btn-publish">
            <button type="submit" class="btn btn-primary col-12"><i class="fa fa-save"></i> {{ __('Save') }}</button>
          </div>
        </div>
      </div>
    </div>
    <div class="single-area">
      <div class="card sub">
        <div class="card-body">
          <h5>{{ __('Status') }}</h5>
          <hr>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="status">
            <option value="1" @if($info->status==1) selected @endif>{{ __('Published') }}</option>
            <option value="2" @if($info->status==2) selected @endif>{{ __('Draft') }}</option>

          </select>
        </div>
      </div>
    </div>
  </div> -->
</div>
</form>
@endsection
@section('script')
<script src="{{ asset('admin/js/addon.js') }}"></script>
@endsection