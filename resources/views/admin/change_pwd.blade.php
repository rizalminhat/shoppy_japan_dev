@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Profile</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Change Password</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="x_panel">
				<div class="x_title">
					{{-- <h2>Form Design <small>different form elements</small></h2> --}}
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
					<br />
<!--
					<div class="alert alert-danger" role="alert">
					  A simple danger alert—check it out!
					</div>
-->
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ route('admin.profile.updatepwd')}}">
						@csrf
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Current Password<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
<!--								<input type="password" name="currPwd" required="required" class="form-control"/>-->
								<input type="password" name="currPwd"  class="form-control" id="currPwd"/>
							</div>
						</div>
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="last-name">New Password <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="password" name="newPwd" required="required" class="form-control" id="newPwd"/>
								@error('newPwd')
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2" >Confirm Password<span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6">
								<input type="password" name="confirmPwd" required="required" class="form-control" id="confirmPwd"/>
								@error('confirmPwd')
									<span class="text-danger">{{$message}}</span>
								@enderror
								<input type="checkbox" class="my-3 mr-2" id="showPwd">Show Password
							</div>
							
						</div>
						
						{{-- <div class="ln_solid"></div> --}}
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
								{{-- <button class="btn btn-primary" type="button">Cancel</button>
								<button class="btn btn-primary" type="reset">Reset</button> --}}
								<button type="submit" class="btn btn-success">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<br />

{{-- </div> --}}

<!-- /page content -->

@endsection
@section('scripts')
<script src="{{ asset('vendors/echarts/dist/echarts.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
	$(document).ready(function(){
		$('#img').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});


		$("#showPwd").click(function () {
			var x = document.getElementById("currPwd");
			var y = document.getElementById("newPwd");
			var z = document.getElementById("confirmPwd");

			if (x.type === "password") {
				x.type = "text";
				y.type = "text";
				z.type = "text";
			} else {
				x.type = "password";
				y.type = "password";
				z.type = "password";
			}

// 			var type = $(inputField).attr("type"); 
// // now test it's value
// if( type === 'password' ){
//   $(inputField).attr("type", "text");
// }else{
//   $(inputField).attr("type", "password");
// } 
		})
	});
</script>



@endsection