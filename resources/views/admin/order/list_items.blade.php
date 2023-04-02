@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
<li class="breadcrumb-item"><a href="{{ route('admin.order.view')}}">Order List</a></li>
<li class="breadcrumb-item active">List Items</li>
</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Order No : {{ $items[0]->order->order_no }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel">
				<div class="x_title">
					{{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Status Item</a> --}}
					{{-- <button type="button" id="modalStatus" class="btn btn-primary" data-toggle="modal" data-target="#modalStatus">Update Status</button>	 --}}
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
				</div>
				
				
				<div class="x_content">
					<div class="text-right mb-3">
						<!--<button type="button" id="btnStatus" href="{{ route('admin.order.modalStatus')}}" class="btn btn-primary" data-type="status">Update Local Post Fee</button>  -->
						<button type="button" id="btnStatus" href="{{ route('admin.order.modalStatus')}}" class="btn btn-primary" data-type="status">Update Status</button>	
						{{-- <button type="button" id="btnProcess" href="{{ route('admin.order.modalProcess')}}" class="btn btn-primary" data-type="process">Process Order</button> --}}
						<a href="{{route('admin.pdf.order', $order->id)}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
					</div>
					<div class="row">
						<div class="card-box table-responsive">
							<table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
								<thead>
									<tr>
										<th><input type="checkbox" id="checkall" ></th>
										<th>No</th>
										<th>Image & Url</th>
										<th>Name</th>
										<th>Quantity</th>
										<th>Total Price (&#165)</th>
										<th>Total Price (RM)</th>
										
										<th>Status Item</th>
										<th>Item Description / Instructions</th>
										<th width="10%">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($items as $key => $item)
									<tr>
										<td><input type="checkbox" class="checkboxtest" value="{{ $item->id }}"></td>
										<td>{{ $key+1 }}</td>  
										<td>
											<a href="{{ (!empty($item->item_img)) ? asset('storage/upload/item_images/'.$item->item_img) : asset('/main/img/dummy-image-square.jpg') }}" target="_blank">
												<img class="img-fluid" id="showImage"  width="200px" src="{{ (!empty($item->item_img)) ? asset('storage/upload/item_images/'.$item->item_img) : asset('/main/img/dummy-image-square.jpg') }}">
											</a>
											<p class="my-2"><a href="{{$item->item_url}}" target="_blank">Item Link</a></p>
										</td>
										<td>{{ (!empty($item->item_name) ? $item->item_name:'No data') }}</td>
										<td>{{ $item->item_quantity }}</td>
										<td>{{ $item->item_subtotal }}</td>
										<td class="text-right">{{ $item->item_total }}</td>
										
										<td>
											@if($item->item_status_id == '0')										
											<span class="badge badge-danger">Not Available</span>
											<br>
												@if(!empty($item->item_remark))
												<span class="font-italic">Remark : {{$item->item_remark}}</span>
												@endif
											@elseif($item->item_status_id == '1')
											<span class="badge badge-success">Available</span>
											@elseif($item->item_status_id == '2')
											<span class="badge badge-warning">Processing</span>
											@else
											<span class="badge badge-warning">Unknown</span>
											@endif
										</td>
										<td class="text-danger">{{ !empty($item->item_desc) ? $item->item_desc: 'No data'}}</td>
										<td>
										<a href="{{ route('admin.order.detailsItem',$item->id) }}" type="button" class="btn btn-info btn-sm">View Item</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Order History</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
				
			
			<div class="x_content">
				<div class="row">
					<div class="col-md-3 mb-3">
						{{-- {{URL::current();}} --}}
						<h6>Address For Shipping</h6>
						<p class="my-0">{{ $order->order_address1 }}</p>
                        <p class="my-0">{{ $order->order_address2 }}</p>
                        <p class="my-0">{{ $order->order_address3 }}</p>
                        <p class="my-0">{{ $order->order_postcode }}, {{$order->order_city}}</p>
                        <p>{{ strtoupper($order->state_name) }}</p>
					</div>
					<div class="col-md-9 mb-3" style="border-left: 1px solid rgba(0,0,0,.09);">
						<ul class="list-unstyled timeline">

					
							<li>
								<div class="block" style="margin-left:40px">
									<div class="block_content">
										<h2 class="title">
											<span>Submit order by {{ $order->user_name }}</span>
										</h2>
										<div class="byline">
											<span>{{ \Carbon\Carbon::parse($order->submit_at)->format('d-m-Y h:i:s A') }}</span> 
											
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
							@if(!empty($order->order_shipping))
							<li>
								<div class="block" style="margin-left:40px">
									<div class="block_content">
										<h2 class="title">
											<span>Process Order</span>
										</h2>
										<div class="byline">
											<span>{{ \Carbon\Carbon::parse($order->order_process_date)->format('d-m-Y h:i:s A') }}</span> 
											
										</div>
										<p class="excerpt">
											Courier Fee (RM) : {{ $order->order_shipping }}
											
										</p>
										<p>
											Status Courier Fee : @if($order->shipping_payment_status == NULL) <span class="badge badge-danger">Waiting Payment</span> 
											@elseif($order->shipping_payment_status == '2')
											<span class="badge badge-success">Received</span>
											@endif
										</p>
									</div>
								</div>
							</li>
							@endif
							
							@if(!empty($order->tracking_no))
							<li>
								<div class="block" style="margin-left:40px">
									<div class="block_content">
										<h2 class="title">
											<span>Process Courier</span>
										</h2>
										<div class="byline">
											<span>{{ \Carbon\Carbon::parse($order->shipping_payment_date)->format('d-m-Y h:i:s A') }}</span> 
											
										</div>
										<p class="excerpt">
											Tracking No : {{ $order->tracking_no }}
											
										</p>
										<p>
											Courier Type : {{ $order->courier_name }}
											<a href="{{ $order->courier_url}}" type="button" class="btn btn-info btn-sm" target="blank">Track by courier</a>
										</p>
									</div>
								</div>
							</li>
							@endif

							@if($order->status_id == '4')
							<li>
								<div class="block" style="margin-left:40px">
									<div class="block_content">
										<h2 class="title">
											<span>Complete Order</span>
										</h2>
										<div class="byline">
											<span>{{ \Carbon\Carbon::parse($order->order_complete_date)->format('d-m-Y h:i:s A') }}</span> 
											
										</div>
										<p class="excerpt">
											Status Order : <span class="badge badge-success">Delivered</span>
											
										</p>
										<p>
										
										</p>
									</div>
								</div>
							</li>
							@endif
							{{-- <li>
								<div class="block" style="margin-left:40px">
									
									<div class="block_content">
										<h2 class="title">
											<a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
										</h2>
										<div class="byline">
											<span>13 hours ago</span> by <a>Jane Smith</a>
										</div>
										<p class="excerpt">
											Film festivals used to be do-or-die moments for movie makers. They
											were where you met the producers that could fund your project, and
											if the buyers liked your flick, they’d pay to Fast-forward and…
											<a>Read&nbsp;More</a>
										</p>
									</div>
								</div>
							</li>
							<li>
								<div class="block" style="margin-left:40px">
									
									<div class="block_content">
										<h2 class="title">
											<a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
										</h2>
										<div class="byline">
											<span>13 hours ago</span> by <a>Jane Smith</a>
										</div>
										<p class="excerpt">
											Film festivals used to be do-or-die moments for movie makers. They
											were where you met the producers that could fund your project, and
											if the buyers liked your flick, they’d pay to Fast-forward and…
											<a>Read&nbsp;More</a>
										</p>
									</div>
								</div>
							</li> --}}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /top tiles -->


<br />
<div id="modalStatus" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Status Item</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.check')}}" method="POST">
				@csrf
			<div class="modal-body" id="data_modal">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>

<div id="modalProcess" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Process Order</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.process', $items[0]->order->id)}}" method="POST">
				@csrf
			<div class="modal-body" id="data_modal2">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>
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
		 
    // $("#delete").click(function() {
	// 	var link = $(this).attr("href");
    //         getValueToDelete(link);
    //     });

		$("#btnStatus").click(function() 
		{
			var link = $(this).attr('href');
			var type = $(this).attr('data-type')
			getValueToUpdate(link,type);
		});

		$("#btnProcess").click(function() 
		{
			var link = $(this).attr('href');
			var id = $(this).attr('data-id')

			getValueToProcess(link,id);
		});

		
    });
	

	function getValueToProcess(link,id){
		$.ajax({
			url: link,
			method: 'POST',
			data:{
					_token: "{{ csrf_token() }}",
			},
			success: function (data) {
				$('#data_modal2').html(data);
				$('#modalProcess').modal('show');
			},
			error:function() {
				alert('No Modal');
			},
		});
    }




	function getValueToUpdate(link,type){
		
        var checkboxtest = [];
        
        $.each($(".checkboxtest:checked"), function() {
            checkboxtest.push($(this).val());
        });
    
        
        var select = checkboxtest ;
        console.log(select);
        if(select.length == 0)
        {
            alert("Please check at least one checkbox");  
        }
        else 
        {
			if(type == 'status')
			{
					$.ajax({
					url: link,
					method: 'POST',
					data:{
							select:select,
							_token: "{{ csrf_token() }}",
					},
					success: function (data) {
						$('#data_modal').html(data);
						$('#modalStatus').modal('show');
						input();
					},
					error:function() {
						alert('No Modal');
					},
				});
			}			
        }    
    }

	function input(){
		var iptCount= $("input[name='item_id[]']");
		$.each( iptCount, function( key, element ) {
		console.log( key + ": " + element );
		
		const select = document.getElementById('item-'+key);
		const text = document.getElementById('hidden-'+key);
		select.addEventListener('change', function handleChange(event) {
		const selectedValue = event.target.value; // 👉️ get selected VALUE

		if(selectedValue == '0')
		{
			$("#hidden-"+key).removeClass( "d-none" );
		}else{
			$("#hidden-"+key).addClass( "d-none" );
		}
		// 👇️ get selected VALUE even outside event handler
		// console.log(select.options[select.selectedIndex].value);

		// 👇️ get selected TEXT in or outside event handler
		// console.log(select.options[select.selectedIndex].text);
		});

		});
		
	}

</script>
@endsection