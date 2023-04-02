@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->

	<li class="breadcrumb-item"><a href="{{ route('admin.product.view')}}">Product List</a></li>
	<li class="breadcrumb-item active">Edit</li>
	{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
	</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Edit Product : {{ ucfirst($product->product_name) }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel">
				<div class="x_title">
					{{-- <h2>Form Design <small>different form elements</small></h2> --}}
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
						<li>
							<a class="close-link"><i class="fa fa-close"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.product.update', $product->id)}}">
						@csrf

						<div class="item form-group">
							<label
								class="col-form-label col-md-2 col-sm-2"
								for="last-name"
								>Shopping Site <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<select name="siteName" class="form-control">
									<option value="" selected disabled>--Select shopping sites--</option>
									@foreach($sites as $site)
									<option value="{{ $site->id }}" {{ ($product->site_id == $site->id) ? 'selected':''}}>{{ $site->site_name }}</option>
									@endforeach
									
								</select>
								@error('siteName')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Product Name<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" name="productName" required="required" class="form-control" value="{{ old('productName') ??  $product->product_name }} "/>
								@error('productName')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Product Url<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" name="productURL" required="required" class="form-control" value="{{ old('productName') ??  $product->product_url }} "/>
								@error('productURL')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Product Price (YEN)<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" name="productPrice" required="required" class="form-control" value="{{ old('productPrice') ??  $product->product_price }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onkeyup="yenfunc()" id="yenprice"/>
								<span class="text-danger">Currency rate {{ $configinfo->currency_yentomyr }}</span>

								@error('productPrice')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Product Price (RM)<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input id="rmprice" type="number" step="0.01" name="productPriceRm" required="required" class="form-control" value="{{ old('productPriceRm') ??  $product->product_price_rm }}" />
								@error('productPriceRm')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Product Status<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<select name="productStatus" id="" class="form-control">
									<option value="" selected disabled>--Select Status--</option>
									<option value="0" {{ ($product->product_status == '0') ? 'selected':''}}>Not Active</option>
									<option value="1" {{ ($product->product_status == '1') ? 'selected':'' }}>Active</option>
								</select>
								@error('productStatus')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2" >Product Image<span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6">
								<input id="img" class="form-control" type="file" name="productImage"/>
								@error('productImage')
								<div class="text-danger">{{ $message }}</div>
								@enderror
								<img class="img-fluid my-3" id="showImage"  width="50%" src="{{ (!empty($product->product_img)) ? asset('storage/upload/product_images/'.$product->product_img) : '' }}" alt="product image">
								
							</div>
						</div>

						
						{{-- <div class="ln_solid"></div> --}}
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
								{{-- <button class="btn btn-primary" type="button">Cancel</button>
								<button class="btn btn-primary" type="reset">Reset</button> --}}
								<button type="submit" class="btn btn-success">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /top tiles -->


<br />

{{-- </div> --}}

<!-- /page content -->

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#img').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
<script>
function yenfunc()
{
	yen = document.getElementById("yenprice");

	myr = document.getElementById("rmprice");

	myr.value = parseFloat((yen.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2); //parseFloat(yen.value) * 0.035;

}
</script>
@endsection