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
// echo "<pre>";
// print_r($packageItems);
// exit;
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
// echo "<pre>";
// print_r($thisPackageCategories);
// exit;

?>
<div class="row add-update">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="alert alert-danger none errorarea">
					<ul id="errors">

					</ul>
				</div>
				<h4 class="mb-3">{{ __('View package') }}</h4>

				<div class="col-md-6" style="margin:auto;">
					<p><strong>Name of the Package</strong>: {{ $thisPackage[$id]['name'] }}</p>
					<p><strong>Description of the Package</strong>: {{ $thisPackage[$id]['description'] }}</p>
					<p><strong>Price per Package</strong>: {{ $thisPackage[$id]['price'] }}</p>
					@if (isset($thisPackageCategories))
						@foreach ($thisPackageCategories as $thisPackageCategory)
							@php
							$packageCatAutoIncId = $thisPackageCategory["id"];
							$packageCatId = $thisPackageCategory["category_id"];
							$noOfItems = $thisPackageCategory["no_of_items"];
							@endphp
							<p><strong>Name of the Category</strong>: {{ $thisCategory[$packageCatId]['name'] }}</p>
							<p><strong>Enter the number of item</strong>: {{ $noOfItems }}</p>

							<p><strong>Package Items</strong></p>
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Description</th>
										<th>Spicy</th>
									</tr>
								</thead>
								<tbody>
								@if (isset($thisPackageItemsRow[$packageCatAutoIncId]))
									@foreach ($thisPackageItemsRow[$packageCatAutoIncId] as $k => $thisRow)
										@php
										$k++;
											$pItemId = $thisRow['id'];
											$name = $thisRow['name'];
											$description = $thisRow['description'];
										@endphp
										<tr>
											<td>{{ $name }}</td>
											<td>{{ $description }}</td>
											<td>
												@if ($thisRow['mild'] == 1)
													Mild
												@elseif ($thisRow['hot'] == 1)
													Hot
												@elseif ($thisRow['extra_hot'] == 1)
													Extra Hot
												@endif
											</td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
						@endforeach
					@endif
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
