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


<div class="row add-update">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="alert alert-danger none errorarea">
					<ul id="errors">

					</ul>
				</div>
				<h4>{{ __('Add new package') }}</h4>



				<form method="post" class="basicform" action="{{ route('store.package.store') }}">
					@csrf

					<input type="hidden" name="status" value="1">
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
											<input type="text" class="form-control" name="name" id="name"
												data-parsley-required data-parsley-group="step1" autocomplete="off">
										</div>
										<div class="form-group">
											<label for="description">Description of the Package</label>
											<textarea class="form-control" rows="5" name="description" id="description"
												data-parsley-required data-parsley-group="step1" autocomplete="off"></textarea>
										</div>
										<div class="form-group">
											<label for="price">Price per Package</label>
											<input type="text" class="form-control" name="price" id="price"
												data-parsley-required data-parsley-type="number" min="1"
												data-parsley-group="step1" autocomplete="off">
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
									<!-- <div class="col-md-12 add-cat-more">
										<p class="text-primary text-right mt-3 mb-3"><i class="fas fa-plus-circle add-icon"></i> Add more category</p>
									</div> -->
									<div class="col-md-12 add-cat-more text-right">
										<p class="text-primary btn btn-success text-right mt-3 mb-3" style="color: #fff !important;"><i class="fas fa-plus-circle add-icon"></i> Add more category</p>
									</div>
								</div>
								<div class="cat-list cat-list-1">
									<div class="card card-1">
										<div class="card-body" style="border: 1px solid grey;">
											<div class="row">
												<div class="col-md-12 remove-cat" style="text-align:right;">
													<label for="uname">&nbsp;</label>
													<br>
													<i class="fas fa-minus-circle remove-cat-icon" data-catid="1"></i>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group mb-0">
														<label for="category_name">Name of the Category</label>
														<input type="text" class="form-control category_name" name="category_name[1]"
															id="category_name" data-parsley-required autocomplete="off">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group mb-0">
														<label for="no_of_items">Max number of item selected</label>
														<input type="text" class="form-control" name="no_of_items[1]" id="no_of_items"
															data-parsley-required data-parsley-type="number" autocomplete="off" maxlength="2" max="25" min="1">
													</div>
												</div>
												<div class="col-md-2">
													<label style="display: block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
													<p class="add-more btn btn-primary  text-right mt-0 mb-3" data-catid="1" style="color: #fff;">Add more item</p>
												</div>
											</div>
											<div class="row">
												<!-- <div class="col-md-12">
													<p class="add-more text-primary text-right mt-3 mb-3" data-catid="1" ><i class="fas fa-plus-circle add-icon"></i> Add more item</p>
												</div> -->
												

											</div>
											<div class="item-list item-list-1">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group mb-0">
															<label>Item Name</label>
															<input type="text" class="form-control item-name" name="item[1][name][1]"
																data-parsley-required>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group mb-0">
															<label>Item Description</label>
															<input type="text" class="form-control item-description"
																name="item[1][description][1]" data-parsley-required>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group mb-0">
															<label for="uname">Spicy</label>
															<br>
															<div class="form-check-inline">
																<label class="form-check-label">
																	<input type="radio" class="form-check-input item-spicy spicy-mild"
																		name="item[1][spicy][1]" value="mild" checked>Mild
																</label>
															</div>
															<div class="form-check-inline">
																<label class="form-check-label">
																	<input type="radio" class="form-check-input item-spicy spicy-hot"
																		name="item[1][spicy][1]" value="hot">Hot
																</label>
															</div>
															<div class="form-check-inline">
																<label class="form-check-label">
																	<input type="radio" class="form-check-input item-spicy spicy-extra_hot"
																		name="item[1][spicy][1]" value="extra_hot">Extra Hot
																</label>
															</div>
															<div class="form-check-inline">
																<label class="form-check-label">
																	<input type="radio" class="form-check-input item-spicy spicy-none"
																		name="item[1][spicy][1]" value="none">None
																</label>
															</div>
														</div>
													</div>
													<div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon"></i></div>

													<!-- <div class="col-md-1 remove-item">
														<label for="uname">&nbsp;</label>
														<br>
														<i class="fas fa-minus-circle remove-icon"></i>
													</div> -->
												</div>
											</div>
										</div>
									</div>
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
