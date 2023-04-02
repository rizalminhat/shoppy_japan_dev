@extends('user.layouts.main')
@section('content')
@if(url()->previous() == 'https://shoppyjapan.my/user/completed/currentcompletedpay')
<li class="breadcrumb-item"><a href="{{ route('user.currentcompletedpay') }}">Completed Payment</a></li>
@elseif(url()->previous() == 'https://shoppyjapan.my/user/completed/currentcompleted')
<li class="breadcrumb-item"><a href="{{ route('user.currentcompleted') }}">Completed Order</a></li>
@else
<li class="breadcrumb-item"><a href="{{ route('user.currentorder') }}">Tracking Order</a></li>
@endif
<li class="breadcrumb-item"><a href="">View Order</a></li>
</ol>
</nav>
<!-- page content -->
<div class="page-title">
  <div class="title_left">
    <h3>View Order</h3>
  </div>
</div>
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Order No: {{ $orderinfo->order_no }}<br>Status : {!!$orderstatus->order_class!!}</h2>
        {{-- <h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>
        <h2><button type="button" class="btn btn-primary">New</button>
        <button type="button" class="btn btn-primary">Create Order</button></h2> --}}
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          {{-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Settings 1</a>
              <a class="dropdown-item" href="#">Settings 2</a>
            </div>
          </li> --}}
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        @if(!empty($addressdelivery->id))
        <div class="item form-group">
          <div class="col-md-6 col-sm-6 ">
            <b>{{ $userinfo->name }}<br>
              ({{ $userinfo->email }})<br>
              {{ $addressdelivery->address1 }}, 
              @if(!empty($addressdelivery->address2))
              <br>{{ $addressdelivery->address2 }}, 
              @else
              @endif
              @if(!empty($addressdelivery->address3))
              <br>{{ $addressdelivery->address3 }},
              @else
              @endif
              <br>
              {{ $addressdelivery->postcode }}, {{ $addressdelivery->city }}, 
              <br>
              {{ strtoupper($addressdelivery->state_name) }}, {{ strtoupper($addressdelivery->country_name) }}</b>
            </div>
          </div>
          @else
          @endif  
          
          {{-- <button type="button" class="btn btn-warning">Edit</button>
          <button type="button" class="btn btn-danger">Delete</button> --}}
          <div class="x_title">
            <h2>All Items</h2>
              <div class="clearfix"></div>
          </div>
          <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped"  id="datatable-checkbox-1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>URL Address</th>
                  <th class="text-center">Item Name</th>
                  <th class="text-center">Item Description / Instruction</th>
                  <th class="text-center">Item Price (JPY)</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Subtotal Item Price (JPY)</th>	
                  <th class="text-center">Services Charge (JPY) </th>
                  <th class="text-center">Total Price (JPY) </th>
                  <th class="text-center">Total Price (MYR) </th>
                 
                  <!--<th class="text-center">Status </th>-->
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach($listitemorder as $key=>$listitemorder)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>
                      <a href="{{ (!empty($listitemorder->item_img)) ? asset('storage/upload/item_images/'.$listitemorder->item_img) : asset('/main/img/dummy-image-square.jpg') }}" target="_blank">
												<img class="img-fluid" id="showImage"  width="200px" src="{{ (!empty($listitemorder->item_img)) ? asset('storage/upload/item_images/'.$listitemorder->item_img) : asset('/main/img/dummy-image-square.jpg') }}">
											</a>
											<p class="my-2"><a href="{{$listitemorder->item_url}}" target="_blank">Item Link</a></p>
                    </td>
                    <td>{{ (!empty($listitemorder->item_name) ? $listitemorder->item_name:'No data') }}</td>
                    <td>{{ (!empty($listitemorder->item_desc) ? $listitemorder->item_desc : 'No data') }}</td>

                    <td class="text-right">{{$listitemorder->item_yenprice}}</td>
                    <td class="text-center">{{$listitemorder->item_quantity}}</td>
                    <td class="text-right">{{$listitemorder->item_subtotal_item}}</td>	
                    <td class="text-right">{{$listitemorder->item_services}}</td>
                    <td class="text-right">{{$listitemorder->item_subtotal}}</td>
                    <td class="text-right">{{number_format($listitemorder->item_total,2)}}</td>
                      {{-- <td class="text-right">{{$listitemorder->order_status}}</td>--}}
                    </tr>
                    @endforeach 
                    {{-- <tr>
                      <td colspan="8" scope="row"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></td>
                      <td class="text-right"><strong>{{number_format($totalorder->total,2)}}</strong><br></td>
                    </tr>  --}}
                    <tfoot>
                      <tr>
                          <th colspan="9" class="text-left"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></th>
                          <th class="text-right"></th>
                      </tr>
                  </tfoot>
                </tbody>
            </table>
          </div>
          

          {{-- Item not available part --}}
          {{-- refer here --}}

          @if($listitemordernotavailable->isNotEmpty())
					<div class="x_title">
            <h2>Not Available Items (Refund)</h2>
            <!--<h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>-->
            <!--<h2><button type="button" class="btn btn-primary">New</button>
              <button type="button" class="btn btn-primary">Create Order</button></h2>-->
              <div class="clearfix"></div>
          </div>
          <div class="table-responsive mb-5">
          <table class="table table-bordered" id="datatable-checkbox-2">
          <thead>
            <tr>
              <th>#</th>
              <th>URL Address</th>
              <th>Item Name</th>
              <th class="text-center">Item Description / Instruction</th>

              <th class="text-center">Item Price (JPY)</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Remarks</th>
              <th class="text-center">Subtotal Item Price (JPY)</th>	
              <th class="text-center">Services Charge (JPY) </th>
              <th class="text-center">Total Price (JPY) </th>
              <th class="text-center">Total Price (MYR) </th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1 ?>
            @foreach($listitemordernotavailable as $listitemordernotavailable)
            <tr>
              <td><?php echo $i;?></td>
              <td>
                <a href="{{ (!empty($listitemordernotavailable->item_img)) ? asset('storage/upload/item_images/'.$listitemordernotavailable->item_img) : asset('/main/img/dummy-image-square.jpg') }}" target="_blank">
                <img class="img-fluid" id="showImage"  width="200px" src="{{ (!empty($listitemordernotavailable->item_img)) ? asset('storage/upload/item_images/'.$listitemordernotavailable->item_img) : asset('/main/img/dummy-image-square.jpg') }}">
                </a>
                <p class="my-2"><a href="{{$listitemordernotavailable->item_url}}" target="_blank">Item Link</a></p>
              </td>
              <td>{{ (!empty($listitemordernotavailable->item_name) ? $listitemordernotavailable->item_name:'No data')}}</td>
              <td>{{ (!empty($listitemordernotavailable->item_desc) ? $listitemorder->item_desc : 'No data') }}</td>

              <td class="text-right">{{$listitemordernotavailable->item_yenprice}}</td>
              <td class="text-center">{{$listitemordernotavailable->item_quantity}}</td>
              <td class="text-left">{{$listitemordernotavailable->item_remark}}</td>
              <td class="text-right">{{$listitemordernotavailable->item_subtotal_item}}</td>	
              <td class="text-right">{{$listitemordernotavailable->item_services}}</td>
              <td class="text-right">{{$listitemordernotavailable->item_subtotal}}</td>
              <td class="text-right">{{number_format($listitemordernotavailable->item_total,2)}}</td>
              <?php //$totalCost += $listitemorder->item_subtotal; ?>
            </tr>
            <?php $i++ ?>
            @endforeach 
            <tfoot>
              <tr>
                  <th colspan="10" class="text-left"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></th>
                  <th class="text-right"></th>
              </tr>
            </tfoot>
          </tbody>
        </table> 
      </div>
      @endif  


      {{-- Item available part --}}
      {{-- refer here --}}
      @if($listitemorderavailable->isNotEmpty())
      <div class="x_title">
        <h2>Available Items </h2>
        <!--<h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>-->
        <!--<h2><button type="button" class="btn btn-primary">New</button>
          <button type="button" class="btn btn-primary">Create Order</button></h2>-->
          <div class="clearfix"></div>
      </div>
        
      <div class="table-responsive mb-5">
        <table class="table table-bordered" id="datatable-checkbox-3">
          <thead>
            <tr>
              <th>#</th>
              <th>URL Address</th>
              <th>Item Name</th>
              <th class="text-center">Item Description / Instruction</th>

              <th class="text-center">Item Price (JPY)</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Subtotal Item Price (JPY)</th>	
              <th class="text-center">Services Charge (JPY) </th>
              <th class="text-center">Total Price (JPY) </th>
              <th class="text-center">Total Price (MYR) </th>
              <!--<th class="text-center">Status </th>-->
            </tr>
          </thead>
          <tbody>
            <?php $i=1 ?>
            @foreach($listitemorderavailable as $listitemorderavailable)
            <tr>
              <td><?php echo $i;?></td>
              <td>
                <a href="{{ (!empty($listitemorderavailable->item_img)) ? asset('storage/upload/item_images/'.$listitemorderavailable->item_img) : asset('/main/img/dummy-image-square.jpg') }}" target="_blank">
                <img class="img-fluid" id="showImage"  width="200px" src="{{ (!empty($listitemorderavailable->item_img)) ? asset('storage/upload/item_images/'.$listitemorderavailable->item_img) : asset('/main/img/dummy-image-square.jpg') }}">
                </a>
                <p class="my-2"><a href="{{$listitemorderavailable->item_url}}" target="_blank">Item Link</a></p>
              </td>
              <td>{{(!empty($listitemorderavailable->item_name) ? $listitemorderavailable->item_name:'No data')}}</td>
              <td>{{ (!empty($listitemorderavailable->item_desc) ? $listitemorder->item_desc : 'No data') }}</td>

              <td class="text-right">{{$listitemorderavailable->item_yenprice}}</td>
              <td class="text-center">{{$listitemorderavailable->item_quantity}}</td>
              <td class="text-right">{{$listitemorderavailable->item_subtotal_item}}</td>	
              <td class="text-right">{{$listitemorderavailable->item_services}}</td>
              <td class="text-right">{{$listitemorderavailable->item_subtotal}}</td>
              <td class="text-right">{{number_format($listitemorderavailable->item_total,2)}}</td>
            <?php //$totalCost += $listitemorder->item_subtotal; ?>
            </tr>
            <?php $i++ ?>
            @endforeach 
            {{-- <tr>
              <td colspan="7" scope="row"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></td>
              <td class="text-right"><strong>{{number_format($totalavailableorder->total,2)}}</strong><br></td>
            </tr>  --}}
          <tfoot>
            <tr>
                <th colspan="9" class="text-left"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></th>
                <th class="text-right"></th>
            </tr>
          </tfoot>
          </tbody>
        </table>
      </div>
      @endif  
					  
					 @if(!empty($orderinfo->order_shipping))
					  <div class="x_title">
					 
					   <h2>Courier Fee</h2>
					  <!--<h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>-->
                    <!--<h2><button type="button" class="btn btn-primary">New</button>
					  <button type="button" class="btn btn-primary">Create Order</button></h2>-->
                    
                    <div class="clearfix"></div>
                  </div>
					  <form id="payform" method="POST" action="{{route('user.processcourier')}}" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
					  <div class="table-responsive">
						  
					  <table class="table table-bordered">
                      <thead>
                        <tr>
						  
                          <th>#</th>
                          <th>Description</th>
                       
						  
						  
						  <th class="text-center">Total Price (MYR) </th>
						  <!--<th class="text-center">Status </th>-->
							
                        </tr>
                      </thead>
                      <tbody>
						  
						  
						  
						   
						  
					      
					   
						  
                        <tr>
							
							
                          <td>1.</td>
                          <td>Courier Fee For Order No. {{ $orderinfo->order_no }}
							 <input id="order_id" class="form-control" type="hidden" name="order_id" 
									value="{{ $orderinfo->id }}">
							</td>
                          
						 
						  <td class="text-right">{{number_format($orderinfo->order_shipping,2)}}</td>
							
							
                          <?php //$totalCost += $listitemorder->item_subtotal; ?>
                        </tr>
						  
						 
						   <tr>
                          <td colspan="2" scope="row"><b>Total Payment</b></td>
                          <td class="text-right"><strong>
							<h2> {{number_format($orderinfo->order_shipping,2)}} </h2>
							  @if(empty($orderinfo->shipping_payment_status))
							  <!--<a href="{{ url('user/order/payment-shipping/'.$orderinfo->id) }}" class="btn btn-primary btn-sm">PROCEED TO PAYMENT</a>-->
							  <button type="submit" class="btn btn-success">PROCEED TO PAYMENT</button>

							  
 	
@else
	@endif						  
 </strong>
							  		  
							  
							  </td>
                                                  </tr> 
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
                        </tr>-->
                      </tbody>
                    </table>
						
					  </div>
						  </form> 
					   @else
	                   @endif	
					  
					<!-- 
					  
					  @if(!empty($addressdelivery->id))
					  <div class="x_title">
					 
					   <h2>Delivery Address </h2>
					
                    
                    <div class="clearfix"></div>
                  </div>
					  <div class="item form-group">
											
											<div class="col-md-6 col-sm-6 ">
												{{ $addressdelivery->address1 }}, 
												@if(!empty($addressdelivery->address2))
												<br>{{ $addressdelivery->address2 }}, 
												@else
					                            @endif
												@if(!empty($addressdelivery->address3))
												<br>{{ $addressdelivery->address3 }},
												@else
					                            @endif
												<br>
												{{ $addressdelivery->postcode }}, {{ $addressdelivery->city }}, 
												<br>
												{{ strtoupper($addressdelivery->state_name) }}, {{ strtoupper($addressdelivery->country_name) }}
											</div>
										</div>
					 @else
					  
					  @endif
					  -->
					 <!-- <form method="POST" action="{{ route('user.createorder')}}">
							 @csrf
							
							<button type="submit" class="btn btn-success">New 2</button>
					   </form>	-->
					<!--  <div class="x_title">
					 
					   <h2>Grand Total Payment :<small class="text-right">{{}}</small></h2>
					
                    
                    <div class="clearfix"></div>
                  </div>-->
					  

                  </div>
                </div>
              </div>
</div>


        <!-- /page content -->

@endsection
@section('scripts')

<script>
$(document).ready(function(){
  $('#datatable-checkbox-1').dataTable({
    footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(9, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(9).footer()).html('RM ' + pageTotal.toFixed(2));
        },
  })

  
   $('#datatable-checkbox-2').dataTable({
    footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(10)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(10, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(10).footer()).html('RM ' + pageTotal.toFixed(2));
        },
  })


   $('#datatable-checkbox-3').dataTable({
    footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(9)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(9, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(9).footer()).html('RM ' + pageTotal.toFixed(2));
        },
  })
})
</script>

@endsection

