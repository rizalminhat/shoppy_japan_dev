@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->

 <li class="breadcrumb-item active">Site List</li>
    {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Site List</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                  <div class="x_title">
                    <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
                     <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button>
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
                          <th><input type="checkbox" id="checkall" ></th>
                          <th>No</th>
                          <th>Name</th>
                          <th>Url</th>
                          <th>Image</th>
                          <th>Status Display</th>
                          <th>Created At</th>
                          <th>Action</th>
                         
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($sites as $key => $site)
                        <tr>
                            
                        <td><input type="checkbox" class="checkboxtest" value="{{ $site->id }}"></td>
                        <td>{{ $key+ 1}}</td>  
                        <td>{{ $site->site_name}}</td>
                        <td><a href="{{ $site->site_url}}" target="_blank">{{ $site->site_url}}</a></td>
                        <td><img src="{{ asset('storage/upload/brand_images/'.$site->site_img)}}" alt="" width="150px"></td>
                        {{-- E:\ZnnServer\shoppyjapan\storage\app\public\upload\brand_images\6284e47fe55aewomen.jpg --}}
                        <td>
                          @if($site->site_status == '0')
                          <span class="badge badge-danger">Not Active</span>
                          @else
                           <span class="badge badge-success">Active</span>
                          @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($site->created_at)->format('d-m-Y h:i:s A')}}</td>
                        <td><a href="{{ route('admin.shoppingsite.show', $site->id) }}" class="btn btn-info btn-sm">Edit</a></td>
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