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
	<div class="col-lg-9">
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
												data-parsley-required data-parsley-group="step1" autocomplete="off">{{ $thisPackage[$id]['description'] }}</textarea>
										</div>
										<div class="form-group">
											<label for="price">Price per Package</label>
											<input type="text" class="form-control" name="price" id="price" value="{{ $thisPackage[$id]['price'] }}" min="1" data-parsley-required data-parsley-type="number" data-parsley-group="step1" autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
								
								<div class="row">
									<div class="col-md-12 add-cat-more">
										<p class="text-primary text-right mt-3 mb-3"><i class="fas fa-plus-circle add-icon"></i> Add more category</p>
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
												<div class="row">
													<div class="col-md-12 remove-cat" style="text-align:right;">
														<i class="fas fa-minus-circle remove-cat-icon" data-catid="{{ $packageCatId }}"></i>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group mb-0">
															<label for="category_name">Name of the Category</label>
															<input type="text" class="form-control" name="category_name[{{ $packageCatId }}]"
																id="category_name" value="{{ $thisCategory[$packageCatId]['name'] }}" data-parsley-required autocomplete="off">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-0">
															<label for="no_of_items">Enter the number of item</label>
															<input type="text" class="form-control" name="no_of_items[{{ $packageCatId }}]" id="no_of_items" value="{{ $noOfItems }}" data-parsley-required data-parsley-type="number" min="1" autocomplete="off">
														</div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-md-12">
														<p class="add-more text-primary text-right mt-3 mb-3" data-catid="{{ $packageCatId }}" ><i class="fas fa-plus-circle add-icon"></i> Add more item</p>
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
														@endphp
														<div class="item-list item-list-{{ $packageCatId }}">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group mb-0">
																		<label>Item Name</label>
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
																	</div>
																</div>
																<div class="col-md-1 remove-item">
																	<label for="uname">&nbsp;</label>
																	<br>
																	<i class="fas fa-minus-circle remove-icon"></i>
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
	<div class="col-lg-3">
		<div class="single-area">
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
		</div>

		@endsection

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

		@section('script')
		<script type="text/javascript"
			src="{{ asset('admin/assets/js/smartwizard/jquery.smartWizard.min.js') }}"></script>
		<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
		<script>
			// "use strict";
			var itemLen = 1;
			var catId = 1;
			$(document).ready(function () {
				let form = $(".basicform");
				let parsleyConfig = {
					errorsContainer: function (parsleyField) {
						return parsleyField.$element.parent().parent();
					}
				};
				form.parsley();



				var btnFinish = $("<button></button>")
					.text("Finish")
					.addClass("btn btn-primary")
					.on("click", function (e) {
						form.parsley().validate();
						e.preventDefault();
						if (form.parsley().isValid()) {
							form.submit();
						}
					});

				// SmartWizard initialize
				$('#smartwizard').smartWizard({
					useURLhash: false,
					showStepURLhash: false,
					enableFinishButton: false,
					toolbarSettings: {
						toolbarPosition: "bottom",
						toolbarExtraButtons: [btnFinish],
					}
				});

				$(".sw-btn-prev").addClass('btn-primary').removeClass('btn-secondary');
				$(".sw-btn-next").addClass('btn-primary').removeClass('btn-secondary');

				// Autocomplete
				let categoryRows = JSON.parse('<?php echo json_encode($categories); ?>');
				let categoryAutoCompRows = categoryRows.map((res, index) => {
					res.value = res.name;
					res = res;
					return res;
				});

				let packageRows = JSON.parse('<?php echo json_encode($packages); ?>');
				let packageRowsObj = {};
				let packageAutoCompRows = packageRows.map((res, index) => {
					packageRowsObj[res.id] = res;
					res.value = res.name;
					res = res;
					return res;
				});
				let packageItems = JSON.parse('<?php echo json_encode($packageItems); ?>');
				let packageItemRowsObj = {};
				let packageItemAutoCompRows = [];
				let pItems = [];
				packageItems.map((res, index) => {
					if (packageItemRowsObj[res.package_id]) {
						pItems.push(res);
						packageItemRowsObj[res.package_id] = pItems;
					} else {
						pItems = [];
						pItems.push(res);
						packageItemRowsObj[res.package_id] = pItems;
					}
					packageItemAutoCompRows.push({
						value: res.name,
						id: res.id,
						description: res.description,
						spicy: res.spicy
					});
				});

				// console.log("packageItems", packageItems);
				console.log("packageItemRowsObj", packageItemRowsObj);
				// console.log("packageItemAutoCompRows", packageItemAutoCompRows);
				// console.log("packageAutoCompRows", packageAutoCompRows);

				$("#category_name").autocomplete({
					source: function (request, response) {
						let categoryAutoCompRowsFilter = categoryAutoCompRows.filter(function (item) {
							return item.value.toLowerCase().indexOf(request.term) >= 0;
						})
						response(categoryAutoCompRowsFilter);
						return;
					},
					select: function (e, ui) {
						//
					},
					change: function (e, ui) {
						// 
					}
				});

				$(".item-name").autocomplete({
					source: function (request, response) {
						let packageItemAutoCompRowsFilter = packageItemAutoCompRows.filter(function (item) {
							return item.value.toLowerCase().indexOf(request.term) >= 0;
						})
						response(packageItemAutoCompRowsFilter);
						return;
					},
					select: function (e, ui) {

						let clickPackageId = ui.item.id;
						console.log(ui.item);
						$(".item-name:focus").parent().closest(".row").find(".item-description").val(ui.item.description);
						$(".item-name:focus").parent().closest(".row").find(".item-spicy").prop("checked", false);
						if (ui.item.spicy) {
							$(".item-name:focus").parent().closest(".row").find(".item-spicy:first").prop("checked", true);
						} else {
							$(".item-name:focus").parent().closest(".row").find(".item-spicy:last").prop("checked", true);
						}
					},
					change: function (e, ui) {

					}
				});


				$(".sw-btn-prev").addClass('d-none');
				$(".sw-btn-group-extra").addClass('d-none');
				$("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
					console.log(stepPosition);
					if (stepPosition === 'first') {
						$(".sw-btn-next").removeClass('d-none');
						$(".sw-btn-prev").addClass('d-none');
						$(".sw-btn-group-extra").addClass('d-none');
					} else if (stepPosition === 'final') {
						if (form.parsley().validate("step1")) {
							$('#smartwizard').smartWizard("next");
							$(".sw-btn-prev").removeClass('d-none');
							$(".sw-btn-group-extra").removeClass('d-none');
							$(".sw-btn-next").addClass('d-none');
						} else {
							$('#smartwizard').smartWizard("prev");
							$(".sw-btn-group-extra").addClass('d-none');
						}
					}
				});

				$(document).on("click", ".add-cat-more", function () {
					catId++;
					console.log("==catId==",catId);
					let copyEl = '<div class="card card-'+catId+'"><div class="card-body" style="border: 1px solid grey;"><div class="row"><div class="col-md-12 remove-cat" style="text-align:right;"><i class="fas fa-minus-circle remove-cat-icon" data-catid="'+catId+'"></i></div></div><div class="row"><div class="col-md-6"><div class="form-group mb-0"><label for="category_name">Name of the Category</label><input type="text" class="form-control ui-autocomplete-input" name="category_name['+catId+']" id="category_name" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-6"><div class="form-group mb-0"><label for="no_of_items">Enter the number of item</label><input type="text" class="form-control" name="no_of_items['+catId+']" id="no_of_items" data-parsley-required="" data-parsley-type="number" min="1" autocomplete="off"></div></div></div><div class="row"><div class="col-md-12"><p class="add-more text-primary text-right mt-3 mb-3" data-catid="'+catId+'" data-itemlen="1"><i class="fas fa-plus-circle add-icon"></i> Add more item</p></div></div><div class="item-list item-list-'+catId+'"><div class="row"><div class="col-md-4"><div class="form-group mb-0"><label>Item Name</label><input type="text" class="form-control item-name ui-autocomplete-input" name="item[' + catId + '][name][1]" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-4"><div class="form-group mb-0"><label>Item Description</label><input type="text" class="form-control item-description" name="item[' + catId + '][description][1]" data-parsley-required=""></div></div><div class="col-md-3"><div class="form-group mb-0"><label for="uname">Spicy</label><br><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy" name="item[' + catId + '][spicy][1]" checked="" data-parsley-multiple="itemspicy">Yes</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy" name="item[' + catId + '][spicy][1]" data-parsley-multiple="itemspicy">No</label></div></div></div><div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon" data-catid="'+catId+'"></i></div></div></div></div></div>';
					// copyEl.find(".item-name").val("");
					// copyEl.find(".item-description").val("");
					// copyEl.find(".item-spicy").removeAttr("checked");
					// copyEl.find(".item-spicy").removeAttr("name");
					$(".cat-list").append(copyEl);
				});

				$(document).on("click", ".add-more", function () {
					// let copyEl = $(".item-list .row:first").clone();
					let thiCatId = $(this).data("catid");
					console.log("==thiCatId==",thiCatId);
					itemLen++;
					// itemLen = $(this).data("itemlen");
					console.log("===itemLen===",itemLen);
					let copyEl = '<div class="row"><div class="col-md-4"><div class="form-group mb-0"><label>Item Name</label><input type="text" class="form-control item-name ui-autocomplete-input" name="item[' + thiCatId + '][name][' + itemLen + ']" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-4"><div class="form-group mb-0"><label>Item Description</label><input type="text" class="form-control item-description" name="item[' + thiCatId + '][description][' + itemLen + ']" data-parsley-required=""></div></div><div class="col-md-3"><div class="form-group mb-0"><label for="uname">Spicy</label><br><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy" name="item[' + thiCatId + '][spicy][' + itemLen + ']" checked="" data-parsley-multiple="itemspicy">Yes</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy" name="item[' + thiCatId + '][spicy][' + itemLen + ']" data-parsley-multiple="itemspicy">No</label></div></div></div><div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon" data-catid="'+thiCatId+'"></i></div></div>';
					// copyEl.find(".item-name").val("");
					// copyEl.find(".item-description").val("");
					// copyEl.find(".item-spicy").removeAttr("checked");
					// copyEl.find(".item-spicy").removeAttr("name");
					$(".item-list-"+ thiCatId).append(copyEl);

					
					// $(this).attr("data-itemlen", itemLen);
				});

				$(document).on("click", ".remove-cat-icon", function () {
					let thiCatId = $(this).data("catid");
					if ($(".cat-list .card").length > 1) {
						$(this).closest(".card-"+ thiCatId).remove();
					}
				});

				$(document).on("click", ".remove-icon", function () {
					let thiCatId = $(this).data("catid");
					if ($(".item-list-"+ thiCatId + " .row").length > 1) {
						$(this).closest(".row").remove();
					}
				});
			});

		</script>

		@endsection

		<!-- JavaScript -->