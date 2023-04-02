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
            <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCourAdd">Add</button>
            <button type="button" class="btn btn-danger btn-sm" id="btnDelete" link="{{route('admin.couriertype.delete')}}">Delete</button>

          </div>
          <div class="row">
            {{-- <div class="col-sm-12"> --}}
              <div class="card-box table-responsive">
                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkall"></th>
                      <th>No</th>
                      <th>Name</th>
                      <th>Url</th>
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($courType as $key=>$cour)
                    <tr>
                      <td><input type="checkbox" class="checkboxtest" value="{{ $cour->id }}"></td>
                      <td>{{ $key+1 }}</td>  
                      <td>{{ $cour->name }}</td>
                      <td><a href="{{ $cour->url }}" target="_blank">{{ $cour->url }}</a></td>
                      <td>
                        @if($cour->status == '1')
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Not Active</span>    
                        @endif
                      </td>
                      <td>{{ \Carbon\Carbon::parse($cour->created_at)->format('d-m-Y h:i A')}}</td>
                      <td>
                      <button type="button"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-cour-{{$cour->id}}">Edit</button>
                      {{-- modal --}}
                      <div id="modal-cour-{{$cour->id}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Update Courier Type</h4>
                              <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <form action="{{ route('admin.couriertype.update', $cour->id)}}" method="POST">
                              @csrf
                            <div class="modal-body">
                              <div class="item form-group">
                                <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Name<span class="text-danger">*</span>
                                </label>
                                <div class="col-form-label col-md-10 col-sm-10 ">
                                    <input type="text" name="courier_name"  class="form-control text-uppercase"  value="{{ old('cour_name') ??  $cour->name  }}" required>
                                    @error('courier_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                              </div>
                              <div class="item form-group">
                                  <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Url<span class="text-danger">*</span>
                                  </label>
                                  <div class="col-form-label col-md-10 col-sm-10 ">
                                      <input type="text" name="courier_url"  class="form-control"  value="{{ old('courier_url') ??  $cour->url  }}" required>
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
                                      <option value="0" {{ ($cour->status == '0') ? 'selected':''}}>Not Active</option>
                                      <option value="1" {{ ($cour->status == '1') ? 'selected':''}}>Active</option>
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
                      {{-- end modal --}}
                      </td>        
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            {{-- </div> --}}
          </div> {{-- end row--}}
        </div>
      </div>
		</div>
	</div>
</div>


<!-- /top tiles -->

<div id="modalCourAdd" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Courier Type</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="{{ route('admin.couriertype.store')}}" method="POST">
        @csrf
      <div class="modal-body">
        <div class="item form-group">
          <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Name<span class="text-danger">*</span>
          </label>
          <div class="col-form-label col-md-10 col-sm-10 ">
              <input type="text" name="courier_name"  class="form-control text-uppercase"  value="{{ old('cour_name') }}" required>
              @error('courier_name')
              <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Url<span class="text-danger">*</span>
            </label>
            <div class="col-form-label col-md-10 col-sm-10 ">
                <input type="text" name="courier_url"  class="form-control"  value="{{ old('courier_url') }}" required>
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
<script>

$(document).ready(function(){
  $("#btnDelete").click(function() 
  {
    var link = $(this).attr("link");
    getValueToDelete(link);
  });
})
  function getValueToDelete(link){
        // var ssl = $('#ssl').val();
        // let token   = $('meta[name="csrf-token"]').attr('content');
        var checkboxtest =[];
        
        $.each($(".checkboxtest:checked"), function() {
            checkboxtest.push($(this).val());
        });
    
        
        var select = checkboxtest ;
        // console.log(select);
        if(select.length == 0)
        {
            alert("Please check at least one checkbox !");  
        }
        else 
        {
        Swal.fire({
            title: 'Confirm delete selected item ?',
            // text: "Padam maklumat ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1f3bb3',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
            }).then((result) =>
            {
                
                if (result.isConfirmed)
                {
                 
                    $.ajax({  
                    url:link,
                    type:"POST",
                    data:{
                        select:select,
                        _token: "{{ csrf_token() }}",
                    },
                        success:function(data){  
                        Swal.fire({
                            title: data[0],
                            //text: 'Do you want to continue',
                            icon:data[1],
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#1f3bb3',
                        }).then(function() {
														$(".checkboxtest").prop("checked", false);
														$("#checkall").prop("checked", false);
                            location.reload();
                            });
                        }  
                    });
                }
            })
            
        }    
    }

</script>
@endsection