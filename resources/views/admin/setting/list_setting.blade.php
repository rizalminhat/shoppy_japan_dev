@extends('admin.layouts.main')
@section('content')
<!-- page content -->
{{-- <div class="right_col" role="main"> --}}
<!-- top tiles -->
	<li class="breadcrumb-item active">Currency Rate & Service Charges</li>
	{{-- <li class="breadcrumb-item active">Add</li> --}}
	{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
	</ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Currency Rate & Service Charges</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                  <div class="x_title">
                    {{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
                     <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button> --}}
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
                          <th>Currency Rate</th>
                          <th>Service Charges</th>
                          <th>Action</th>
                          
                         
                        </tr>
                      </thead>


                      <tbody>
                      
                        @foreach($configs as $key => $config)
                        <tr>
                            
                        <td><input type="checkbox" class="checkboxtest" value=""></td>
                        <td>{{ $key+1 }}</td>  
                        <td>{{ $config->currency_yentomyr }}</td>
                        <td>{{ $config->services_charge }}</td>
                        <td>
                        <button type="button" id="modal1" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalConfig">Edit</button>	

                        <div id="modalConfig" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Settings</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <form action="{{ route('admin.config.update', $config->id)}}" method="POST">
                                @csrf
                              <div class="modal-body">
                                <div class="item form-group">
                                  <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Currency Rate<span class="text-danger">*</span>
                                  </label>
                                  <div class="col-form-label col-md-10 col-sm-10 ">
                                      <input type="number" step="0.001" min="0.001" name="currency_rate"  class="form-control"  value="{{ old('currency_rate') ??  $config->currency_yentomyr  }}" required>
                                      @error('currency_rate')
                                      <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                  </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Service Charge<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-form-label col-md-10 col-sm-10 ">
                                        <input type="text" name="service_charge"  class="form-control" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="{{$config->services_charge}}" required>
                                        @error('service_charge')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
                        </td>        
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
@endsection