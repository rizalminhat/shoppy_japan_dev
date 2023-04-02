@extends('user.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
	<li class="breadcrumb-item"><a href="{{ route('user.profile')}}">Profile</a></li>
	<li class="breadcrumb-item active">Image</li>
	{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
	</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Profile Image</h3>
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
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('user.updateprofileimg')}}">
						@csrf

						<div class="item form-group">
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2" >Choose Image<span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6">
								<input id="img" class="form-control" type="file" name="userImage"/>
								<div class="text-danger">*Limit file size 2MB</div>
								@error('userImage')
								<div class="text-danger">{{ $message }}</div>
								@enderror
								
								<img class="img-fluid my-3" id="showImage"  width="50%" src="{{ (!empty($user->user_image) ? asset('storage/upload/user_image/'.$user->user_image):asset('main/img/person_icon.png'))}}" alt="product image">
								
							</div>
						</div>

						
						{{-- <div class="ln_solid"></div> --}}
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
								{{-- <button class="btn btn-primary" type="button">Cancel</button>
								<button class="btn btn-primary" type="reset">Reset</button> --}}
								<button type="submit" class="btn btn-success">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
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