@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Transaction List</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Transaction List</h3>
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
					  @if(Route::currentRouteName() == 'admin.attempt_transaction')
					  		<div class="row mb-3">
                                <div class="text-right col-12"><button class="btn btn-primary btn-sm" id="btnRequery">Re-Query Transaction</button></div>
                            </div>
					  @endif
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
                          <th>Email/No Phone</th>
                          <th>Order Ref</th>
							<th>Type</th>
                          <th>Amount</th>
						  <th>Date</th>
						  <th>Status</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($order as $key => $or)
                        <tr>
                            
                        <td><input type="checkbox" class="checkboxlist" value="{{ $or->online_order_id }}"></td>
                        <td>{{ $key+ 1}}</td>  
                        <td><a href="{{ route('admin.buyer.detail', $or->online_user_id )}}">{{ $or->name }}</a></td>
							<td>{{ $or->email }}<br/><span class="small">{{ $or->phone }}</span></td>
                        <td>{{$or->online_order_reference}}</td>
							<td>{{$or->online_order_type}}</td>
						<td><div class="text-right">{{number_format($or->online_order_amount,2)}}</div></td>
							<td>{{date('d/m/y h:i A',strtotime($or->online_order_created))}}</td>
							<td><div class="text-center">{{$or->online_order_status_name}}</div></td></tr>
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
<div id="attemptIn" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Status Item</h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">x</span>
				</button>
			</div>
			
			<div class="modal-body" id="data_modal">
			
			
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary d-none">Save</button>
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
		
		$("#btnRequery").click(function(){
			if($(".checkboxlist:checked").length == 1){
			   $.ajax({  
					url:"{{route('admin.requery')}}",
					type:"POST",
					data:{
						data_value:$(".checkboxlist:checked").val(),
						_token: "{{ csrf_token() }}",
					},
					success:function(data){  
							$('#attemptIn').find('.modal-title').html(data[1]);
							$('#attemptIn').find('.modal-body').html(data[0]);
							$('#attemptIn').find('.modal-footer').html(data[2]);
							$('#attemptIn').modal('show');
					
						$('#reprocess').click(function(){
							$('#transform').submit();
						});

						/*Swal.fire({
							title: data[0],
							//text: 'Do you want to continue',
							icon:data[1],
							confirmButtonText: 'Close',
							confirmButtonColor: '#1f3bb3',
						}).then(function() {
														//$(".checkboxtest1").prop("checked", false);
														//$("#checkall1").prop("checked", false);
							//location.reload();
							});*/
					}  
				});
			}else{
				alert('Please select one data only...');
			}
		});
		
    });
    
</script>

@endsection