@extends('user.layouts.main')
@section('content')
<li class="breadcrumb-item"><a href="{{ route('user.currentorder') }}">Tracking Order</a></li>
<li class="breadcrumb-item"><a href="{{ route('user.neworder') }}">New Order</a></li>
<li class="breadcrumb-item"><a href="">Review Payment</a></li>
</ol>
</nav>
        <!-- page content -->
        <div class="page-title">
  <div class="title_left">
    <h3>Review Payment</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
					 
					   <h2>Order No: <small>{{ $orderinfo->order_no }}</small></h2>
					  <!--<h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>-->
                    <!--<h2><button type="button" class="btn btn-primary">New</button>
					  <button type="button" class="btn btn-primary">Create Order</button></h2>-->
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
					  
<!--<button type="button" class="btn btn-warning">Edit</button>
	                        <button type="button" class="btn btn-danger">Delete</button>-->
                    <div class="table-responsive">
					  <table class="table table-bordered">
                      <thead>
                        <tr>
						  
                          <th>#</th>
                          <th>URL Address</th>
                          <th class="text-center">Item Price (JPY)</th>
                          <th class="text-center">Quantity</th>
						  <th class="text-center">Subtotal Item Price (JPY)</th>	
						  <th class="text-center">Services Charge (JPY) </th>
						  
						  <th class="text-center">Total Price (JPY) </th>
						 
						  
						  
						  <th class="text-center">Total Price (MYR) </th>
							
                        </tr>
                      </thead>
                      <tbody>
						  
						  
						  
						   
						  <?php $i=1 ?>
						  
						   @foreach($listitemorder as $listitemorder)
					      
					   
						  
                        <tr>
							
							
                          <td><?php echo $i;?></td>
                          <td>{{$listitemorder->item_url}}</td>
                          <td class="text-right">{{$listitemorder->item_yenprice}}</td>
						  <td class="text-center">{{$listitemorder->item_quantity}}</td>
						  <td class="text-right">{{$listitemorder->item_subtotal_item}}</td>	
						  <td class="text-right">{{$listitemorder->item_services}}</td>
						 
						  <td class="text-right">{{$listitemorder->item_subtotal}}</td>
						  
						 
						  <td class="text-right">{{number_format($listitemorder->item_total,2)}}</td>
							
                          <?php //$totalCost += $listitemorder->item_subtotal; ?>
                        </tr>
						  
						  <?php $i++ ?>
						  @endforeach 
						   <tr>
                          <td colspan="7" scope="row"><b><span class="text-danger">Total Payment *(Exclude Courier Fee)</span></b></td>
                          <td class="text-right"><h2><strong>{{number_format($totalorder->total,2)}}</strong></h2><br>
							  		  
							  
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
					  
					  <div class="x_title">
					 
					   <h2>Delivery Address </h2>
					  <!--<h2>Order No: <small>{{ app('request')->input('order_no') }}</small></h2>-->
                    <!--<h2><button type="button" class="btn btn-primary">New</button>
					  <button type="button" class="btn btn-primary">Create Order</button></h2>-->
                    
                    <div class="clearfix"></div>
                  </div>
					  
					 <form id="payform" method="POST" action="/user/order/payment-process-order" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
						 
						 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">New Address
											</label>
											<div class="col-md-6 col-sm-6 ">
																		   <label class="col-form-label col-md-9 col-sm-9 label-align text-left" for="url-address">
												<input type="radio" id="myCheck999" name="mail" value="999" onclick="myFunction999()" required>
													</label>
											</div>
										</div>
						 <?php $ik=1 ?>
						 @foreach($mailingaddress as $mailingaddress)   
						 
						 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Address <?php echo $ik;?>
												
												
												
												
												
											</label>
												<input type="hidden" id="per<?php echo $ik;?>address1" value="{{$mailingaddress->address1}}" name="mail<?php echo $ik;?>address1">
							 					<input type="hidden" id="per<?php echo $ik;?>address2" value="{{$mailingaddress->address2}}" name="mail<?php echo $ik;?>address2">
							                    <input type="hidden" id="per<?php echo $ik;?>address3" value="{{$mailingaddress->address3}}" name="mail<?php echo $ik;?>address3">
							                    <input type="hidden" id="per<?php echo $ik;?>postcode" value="{{$mailingaddress->postcode}}" name="mail<?php echo $ik;?>postcode">
							                    <input type="hidden" id="per<?php echo $ik;?>city" value="{{$mailingaddress->city}}" name="mail<?php echo $ik;?>city">
							                    <input type="hidden" id="per<?php echo $ik;?>state" value="{{$mailingaddress->state}}" name="mail<?php echo $ik;?>state">
							 
											<div class="col-md-6 col-sm-6 ">
												<label class="col-form-label col-md-9 col-sm-9 label-align text-left for="url-address">
												<input type="radio" id="myCheck<?php echo $ik;?>" name="mail" value="<?php echo $ik;?>" onclick="myFunction<?php echo $ik;?>()" required>
												{{ $mailingaddress->address1 }}, 
												@if(!empty($mailingaddress->address2))
												{{ $mailingaddress->address2 }}, 
												@else
					                            @endif
												@if(!empty($mailingaddress->address3))
												{{ $mailingaddress->address3 }},
												@else
					                            @endif
												
												{{ $mailingaddress->postcode }}, {{ $mailingaddress->city }}, 
												
												{{ strtoupper($mailingaddress->state_name) }}, {{ strtoupper($mailingaddress->country_name) }}
											</label>
													</div>
										</div>
							<?php $ik++ ?>			
						 @endforeach
						 
						 
						 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Address 1 <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="address1" style="text-transform:uppercase" value="" name="address1"  required="required" class="form-control ">
											</div>
										</div>
						        <input id="order_id" class="form-control" type="hidden" name="order_id" value="{{ $orderinfo->id }}">
						 <input id="user_id" class="form-control" type="hidden" name="user_id" value="{{ $orderinfo->user_id }}">
						       
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Address 2
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" style="text-transform:uppercase" value="" id="address2" name="address2" class="form-control ">
											</div>
										</div>
						                <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Address 3
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" style="text-transform:uppercase" value="" id="address3" name="address3" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label for="postcode" class="col-form-label col-md-3 col-sm-3 label-align">Postcode <span class="text-danger">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="postcode" style="text-transform:uppercase" value="" class="form-control" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"   name="postcode" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">City <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="city" style="text-transform:uppercase" value="" name="city" required="required" class="form-control ">
											</div>
										</div>
						 
						                <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">State <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select name="state" id="state" class="form-control" required>
                <option value="" @if (old('state') == "") {{ 'selected' }} @endif>Choose</option>
                @foreach($liststate as $liststate)
											
					<option value="{{$liststate->state_in}}"
							
							>{{ strtoupper($liststate->state_name) }}</option>								
													
				@endforeach
                <!--<option value="2" @if (old('percountry') == "2") {{ 'selected' }} @endif>Kedah</option>-->
            </select>
											</div>
										</div>
						 
						 <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">Country <span class="text-danger">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select name="country" id="country" class="form-control" required>
													@foreach($listCountry as $country)
													<option value="{{$country->country_id}}" @if (old('country') == $country->country_id) {{ 'selected' }} @endif>{{ $country->country_name}}</option>
													@endforeach						
												</select>
											</div>
										</div>
						               <!-- <div class="item form-group">
											<label for="item-services" class="col-form-label col-md-3 col-sm-3 label-align">Services Charge (MYR) <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="services" class="form-control" type="text" name="services" value="" readonly="readonly" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-subtotalservise" class="col-form-label col-md-3 col-sm-3 label-align"><b>Sub Total Services Charge (MYR)</b><span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="subtotalservise" class="form-control" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  readonly="readonly" name="subtotalservise" required="required">
											</div>
										</div>
						                 <div class="item form-group">
											<label for="item-total" class="col-form-label col-md-3 col-sm-3 label-align"><b>Total (MYR)</b> <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="total" class="form-control" type="text" name="total"  readonly="readonly" required="required">
											</div>
										</div> -->
						  
										<!--<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Gender</label>
											<div class="col-md-6 col-sm-6 ">
												<div id="gender" class="btn-group" data-toggle="buttons">
													<label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
														<input type="radio" name="gender" value="male" class="join-btn"> &nbsp; Male &nbsp;
													</label>
													<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
														<input type="radio" name="gender" value="female" class="join-btn"> Female
													</label>
												</div>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Date Of Birth <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
												<script>
													function timeFunctionLong(input) {
														setTimeout(function() {
															input.type = 'text';
														}, 60000);
													}
												</script>
											</div>
										</div> -->
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<!--<button class="btn btn-primary" type="button">Cancel</button>-->
												<button class="btn btn-primary" type="reset">RESET</button>
												 <a href="{{ route('user.neworder')}}" class="btn btn-primary">BACK</a>
												<button type="submit" class="btn btn-success">PLACE ORDER</button>
											</div>
											
										</div>
										<div class="row">
												<label class="text-danger font-italic font-weight-bolder"> WARNING !!! Please make sure you didn't close this page after payment and wait until it redirects back to your dashboard. </label>
											</div>
									</form>
					  
					  

                  </div>
                </div>
              </div>
</div>
<?php $ikl=1 ?>
 @foreach($mailingaddress2 as $mailingaddress2) 
<script>
	
	
  function myFunction<?php echo $ikl;?>() {
    var checkBox = document.getElementById("myCheck<?php echo $ikl;?>");  
    var per<?php echo $ikl;?>add1 = document.getElementById("per<?php echo $ikl;?>address1");
	var per<?php echo $ikl;?>add2 = document.getElementById("per<?php echo $ikl;?>address2"); 
	var per<?php echo $ikl;?>add3 = document.getElementById("per<?php echo $ikl;?>address3"); 
	var per<?php echo $ikl;?>postcode = document.getElementById("per<?php echo $ikl;?>postcode"); 
	var per<?php echo $ikl;?>city = document.getElementById("per<?php echo $ikl;?>city"); 
	var per<?php echo $ikl;?>state = document.getElementById("per<?php echo $ikl;?>state"); 
	//var peradd2 = document.getElementById("peraddress2");   
	//var peradd3 = document.getElementById("peraddress3"); 
	//var perpost = document.getElementById("perpostcode"); 
	//var percity = document.getElementById("percity"); 
	//var perstate = document.getElementById("perstate"); 
	  
    var mailadd1 = document.getElementById("address1"); 
	var mailadd2 = document.getElementById("address2"); 
	var mailadd3 = document.getElementById("address3"); 
	var mailpostcode = document.getElementById("postcode"); 
	var mailcity = document.getElementById("city");
	var mailstate = document.getElementById("state");
	//var mailadd2 = document.getElementById("mailaddress2"); 
	//var mailadd3 = document.getElementById("mailaddress3"); 
	//var mailpost = document.getElementById("mailpostcode"); 
	//var mailcity = document.getElementById("mailcity"); 
	//var mailstate = document.getElementById("mailstate");
    if (checkBox.checked == true){
          mailadd1.value=per<?php echo $ikl;?>add1.value;
		  mailadd2.value=per<?php echo $ikl;?>add2.value;
		  mailadd3.value=per<?php echo $ikl;?>add3.value;
		  mailpostcode.value=per<?php echo $ikl;?>postcode.value;
		  mailcity.value=per<?php echo $ikl;?>city.value;
		  mailstate.value=per<?php echo $ikl;?>state.value;
		 // mailadd2.value=peradd2.value;
		 // mailadd3.value=peradd3.value;
		//  mailpost.value=perpost.value;
		 // mailcity.value=percity.value;
		  //mailstate.value=perstate.value;
    } else {
          mail<?php echo $ikl;?>add1.value="";
		  mail<?php echo $ikl;?>add2.value="";
		  mail<?php echo $ikl;?>add3.value="";
		  mail<?php echo $ikl;?>postcode.value="";
		  mail<?php echo $ikl;?>city.value="";
		  mail<?php echo $ikl;?>state.value="";
		 // mailadd2.value="";
		 // mailadd3.value="";
		//  mailpost.value="";
		 // mailcity.value="";
		 // mailstate.value="";
    }
  }
	<?php $ikl++; ?>
</script>
@endforeach
						 
<script>
	
	
  function myFunction999() {
    var checkBox = document.getElementById("myCheck999");  
   
	
	  
    var mailadd1 = document.getElementById("address1"); 
	var mailadd2 = document.getElementById("address2"); 
	var mailadd3 = document.getElementById("address3"); 
	var mailpostcode = document.getElementById("postcode"); 
	var mailcity = document.getElementById("city");
	var mailstate = document.getElementById("state");
	//var mailadd2 = document.getElementById("mailaddress2"); 
	//var mailadd3 = document.getElementById("mailaddress3"); 
	//var mailpost = document.getElementById("mailpostcode"); 
	//var mailcity = document.getElementById("mailcity"); 
	//var mailstate = document.getElementById("mailstate");
    if (checkBox.checked == true){
          mailadd1.value="";
		  mailadd2.value="";
		  mailadd3.value="";
		  mailpostcode.value="";
		  mailcity.value="";
		  mailstate.value="";
		 // mailadd2.value=peradd2.value;
		 // mailadd3.value=peradd3.value;
		//  mailpost.value=perpost.value;
		 // mailcity.value=percity.value;
		  //mailstate.value=perstate.value;
    } 
  }
	<?php $ikl++; ?>
</script>						 

        <!-- /page content -->

@endsection
