@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Details Order : {{ $itemCourier[0]->order->order_no }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">

			@foreach($itemCourier as $key => $item)
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
					<div class="mb-3">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Update Process Order</button>	
						
						<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Update Process Order</h4>
									<button type="button" class="close" data-dismiss="modal">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<form action="{{ route('admin.order.process', $item->id)}}" method="POST">
									@csrf
								<div class="modal-body">
								
									<div class="item form-group">
										<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Description  <span class="text-danger"></span>
										</label>
										<div class="col-form-label col-md-10 col-sm-10 ">
											<input type="text" id="first-name" name="desc" required="required" class="form-control"/>
											{{-- <p class="text-black-50 font-weight-bold">{{ $item->user->name }}</p> --}}
										</div>
										{{-- <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Url : <span class="text-danger"></span>
										</label>
										<div class="col-form-label col-md-4 col-sm-4 "> --}}
											{{-- <input type="text" id="first-name" name="brandName" required="required" class="form-control"/> --}}
											{{-- <p class="text-black-50 font-weight-bold"><a target="_blank" href="{{ $item->item_url }}">{{ $item->item_url }}</a></p>
										</div> --}}
									</div>
									<div class="item form-group">
										<label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Status<span class="text-danger"></span>
										</label>
										<div class="col-form-label col-md-10 col-sm-10 ">
											<select name="item_status" id="" class="form-control">
												<option value="" selected disabled>--Select Item Status--</option>
												@foreach($itemStatus as $status)
												<option value="{{ $status->item_status_code }}" {{ ($item->item_status_id == $status->item_status_code) ? 'selected':'' }}>{{ $status->item_status_name }}</option>
												@endforeach
											</select>
										</div>
										
									</div>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</form>
							</div>
						</div>
					</div>
									
					</div>
					
					<div class="row">
						<div class="col-md-3 mb-3">
							<h5>{{ $item->user->name }}</h5>
							<h6>{{ $item->user->email }}</h6>
							<h6>{{ $item->user->phone}}</h6>
							<h6>Address</h6>

						</div>
						<div class="col-md-9 mb-3" style="border-left: 1px solid rgba(0,0,0,.09);">
							<ul class="list-unstyled timeline">

								@foreach($item->item_process as $itemProcess)
								<li>
									<div class="block">
										{{-- <div class="tags">
											<a href="#" class="tag">
												<span>Completed</span>
											</a>
										</div> --}}
										<div class="block_content">
											<h2 class="title">
												<a>{{ $itemProcess->desc}}</a>
											</h2>
											<div class="byline">
												<span>{{$itemProcess->datetime }}</span>
												
											</div>
											{{-- <p class="excerpt">
												Film festivals used to be do-or-die moments for movie makers. They
												were where you met the producers that could fund your project, and
												if the buyers liked your flick, they’d pay to Fast-forward and…
												<a>Read&nbsp;More</a>
											</p> --}}
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				
								
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