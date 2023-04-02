@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Weekly Sales</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Weekly Sales ({{ $weekStartDate }} - {{ $weekEndDate }})</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<!-- kotak atas -->
	<div class="row">
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-money"></i><b> TOTAL SALES </b></h2>
	                <h1 class="text-white"><b>RM {{ number_format($sumByWeek,2) }}</b></h1>
	                
	            </div>
	        </div>
	    </div>
	   
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-stack-overflow"></i><b> TOTAL ORDER </b></h2>
	                <h1 class="text-white"><b>{{ $total_orders }}</b></h1>
	               
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-user"></i><b> TOTAL BUYER </b></h2>
	                <h1 class="text-white"><b>{{ $buyers }}</b></h1> <!-- $buyers->total -->
	              
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-user"></i><b> TOTAL LINKS </b></h2>
	                <h1 class="text-white"><b>{{ $weeklyLinks }}</b></h1> <!-- $buyers->total -->
	              
	            </div>
	        </div>
	    </div>
    </div>

    <!-- total orders daily + order status -->
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
	        <div class="dashboard_graph">
	            <div class="row x_title">
		            <div class="col-md-6">
		                <h2>Total Sales Weekly</h2>
		            </div>
		            <!-- <div class="col-md-6">
		                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
		                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
		                  <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
		                </div>
		            </div> -->
	            </div>

	            <div class="col-md-12 col-sm-12 ">
	              	<!-- <div id="chart_plot_01" class="demo-placeholder"></div> -->
	              	<!-- <div class="x_content"> -->
		            	<canvas id="barChartTotalSales"></canvas>
		            	<!-- <canvas id="graph_bar"></canvas> -->
		            	<!-- <div id="graph_bar" style="width:100%; height:280px;"></div> -->
		          	<!-- </div> -->
	            </div>

<!--
	            <div class="col-md-5 col-sm-5  bg-white">
		            <div class="col-md-12 col-sm-12 ">
			            <div class="x_panel tile fixed_height_320 overflow_hidden">
			                <div class="x_title">
			                  <h2>Order Status</h2>
			                 
			                 
			                </div>
			                 <canvas id="canvasDoughnutOne" class="canvasDoughnutOne" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
			            </div>
       
		            </div>
	            </div>
-->

	            <div class="clearfix"></div>
	        </div>
        </div>
    </div>

    <br>
  

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
	// $(function() {
		// 	function init_charts() {
		// 		console.log('run_charts  typeof [' + typeof (Chart) + ']');
		// 		if( typeof (Chart) === 'undefined'){ return; }
		// 		console.log('init_charts');
		// 		Chart.defaults.global.legend = { enabled: false };

		// 		// Bar chart 
		// 		if ($('#mybarChartOne').length ){ 

	// BAR CHART NUMBER OF ORDERS DAILY	  
		var nameSaleDaily = @json($dateDaily);
		var totalSaleDaily =  @json($totalDaily);
		
		const realSales2 = [];
		for (let i = 0; i < totalSaleDaily.length; i++) {
			var totalSales2 = +totalSaleDaily[i].toFixed(2);
			realSales2.push(totalSales2);
		}
		var ctx = document.getElementById("barChartTotalSales");
		var barChartTotalSales = new Chart(ctx, {
			type: 'bar',
			height: 350,
			data: {
			  	labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
			  	datasets: [{
					label: 'Total Sales', //Total Sales
					backgroundColor: "#26B99A",
					data: realSales2 //[51, 30, 40, 28, 92, 50, 45]
			  	}/*, {
					label: '# of Sales',
					backgroundColor: "#03586A",
					data: [41, 56, 25, 48, 72, 34, 12]
			  	}*/]
			},

			options: {
				scales: {
					yAxes: [{
					  	ticks: {
							beginAtZero: true
					  	}
					}]
				}
			}
		});

	//CANVAS DOUGHNUT ORDER STATUSES 1
	var statusWeekly = @json($statusWeekly);
	
//	console.log(statusWeekly);
	const totalStatus = [];
	const nameStatus = [];
		for (let i = 0; i < statusWeekly.length; i++) {
			
			totalStatus.push(statusWeekly[i].total);
			 nameStatus.push(statusWeekly[i].order_status);
		}
	
//	console.log(totalStatus);
		var ctx = document.getElementById("canvasDoughnutOne");
	  	var data = {
			labels: nameStatus,
			datasets: [{
				data: totalStatus,
				backgroundColor: ["#BDC3C7","#26B99A","#3498DB"],
				hoverBackgroundColor: ["#34495E","#B370CF","#CFD4D8"]
			}]
		};
		var canvasDoughnut = new Chart(ctx, {
			type: 'doughnut',
			tooltipFillColor: "rgba(51, 51, 51, 0.55)",
			data: data
		});

	//CANVAS DOUGHNUT ORDER STATUSES 
		
	

	/*	// 	} 
		// }
  		// 	}); */
</script>




@endsection