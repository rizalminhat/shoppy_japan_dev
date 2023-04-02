@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
		<li class="breadcrumb-item"><a href="{{ route('admin.order.view')}}">Order List</a></li>
		<li class="breadcrumb-item"><a href="{{ route('admin.order.items', $item->order->id )}}">List Items</a></li>
		<li class="breadcrumb-item active"></a>Details Items</li>
	</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Order No : {{ $item->order->order_no }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">

			<div class="x_panel">
				<div class="x_title">
					<h2 class="text-black-50 font-weight-bold">Details Item</h2>
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
					<div class="item form-group">
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Buyer Name : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4 ">
							<p class="text-black-50 font-weight-bold">{{ $item->user->name }}</p>
						</div>
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Url : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4 ">
							<p class="text-black-50 font-weight-bold"><a target="_blank"href="{{ $item->item_url }}">{{ $item->item_url }}</a></p>
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Price (&#165) : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
							<p class="text-black-50 font-weight-bold">{{ $item->item_yenprice }}</p>
						</div>
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Quantity : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
							<p class="text-black-50 font-weight-bold">{{ $item->item_quantity }}</p>
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Subtotal Item Price (&#165) : </h4>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							<p class="text-black-50 font-weight-bold">{{ $item->item_subtotal_item }}</p>
						</div>
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Status : </h4>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							{{-- itemstatus_id
							itemstatus_orderstatus --}}
							@if($item->itemstatus_id == '0')
							<span class="badge badge-danger">{{$item->itemstatus_orderstatus}}</span>
							@elseif($item->itemstatus_id == '1')
							<span class="badge badge-success">{{$item->itemstatus_orderstatus}}</span>
							@else
							<span class="badge badge-warning">Unknown</span>
							@endif
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Services Charges (&#165) : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
							<p class="text-black-50 font-weight-bold">{{ $item->item_services }}</p>
						</div>
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Total Price (&#165) : <span class="text-danger"></span>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							<p class="text-black-50 font-weight-bold">{{ $item->item_subtotal }}</p>
						</div>
					</div>
					<div class="item form-group">
						<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Total Price (RM) : </h4>
						</label>
						<div class="col-form-label col-md-4 col-sm-4">
							<p class="text-black-50 font-weight-bold">{{ $item->item_total }}</p>
						</div>
					</div>					
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.itemimage')}}">
					@csrf
					<input type="hidden" name='item_id' value="{{$item->id }}" readonly>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">Item Name<span class="text-danger">*</span>
							</label>
							<div class="col-form-label col-md-4 col-sm-4">
								<input type="text" name="item_name" class="form-control" value="{{$item->item_name}}"/>
							</div>
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" >Item Image<span class="text-danger">*</span></label>
							<div class="col-form-label col-md-4 col-sm-4">
								<input id="img" class="form-control" type="file" name="item_image"/>
								@error('item_image')
								<div class="text-danger">{{ $message }}</div>
								@enderror
								<img class="img-fluid my-3" id="showImage"  width="40%" src="{{ (!empty($item->item_img)) ? asset('storage/upload/item_images/'.$item->item_img) : asset('/main/img/dummy-image-square.jpg') }}"
								alt="product image">
								
							</div>
						</div>

						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
								<button type="submit" class="btn btn-primary">Save</button>
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
@endsection