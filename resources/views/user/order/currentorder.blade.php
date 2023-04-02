@extends('user.layouts.main')
@section('content')
        <!-- page content -->
<li class="breadcrumb-item"><a href="">Tracking Order</a></li>
</ol>
</nav>
        <div class="page-title">
  <div class="title_left">
    <h3>Tracking Order</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<div class="text-right mb-3">
						@if(empty($draftorder->id))
						<form method="POST" action="{{ route('user.createorder')}}">
							@csrf
							<!--{{Auth::user()->id;}}-->
							<button type="submit" class="btn btn-success">New Order</button>
						</form>		
						@else
						<a href="{{ route('user.neworder')}}" class="btn btn-primary">New Order</a>
						@endif
						<!--<button type="button" class="btn btn-primary">Create Order</button>-->
					</div>  
					
					<div class="table-responsive">
                    <table class="table table-bordered" id="dt-order" width="100%">
						<thead>
                        <tr>
							<th>#</th>
							<th width="25%">Order No.</th>
							<th>Submit Date</th>
							<th>Order Amount (MYR)</th>
							<th>Refund Amount (MYR)</th>
							<th>Order Status</th>
							<th>Item Status</th>
							<th>Courier Payment Status / Amount (MYR)</th>
							<th>Courier Info</th>
							<th>Total Payment (MYR)</th>	
							<th>Action</th>	
                        </tr>
                      </thead>
                      <tbody>
						  <?php $i=1 ?>
						  
						   @foreach($listsubmitorder as $listsubmitorder)
                        <tr>
                          <th scope="row"><?php echo $i;?></th>
                          <td>
							<b><a target="_blank" href="{{ url('user/order/view-order/'.$listsubmitorder->order_id) }}">{{$listsubmitorder->order_no}}</a></b>
							<p class="mt-2"> Your Item :</p>
							@if(!empty($listsubmitorder->item_details))
								@foreach($listsubmitorder->item_details as $ke=>$item)
								<b><span>{{($ke+1)}}.{{(!empty($item->item_name) ? $item->item_name:'No item name')}}</span></b><br>
								@endforeach
							@endif
						 </td>
                          <td>{{ \Carbon\Carbon::parse($listsubmitorder->submit_at)->format('d-m-Y h:i:s A')}}</td>
                          <td class="text-right">{{number_format($listsubmitorder->totalpay,2)}}</td>
						  <td class="text-right">{{number_format($listsubmitorder->deductpay,2)}}</td>	
						  <td>
							
							  {!!$listsubmitorder->order_class!!} 
							  
							  
							</td>
							<td class="text-left">

								{{-- komen by rizal --}}
								{{-- @if($listsubmitorder->order_stat_id >= '2')
								 @if($listsubmitorder->totalavailable == '0')
								
								 @else
								<span class="badge badge-success">Available Item :{{$listsubmitorder->totalavailable}}</span><br>
								 @endif
								
								@if($listsubmitorder->totalnotavailable == '0')
								
								@else
								<span class="badge badge-danger">Not Available Item :{{$listsubmitorder->totalnotavailable}}</span>
								@endif
								@else
								@endif --}}
								
								@if($listsubmitorder->order_stat_id >= '1')
								<span class="badge badge-warning">In Process Item : {{$listsubmitorder->totalprocess}}</span>
								<span class="badge badge-success">Available Item : {{$listsubmitorder->totalavailable}}</span><br>
								<span class="badge badge-danger">Not Available Item : {{$listsubmitorder->totalnotavailable}}</span>
								@endif
								
							</td>
							
							<td>
								
								@if(($listsubmitorder->order_stat_id == '5') || ($listsubmitorder->order_stat_id == '1'))
								 
								 <span class="badge badge-dark">None</span>
								@else
							    @if($listsubmitorder->shipping_payment_status == '')
								    
								
								
							  <span class="badge badge-warning">Waiting For Payment</span> <b><i>(RM{{$listsubmitorder->order_shipping}})</i></b>
							   @elseif($listsubmitorder->shipping_payment_status == '2') 
								
							  <span class="badge badge-success">Paid</span>  <b><i> <strike> (RM{{$listsubmitorder->order_shipping}}) </strike> </i></b>  
								
								
								
							   @else
							  
							  @endif
							  @endif
								
								
								
								
								
								
								</td>
							<td>@if($listsubmitorder->tracking_no != '')
								<b>{{$listsubmitorder->name}}:{{$listsubmitorder->tracking_no}}</b>
								@else
								
								@endif</td>
							<td>
								@if($listsubmitorder->shipping_payment_status == '2')
								
							<b>{{number_format($listsubmitorder->totalpay-$listsubmitorder->deductpay+$listsubmitorder->order_shipping,2)}}<b>
								@else
							<b>{{number_format($listsubmitorder->totalpay-$listsubmitorder->deductpay,2)}}</b>	
								@endif
							 
							</td>
						  <td><a href="{{ url('user/order/view-order/'.$listsubmitorder->order_id) }}" class="btn btn-primary btn-sm">View Order</a>
							  @if($listsubmitorder->shipping_payment_status == '2')
							       @if($listsubmitorder->tracking_no == '')
							       @else
							   <a href="https://www.17track.net/en" target="_blank" class="btn btn-primary btn-sm">View Tracking</a><br>

							  
							  <a href="{{ url('user/order/received-order/'.$listsubmitorder->order_id) }}" class="btn btn-warning btn-sm">Order Received</a>
							       @endif
							       
							 
							  @else
							  
							  @endif
							@php
							  //echo $linkpaycourier; 
							 @endphp
							  
							  @if(($listsubmitorder->order_stat_id == '2') && ($listsubmitorder->shipping_payment_status == ''))
							  <form id="payform" method="POST" action="{{route('user.processcourier')}}" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
							   <input id="order_id" class="form-control" type="hidden" name="order_id" value="{{$listsubmitorder->order_id}}">
							  	 <button type="button" class="btn btn-info btn-sm inpay" data-order="{{$listsubmitorder->order_id}}">Pay Courier (zPay/SJPAY)</button>
								  @if(NULL !== app('request')->input('debug') && app('request')->input('debug') == 'sjpay')
								  <button type="submit" class="btn btn-success btn-sm">Pay Courier</button>
								 
								  @endif
								  </form>
							  @endif
							  
							
							</td>
                        </tr>
						  <?php $i++ ?>
						  @endforeach 
                       <!-- <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                        </tr> -->
                      </tbody>
						</table>
					  </div>
                  </div>
                </div>
              </div>
</div>

        <!-- /page content -->
<div id="modalIn" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel"></h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" id="data_modal2">
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>

	$(function(){
		$(".inpay").click(function(){
			//alert($(this).data('order'));
			$.ajax({  
				url:"{{route('user.paymentselection')}}",
				type:"POST",
				data:{
					data_value:$(this).data('order'),
					_token: "{{ csrf_token() }}",
				},
					success:function(data){  
						$('#modalIn').find('.modal-title').html(data[1]);
						$('#modalIn').find('.modal-body').html(data[0]);
						$('#modalIn').find('.modal-footer').html(data[2]);
						$('#modalIn').modal('show');
						
						$('#thepay').click(function(){
							$('#payform'+$(this).data('payment')).submit();
						});
						
					/*Swal.fire({
						title: data[0],
						//text: 'Do you want to continue',
						icon:data[1],
						confirmButtonText: 'Close',
						confirmButtonColor: '#1f3bb3',
					}).then(function() {
													//$(".checkboxtest1").prop("checked", false);
													//$("#checkall1").prop("checked", false);
						//location.reload();
						});*/
					}  
				});
		});

		$('#dt-order').dataTable({
        // order: [[0, 'asc']],
        // columnDefs: [{ orderable: false, targets: [0] }],
        });
	});

</script>
@endsection
