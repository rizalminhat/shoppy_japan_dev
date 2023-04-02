@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Buyer List</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Buyer List</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                  <div class="x_title">
                    {{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a> --}}
                     {{-- <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button> --}}
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
                          <th>No Phone</th>
                          <th>Email</th>
                          <th>Home Address</th>
                         
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($buyers as $key => $buyer)
                        <tr>
                            
                        <td><input type="checkbox" class="checkboxtest" value="{{ $buyer->id }}"></td>
                        <td>{{ $key+ 1}}</td>  
                        <td><a href="{{ route('admin.buyer.detail', $buyer->id )}}">{{ $buyer->name }}</a></td>
                        <td>{{ $buyer->phone }}</td>
                        <td>{{ $buyer->email }}</td>
                        {{-- E:\ZnnServer\shoppyjapan\storage\app\public\upload\brand_images\6284e47fe55aewomen.jpg --}}
                        <td>
                          @if($buyer->address1 != NULL)
                          {{ $buyer->address1 }}, {{ $buyer->address2 }} {{ $buyer->address3 }}  {{ $buyer->postcode }} {{ $buyer->city }}, {{ $buyer->state }}</td>
                          @endif
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