@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Add Shopping Sites</h3>
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
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.shoppingsite.store')}}">
						@csrf
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Shopping Site Name<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" id="first-name" name="brandName" required="required" class="form-control"/>
							</div>
						</div>
						<div class="item form-group">
							<label
								class="col-form-label col-md-2 col-sm-2"
								for="last-name"
								>Shopping Site URL <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" id="last-name" name="brandUrl" required="required" class="form-control"/>
							</div>
						</div>
						<div class="item form-group">
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2" >Shopping Site Image<span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6">
								<input id="img" class="form-control" type="file" name="brandImage"/>
								<img class="img-fluid my-3" id="showImage"  width="50%" src="" alt="brand image">
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