@extends('layouts.backend.app')
@section('content')
<div class="row">
 <div class="col-lg-9">      
  <div class="card">
   <div class="card-body">
     <div class="alert alert-danger none errorarea">
      <ul id="errors">

      </ul>
    </div>
    <h4>{{ __('Edit Coupon') }}</h4>
    <form method="post" id="basicform" action="{{ route('store.coupon.update',$info->id) }}">
     @csrf
     @method('PUT')
     <div class="custom-form pt-20">

       @php
       $arr['title'] = 'Coupon Code';
       $arr['id'] = 'name';
       $arr['type'] = 'text';
       $arr['placeholder'] = 'Coupon Code';
       $arr['name'] = 'title';
       $arr['value'] = $info->title;
       $arr['is_required'] = true;

       echo  input($arr);

       $arr['title']= 'percent';
       $arr['id']= 'percent';
       $arr['type']= 'number';
       $arr['placeholder']= 'Enter percent of amount';
       $arr['name']= 'percent';
       $arr['value'] = $info->count;
       $arr['is_required'] = true;

       echo  input($arr);

       $arr['title']= 'Expired Date';
       $arr['id']= 'expired_date';
       $arr['type']= 'date';
       $arr['placeholder']= 'Enter Expired Date';
       $arr['name']= 'expired_date';
       $arr['value'] = $info->slug;
       $arr['is_required'] = true;

       echo  input($arr);    
       @endphp

     </div>
   </div>
 </div>

</div>
<div class="col-lg-3">
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
    <option value="1" @if($info->status==1) selcted @endif>{{ __('Published') }}</option>
    <option value="2" @if($info->status==2) selcted @endif>{{ __('Draft') }}</option>

  </select>
</div>
</div>
</div>
</div>
</div>
</form>
@endsection

@section('script')
<script src="{{ asset('admin/js/form.js') }}"></script>
@endsection