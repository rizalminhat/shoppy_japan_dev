@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>List Shopping Sites</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                  <div class="x_title">
                    <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
                     <button class="btn btn-danger">Delete</button>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    {{-- <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p> --}}
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                      <thead>
                        <tr>
                         
							 <th><input type="checkbox" id="check-all" ></th>
						  
                          <th>Name</th>
                          <th>URL</th>
                          <th>Image</th>
                          <th>Created At</th>
                         
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($sites as $site)
                        <tr>
                                  
                        <td><input type="checkbox" id="check-all" ></td>
                        <td>{{ $site->brand_name}}</td>
                        <td>{{ $site->brand_url}}</td>
                        <td><img src="{{ url('upload/brand_images/'.$site->brand_img)}}" alt="" width="150px"></td>
                        <td>{{ \Carbon\Carbon::parse($site->created_at)->format('d-m-Y h:i:s A')}}</td>
                      
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  </div>
              </div>
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