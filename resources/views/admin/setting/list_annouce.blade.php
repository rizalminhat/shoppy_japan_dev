@extends('admin.layouts.main')
@section('content')
<!-- page content -->
<li class="breadcrumb-item active">List Annoucement</li>
{{-- <li class="breadcrumb-item active">Add</li> --}}
{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
</ol>
</nav>

{{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>List Annoucement</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="text-right mb-3">
            <button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalAnnouce">Add</button>
            <button class="btn btn-danger" id="delete" href="{{ route('admin.annouce.delete')}}">Delete</button>
            {{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
          <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button> --}}
          
          </div>
          <div class="row">
              <div class="card-box table-responsive">
                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkall"></th>
                      <th>No</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Display</th>
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($annouce as $key=>$ann)
                    <tr>
                      <td><input type="checkbox" class="checkboxtest" value="{{$ann->id}}"></td>
                      <td>{{ $key+1}}</td>
                      <td>{{$ann->announce_title}}</td>  
                      <td>{{$ann->announce_description}}</td>
                      <td>
                        {{$ann->announce_type}}
                      </td>
                      <td>
                        @if($ann->announce_status == '0')
                        <span class="badge badge-danger">Not Active</span>
                        @else
                        <span class="badge badge-primary">Active</span>
                        @endif
                      </td>
                      <td>{{Carbon\Carbon::parse($ann->created_at)->format('d-m-Y h:i:s A')}}</td>
                      <td>
                      <button type="button"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-ann-{{$ann->id}}">Edit</button>	
                      <div id="edit-ann-{{$ann->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Edit Annoucement {{$ann->announce_title}}</h4>
                              <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <form action="{{ route('admin.annouce.update', $ann->id)}}" method="POST">
                              @csrf
                            <div class="modal-body">
                              <div class="item form-group">
                                <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Title <span class="text-danger">*</span>
                                </label>
                                <div class="col-form-label col-md-10 col-sm-10 ">
                                    <input type="text" name="ann_title"  class="form-control text-uppercase"  value="{{$ann->announce_title}}" required>
                                </div>
                              </div>
                              <div class="item form-group">
                                  <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Description <span class="text-danger">*</span>
                                  </label>
                                  <div class="col-form-label col-md-10 col-sm-10 ">
                                    <textarea class="form-control" rows="3" placeholder="" name="ann_desc">{{$ann->announce_description}}</textarea>
                                  </div>
                              </div>
                              <div class="item form-group">
                                <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">Display <span class="text-danger">*</span>
                                </label>
                                <div class="col-form-label col-md-10 col-sm-10 ">
                                    <select name="ann_type" id="" class="form-control">
                                      <option value="main page" {{ ($ann->announce_type == 'main page') ? 'selected':''}}>Main Page</option>
                                      <option value="user" {{ ($ann->announce_type == 'user') ? 'selected':''}}>User</option>
                                      <option value="both" {{ ($ann->announce_type == 'both') ? 'selected':''}}>Both</option>
                                    </select>
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">Status Display <span class="text-danger">*</span>
                                </label>
                                <div class="col-form-label col-md-10 col-sm-10 ">
                                    <select name="ann_status" id="" class="form-control">
                                      <option value="1" {{ ($ann->announce_status == '1') ? 'selected':''}}>Active</option>
                                      <option value="0" {{ ($ann->announce_status == '0') ? 'selected':''}}>Not Active</option>
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
                      </td>        
                    </tr>
                    @endforeach
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
        <h4 class="modal-title" id="myModalLabel">Add New Annoucement</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="{{ route('admin.annouce.store')}}" method="POST">
        @csrf
      <div class="modal-body">
        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Title <span class="text-danger">*</span>
          </label>
          <div class="col-form-label col-md-10 col-sm-10 ">
              <input type="text" name="ann_title"  class="form-control text-uppercase"  value="{{ old('cour_name') }}" required>
              @error('courier_name')
              <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Description <span class="text-danger">*</span>
            </label>
            <div class="col-form-label col-md-10 col-sm-10 ">
              <textarea class="form-control" rows="3" placeholder="" name="ann_desc"></textarea>
            </div>
        </div>
        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">Display <span class="text-danger">*</span>
          </label>
          <div class="col-form-label col-md-10 col-sm-10 ">
              <select name="ann_type" id="" class="form-control">
                <option value="main page">Main Page</option>
                <option value="user">User</option>
                <option value="both">Both</option>
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