@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->



    <li class="breadcrumb-item active"><a href="#">Order List</a></li>
    {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Order List</h3>
		</div>
	</div>
	<div class="clearfix"></div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-12">
      <div class="x_panel">
        <div class="row x_title">
          <div class="col-md-6">
            <h3>Track Order</h3>
          </div>
            {{-- <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            
              <li>
                <a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul> --}}
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
					<br>
					<form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.findorder')}}">
            @csrf
            <div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Order No.</label>
							<div class="col-md-6 col-sm-6">
								<input type="text"  name="orderNo" required="required" class="form-control">
							</div>
              <div class="col-md-4">
                  <button type="submit" class="btn btn-primary">Search</button>

              </div>
						</div>						
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
							</div>
						</div>
					</form>
				</div>
      </div>
    </div>
  </div>
	<div class="row">
    <div class="col-md-12 col-sm-12 col-12">
								<div class="x_panel">
									<div class="x_title">
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
										<div class="col-sm-2">
											<!-- required for floating -->
											<!-- Nav tabs -->
											<div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
												<a class="nav-link active" id="neworder-tab" data-toggle="pill"  href="#neworder" role="tab" aria-controls="v-pills-home" aria-selected="true">New Order</a>
                        <a class="nav-link" id="purchase-tab" data-toggle="pill"  href="#purchase" role="tab" aria-controls="v-pills-home" aria-selected="true">Already Purchased</a>

												<a class="nav-link" id="process-tab" data-toggle="pill" href="#process" role="tab" aria-controls="v-pills-profile" aria-selected="false">Process</a>
												<a class="nav-link" id="courier-tab" data-toggle="pill" href="#courier" role="tab" aria-controls="v-pills-messages" aria-selected="false">Courier</a>
												<a class="nav-link" id="doneorder-tab" data-toggle="pill" href="#doneorder" role="tab" aria-controls="v-pills-settings" aria-selected="false" >Complete Order</a>
                        <a class="nav-link" id="cancel-tab" name="cancel-tab" data-toggle="pill" href="#cancel"  role="tab" aria-controls="v-pills-settings" aria-selected="false" >Cancel Items</a>
                        <a class="nav-link" id="refund-tab" name="cancel-tab" data-toggle="pill" href="#refund"  role="tab" aria-controls="v-pills-settings" aria-selected="false" >Refund</a>
											</div>
										</div>

										<div class="col-sm-10">
											<!-- Tab panes -->

											<div class="tab-content" id="v-pills-tabContent">

                        {{-- tab new order --}}
												<div class="tab-pane fade show active" id="neworder" role="tabpanel" aria-labelledby="v-pills-home-tab">
                          <div class="x_content">
                            <div class="text-right mb-3">
                              <button class="btn btn-primary btn-sm" id="btnPurchase" href="{{ route('admin.order.modalPurchase')}}">Purchase Order</button>
                              {{-- <button class="btn btn-danger btn-sm" id="buttonCancel" href="{{ route('admin.order.cancel')}}" >Cancel Order</button> --}}
                            </div>
                          <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall" ></th>
                                        <th>No</th>
                                        {{-- <th>Item URL</th> --}}
                                        <th>Order No</th>
                                        <th>Buyer Name</th>
                                        <th>Submit Date</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      
                                    
                                      @foreach($newOrder as $key=>$new)
                                      <tr>
                                
                                      <td><input type="checkbox" class="checkboxtest" value="{{ $new->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      {{-- <td>{{ $item->item_url }}</td> --}}
                                      <td>
                                        {{$new->order_no}}
                                      </td>
                                      <td><a href="{{route('admin.buyer.detail', $new->user->id)}}">{{ ucfirst($new->user->name) }}</a></td>
                                      
                                      <td>{{date('d-m-Y  h:i:s A', strtotime($new->submit_at));}}</td>
                                      </td></td>
                                      <td><span class="badge badge-primary">New</span></td>
                                      <td>
                                        <a href="{{ route('admin.order.items',$new->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                                      </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{-- end tab new order --}}

                        {{-- tab purchased order --}}
                        <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="v-pills-home-tab">
                          <div class="x_content">
                            <div class="text-right mb-3">
								
                              <button class="btn btn-primary btn-sm" id="btnProcess1" href="{{ route('admin.order.modalProcess')}}">Process Order</button>
								
                              {{-- <button class="btn btn-danger btn-sm" id="buttonCancel" href="{{ route('admin.order.cancel')}}" >Cancel Order</button> --}}
                            </div>
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox1" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall1" ></th>
                                        <th width="1%">No</th>
                                        {{-- <th>Item URL</th> --}}
                                        <th>Order No & Item</th>
                                        <th>Buyer Name</th>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      
                                    
                                      @foreach($purchaseOrder as $key=>$purchase)
                                      <tr>
                                
                                      <td><input type="checkbox" class="checkboxtest1" value="{{ $purchase->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      {{-- <td>{{ $item->item_url }}</td> --}}
                                      <td>
                                        {{$purchase->order_no}}
                                        <p class="mt-2">Item :</p>
                                        @foreach($purchase->peritem as $key=>$item)
                                        <span>{{($key+1)}}.<a href="{{ route('admin.order.detailsItem',$item->id) }}"> {{(!empty($item->item_name) ? $item->item_name:'No item name')}} </a></span>
										  @if($item->item_status_id == '0')
										  <span class="badge badge-danger">Not Available</span>
										  @elseif($item->item_status_id == '1')
										  <span class="badge badge-primary">Available</span>
										  @else
										  <span class="badge badge-warning">Processing</span>
										  @endif
										  <br>
                                        @endforeach
                                      </td>
                                      <td><a href="{{route('admin.buyer.detail', $purchase->user->id)}}">{{ ucfirst($purchase->user->name) }}</a></td>
                                      
                                      <td>{{ \Carbon\Carbon::parse($purchase->submit_at)->format('d-m-Y h:i:s A')}}</td>
                                      </td></td>
                                      <td><span class="badge badge-primary">New</span></td>
                                      <td>
                                        <a href="{{ route('admin.order.items',$purchase->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                                      </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{-- end tab --}}
                        {{-- tab process --}}
												<div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="x_content">
                            <div class="text-right mb-3">
                                <button class="btn btn-primary btn-sm" id="btnShipping" href=" {{ route('admin.order.modalShipping')}}">Process Shipping</button>
                            </div>
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox2" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall2" ></th>
                                        <th>No</th>
                                        {{-- <th>Item URL</th> --}}
                                        <th>Order No</th>
                                        <th>Buyer Name</th>
                                        <th>Process Date</th>
                                        <th>International Courier Fee (RM)</th>
										                    <th>Local Courier Fee (RM)</th> 
										                    <th>Total Courier Fee (RM)</th>
                                        <th>Status Courier Fee</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                      @foreach($processOrder as $key=>$process)
                                      <tr>
                                
                                     <td><input type="checkbox" class="checkboxtest2" value="{{ $process->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      {{-- <td>{{ $item->item_url }}</td> --}}
                                      <td>
                                        {{$process->order_no}}
                                        <p class="mt-2">Item :</p>
                                        @foreach($process->peritem as $nk=>$item)
                                        <span>{{($nk+1)}}.<a href="{{ route('admin.order.detailsItem',$item->id) }}"> {{(!empty($item->item_name) ? $item->item_name:'No item name')}}</a></span><br>
                                        @endforeach
                                      </td>
                                      <td><a href="{{route('admin.buyer.detail', $process->user->id)}}">{{ ucfirst($process->user->name) }}</a></td>
                                     
                                      <td> @if(!empty($process->order_process_date)){{ \Carbon\Carbon::parse($process->order_process_date)->format('d-m-Y h:i:s A')}}  @endif</td>
                                    
                                      <td class="text-right">{{ number_format($process->order_international,2)}}</td>
                                      <td>@if(!empty($process->order_local)) 
                                        {{ number_format($process->order_local,2) }} 
                                        @else
                                        0.00
                                        @endif</td>
                                        <td class="text-right">{{ number_format($process->order_shipping,2)}}</td>
                                      <td>
                                        @if($process->shipping_payment_status == NULL)
                                        <span class="badge badge-danger">Waiting Payment</span>
                                        @elseif($process->shipping_payment_status == '2')
                                        <span class="badge badge-success">Received</span>
                                        @else
                                        <span class="badge badge-warning">Unknown</span>
                                        @endif
                                        
                                      </td>
                                      <td>
                                        <a href="{{ route('admin.order.items',$process->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                                      </td>
                                      </tr>
                                      @endforeach
                                      
                                      {{-- @endforeach --}}
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{-- end tab process --}}

                        {{--  tab courier --}}
                        <div class="tab-pane fade" id="courier" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="x_content">
                            <div class="text-right mb-3">
                                <button class="btn btn-primary btn-sm" id="btnReceived" href=" {{ route('admin.order.modalReceived')}}">Complete Order</button>
                            </div>
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox3" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall3" ></th>
                                        <th width="5%">No</th>
                                        <th>Order No</th>
                                        <th>Buyer Name</th>
                                        <th>Tracking No</th>
                                        <th>Courier</th>
                                        <th>Courier Date</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($courierOrder as $key=>$courier)
                                      <tr>
                                
                                      <td><input type="checkbox" class="checkboxtest3" value="{{ $courier->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      <td>{{ $courier->order_no }}
                                      <p>Item :</p>
                                      @foreach($courier->peritem as $nk=>$item)
                                      <span>{{($nk+1)}}.<a href="{{ route('admin.order.detailsItem',$item->id) }}"> {{(!empty($item->item_name) ? $item->item_name:'No item name')}}</a></span>
                                      @endforeach
                                      </td>
                                      <td><a href="{{route('admin.buyer.detail', $courier->user->id)}}">{{ $courier->user->name}}</a></td>
                                      <td>{{ $courier->tracking_no }}</td>
                                      <td>{{ $courier->courier->name }}</td>
                                      <td>{{ \Carbon\Carbon::parse($courier->shipping_payment_date)->format('d-m-Y h:i:s A') }}</td>
                                      <td><span class="badge badge-success">{{ ($courier->status_id == '3') ? 'Delivery':'' }}</span></td>
                                      <td>
                                        <a href="{{ route('admin.order.items',$courier->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                                      </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{--  end tab courier --}}

                        {{--  tab doneorder --}}
                        <div class="tab-pane fade" id="doneorder" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                          <div class="x_content">
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox4" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall4"></th>
                                        <th>No</th>
                                        <th>Order No</th>
                                        <th>Buyer Name</th>
                                        <th>Tracking No.</th>
                                        <th>Complete Date</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                      <tbody>
                                      @foreach($completeOrder as $key=>$done)
                                      <tr>
                                
                                        <td><input type="checkbox" class="checkboxtest4" value="{{ $done->id }}"></td>
                                        <td>{{ $key +1 }}</td>  
                                        <td>{{ $done->order_no }}
                                          <p>Item :</p>
                                          @foreach($done->peritem as $nk=>$item)
                                          <span>{{($nk+1)}}.<a href="{{ route('admin.order.detailsItem',$item->id) }}"> {{(!empty($item->item_name) ? $item->item_name:'No item name')}}</a></span>
                                          @endforeach
                                        </td>
                                        <td><a href="{{route('admin.buyer.detail', $done->user->id)}}">{{ $done->user->name}}</a></td>
                                        <td>{{ $done->tracking_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($done->order_complete_date)->format('d-m-Y h:i:s A') }}</td>
                                        
                                        <td><span class="badge badge-success">{{ ($done->status_id == '4') ? 'Completed':'' }}</span></td>
                                        <td>
                                          <a href="{{ route('admin.order.items',$done->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{--  end tab doneorder --}}


                        {{-- tab cancel order --}}
												<div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                          <div class="x_content">
                            <div class="text-right mb-3">
                                <button class="btn btn-danger btn-sm" id="btnRefund" href=" {{ route('admin.order.modalRefund')}}">Refund</button>
                            </div>
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox5" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall5" ></th>
                                        <th>No</th>
                                        <th>Item Name & No</th>
                                        <th>Order No.</th>
                                        <th>Buyer Name</th>
                                        <th>Order Date</th>
                                        <th>Amount (RM)</th>
                                        <th>Status Item</th>
                                        <th width="10%">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($cancelOrder as $key=>$cancel)
                                      <tr>
                                
                                      <td><input type="checkbox" class="checkboxtest5" value="{{ $cancel->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      <td>{{(!empty($cancel->item_name) ? $cancel->item_name:'No item name')}}<br>
                                        <span class="font-italic">{{ $cancel->item_no}}</span></td>
                                      <td>{{$cancel->order->order_no}}</td>
                                      <td><a href="{{route('admin.buyer.detail', $cancel->user->id)}}">{{ $cancel->user->name}}</a></td>
                                      
                                      <td>{{ \Carbon\Carbon::parse($cancel->order->submit_at)->format('d-m-Y h:i:s A')}}</td>
                                      <td class="text-right">
                                        {{number_format($cancel->item_total,2) }}
                                      </td>
                                      <td>
                                        @if($cancel->item_status_id == '0')
                                        <span class="badge badge-danger">Not Available</span>
                                        <br>
                                        @if(!empty($cancel->item_remark))
                                          <span class="font-italic">Remark : {{$cancel->item_remark}}</span>
                                        @endif
                                        @elseif($cancel->item_status_id == '1')
                                        <span class="badge badge-success">Available</span>
                                        @else
                                        <span class="badge badge-warning">Unknown</span>
                                        @endif
                                      </td>
                                      <td>
                                         <a href="{{ route('admin.order.detailsItem',$cancel->id) }}" type="button" class="btn btn-info btn-sm">View Item</a>
                                      </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{-- end tab cancel order --}}

                        {{-- tab refund --}}
                        <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                          <div class="x_content">
                            <div class="row">
                              {{-- <div class="col-sm-12"> --}}
                                <div class="card-box table-responsive">
                                  <table id="datatable-checkbox6" class="table table-striped table-bordered bulk_action" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th><input type="checkbox" id="checkall6" ></th>
                                        <th>No</th>
                                        <th>Buyer Name</th>
                                        <th>Reference No.</th>
                                        <th>Amount (RM)</th>
                                        <th>Date/Time</th>
                                        
                                        
                                        {{-- <th>Created At</th> --}}
                                        <th>Refund Item</th>
                                        {{-- <th width="10%">Action</th> --}}
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($refunds as $key=>$refund)
                                      <tr>
                                
                                      <td><input type="checkbox" class="checkboxtest6" value="{{ $refund->id }}"></td>
                                      <td>{{ $key +1 }}</td>  
                                      <td><a href="{{route('admin.buyer.detail', $refund->user->id)}}">{{ $refund->user->name}}</a></td>
                                      <td>{{ $refund->refund_refno}}</td>
                                      <td class="text-right">{{ number_format($refund->refund_amount,2)}}</td>
                                      <td>{{ \Carbon\Carbon::parse($refund->refund_date)->format('d-m-Y') }} <br>
                                      {{ \Carbon\Carbon::parse($refund->refund_time)->format('h:i A') }}</td>
                                      <td>
                                      @foreach($refund->items as $keys => $item)
                                      {{ $keys+1 }}.  <a href="{{ route('admin.order.detailsItem',$item->id) }}">{{(!empty($item->item_name)? $item->item_name:'View Item')}}</a><br>
                                      @endforeach
                                      </td>
                                      {{-- <td>
                                         
                                      </td> --}}
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                {{-- </div> --}}
                            </div>
                          </div>
												</div>
                        {{-- end tab refund --}}
											</div>
                      {{-- end tab --}}
										</div>

										<div class="clearfix"></div>
									</div>
								</div>
							</div>

	</div>
</div>

<!-- /top tiles -->


<br />

<div id="modalPurchase" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Complete Purchase Order</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.purchase')}}" method="POST">
				@csrf
			<div class="modal-body" id="dataPurchase">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
				<button type="submit" class="btn btn-primary">Yes</button>
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
			<form action="{{ route('admin.order.process.all2')}}" method="POST">
				@csrf
			<div class="modal-body" id="data_modal2">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
		</div>
	</div>
</div>

<div id="modalShipping" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Process Shipping</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.processShipping')}}" method="POST">
				@csrf
			<div class="modal-body" id="dataShipping">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
		</div>
	</div>
</div>

<div id="modal_recieve" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Complete Order</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.processRecieved')}}" method="POST">
				@csrf
			<div class="modal-body" id="data_recieve">
			
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
		</div>
	</div>
</div>

<div id="modal_refund" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Process Refund</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('admin.order.processRefund')}}" method="POST">
				@csrf
			<div class="modal-body" id="data_refund">
			
			
				
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
	<script type="text/javascript">
			$(function () {
				$('#datetime').datetimepicker();
			});
		</script>
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
{{-- <script>
  $(document).ready(function() {



    const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9,10];
    // let txt = "";
    // numbers.forEach(myFunction);

    for (let i = 1; i < numbers.length; i++) {
      
      var count = 'datatable'+[i];

      count = $('#datatable-checkbox'+[i]);

      var $dt = count;
      $dt.dataTable({
      order: [[1, 'asc']],
      columnDefs: [{ orderable: false, targets: [0] }],
      });
      
      $dt.on('draw.dt', function () {
        $('checkbox input').iCheck({
          checkboxClass: 'icheckbox_flat-green',
        });
      });
      

      var checkTest = ".checkboxtest"+[i];
      var checkAll = "#checkall"+[i];

      $("#checkall"+[i]).change(function()
      {
        $(".checkboxtest"+[i]).prop("checked", $(this).prop("checked"))
      })
      

      $(".checkboxtest"+[i]).change(function()
      {
        if($(this).prop("checked")==false){
          $("#checkall"+[i]).prop("checked", false)
        }
        if($(".checkboxtest"+[i]+":checked").length == $(".checkboxtest"+[i]).length){
          $("#checkall"+[i]).prop("checked", true)
        }
      })

    }


  });
</script> --}}
<script>
$(document).ready(function () {
  
  $("#btnProcess").click(function() 
  {
    var link = $(this).attr("href");
    getValueToProcess(link);
  });

  $("#btnProcess1").click(function() 
  {
    var link = $(this).attr("href");
    getValueToProcess1(link);
  });
  
  $("#btnPurchase").click(function() 
  {
    var link = $(this).attr("href");
    getValueToPurchase(link);
  });


  $("#btnShipping").click(function() 
  {
    var link = $(this).attr("href");
    getValueToShipping(link);
  });


  $("#buttonUpdate").click(function() 
  {
    var modal = $(this).attr('data-modal');
    getValueToUpdate(modal);
  });
  
  $("#buttonCancel").click(function() 
  {
    var link = $(this).attr("href");
    getValueToCancel(link);
  });

  $("#btnRefund").click(function() 
  {
    var link = $(this).attr("href");
    getValueToRefund(link);
  });

  $("#btnReceived").click(function(){
    var link = $(this).attr("href");
    getValueToComplete(link);
  })
})



function getValueToShipping(link){
		
    var checkboxtest = [];
    
    $.each($(".checkboxtest2:checked"), function() {
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
      $.ajax({
        url: link,
        method: 'POST',
        data:{
          select:select,
          _token: "{{ csrf_token() }}",
        },
        success: function (data) {
          $('#dataShipping').html(data);
          $('#modalShipping').modal('show');
        },
        error:function() {
          alert('No Modal');
        },
      });
    }    
}

	function getValueToPurchase(link){
		
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
        // else if(select.length > 1)
        // {
        //    alert("Please check only one checkbox");  
        // }
        else 
        {
          $.ajax({
            url: link,
            method: 'POST',
            data:{
              select:select,
              _token: "{{ csrf_token() }}",
            },
            success: function (data) {
              $('#dataPurchase').html(data);
              $('#modalPurchase').modal('show');
            },
            error:function() {
              alert('No Modal');
            },
          });
        }    
    }

	function getValueToProcess1(link){
		
        var checkboxtest = [];
        
        $.each($(".checkboxtest1:checked"), function() {
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

    function getValueToComplete(link){
		
        var checkboxtest = [];
        
        $.each($(".checkboxtest3:checked"), function() {
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
          $.ajax({
            url: link,
            method: 'POST',
            data:{
              select:select,
              _token: "{{ csrf_token() }}",
            },
            success: function (data) {
              $('#data_recieve').html(data);
              $('#modal_recieve').modal('show');
            },
            error:function() {
              alert('No Modal');
            },
          });
        }    
    }

function getValueToProcess(link){
        // var ssl = $('#ssl').val();
        let token   = $('meta[name="csrf-token"]').attr('content');
        var checkboxtest =[];
        
        $.each($(".checkboxtest2:checked"), function() {
            checkboxtest.push($(this).val());
        });
    
        
        var select = checkboxtest ;
        console.log(select);
        if(select.length == 0)
        {
            alert("Please check at least one checkbox !");  
        }
        else 
        {
        Swal.fire({
            title: 'Confirm process all orders ?',
            // text: "Padam maklumat ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1f3bb3',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
            }).then((result) =>
            {
                
                if (result.isConfirmed)
                {
                 
                    $.ajax({  
                    url:link,
                    type:"POST",
                    data:{
                        select:select,
                        _token: "{{ csrf_token() }}",
                    },
                        success:function(data){  
                        Swal.fire({
                            title: data[0],
                            //text: 'Do you want to continue',
                            icon:data[1],
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#1f3bb3',
                        }).then(function() {
														$(".checkboxtest2").prop("checked", false);
														$("#checkall2").prop("checked", false);
                            location.reload();
                            });
                        }  
                    });
                }
            })
            
        }    
    }


function getValueToCancel(link){
        // var ssl = $('#ssl').val();
        let token   = $('meta[name="csrf-token"]').attr('content');
        var checkboxtest =[];
        
        $.each($(".checkboxtest1:checked"), function() {
            checkboxtest.push($(this).val());
        });
    
        
        var select = checkboxtest ;
        // console.log(select);
        if(select.length == 0)
        {
            alert("Please check at least one checkbox !");  
        }
        else 
        {
        Swal.fire({
            title: 'Confirm cancel selected orders ?',
            // text: "Padam maklumat ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1f3bb3',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
            }).then((result) =>
            {
                
                if (result.isConfirmed)
                {
                 
                    $.ajax({  
                    url:link,
                    type:"POST",
                    data:{
                        select:select,
                        _token: "{{ csrf_token() }}",
                    },
                        success:function(data){  
                        Swal.fire({
                            title: data[0],
                            //text: 'Do you want to continue',
                            icon:data[1],
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#1f3bb3',
                        }).then(function() {
														$(".checkboxtest1").prop("checked", false);
														$("#checkall1").prop("checked", false);
                            location.reload();
                            });
                        }  
                    });
                }
            })
            
        }    
    }

    function getValueToRefund(link){
		
        var checkboxtest = [];
        
        $.each($(".checkboxtest5:checked"), function() {
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
          $.ajax({
            url: link,
            method: 'POST',
            data:{
              select:select,
              _token: "{{ csrf_token() }}",
            },
            success: function (data) {
              if(data === "")
              {
                  Swal.fire({
                    title: 'Refund Process',
                    text: "Selected items for refund not in the same order no. Please recheck again",
                    icon: 'warning',
                    // showCancelButton: true,
                    confirmButtonColor: '#1f3bb3',
                    // cancelButtonColor: '#d33',
                    // cancelButtonText: 'Close',
                    confirmButtonText: 'Close'
                  })
              }else{
                $('#data_refund').html(data);
                $('#modal_refund').modal('show');
              }
            },
            error:function() {
              alert('No Modal');
            },
          });
        }    
    }
</script>
@endsection