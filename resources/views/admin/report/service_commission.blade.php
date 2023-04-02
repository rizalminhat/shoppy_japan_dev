@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Service Commmission</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Service Commission for Month ({{ $monthName }})</h3>
    </div>
  </div>
  <div class="clearfix"></div>
 
  <!-- kotak atas -->
  <div class="row">
    <div class="col-md-3">
      <div class="x_panel bg-c-green br-1"> 
        <div class="x_content">
            <h2 class="text-white"><i class="fa fa-money"></i><b> TODAY LINKS </b></h2>
            <h1 class="text-white"><b>{{$todayLinks}} links</b></h1>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="x_panel bg-c-green br-1"> 
          <div class="x_content">
              <h2 class="text-white"><i class="fa fa-stack-overflow"></i><b> WEEKLY LINKS ({{ $weekStartDate }} - {{ $weekEndDate }})</b></h2>
              <h1 class="text-white"><b>{{ $weeklyLinks }} links</b></h1>
          </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="x_panel bg-c-green br-1"> 
          <div class="x_content">
              <h2 class="text-white"><i class="fa fa-user"></i><b> MONTHLY LINKS {{ date('M-Y')}}</b></h2>
              <h1 class="text-white"><b>{{ $monthlyLinks }} links</b></h1>
          </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="x_panel bg-c-green br-1"> 
          <div class="x_content">
              <h2 class="text-white"><i class="fa fa-user"></i><b> YEARLY LINKS - {{ date('Y') }}</b></h2>
              <h1 class="text-white"><b>{{ $yearlyLinks }} links</b></h1>
          </div>
      </div>
    </div>
  </div>

  <br>
  <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_content">
              <div id="dailyChart"></div>
            </div>
        </div>
      </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="row x_title">
          <div class="col-md-6">
              <h2>Total Links Monthly for the Year {{ $currYear }}</h2>
          </div>
        </div>
        <div class="x_content">
          <!-- <div id="monthlyChart"></div> -->
          <canvas id="barChartTotalLinkMonthly"></canvas>              
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="row x_title">
          <div class="col-md-6">
              <h2>Total Links Daily for this Week ({{$weekStartDate}} - {{$weekEndDate}})</h2>
          </div>
        </div>
          <div class="x_content">
            <!-- <div id="monthlyChart"></div> -->
            <canvas id="barChartTotalLinkWeekly"></canvas>              
          </div>
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
    // BAR CHART TOTAL LINKS DAILY FOR A MONTH  
      var totalLinkDaily =  @json($totalDaily);
      var year = new Date().getFullYear();
      const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      const d = new Date();
      
        var options = {
        chart: {
          type: 'area',
          height: 350,
          zoom: { enabled: false}
        },
        title: {
              text: 'Daily Links In '+ monthNames[d.getMonth()] + ' ' + year,
              align: 'left'
            },
        series: [{
          name: 'Total links',
          data: totalLinkDaily  //[51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 51, 30, 40, 28, 92, 30, 40, 28, 92, 100,51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 78]
        
        }],
        xaxis: {
          categories: @json($fetchDayInMonth),
          title: {text: 'Date'}
        },
        yaxis: {
          tickAmount: 3,
          labels: {
                formatter: function(val) {
                return val.toFixed(0);
              }
          },
          title: {text: 'Total links'}
          }
      }

      var dailyChart = new ApexCharts(document.querySelector("#dailyChart"), options);

      dailyChart.render(); 

    // BAR CHART TOTAL LINKS WEEKLY FOR A YEAR  
      /*var totalSalessDaily =  @json($totalDaily);
      var year = new Date().getFullYear();
      const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      const d = new Date();
      
        var options = {
        chart: {
          type: 'area',
          height: 350,
          zoom: { enabled: false}
        },
        title: {
              text: 'Daily Sales In '+ monthNames[d.getMonth()],
              align: 'left'
            },
        series: [{
          name: 'Total Links',
          data: totalSaleDaily  //[51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 51, 30, 40, 28, 92, 30, 40, 28, 92, 100,51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 78]
        
        }],
        xaxis: {
          categories: ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"],
          title: {text: 'Date'}
        },
        yaxis: {
          tickAmount: 3,
          labels: {
                formatter: function(val) {
                return val.toFixed(0);
              }
          },
          title: {text: 'Total Links'}
          }
      }

      var chart = new ApexCharts(document.querySelector("#chart"), options);

      chart.render(); */

    // BAR CHART TOTAL LINKS MONTHLY FOR A YEAR  
      /*var MonthlyLinks =  @//json($totalLinksMonthly);
      var year = new Date().getFullYear();
      //const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      //const currentYear = new Date().getFullYear();
      const d = new Date();
      var options = {
        chart: {type: 'area',height: 350,zoom: { enabled: false}},
        title: {
              //text: 'Monthly Links In Year '+ currentYear,
              align: 'left'
            },
        series: [{
          name: 'Total Links',
          data: MonthlyLinks //[51, 30, 40, 28, 92, 30, 40, 28, 92, 100, 51, 30, 40, 28, 92]  //
        }],
        xaxis: {
          categories: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
          title: {text: 'Date'}
        },
        yaxis: {
          tickAmount: 3,
          labels: {
                formatter: function(val) {
                return val.toFixed(0);
              }
          },
          title: {text: 'Total Links'}
          }
      }
      var monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), options);
      monthlyChart.render(); /**/
    
    // BAR CHART V2 TOTAL LINKS MONTHLY FOR A YEAR   
      var totalLinkMonthlyyy =  @json($totalLinksMonthly);
      var monthName = @json($fetchMonth);
      console.log(monthName);
      var ctx = document.getElementById("barChartTotalLinkMonthly");
      var yearNo = new Date().getFullYear();
      var barChartTotalLinkMonthly = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthName,
            datasets: [{
            label: 'Total Links Monthly' , //Total Sales
            backgroundColor: "#26B99A",
            data: totalLinkMonthlyyy //[51, 30, 40, 28, 92, 50, 45]
            }]
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
      });/**/

    // BAR CHART V2 TOTAL LINKS WEEKLY FOR A YEAR   
      var weeklyLinks =  @json($totalLinksWeekly);
      var ctx = document.getElementById("barChartTotalLinkWeekly");
      var yearNo = new Date().getFullYear();
      var barChartTotalLinkWeekly = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            datasets: [{
            label: 'Total Links Daily' , //Total Sales
            backgroundColor: "#26B99A",
            data: weeklyLinks //[51, 30, 40, 28, 92, 50, 45]
            }]
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
      });/**/
  </script>

@endsection