@extends('user.layouts.main')
@section('content')

<!-- page content -->
<li class="breadcrumb-item"><a href="">Wallet</a></li>
</ol>
</nav>
 <div class="page-title">
 <div class="title_left">
     <form id="payform" method="POST" action="{{route('user.wallet.request')}}" data-parsley-validate class="form-horizontal form-label-left">
		 @csrf
		 <div class="x_panel">
									<div class="x_title">
										<h2>TOPUP YOUR eWALLET </h2> (Under Construction)
										<ul class="nav navbar-right panel_toolbox">
											<li>
												<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<br>@php
										$inbank = '<select name="bank_pay" id="inbank" class="form-control">';
										foreach($bankdata as $kb => $kv){
										
										$dbank = preg_split("/@/",$kv);
										if($dbank[2] != 1){
											$inbank .= '<option disabled>'.$dbank[1].'</option>';
										}else{
											$inbank .= '<option value="'.$dbank[0].'">'.$dbank[1].'</option>';
										}
										
											
										}
										$inbank .= '</select>';
										@endphp
										<form id="topupFormId" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
											<input type="hidden" id="type" name="type" value="topup">
											<div class="item form-group">
												<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">DESIRE AMOUNT<span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6">
													<input type="number" id="amount" name="amount_pay" min="10" placeholder="Minimum RM 10.00" required="required" class="form-control">
												</div>
											</div>
											
											<div class="item form-group">
												<label class="col-form-label col-md-3 col-sm-3 label-align">Payment Bank<span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6">
													{!!$inbank!!}
												</div>
											</div>
											<div class="ln_solid"></div>
											<div class="item form-group">
												<div class="col-md-6 col-sm-6 offset-md-3">
													@php
													//if(isset($_GET['debug']) && $_GET['debug'] == 'pay'){
														echo '<button type="submit" class="btn btn-success">Topup eWallet</button>';
													//}
													
													@endphp
												</div>
											</div>
										</form>
									</div>
								</div>
	  </form>
  </div>
</div>
<!-- /page content -->
@endsection
