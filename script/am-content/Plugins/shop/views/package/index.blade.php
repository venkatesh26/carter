@section('style')

@endsection
@extends('layouts.backend.app')

@section('content')

<div class="card">
	<div class="card-body">
		<div class="row mb-30">
			<div class="col-lg-6">
				<h4>{{ __('Package List') }}</h4>
			</div>
			@if($auth_id != 1)
			<div class="col-lg-6">
				<div class="add-new-btn">
					<a href="{{ route('store.package.create') }}" class="btn btn-primary f-right">{{ __('Add New') }}</a>
				</div>
			</div>
			@endif
		</div>
		<div class="cart-filter mb-20">

			<!-- <a href="{{ route('store.package.index') }}">{{ __('All') }} <span>({{ App\Package::where('user_id',$auth_id)->count() }})</span></a>
			<a href="?st=1">{{ __('Published') }} <span>({{ App\Package::where('user_id',$auth_id)->where('status',1)->count() }})</span></a>
			<a href="?st=2">{{ __('Drafts') }} <span>({{ App\Terms::where('type',6)->where('auth_id',$auth_id)->where('status',2)->count() }})</span></a> -->
			<!--<a href="?st=trash" class="trash">{{ __('Trash') }} <span>({{ App\Terms::where('type',6)->where('auth_id',$auth_id)->where('status',0)->count() }})</span></a>-->
		</div>
		<div class="card-action-filter">
			<div class="row mb-10">
				<div class="col-lg-6">
					@php
					$fAction = route('store.products.destroy');
					if(auth()->user()->role->id == 1) {
						$fAction = route('admin.shop.bulkaction');
					}
					@endphp
					<form id="basicform" method="post" action="{{ $fAction }}">
						@csrf
						<!-- <div class="d-flex">
							<div class="single-filter">
								<div class="form-group">
									<select class="form-control" name="status">
										<option>{{ __('Bulk Actions') }}</option>
										<option value="publish">{{ __('Publish') }}</option>
										<option value="drafts">{{ __('Drafts') }}</option>
										@if(auth()->user()->role->id == 1)
										<option value="approve">{{ __('Approve') }}</option>
										<option value="decline">{{ __('Decline') }}</option>
										<option value="disapprove">{{ __('DisApprove') }}</option>
										@endif
										<option value="trash">{{ __('Move to Trash') }}</option>
										<option value="delete">{{ __('Delete Permanently') }}</option>
									</select>
								</div>
							</div>
							<div class="single-filter">
								<button type="submit" class="btn btn-primary mt-1 ml-2">{{ __('Apply') }}</button>
							</div>
						</div> -->
					</div>
					<div class="col-lg-6">
						<div class="single-filter f-right">
							<div class="form-group">

								<!-- <input type="text" id="data_search" class="form-control" placeholder="Enter Value"> -->

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive custom-table">
				<table class="table">
					<thead>
						<tr>
							<th class="am-select">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="checkAll">
									<label class="custom-control-label" for="checkAll"></label>
								</div>
							</th>
							<th class="am-title">{{ __('Package Name') }}</th>
							<th class="am-title">{{ __('Customer Name') }}</th>
							<!-- <th class="am-tags">{{ __('Description') }}</th> -->
							<th class="am-tags">{{ __('Price') }}</th>
							<th class="am-tags">{{ __('Status') }}</th>
							<!-- <th class="am-tags">{{ __('Approved Status') }}</th> -->
							@if(auth()->user()->role->id == 1)
								<th class="am-tags">{{ __('Action') }}</th>
							@endif
							<th class="am-title">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($packages as $package)
						<tr data-rowid="{{ $package->id }}">
							<th>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $package->id }}" value="{{ $package->id }}">
									<label class="custom-control-label" for="customCheck{{ $package->id }}"></label>
								</div>
							</th>
							<td>{{ $package->name }}</td>
							<td>{{ auth()->user()->first_name }}</td>

							<!-- <td>{{ $package->description }}</td> -->
							<td>{{ $package->price }}</td>
							<td>{{ $package->status == 1 ? "Published" : "Draft" }}</td>
							<!-- <td>
								{{ $package->approved == 1 ? "Approved" : "Not Approved" }}
							</td> -->
							@if(auth()->user()->role->id == 1)
							<td>
								@if($package->approved == 0)
								<button type="button" class="btn btn-success approve" >Approve</button>
								<button type="button" class="btn btn-danger decline" >Decline</button>
								@endif
								@if($package->approved == 1)
								<!-- <button type="button" class="btn btn-danger disapprove" >Disapprove</button> -->
								@endif
								@if($package->approved == 2)
								<button type="button" class="btn btn-success approve" >Approve</button>
								@endif
							</td>
							@endif
							<td>
								{{ $package->title }}
								@if(auth()->user()->role->id == 1)
								<div class="hover">
									<a href="{{ route('admin.shop.package.show',$package->id) }}" class="last">{{ __('View') }}</a>
								</div>
								@else
								<div class="hover">
									<button type="button" class="btn btn-primary" >
										<a class="text-white" href="{{ route('store.package.edit',$package->id) }}">{{ __('Edit') }}</a>
									</button>
									<button type="button" class="btn btn-success" >
										<a class="text-white" href="{{ route('store.package.show',$package->id) }}" class="last">{{ __('View') }}</a>
									</button>
								</div>
								@endif
							</td>
						</tr>
						@endforeach

					</tbody>
<!-- 
					<tfoot>
						<tr>
							<th class="am-select">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input checkAll" id="checkAll">
									<label class="custom-control-label" for="checkAll"></label>
								</div>
							</th>
							<th class="am-title">{{ __('Package Name') }}</th>
							<th class="am-title">{{ __('Customer Name') }}</th>
							<th class="am-tags">{{ __('Description') }}</th> 
							<th class="am-tags">{{ __('Price') }}</th>
							<th class="am-tags">{{ __('Status') }}</th>
							<th class="am-tags">{{ __('Approved Status') }}</th>
							@if(auth()->user()->role->id == 1)
								<th class="am-tags">{{ __('Action') }}</th>
							@endif
							<th class="am-title">{{ __('Action') }}</th>
						</tr>
					</tfoot> -->
				</table>
				{{ $packages->links() }}
			</div>
		</div>
	</div>



@endsection

@section('script')
<script src="{{ asset('admin/js/form.js') }}"></script>
<script type="text/javascript">
"use strict";
	//success response will assign this function
	 function success(res){
	 	location.reload();
	 }
	 function errosresponse(xhr){

	 	$("#errors").html("<li class='text-danger'>"+xhr.responseJSON[0]+"</li>")
	 }

	 $(document).on("click", ".approve, .disapprove, .decline", function () {
		let approve = 0;
		let id = $(this).closest("tr").data("rowid");
		if ($(this).hasClass("approve")) {
			approve = 1;
		} else if ($(this).hasClass("decline")) {
			approve = 2;
		}
		if ([0,1,2].indexOf(approve) >= 0 && id) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				}
			});
			var formData = {
				title: jQuery('#title').val(),
				description: jQuery('#description').val(),
			};
			var request = $.ajax({
				url: "{{ route('admin.shop.approvepackage') }}",
				type: "POST",
				data: { id: id, approve: approve },
				success:function(res){
					if (res.status) {
						location.reload();
					}
				}
			});
		}

	});
</script>
@endsection
