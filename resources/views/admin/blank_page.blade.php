@extends('admin.layouts.main')
@section('content')
<!-- page content -->
<li class="breadcrumb-item active">Courier Type</li>
{{-- <li class="breadcrumb-item active">Add</li> --}}
{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
</ol>
</nav>

{{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Courier Type</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="text-right mb-3">
            <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAnnouce">Add</button>
            {{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
          <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button> --}}
          
          </div>
          <div class="row">
              <div class="card-box table-responsive">
                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkall" ></th>
                      <th>No</th>
                      <th>Currency Rate</th>
                      <th>Service Charges</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="checkbox" class="checkboxtest" value=""></td>
                      <td></td>  
                      <td></td>
                      <td></td>
                      <td>{{Carbon\Carbon::parse()->format('d-m-Y h:i:s A')}}</td>
                      <td>
                      <button type="button" id="modal1" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalConfig">Edit</button>	

                      
                      </td>        
                    </tr>
                  </tbody>
                </table>
              </div>
           
          </div> {{-- end row--}}
        </div>
      </div>
		</div>
	</div>
</div>

<!-- /top tiles -->


<br />
<div id="modalAnnouce" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Courier Type</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="" method="POST">
        @csrf
      <div class="modal-body">
        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Name<span class="text-danger">*</span>
          </label>
          <div class="col-form-label col-md-10 col-sm-10 ">
              <input type="text" name="courier_name"  class="form-control text-uppercase"  value="{" required>
              @error('courier_name')
              <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Url<span class="text-danger">*</span>
            </label>
            <div class="col-form-label col-md-10 col-sm-10 ">
                <input type="text" name="courier_url"  class="form-control"  value="" required>
                @error('courier_url')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">Status<span class="text-danger">*</span>
          </label>
          <div class="col-form-label col-md-10 col-sm-10 ">
              <select name="courier_status" id="" class="form-control">
                <option value="0">Not Active</option>
                <option value="1">Active</option>
              </select>
          </div>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>  

<!-- /page content -->

@endsection
@section('scripts')
@endsection