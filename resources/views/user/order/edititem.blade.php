@extends('user.layouts.main')
@section('content')
<li class="breadcrumb-item"><a href="{{ route('user.currentorder') }}">Tracking Order</a></li>
<li class="breadcrumb-item"><a href="{{ route('user.neworder') }}">New Order</a></li>
<li class="breadcrumb-item"><a href="">Edit</a></li>
</ol>
</nav>
        <!-- page content -->
        <div class="page-title">
  <div class="title_left">
    <h3>Edit Item</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
					 
					   <h2>Order No: <small>{{ $latestorderinfo->order_no }}</small></h2>
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
                    
					  
					  
					 <!-- <form method="POST" action="{{ route('user.createorder')}}">
							 @csrf
							
							<button type="submit" class="btn btn-success">New 2</button>
					   </form>	-->
					  
					  <!--<form id="demo-form2" method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf -->
					  
					  <form action="{{ url('user/order/update-item/'.$item->id) }}" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        @method('PUT')
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="url-address">URL Address <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="url_address" value="{{ $item->item_url }}" name="url_address" required="required" class="form-control ">
											</div>
										</div>
						        <input id="item_order_id" class="form-control" type="hidden" name="item_order_id" value="{{ $latestorderinfo->id }}">
						        <input id="item_currency" class="form-control" type="hidden" name="item_currency" value="{{ $configinfo->currency_yentomyr }}">
						  <input type="hidden" id="myprice" name="myprice" class="form-control">
										
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="item-price">Item Price (JPY)<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												 
												<span style="position: absolute; margin-left: 80px; margin-top: 10px;">(JPY)</span><input type="text" id="price" name="price" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  onkeyup="yenfunc()" value="{{ $item->item_yenprice }}" required="required" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label for="item-desc" class="col-form-label col-md-3 col-sm-3 label-align">Item Description / Instructions<span class="text-danger">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="message" class="form-control" name="item_desc" placeholder="Example:size:30,color:red">{{$item->item_desc}}</textarea>
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-quantity" class="col-form-label col-md-3 col-sm-3 label-align">Quantity <span class="text-danger">*</span></label>
											<div class="col-md-3 col-sm-3 ">
												<input id="quantity" class="form-control" type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
													   value="{{ $item->item_quantity  }}" min="1" onkeyup="Quantityfunc()" name="quantity" required="required">
											</div>
							                
							                <div class="col-md-3 col-sm-3 ">
												<span style="position: absolute; margin-left: 80px; margin-top: 10px;">(JPY)</span><input id="total_itemyen" class="form-control" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
													     value="{{ $item->item_subtotal_item  }}" name="total_itemyen" readonly="readonly">
											</div>
							  
										</div>
						                <div class="item form-group">
											<label for="item-services" class="col-form-label col-md-3 col-sm-3 label-align">Services Charge (JPY) <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="services" class="form-control" type="text" name="services" value="{{ $configinfo->services_charge }}" readonly="readonly" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-total" class="col-form-label col-md-3 col-sm-3 label-align"><b>Total</b> <span class="text-danger">*</span></label>
											<div class="col-md-3 col-sm-3 ">
												
												<span style="position: absolute; margin-left: 80px; margin-top: 10px;">(JPY)</span><input id="grand_totalyen" class="form-control" type="text" name="grand_totalyen"  value="{{ $item->item_subtotal  }}" readonly="readonly" style="padding-left: 8px;">
												<div>
   
</div>
											</div>  
											 
											 <div class="col-md-3 col-sm-3 ">
												<span style="position: absolute; margin-left: 80px; margin-top: 10px;">(MYR)</span><input id="total" class="form-control" type="text" name="total"  value="{{ $item->item_total  }}" readonly="readonly">
											</div> <!--* Currency rate ({{ $configinfo->currency_yentomyr }})-->
											 <div class="col-md-3 col-sm-3 "><a href="{{ url('user/order/neworder') }}"><input type="button" class="btn btn-primary" value="Cancel" /></a>
												<button class="btn btn-primary" type="reset">Reset</button>
												<button type="submit" class="btn btn-success">Save</button></div>
										</div>
						             
						              <!--  <div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="item-myprice">Item Price (MYR)<span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="myprice" name="myprice" value="{{ $item->item_rmprice }}" required="required" class="form-control" readonly="readonly">
											</div>
										</div>
										<div class="item form-group">
											<label for="item-quantity" class="col-form-label col-md-3 col-sm-3 label-align">Quantity <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="quantity" class="form-control" type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  onchange="Quantityfunc()" value="{{ $item->item_quantity }}" name="quantity" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-totalrm" class="col-form-label col-md-3 col-sm-3 label-align"><b>Sub Total Price (MYR)</b><span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="totalrm" class="form-control" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  readonly="readonly" value="{{ $item->item_subtotal }}"  name="totalrm" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-services" class="col-form-label col-md-3 col-sm-3 label-align">Services Charge (MYR) <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="services" class="form-control" type="text" name="services" value="{{ $configinfo->services_charge }}" readonly="readonly" required="required">
											</div>
										</div>
						                <div class="item form-group">
											<label for="item-subtotalservise" class="col-form-label col-md-3 col-sm-3 label-align"><b>Sub Total Services Charge (MYR)</b><span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="subtotalservise" class="form-control" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  readonly="readonly" value="" name="subtotalservise" required="required">
											</div>
										</div>
						                 <div class="item form-group">
											<label for="item-total" class="col-form-label col-md-3 col-sm-3 label-align"><b>Total (MYR)</b> <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="total" class="form-control" type="text" name="total"  value="{{ $item->item_total }}" readonly="readonly" required="required">
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
										<!--<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												
												<a href="{{ url('user/order/neworder') }}"><input type="button" class="btn btn-primary" value="Cancel" /></a>
												<button class="btn btn-primary" type="reset">Reset</button>
												<button type="submit" class="btn btn-success">Save</button>
											</div>
										</div>-->

									</form>

                  </div>
                </div>
              </div>
</div>
<script>
		var yen, myr;
function init()
{
    yen = document.getElementById("price");
    myr = document.getElementById("myprice");
   
}

function yenfunc()
{
	yen = document.getElementById("price");
	quantity = document.getElementById("quantity");
    myr = document.getElementById("myprice");
	
	
	//servicescharge.value = parseFloat((services.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2);
    myr.value = parseFloat((yen.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2); //parseFloat(yen.value) * 0.035;
	total_itemyen.value = yen.value * quantity.value;
	grand_totalyen.value = (yen.value * quantity.value) + {{ $configinfo->services_charge }};
	
	total.value= parseFloat(((yen.value * quantity.value)+({{ $configinfo->services_charge }}))*({{ $configinfo->currency_yentomyr }})).toFixed(2);
	
	
	//total.value= parseFloat({{ $configinfo->services_charge }} + (yen.value * quantity.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2);
	//document.getElementById('quantity').value = '';
	//document.getElementById('subtotalservise').value = '';
	//document.getElementById('total').value = '';
   
}
	
function Quantityfunc()
{
	yen = document.getElementById("price");
	quantity = document.getElementById("quantity");
    myr = document.getElementById("myprice");
	
	//servicescharge.value = parseFloat((services.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2);
    myr.value = parseFloat((yen.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2); //parseFloat(yen.value) * 0.035;
	total_itemyen.value = yen.value * quantity.value;
	grand_totalyen.value = (yen.value * quantity.value) + {{ $configinfo->services_charge }};
	total.value= parseFloat(((yen.value * quantity.value)+({{ $configinfo->services_charge }}))*({{ $configinfo->currency_yentomyr }})).toFixed(2);
	/*myr = document.getElementById("myprice");
	quantity = document.getElementById("quantity");
	totalrm = document.getElementById("totalrm");
	subtotalservise = document.getElementById("subtotalservise");
	total = document.getElementById("total");
	//totalrm = document.getElementById("totalrm");
	
    totalrm.value = parseFloat(myr.value * quantity.value).toFixed(2); 
	subtotalservise.value = parseFloat({{ $configinfo->services_charge }} * 1).toFixed(2); 
	total.value = parseFloat({{ $configinfo->services_charge }} * 1 + myr.value * quantity.value).toFixed(2);*/
	//total.value = parseFloat(({{ $configinfo->services_charge }} * quantity.value).toFixed(2) + parseFloat(myr.value * quantity.value).toFixed(2)); 
	
   // eur.value = parseFloat(gbp.value) * 0.69714;
   // cad.value = parseFloat(gbp.value) * 0.50221;
   // aud.value = parseFloat(gbp.value) * 0.43497;
}
	
function Subtotalservicesfunc()
{
	myr = document.getElementById("myprice");
	quantity = document.getElementById("quantity");
	totalrm = document.getElementById("totalrm");
	totalrm = document.getElementById("totalrm");
	
   // totalrm.value = parseFloat(myr.value * quantity.value).toFixed(2); 
	
   // eur.value = parseFloat(gbp.value) * 0.69714;
   // cad.value = parseFloat(gbp.value) * 0.50221;
   // aud.value = parseFloat(gbp.value) * 0.43497;
}	
	
	
	
function Totalfunc()
{
	//price = document.getElementById("price");
	//myprice = document.getElementById("myprice");
	totalrm = document.getElementById("totalrm");
	quantity = document.getElementById("quantity");
	
	total = document.getElementById("total");
	
	total.value = parseFloat(totalrm.value + {{ $configinfo->services_charge }}).toFixed(2); //parseFloat((price.value) * {{ $configinfo->currency_yentomyr }}).toFixed(2) * quantity.value;
    //totalrm.value = parseFloat(myr.value * quantity.value).toFixed(2); 
   // eur.value = parseFloat(gbp.value) * 0.69714;
   // cad.value = parseFloat(gbp.value) * 0.50221;
   // aud.value = parseFloat(gbp.value) * 0.43497;
}	
	
	

init();
		</script>

        <!-- /page content -->

@endsection
