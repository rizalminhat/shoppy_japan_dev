@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->

	<li class="breadcrumb-item"><a href="{{ route('admin.shoppingsite.view')}}">Site List</a></li>
	<li class="breadcrumb-item active">Edit</li>
	{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
	</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Edit Shopping Site</h3>
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
					<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('admin.shoppingsite.update', $site->id)}}">
						@csrf
						<div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name">Site Name<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text"  name="brandName"  class="form-control"/ value="{{ $site->site_name }}">
								@error('brandName')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label
								class="col-form-label col-md-2 col-sm-2"
								for="last-name"
								>Site URL <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<input type="text" id="last-name" name="brandUrl" required="required" class="form-control" value="{{ $site->site_url }}">
								@error('brandUrl')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label
								class="col-form-label col-md-2 col-sm-2"
								for="last-name"
								>Status Display <span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-sm-6">
								<select name="brandStatus" id="" class="form-control">
									<option value="" disabled selected>--Select Status--</option>
									<option value="0" {{ ($site->site_status == '0') ? 'selected':''}}>Not Active</option>
									<option value="1" {{ ($site->site_status == '1') ? 'selected':'' }}>Active</option>
								</select>
								
								@error('brandStatus')
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="item form-group">
							<label for="middle-name" class="col-form-label col-md-2 col-sm-2" >Site Image<span class="text-danger">*</span></label>
							<div class="col-md-6 col-sm-6">
								<input id="img" class="form-control" type="file" name="brandImage"/>
								@error('brandImage')
								<div class="text-danger">{{ $message }}</div>
								@enderror
								<img class="img-fluid my-3" id="showImage"  width="50%" src="{{ (!empty($site->site_img)) ? asset('storage/upload/brand_images/'.$site->site_img) : '' }}" alt="site image">								
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