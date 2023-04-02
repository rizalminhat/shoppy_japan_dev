@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Financial Report</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Report Financial</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
		   <div class="x_panel">
                <div class="x_title">
                  	<!-- fefefef -->
                    <!-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a> -->
                    <!-- <a href="" class="btn btn-primary">Add</a> -->
                    <!-- <button class="btn btn-danger" id="delete" href="{{-- route('admin.shoppingsite.delete')--}}">Delete</button>> -->
                    <!-- <button class="btn btn-danger" id="delete" href="">Delete</button> -->
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                	<!-- by date, month, year, receipt, statement -->
                	<div class="card-body">
			            {{-- @if(request()->is('admin*'))
		  			    	<form id="jquery-val-form" class="form" action="{{ route('report.hasil_report_financial') }}" method="POST">
		  		    		@else
		  			    	<form id="jquery-val-form" class="form" action="{{ route('usermembers.updatepassword',Auth::guard('user')->user()->member->meme_index) }}" method="POST">	
		  		    	@endif --}}		
		                @csrf
		                @method('PUT')
		                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="GET" action="{{ route('admin.report.hasil_report_financial') }}">
							<div class="row">
		  					    <div class="col-12"><!-- jenis laporan -->
			                      	<div class="mb-1 row">
			                      		<div class="col-md-2 col-sm-2">
											<label class="col-form-label" name="report___type">REPORT TYPE <span class="text-danger">*</span></label>
										</div>
										<div class="col-md-7 col-sm-7">
											<select class="form-control" name="report_type" id="report_type" required>
												<option value="" selected disabled>-- Choose Report Type -- </option>
												<option value="r_date">Report by Date</option>
		                                		<option value="r_month">Report by Month</option>
		                                		<option value="r_year">Report by Year</option>
												<option value="r_month_year">Report by Month and Year</option>
											</select>
										</div>
									</div>
			                    </div>

		  					    <div class="col-12" style="display:none" id="optdate"><!-- report by date -->
			                      	<div class="mb-1 row">
			                      		<div class="col-md-2 col-sm-2">
											<label class="col-form-label" name="bydate" id="bydate">DATE <span class="text-danger">*</span></label>
										</div>
										<div class="col-md-10 col-sm-10">
											<div class="col-sm-1">
		                      					<label class="col-form-label">FROM&nbsp;</label>
		                      				</div>
		                      				<div class="col-sm-3">
		                      					<!-- <input type="number" name="umur1" id="umur1" class="form-control w-100" required min="18" max="130" placeholder="18 TAHUN"> -->
		                      					<input name="fromdate" id="fromdate" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" />
		                      					<!-- required="required"  -->
		                      				</div>
		                      				<div class="col-sm-1">
		                      					<label class="col-form-label">TILL&nbsp;</label>
		                      				</div>
		                      				<div class="col-sm-3">
		                      					<input name="todate" id="todate" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" /> 
		                      					<!-- required="required"  -->
		                      				</div>
										</div>
									</div>
			                    </div>

		  					    <div class="col-12" style="display:none" id="optmonth"><!-- report by month -->
			                      	<div class="mb-1 row">
			                      		<div class="col-md-2 col-sm-2">
											<label class="col-form-label">MONTH <span class="text-danger">*</span></label>
										</div>
										<div class="col-md-7 col-sm-7">
										
											<select class="form-control" name="bymonth" id="bymonth">
	                                    		<option value="" selected disabled>-- Choose Month -- </option>
	                                  		 	@foreach($monthss as $key=>$data)
	                                  		 		<option value="{{ $data->month_code }}">{{ strtoupper($data->month_name) }}</option>
	                                  		 	@endforeach 
	                           				 	<?php /*<option value="{{ //$loop->iteration }}">{{ //strtoupper($value) }}</option> */ ?>
											</select>
										</div>
									</div>
			                    </div>

		  					    <div class="col-12" style="display:none" id="optyear"><!-- report by year -->
			                      	<div class="mb-1 row">
			                      		<div class="col-md-2 col-sm-2">
											<label class="col-form-label">YEAR <span class="text-danger">*</span></label>
										</div>
										<div class="col-md-7 col-sm-7">
											<select class="form-control" name="byyear" id="byyear">
												<option value="" selected disabled>-- Choose Year -- </option>
												<?php 
													$curYear = date("Y");
													
													for($i=2022; $i<=$curYear; $i++)
													{
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
													
												?>
											</select>
										</div>
									</div>
			                    </div>

		  					  	<br><br><br>
								<br><span class="text-danger">Information with (*) must be filled.</span>
								<br><br>
								
		  					    <div class="col-12"> <!-- button generate report / reset -->
			                      	<div class="mb-1 row">
			                          	<div class="col-sm-2">
			                          	</div>
			                          	<div class="col-sm-10">
			                               	<button type="submit" class="btn btn-primary">GENERATE REPORT</button>
											<button type="reset" class="btn btn-outline-secondary">RESET</button>	
			                          	</div>
			                      	</div>
			                    </div>
			                    <br><br><br><br><br>
			            
							</div>
		           		</form>
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
    	$('#report_type').on('change', function(){
			//var yaxis = this.value;
			var yaxis = document.getElementById('report_type');
			var datayaxis = yaxis.options[yaxis.selectedIndex].value;
			if(datayaxis == 'r_date'){
				$('#optdate').css('display','block');
				$('#optmonth').css('display','none');
				$('#optyear').css('display','none');
				//uncheckBox ();
			}
			if(datayaxis == 'r_month'){
				$('#optdate').css('display','none');
				$('#optmonth').css('display','block');
				$('#optyear').css('display','none');
				//uncheckBox ();
			}
			if(datayaxis == 'r_year'){
				$('#optdate').css('display','none');
				$('#optmonth').css('display','none');
				$('#optyear').css('display','block');
				//uncheckBox ();
			}
			if(datayaxis == 'r_month_year'){
				$('#optdate').css('display','none');
				$('#optmonth').css('display','block');
				$('#optyear').css('display','block');
				//uncheckBox ();
			}
		});

        $('#img').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });

        $('#datatable-buttons_filter').css({"position":"relative","left":"-100px"});
	    $('#myTable').DataTable( {
	      	"scrollX": true,
	      	lengthMenu: [[10, 100, 1000, -1],[10, 100, 1000, "Semua"]],
	      
	      	"dom": '<"top"<"left-col"l><"center-col"B><"right-col"f>>rtip',

	      	buttons: [
	        //'colvis',
	        {
	          extend: 'colvis',
	          className: "btn btn-warning dropdown-toggle mt-50 text-right",
	          text: feather.icons["printer"].toSvg({class: "font-small-4 me-50" }) + "Pilih Column",
	        },
	        {
	          extend: "collection",
	          className: "btn btn-dark dropdown-toggle mt-50 text-right",
	          text: feather.icons["printer"].toSvg({class: "font-small-4 me-50" }) + "Cetak",
	          buttons: [
	            {
	              extend: "print",
	              messageTop: ''+ reportName +'<br>'+ negeriTitle +'<br>'+ kawasanTitle +'<br>'+ cawanganTitle +'<br>'+ jantinaTitle +'<br>'+ etnikTitle +'<br>'+ umurTitle,
	              text: feather.icons.globe.toSvg({class: "font-small-4 me-50"}) + "WEB",
	              className: "dropdown-item",
	              exportOptions: {
	                  columns: [ 0, ':visible' ],
	                  rows: function ( idx, data, node ) {
	                  var table = $('.laporan-list-table').DataTable();
	                  var selected = [];
	                  $(".dt-checkboxes:checked").each(function() {
	                    console.log(table.row($(this).closest('tr')).index());
	                    selected.push(table.row($(this).closest('tr')).index());
	                  });
	                  if( selected.length === 0 || $.inArray(idx, selected) !== -1)
	                    return true;
	                  return false;
	                }
	              }
	            }, 
	            {
	              extend: "pdf",
	              messageTop: ''+ reportName +'\n'+ negeriTitle +'\n'+ kawasanTitle +'\n'+ cawanganTitle +'\n'+ jantinaTitle +'\n'+ etnikTitle +'\n'+ umurTitle,
	              text: feather.icons.file.toSvg({class: "font-small-4 me-50"}) + "PDF",
	              className: "dropdown-item",
	              orientation: "landscape",
	              pageSize: 'LEGAL', // TABLOID OR LEGAL
	              exportOptions: {
	                  //columns: [0,1,2,3,4,5,6,7,8,9],
	                  //columns: ':visible'
	                  columns: [ 0, ':visible' ],
	                  rows: function ( idx, data, node ) {
	                  var table = $('.laporan-list-table').DataTable();
	                  var selected = [];
	                  $(".dt-checkboxes:checked").each(function() {
	                    console.log(table.row($(this).closest('tr')).index());
	                    selected.push(table.row($(this).closest('tr')).index());
	                  });
	                  if( selected.length === 0 || $.inArray(idx, selected) !== -1)
	                    return true;
	                  return false;
	                }
	              }
	            } 
	          ],
	        }],

	      	"language": {
		        "lengthMenu": "Papar _MENU_ Entri",
		        "search": "Cari:",
		        paginate: {
		          previous: "&nbsp;",
		          next: "&nbsp;"
		        },
		        "zeroRecords": "Tiada Data - Maaf",
		        "info": "Paparan _START_ hingga _END_ daripada _TOTAL_ entri",
		        "infoEmpty": "Tiada Rekod",
		        "infoFiltered": "(Ditapis daripada _MAX_ jumlah rekod)",
		        "pageLength": 100
	       }
	    } );

    });    
</script>

<script>
	// $(document).ready(function () {
	// 	$('#report_type').on('change', function(){
	// 		//var yaxis = this.value;
	// 		var yaxis = document.getElementById('report_type');
	// 		var datayaxis = yaxis.options[yaxis.selectedIndex].value;
	// 		if(datayaxis == 'r_date'){
	// 			$('#optdate').css('display','block');
	// 			$('#optmonth').css('display','none');
	// 			$('#optyear').css('display','none');
	// 			//uncheckBox ();
	// 		}
	// 		if(datayaxis == 'r_month'){
	// 			$('#optdate').css('display','none');
	// 			$('#optmonth').css('display','block');
	// 			$('#optyear').css('display','none');
	// 			//uncheckBox ();
	// 		}
	// 		if(datayaxis == 'r_year'){
	// 			$('#optdate').css('display','none');
	// 			$('#optmonth').css('display','none');
	// 			$('#optyear').css('display','block');
	// 			//uncheckBox ();
	// 		}
	// 	});
	// })
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
		
	}
</script>

@endsection