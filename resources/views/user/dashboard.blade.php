@extends('user.layouts.main')
@section('content')
        <!-- page content -->
        {{-- <div class="right_col" role="main"> --}}
          <!-- top tiles -->
          {{-- <li class="breadcrumb-item active"><a href="{{ route('user.dashboard')}}">Dashboard</a></li> --}}
    {{-- <li class="breadcrumb-item active">List Items</li> --}}
    <li class="breadcrumb-item"><a href="{{ route('user.dashboard')}}">Dashboard</a></li>
  </ol>
</nav>

          <!-- /top tiles -->

<div class="">
	{{-- <div class="page-title">
		<div class="title_left">
			<h3>My Dashboard</h3>
		</div>
	</div> --}}
	<div class="clearfix"></div>
  @if (Auth::user()->user_announce == '1')  
  <div class="row mt-4">
    @foreach($announce as $an)
    <div class="col-md-6 mb-3">
      <div class="card border-left-shpyjp rounded-lg">
        <div class="card-title text-md-center">
          <h3 class="font-weight-bolder text-capitalize">{{$an->announce_title}}</h3>
        </div>
        <div class="card-body">
          <h6 class="text-justify">{{$an->announce_description}}</h6>

        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
      <div class="row my-4">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Track Order</small></h3>
                  </div>
                  
                </div>
                <div class="x_content">
					<br>
					<form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{ route('user.findorder')}}">
            @csrf
            <div class="item form-group">
							<label class="col-form-label col-md-2 col-sm-2" for="first-name"><h4>Order No.</h4></label>
							<div class="col-md-8 py-2">
								<input type="text"  name="orderNo" required="required" class="form-control">
							</div>
              <div class="col-md-2 py-2">
                  <button type="submit" class="btn btn-primary">Search</button>

              </div>
						</div>						
						<div class="item form-group text-right">
							<div class="col-md-12 col-sm-12 mt-2">
							</div>
						</div>
					</form>
				</div>
              

                <div class="clearfix"></div>
              </div>
            </div>

          </div>

    <div class="row">
      <div class="col-md-4 ">
        <div class="x_panel bg-c-blue br-1"> 
          <a href="{{ route('user.currentorder')}}">
              <div class="x_content">
                  <h2 class="text-white">New Orders</h2>
                  <h3 class="text-white">{{ $newOrder }}</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="x_panel bg-c-purple br-1"> 
            <div class="x_content">
              <a href="{{ route('user.currentorder') }}">
                <h2 class="text-white">Process Orders</h2>
                <h3 class="text-white">{{ $processOrder }}</h3>
              </a>
                
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="x_panel bg-c-green br-1"> 
            <div class="x_content">
              <a href="{{ route('user.currentorder')}}">
                <h2 class="text-white">Complete Orders</h2>
                <h3 class="text-white">{{ $completeOrder }}</h3>
              </a>
            </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_content">
            <div id="chart"></div>
          </div>
        </div>
      </div>
    </div>

    
</div>
        

        <!-- /page content -->

@endsection
@section('scripts')
<script src="{{ asset('vendors/echarts/dist/echarts.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<script>

  var data =  @json($arr);
  var year = new Date().getFullYear();
  
  var options = {
  chart: {
    type: 'area',
    height: 350,
    zoom: { enabled: false}
  },
  title: {
          text: 'Order For Year '+year,
          align: 'left'
        },
  series: [{
    name: 'Total orders',
    data: data,
    
  }],
  xaxis: {
    categories: ['Jan','Feb','Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
    title: {text: 'Month'}
  },
  yaxis: {
    tickAmount: 3,
    labels: {
      formatter: function(val) {
        return val.toFixed(0);
      }
    },
    title: {text: 'Total orders'}
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();


</script>
@endsection