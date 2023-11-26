@extends('layouts.backend.app')
@section('content')

@section('style')
<link href="{{ asset('admin/assets/css/smartwizard/smart_wizard.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/smartwizard/smart_wizard_theme_arrows.min.css') }}" rel="stylesheet"
	type="text/css" />
<link href="{{ asset('admin/assets/css/smartwizard/smart_wizard_theme_dots.min.css') }}" rel="stylesheet"
	type="text/css" />
<link href="{{ asset('admin/assets/css/smartwizard/smart_wizard_theme_circle.min.css') }}" rel="stylesheet"
	type="text/css" />
@endsection

<style>
.add-more.btn,.remove-cat-icon.btn{
	cursor: pointer;
}
</style>
<?php
// echo $id;exit;
$thisPackage = [];
foreach ($packages as $value)
{
   $thisPackage[$value["id"]] = $value;
}
$thisPackageItems = [];
foreach ($packageItems as $value)
{
   $thisPackageItems[$value["package_id"]][$value["package_category_id"]][] = $value;
}
$thisCategory = [];
foreach ($categories as $value)
{
   $thisCategory[$value["id"]] = $value;
}

$thisPackageCategories = [];
foreach ($packageCategories as $value)
{
   $thisPackageCategories[$value["id"]] = $value;
}

$thisPackageItemsRow = [];
if (isset($thisPackageItems[$id])) {
	$thisPackageItemsRow = $thisPackageItems[$id];
}

// echo $thisPackageItems[$id]['name'];exit;
// echo "<pre>";
// print_r($thisCategory);
// exit;
// $noOfItems = (int) $thisPackage[$id]['no_of_items'];



?>
<div class="row add-update">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="alert alert-danger none errorarea">
					<ul id="errors">

					</ul>
				</div>
				<h4>{{ __('Edit package') }}</h4>



				<form method="post" class="basicform" action="{{route('store.package.update',$id)}}">
					@csrf
					@method('PUT')

					<input type="hidden" value="1" name="status">
					<!-- SmartWizard html -->
					<div id="smartwizard" class="sw-main sw-theme-arrows mt-5">
						<ul class="nav nav-tabs step-anchor">
							<li class="nav-item">
								<a class="nav-link" href="#step-1"> <strong>Step 1</strong>
									<!--<br>This is step description-->
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#step-2"> <strong>Step 2</strong>
									<!--<br>This is step description-->
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">Name of the Package</label>
											<input type="text" class="form-control" name="name" id="name" value="{{ $thisPackage[$id]['name'] }}"
												data-parsley-required data-parsley-group="step1" autocomplete="off">
										</div>
										<div class="form-group">
											<label for="description">Description of the Package</label>
											<textarea class="form-control" rows="5" name="description" id="description"
												data-parsley-required data-parsley-group="step1" autocomplete="off" style="white-space: pre-wrap;">{{ $thisPackage[$id]['description'] }}</textarea>
										</div>
										<div class="form-group">
											<label for="price">Price per Package</label>
											<input type="text" class="form-control" name="price" id="price" value="{{ $thisPackage[$id]['price'] }}" min="1" data-parsley-required data-parsley-type="number" data-parsley-group="step1" autocomplete="off">
										</div>
										<div class="form-group">
											<label for="halal">Halal Status</label><br>
											<input type="checkbox" class="" name="halal" id="halal"
												data-parsley-group="step1" autocomplete="off" value="1"> Yes, All foods are halal
										</div>
									</div>
								</div>
							</div>
							<div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">

								<div class="row">
									<div class="col-md-12 add-cat-more text-right">
										<p class="text-primary btn btn-success text-right mt-3 mb-3" style="color: #fff !important;"><i class="fas fa-plus-circle add-icon"></i> Add more category</p>
									</div>
								</div>
								<div class="cat-list cat-list-1">
									@if (isset($thisPackageCategories))
										@foreach ($thisPackageCategories as $thisPackageCategory)
										@php
										$packageCatAutoIncId = $thisPackageCategory["id"];
										$packageCatId = $thisPackageCategory["category_id"];
										$noOfItems = $thisPackageCategory["no_of_items"];
										@endphp
										<div class="card card-{{ $packageCatId }}">
											<div class="card-body" style="border: 1px solid grey;">
												<!-- <div class="row">
													<div class="col-md-12 remove-cat" style="text-align:right;">
														<i class="fas fa-minus-circle remove-cat-icon" data-catid="{{ $packageCatId }}"></i>
													</div>
												</div> -->
												<div class="row">
													<div class="col-md-4">
														<div class="form-group mb-0">
															<label for="category_name">Name of the Category</label>
															<input type="text" class="form-control category_name" name="category_name[{{ $packageCatId }}]"
																id="category_name" value="{{ $thisCategory[$packageCatId]['name'] }}" data-parsley-required autocomplete="off">

																<input type="hidden" class="form-control " name="pcategory_name[{{ $packageCatId }}]" value="{{$packageCatAutoIncId }}" autocomplete="off">
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group mb-0">
															<label for="no_of_items">Max number of item selected</label>
															<input type="text" class="form-control" name="no_of_items[{{ $packageCatId }}]" id="no_of_items" value="{{ $noOfItems }}" data-parsley-required data-parsley-type="number" min="1" maxlength="2" max="25" autocomplete="off">
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group mb-0">
															<label style="display: block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
															<p class="add-more btn btn-primary  text-right mt-0 mb-3" data-catid="{{ $packageCatId }}"  style="color: #fff;">
																<!-- <i class="fas fa-plus-circle add-icon"></i>  -->
															Add more item</p>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group mb-0 remove-cat">
															<label style="display: block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
															<p class=" remove-cat-icon btn btn-danger  text-left mt-0 mb-3" data-catid="{{ $packageCatId }}"  style="color: #fff;"> Remove this category</p>
														</div>
													</div>
												</div>

												@if (isset($thisPackageItemsRow[$packageCatAutoIncId]))
													@foreach ($thisPackageItemsRow[$packageCatAutoIncId] as $k => $thisRow)
														@php
														$k++;
															$pItemId = $thisRow['id'];
															$name = $thisRow['name'];
															$description = $thisRow['description'];
															$mildChecked = ($thisRow['mild'] == 1) ? "checked='checked'" : '' ;
															$hotChecked = ($thisRow['hot'] == 1) ? "checked='checked'" : '' ;
															$exHotChecked = ($thisRow['extra_hot'] == 1) ? "checked='checked'" : '' ;
															$noneChecked = ($thisRow['none'] == 1) ? "checked='checked'" : '' ;
														@endphp
														<div class="item-list item-list-{{ $packageCatId }}">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group mb-0">
																		<label>Item Name</label>
																		<input type="hidden" class="form-control pItemId" id="item[{{ $packageCatId }}][pItemId][{{ $k }}]" name="item[{{ $packageCatId }}][pItemId][{{ $k }}]" value="{{ $pItemId }}">
																		<input type="text" class="form-control item-name" name="item[{{ $packageCatId }}][name][{{ $k }}]"
																			value="{{ $name }}" data-parsley-required>
																	</div>
																</div>
																<div class="col-md-4">
																	<div class="form-group mb-0">
																		<label>Item Description</label>
																		<input type="text" class="form-control item-description"
																			name="item[{{ $packageCatId }}][description][{{ $k }}]" value="{{ $description }}" data-parsley-required>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group mb-0">
																		<label for="uname">Spicy</label>
																		<br>
																		<div class="form-check-inline">
																			<label class="form-check-label">
																				<input type="radio" class="form-check-input item-spicy spicy-mild"
																					name="item[{{ $packageCatId }}][spicy][{{ $k }}]]" value="mild" {{ $mildChecked }}>Mild
																			</label>
																		</div>
																		<div class="form-check-inline">
																			<label class="form-check-label">
																				<input type="radio" class="form-check-input item-spicy spicy-hot"
																					name="item[{{ $packageCatId }}][spicy][{{ $k }}]]" value="hot" {{ $hotChecked }}>Hot
																			</label>
																		</div>
																		<div class="form-check-inline">
																			<label class="form-check-label">
																				<input type="radio" class="form-check-input item-spicy spicy-extra_hot"
																					name="item[{{ $packageCatId }}][spicy][{{ $k }}]]" value="extra_hot" {{ $exHotChecked }}>Extra Hot
																			</label>
																		</div>
																		<div class="form-check-inline">
																			<label class="form-check-label">
																				<input type="radio" class="form-check-input item-spicy spicy-none"
																					name="item[{{ $packageCatId }}][spicy][{{ $k }}]]" value="none" {{ $noneChecked }}>None
																			</label>
																		</div>
																	</div>
																</div>
																<div class="col-md-1 remove-item">
																	<label for="uname">&nbsp;</label>
																	<br>
																	<p class="btn btn-danger  text-right mt-0 mb-3 remove-icon" style="color: #fff;font-size: inherit;" data-catid="{{ $packageCatId }}">Remove</p>
																	<!-- <i class="fas fa-minus-circle remove-icon"></i> -->
																</div>
															</div>
														</div>
													@endforeach
												@endif
											</div>
										</div>
										@endforeach
									@endif
								</div>


							</div>
						</div>
					</div>
			</div>
		</div>

	</div>
	<!-- <div class="col-lg-3"> -->
		<!-- <div class="single-area">
			<div class="card">
				<div class="card-body">
					<h5>{{ __('Publish') }}</h5>
					<hr>
					<div class="btn-publish">
						<button type="submit" class="btn btn-primary col-12 basicbtn"><i class="fa fa-save"></i> {{
							__('Save')
							}}</button>
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
						<option value="1">{{ __('Published') }}</option>
						<option value="2">{{ __('Draft') }}</option>

					</select>
				</div>
			</div>
		</div> -->

		@endsection

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

		@section('script')
		<script src="{{ asset('admin/assets/js/smartwizard/jquery.smartWizard.min.js') }}"></script>
		<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
		<script>
			var categoryRows = JSON.parse('<?php echo json_encode($categories); ?>');
			var packageRows = JSON.parse('<?php echo json_encode($packages); ?>');
			var packageItems = JSON.parse('<?php echo json_encode($packageItems); ?>');
		</script>
		<script type="text/javascript" src="{{ asset('admin/assets/js/package.js') }}"></script>

		@endsection

		<!-- JavaScript -->
