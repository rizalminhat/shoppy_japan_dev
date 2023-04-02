@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->

	<li class="breadcrumb-item active">Product List</li>
	
	</ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Product List</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                  <div class="x_title">
                    <a href="{{ route('admin.product.create')}}" class="btn btn-primary">Add</a>
                     <button class="btn btn-danger" id="delete" href="{{ route('admin.product.delete')}}">Delete</button>
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
                          <th>Shopping Site</th>
                          <th>Url</th>
                          <th>Price (&#165;)</th>
                          <th>Price (RM)</th>
                          <th>Created At</th>

                          <th>Status Display</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($products as $key => $product)
                        <tr>
                            
                        <td><input type="checkbox" class="checkboxtest" value="{{ $product->id }}"></td>
                        <td>{{ $key+ 1}}</td>  
                        <td>{{ ucfirst($product->product_name)}}</td>
                        <td>
                          @if(!empty($product->site->site_name))
                          {{ $product->site->site_name}}
                          @else
                          <span class="badge badge-danger">Unknown</span>
                          @endif
                        </td>
                        <td>
                          @if(!empty($product->product_url))
                          <a href="{{ $product->product_url }}" target="_blank">Product Link</a>
                          @else
                          Not Set
                          @endif
                        </td>
                        <td>{{ number_format($product->product_price, 0, ".", ",") }}</td>
                        <td>
                          @php
                          $priceRm = $product->product_price * $config->currency_yentomyr;
                          @endphp

                          {{number_format($priceRm, 2)}}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d-m-Y h:i:s A')}}</td>

                        <td>
                          @if($product->product_status == '0')
                          <span class="badge badge-danger">Not Active</span>
                          @elseif($product->product_status == '1')
                          <span class="badge badge-success">Active</span>
                          @else
                          <span class="badge badge-warning">Unknown</span>
                          @endif
                        </td>
                        <td><img src="{{ asset('storage/upload/product_images/'.$product->product_img)}}" alt="" width="150px"></td>
                        {{-- E:\ZnnServer\shoppyjapan\storage\app\public\upload\brand_images\6284e47fe55aewomen.jpg --}}
                       
                        <td><a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-info btn-sm">Edit</a></td>
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