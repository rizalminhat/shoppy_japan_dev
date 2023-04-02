@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Dashboard Sales Report</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Dashboard Sales Report</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	
	
	<!-- kotak atas -->
	<div class="row">
		<div class="col-md-3">
			<div class="x_panel bg-success br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Sales Previous Year </h2>
					<h2 class="text-white">{{$prevYear}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($tsPrevYear,2)}}</h3>
					
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="x_panel bg-success br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Sales Current Year </h2>
					<h2 class="text-white">{{$currYear}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($tsCurrYear,2)}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-success br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Sales Previous Month </h2>
					<h2 class="text-white">{{$prevMonth}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($tsPrevMonth,2)}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-success br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Sales Current Month </h2>
					<h2 class="text-white">{{$currMonth}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($tsCurrMonth,2)}}</h3>
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="x_panel bg-info br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Links Previous Year </h2>
					<h2 class="text-white">{{$prevYear}}</h2>
					<h3 class="text-white font-weight-bold">{{$tlpy}}</h3>
					
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="x_panel bg-info br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Links Current Year </h2>
					<h2 class="text-white">{{$currYear}}</h2>
					<h3 class="text-white font-weight-bold">{{$tlcy}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-info br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Links Previous Month </h2>
					<h2 class="text-white">{{$prevMonth}}</h2>
					<h3 class="text-white font-weight-bold">{{$tlpm}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-info br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Links Current Month </h2>
					<h2 class="text-white">{{$currMonth}}</h2>
					<h3 class="text-white font-weight-bold">{{$tlcm}}</h3>
					
				</div>
			</div>
		</div>
	</div>

	{{-- 3rd row --}}
	<div class="row">
		<div class="col-md-3">
			<div class="x_panel bg-danger br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Refund Previous Year </h2>
					<h2 class="text-white">{{$prevYear}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($trpy,2)}}</h3>
					
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="x_panel bg-danger br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Refund Current Year </h2>
					<h2 class="text-white">{{$currYear}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($trcy,2)}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-danger br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Refund Previous Month </h2>
					<h2 class="text-white">{{$prevMonth}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($trpm,2)}}</h3>
					
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="x_panel bg-danger br-1"> 
				<div class="x_content">
					<h2 class="text-white">Total Refund Current Month </h2>
					<h2 class="text-white">{{$currMonth}}</h2>
					<h3 class="text-white font-weight-bold">RM {{number_format($trcm,2)}}</h3>
					
				</div>
			</div>
		</div>
	</div>

<div class="row">
	<div class="col-md-6">
		<div class="x_panel">
			<div class="row x_title">
				<div class="col-md-6">
					
					<h2>Total Sales Year - {{$currYear}}</h2>
				</div>
			</div>
			<div class="x_content">
				<!-- <div id="monthlyChart"></div> -->
				
				<div id="barChartSalesCurrYear"></div>            
			</div>
			
		</div>
	</div>
	
	<div class="col-md-6 col-sm-12">
		<div class="x_panel">
		<div class="row x_title">
			<div class="col-md-6">
				<h2>Total Links Current Year - {{$currYear}}</h2>
			</div>
		</div>
			<div class="x_content">
			<!-- <div id="monthlyChart"></div> -->
				<div class="" id="totLinksCurrMon"></div>               
			</div>
		</div>
	</div>

</div>


<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="x_panel">
		<div class="row x_title">
			<div class="col-md-6">
				<h2>Total Sales Year - {{$prevYear}}</h2>
			</div>
		</div>
			<div class="x_content">
			<!-- <div id="monthlyChart"></div> -->
				<div class="" id="chart"></div>               
			</div>
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6">
		<div class="x_panel">
		<div class="row x_title">
			<div class="col-md-6">
				<h2>Total Links Prev Year - {{$prevYear}}</h2>
			</div>
		</div>
			<div class="x_content">
			<!-- <div id="monthlyChart"></div> -->
				<div class="" id="linksMonthPrevYear"></div>               
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
$(document).ready(function () {
	var fetchMonth = @json($fetchMonth);
	
	function chart1(fetchMonth){
		var salesMonthPrevYear =  @json($salesPrevYearByMonth);
		
		const realSales = [];
		for (let i = 0; i < salesMonthPrevYear.length; i++) {
			var totalSales = +salesMonthPrevYear[i].toFixed(2);
			realSales.push(totalSales);
		}

		var options1 = {
			series: [{
			name: 'Total Sales',
			data: realSales
			}],
			chart: {
			type: 'bar',
			height: 350,
			
			},
			colors: ['#dd6758', '#E91E63'],
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '40%',
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
			categories: fetchMonth,
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

			var chart1 = new ApexCharts(document.querySelector("#chart"), options1);

			chart1.render();
		}
	
	function chart2(fetchMonth){
		

		var salesMonthCurrYear =  @json($salesCurrYearByMonth);
//		var linksMonthCurrYear = @json($linksMonthCurrYear);
		// let sum = 0;
		// 				salesMonthPrevYear.forEach(item => {
		// 			sum += item;
		// 		});

		// console.log(sum);
		const realSales2 = [];
		for (let i = 0; i < salesMonthCurrYear.length; i++) {
			var totalSales2 = +salesMonthCurrYear[i].toFixed(2);
			realSales2.push(totalSales2);
		}


		var options2 = {
			series: [{
				name: 'Total Sales',
				data: realSales2,
			}],
				chart: {
				type: 'bar',
				height: 350,
			
			},
//			colors: ['#26B99A', '#E91E63'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '40%',
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
				categories: fetchMonth,
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

			var chart2 = new ApexCharts(document.querySelector("#barChartSalesCurrYear"), options2);

			chart2.render();
	}

	function chartLinkCurrMon(fetchMonth){
		

//		var salesMonthCurrYear =  @json($salesCurrYearByMonth);
		var linksMonthCurrYear = @json($linksMonthCurrYear);
		// let sum = 0;
		// 				salesMonthPrevYear.forEach(item => {
		// 			sum += item;
		// 		});

		// console.log(sum);
//		const realSales2 = [];
//		for (let i = 0; i < salesMonthCurrYear.length; i++) {
//			var totalSales2 = +salesMonthCurrYear[i].toFixed(2);
//			realSales2.push(totalSales2);
//		}


		var options3 = {
			series: [{
				name: 'Total Links',
				data: linksMonthCurrYear,
			}],
				chart: {
				type: 'bar',
				height: 350,
			
			},
//			colors: ['#26B99A', '#E91E63'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '40%',
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
				categories: fetchMonth,
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
					return  val
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

			var chart3 = new ApexCharts(document.querySelector("#totLinksCurrMon"), options3);

			chart3.render();
	}
	
	function chartLinkPrevMon(fetchMonth){
		

//		var salesMonthCurrYear =  @json($salesCurrYearByMonth);
		var linksMonthPrevYear = @json($linksMonthPrevYear);
	


		var options3 = {
			series: [{
				name: 'Total Links',
				data: linksMonthPrevYear,
			}],
				chart: {
				type: 'bar',
				height: 350,
			
			},
			colors: ['#dd6758', '#E91E63'],
			plotOptions: {
				bar: {
				horizontal: false,
				columnWidth: '40%',
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
				categories: fetchMonth,
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
					return  val
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

			var chart4 = new ApexCharts(document.querySelector("#linksMonthPrevYear"), options3);

			chart4.render();
	}
	chart1(fetchMonth);
	chart2(fetchMonth);
	chartLinkCurrMon(fetchMonth);
	chartLinkPrevMon(fetchMonth);
	
	$(document).bind("contextmenu",function(e) {
	 e.preventDefault();
	});

	$(document).keydown(function(e){
		if(e.which === 123){
		   return false;
		}
	});
})
</script>

@endsection