@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Monthly Sales</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Monthly Sales ({{ $monthName }})</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<!-- kotak atas -->
	<div class="row">
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-money"></i><b> TOTAL SALES </b></h2>
	                <h3 class="text-white font-weight-bold"><b>RM {{ number_format($sumByMonth,2) }}</b></h3>
	                
	            </div>
	        </div>
	    </div>
	  
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-stack-overflow"></i><b> TOTAL ORDER </b></h2>
	                <h3 class="text-white font-weight-bold"><b>{{ $totalOrders }}</b></h3>
	               
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-user"></i><b> TOTAL BUYER </b></h2>
	                <h3 class="text-white font-weight-bold"><b>{{ $buyers }}</b></h>
	                
	            </div>
	        </div>
	    </div>
	    <div class="col-md-3">
	        <div class="x_panel bg-c-green br-1"> 
	            <div class="x_content">
	                <h2 class="text-white"><i class="fa fa-user"></i><b> MONTHLY LINKS </b></h2>
	                <h3 class="text-white font-weight-bold"><b>{{ $monthlyLinks }}</b></h3>
	               
	            </div>
	        </div>
	    </div>
    </div>

	<!-- total sales -->
   

    <br>
    <div class="row">
      	<div class="col-md-12 col-sm-12">
        	<div class="x_panel">
          		<div class="x_content">
            		<div id="chart"></div>
          		</div>
        	</div>
      	</div>
		<div class="col-md-12 col-sm-12">
        	<div class="x_panel">
          		<div class="x_content">
            		<div id="chartLinks"></div>
          		</div>
        	</div>
      	</div>
    </div>

    <br>
    <!-- top product + order status donut chart -->
    

</div>

<!-- /top tiles -->


<br />

{{-- </div> --}}

<!-- /page content -->

@endsection
@section('scripts')
	<script src="{{ asset('vendors/echarts/dist/echarts.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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

		// BAR CHART TOTAL SALES	  
			// var ctx = document.getElementById("barChartTotalSales");
			// var barChartTotalSales = new Chart(ctx, {
			// 	type: 'bar',
			// 	data: {
			// 	  	labels: ["Week 1","Week 2","Week 3","Week 4","Week 5"],
			// 	  	datasets: [{
			// 			label: '# of Sales',
			// 			backgroundColor: "#26B99A",
			// 			data: [51, 30, 40, 28, 92]
			// 	  	}/*, {
			// 			label: '# of Sales',
			// 			backgroundColor: "#03586A",
			// 			data: [41, 56, 25, 48, 72]
			// 	  	}*/]
			// 	},

			// 	options: {
			// 		scales: {
			// 			yAxes: [{
			// 			  	ticks: {
			// 					beginAtZero: true
			// 			  	}
			// 			}]
			// 		}
			// 	}
			// });

		//CANVAS DOUGHNUT ORDER STATUSES 1
			/*var ctx = document.getElementById("canvasDoughnut");
		  	var data = {
				labels: ["Dark Grey","Purple Color","Gray Color","Green Color","Blue Color"],
				datasets: [{
					data: [120, 50, 140, 180, 100],
					backgroundColor: ["#455C73","#9B59B6","#BDC3C7","#26B99A","#3498DB"],
					hoverBackgroundColor: ["#34495E","#B370CF","#CFD4D8","#36CAAB","#49A9EA"]
				}]
			};
			var canvasDoughnut = new Chart(ctx, {
				type: 'doughnut',
				tooltipFillColor: "rgba(51, 51, 51, 0.55)",
				data: data
			});*/

		//CANVAS DOUGHNUT ORDER STATUSES 
		
//			var chart_doughnut_settingszz = {
//				type: 'doughnut',
//				tooltipFillColor: "rgba(51, 51, 51, 0.55)",
//				data: {
//					labels: nameOrderStatus, // ["Draft","Waiting","Process","Courier","Completed","Cancelled"],
//					datasets: [{
//						data: totalOrderStatus, //[15, 20, 30, 10, 30, 5]
//						backgroundColor: ["#f0f0f0","#ffe724","#1dacbb","#7e8181","#21a746","#ea3838"],
//										//["#BDC3C7","#9B59B6","#E74C3C","#26B99A","#3498DB"],
//										//[ putih, kuning, biru, grey, hijau, merah ]
//						hoverBackgroundColor: ["#c4c4c4","#ffef70","#7ff3ff","#bcc6c6","#2edc5e","#ff7b7b"]
//										//["#CFD4D8","#B370CF","#E95E4F","#36CAAB","#49A9EA",""]
//					}]
//				},
//				options: { 
//					legend: false, 
//					responsive: false 
//				}
//			}
//			$('.canvasDoughnutOne').each(function(){
//				var chart_element = $(this);
//				var chart_doughnut = new Chart( chart_element, chart_doughnut_settingszz);
//			});	 
		
		// BAR CHART TOTAL SALES DAILY FOR A MONTH	
//			var totalSaleDaily =  @json($totalSalesDaily);
//			var year = new Date().getFullYear();
//			const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
//			const d = new Date();
//		  
//		  	var options = {
//		  	chart: {
//			    type: 'area',
//			    height: 350,
//			    zoom: { enabled: false}
//		  	},
//		  	title: {
//		          text: 'Daily Sales In '+ monthNames[d.getMonth()],
//		          align: 'left'
//		        },
//		  	series: [{
//			    name: 'Total orders',
//			    data: totalSaleDaily  //[51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 51, 30, 40, 28, 92, 30, 40, 28, 92, 100,51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 78]
//		    
//		  	}],
//		  	xaxis: {
//		    	categories: ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],
//		    	title: {text: 'Date'}
//		  	},
//		  	yaxis: {
//		    	tickAmount: 3,
//		    	labels: {
//			      		formatter: function(val) {
//			        	return val.toFixed(0);
//			      	}
//			    },
//		    	title: {text: 'Total orders'}
//		  		}
//			}
//
//			var chart = new ApexCharts(document.querySelector("#chart2"), options);
//
//			chart.render(); 
		
		function chart2(fetchDays){
		

		var salesDaily =  @json($totalSalesDaily);
		var monthName = @json($monthName);
		// let sum = 0;
		// 				salesMonthPrevYear.forEach(item => {
		// 			sum += item;
		// 		});

		// console.log(sum);
		const realSales2 = [];
		for (let i = 0; i < salesDaily.length; i++) {
			var totalSales2 = +salesDaily[i].toFixed(2);
			realSales2.push(totalSales2);
		}


		var options2 = {
			series: [{
				name: 'Total Sales',
				data: realSales2,
			}],
				chart: {
				type: 'bar',
				height: 400,
			
			},
			title: {
		          text: 'Daily Sales In '+monthName,
		          align: 'left'
		        },
			colors: ['#26B99A', '#E91E63'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '50%',
				endingShape: 'rounded',
				
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 1,
				colors: ['black']
			},
			xaxis: {
				categories: fetchDays,
			},
			yaxis: {
				title: {
				text: 'Amount (RM)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
				formatter: function (val) {
					return "RM " + val
				}
				}
			},
			legend: {
				show: true,
				showForSingleSeries: true,
				showForNullSeries: true,
				showForZeroSeries: true,
				position: 'bottom',
				horizontalAlign: 'center', 
				floating: false,
				fontSize: '14px',
				fontFamily: 'Helvetica, Arial',
				fontWeight: 400,
			},
		};

			var chart2 = new ApexCharts(document.querySelector("#chart"), options2);

			chart2.render();
	}
		
		
	function chartLinks(fetchDays,monthName){
		

		var linkDaily =  @json($totalLinkDaily);
		var monthName = @json($monthName);


		var options2 = {
			series: [{
				name: 'Total Links',
				data: linkDaily,
			}],
				chart: {
				type: 'bar',
				height: 400,
			
			},
			title: {
		          text: 'Daily Links In '+monthName,
		          align: 'left'
		        },
			colors: ['#E91E63'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '50%',
				endingShape: 'rounded',
				
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 1,
				colors: ['black']
			},
			xaxis: {
				categories: fetchDays,
			},
			yaxis: {
				title: {
				text: 'Links'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
				formatter: function (val) {
					return + val
				}
				}
			},
			legend: {
				show: true,
				showForSingleSeries: true,
				showForNullSeries: true,
				showForZeroSeries: true,
				position: 'bottom',
				horizontalAlign: 'center', 
				floating: false,
				fontSize: '14px',
				fontFamily: 'Helvetica, Arial',
				fontWeight: 400,
			},
		};

			var chart2 = new ApexCharts(document.querySelector("#chartLinks"), options2);

			chart2.render();
	}
		
	chart2(@json($fetchDays));
	chartLinks(@json($fetchDays), @json($monthName));
	</script>

@endsection