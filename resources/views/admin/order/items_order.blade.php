@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
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

					<button type="button" id="btnStatus" href="{{ route('admin.order.modalStatus')}}" class="btn btn-primary" data-type="status">Update Status</button>	

					<button type="button" id="btnProcess" href="{{ route('admin.order.modalProcess')}}" class="btn btn-primary" data-type="process">Process Order</button>

                    <ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
				</div>
					
				
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    {{-- <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p> --}}
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
						<thead>
							<tr>
							<th><input type="checkbox" id="checkall" ></th>
							<th>No</th>
							<th>Url</th>
							<th>Quantity</th>
							<th>Total Price (&#165)</th>
							<th>Total Price (RM)</th>
							<th>Status Item</th>
							<th>Created At</th>
							<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $key => $item)
							<tr>
								<td><input type="checkbox" class="checkboxtest" value="{{ $item->id }}"></td>
								<td>{{ $key+1 }}</td>  
								<td><a href="{{ $item->item_url }}" target="_blank">Item Link</a></td>
								<td>{{ $item->item_quantity }}</td>
								<td>{{ $item->item_subtotal }}</td>
								<td class="text-right">{{ $item->item_total }}</td>
								<td>
									
									
									@if($item->item_status_id == 0)
									<span class="badge badge-danger">Not Available</span>
									@elseif($item->item_status_id == 1)
									<span class="badge badge-success">Available</span>
									@else
									<span class="badge badge-warning">Unknown</span>
									@endif
								</td>
								<td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y h:i:s A')}}</td>
								<td>
								<a href="{{ route('admin.order.detailsItem',$item->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
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


	
{{-- </div> --}}
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
		var type = $(this).attr('data-type')

		getValueToUpdate(link,type);
	});


    });
	
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
					},
					error:function() {
						alert('No Modal');
					},
				});
			}
			else if(type == 'process')
			{
				$.ajax({
				url: link,
				method: 'POST',
				data:{
                        select:select,
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
			
        }    
    }
</script>
@endsection