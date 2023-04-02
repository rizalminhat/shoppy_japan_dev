@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
		
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Details Order : {{ $orders[0]->order_no }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">

			@foreach($orders[0]->items as $key => $item)
			<div class="x_panel">
				<div class="x_title">
					<h2 class="text-black-50 font-weight-bold">Item {{ $key + 1 }}</h2>
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
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.order.check', $item->id )}}">
						@csrf
						<input type="text" name="order_id" value="{{ $orders[0]->id }}">
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Buyer Name : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4 ">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $orders[0]->user->name }}</p>
							</div>
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Url : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4 ">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold"><a target="_blank"href="{{ $item->item_url }}">{{ $item->item_url }}</a></p>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Yen Price : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_yenprice }}</p>
							</div>
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Rm Price : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_rmprice }}</p>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Quantity : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_quantity }}</p>
							</div>
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Sub Total (RM) : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_subtotal }}</p>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Services Rate (RM) : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_services }}</p>
							</div>
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Total Services Rate (RM) : <span class="text-danger"></span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<p class="text-black-50 font-weight-bold">{{ $item->item_subtotal_services }}</p>
							</div>
						</div>
						
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Status : </h4>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<select name="status_id" class="form-control">
									<option value="" selected="" disabled="">--Select Item Status--</option>
									
									<option value="0" {{ ($item->item_status_id == '0') ? 'selected':''}}>Not Available</option>
									<option value="1" {{ ($item->item_status_id == '1') ? 'selected':''}}>Available</option>
									
								</select>
							</div>
							
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 " for="first-name"><h5 class="text-black-50 font-weight-bold">Total Price (RM) : </h5>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
								<h4 class="text-black-50 font-weight-bold">{{ $item->item_total }}</h4>
							</div>
							
						</div>
						
						{{-- <div class="ln_solid"></div> --}}
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
								{{-- <button class="btn btn-primary" type="button">Cancel</button>
								<button class="btn btn-primary" type="reset">Reset</button> --}}
								<button type="submit" class="btn btn-success" name="btnOrder">Confirm Status Item {{ $key + 1}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			@endforeach
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
@endsection