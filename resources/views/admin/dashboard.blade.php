@extends('admin.layouts.main')
@section('content')
        <!-- page content -->
        {{-- <div class="right_col" role="main"> --}}
          <!-- top tiles -->

          <!-- /top tiles -->
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Dashboard</a></li>
  </ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>My Dashboard</h3>
		</div>
	</div>
	<div class="clearfix"></div>

  {{-- 1st row --}}
    <div class="row mt-3">
      <div class="col-md-4">
        <div class="x_panel bg-success br-1"> 
          <a href="{{ url('/admin/order/list_order#cancel-tab')}}">
              <div class="x_content">
                  <h2 class="text-white">New Orders</h2>
                  <h3 class="text-white">{{ $neworders }} orders</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="x_panel bg-success br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.order.view') }}">
                <h2 class="text-white">Already Purchased</h2>
                <h3 class="text-white">{{ $purchaseOrder }} orders</h3>
              </a>
                
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="x_panel bg-success br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.order.view') }}">
                <h2 class="text-white">In Process</h2>
                <h3 class="text-white">{{ $process_orders }} orders</h3>
              </a>
                
            </div>
        </div>
      </div>
    </div>

    {{-- 2nd row --}}
    <div class="row">
      <div class="col-md-4">
        <div class="x_panel  bg-c-blue br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.order.view') }}">
                <h2 class="text-white">In Courier</h2>
                <h3 class="text-white">{{ $in_courier}} orders</h3>
              </a>
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="x_panel bg-c-blue br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.order.view') }}">
                <h2 class="text-white">Complete Orders</h2>
                <h3 class="text-white">{{ $completeOrder }} orders</h3>
              </a>
            </div>
        </div>
      </div>
        <div class="col-md-4">
        <div class="x_panel  bg-c-blue br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.order.view') }}">
                <h2 class="text-white">Total Orders</h2>
                <h3 class="text-white">{{ $total_orders }} orders</h3>
              </a>
            </div>
        </div>
      </div>
    </div>

    {{-- 3nd row --}}
    <div class="row">
      <div class="col-md-3 ">   
        <div class="x_panel bg-c-danger br-1"> 
          <a href="#">
              <div class="x_content">
                  <h2 class="text-white">Prev Month Links {{$preMonth}}-{{$myYear}}<h2>
                  <h3 class="text-white">{{$prevMonLinks}} links</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-3 ">   
         <div class="x_panel bg-c-danger br-1"> 
          <a href="#">
              <div class="x_content">
                  <h2 class="text-white">Monthly Links {{ date('M-Y')}}<h2>
                  <h3 class="text-white">{{ $monthlyLinks }} links</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-3 ">   
         <div class="x_panel bg-c-danger br-1"> 
          <a href="#">
              <div class="x_content">
                  <h2 class="text-white">Total Links<h2>
                  <h3 class="text-white">{{$totalLinks}} links</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-3 ">   
        <div class="x_panel bg-c-danger br-1"> 
          <a href="#">
              <div class="x_content">
                  <h2 class="text-white">Today Sales<h2>
                  <h3 class="text-white">RM {{number_format($todaySales,2)}}</h3>
              </div>
          </a>
        </div>
      </div>
    </div>

    {{-- 4rd row --}}
    <div class="row">
      <div class="col-md-3">
        <div class="x_panel bg-info br-1"> 
            <div class="x_content">
              <a href="#">
                <h2 class="text-white">Total Yesterday Sales</h2>
                <h3 class="text-white">RM {{number_format($yesterdaySales,2)}}</h3>
              </a>
            </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="x_panel bg-info br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.weekly_sales')}}">
                <h2 class="text-white">Total Weekly Sales</h2>
                <h3 class="text-white">RM {{ number_format($sumByWeek,2) }}</h3>
              </a>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="x_panel bg-info br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.monthly_sales')}}">
                <h2 class="text-white">Total Monthly Sales - {{Carbon\Carbon::now()->format('F')}}</h2>
                <h3 class="text-white">RM {{ number_format($sumByMonth,2) }}</h3>
              </a>
            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="x_panel bg-info br-1"> 
            <div class="x_content">
              <a href="">
                <h2 class="text-white">Total Sales</h2>
                <h3 class="text-white">RM {{ number_format($totalSales,2) }}</h3>
              </a>
            </div>
        </div>
      </div>
    </div>

    {{-- 5 row --}}
    <div class="row">
      <div class="col-md-4 ">
        <div class="x_panel bg-secondary br-1"> 
          <a href="{{ route('admin.user.view')}}">
              <div class="x_content">
                  <h2 class="text-white">Today Register Users
                  </h2>
                  <h3 class="text-white">{{$todayUser}} users</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-4 ">
        <div class="x_panel bg-secondary br-1"> 
          <a href="{{ route('admin.user.view')}}">
              <div class="x_content">
                  <h2 class="text-white">Total Registered Users</h2>
                  <h3 class="text-white">{{ $users }} users</h3>
              </div>
          </a>
        </div>
      </div>
      <div class="col-md-4 ">
      <div class="x_panel bg-secondary br-1"> 
            <div class="x_content">
              <a href="{{ route('admin.buyer.view')}}">
                <h2 class="text-white">Total Active Users</h2>
                <h3 class="text-white">{{ $buyers }} users</h3>
              </a>
            </div>
        </div>
      </div>
    </div>      


    <div class="row mt-3">
      <div class="col-md-12 col-sm-12 ">
        <div class="dashboard_graph">

          <div class="row x_title">
            <div class="col-md-6">
              <h3>Recent Order</small></h3>
            </div>
            
          </div>

            <div class="card-box table-responsive">
              {{-- <p class="text-muted font-13 m-b-30">
                DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
              </p> --}}
              <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="checkall" ></th>
                    <th>No</th>
                    <th>Order No</th>
                    <th>Name</th>
                    <th>No Phone</th>
                    <th>Email</th>
                    <th>Order At</th>
                    <th>Action</th>
                    
                  </tr>
                </thead>


                <tbody>
                  @foreach($recent_orders as $key => $rc_order)
                  <tr>
                      
                  <td><input type="checkbox" class="checkboxtest" value="{{ $rc_order->id }}"></td>
                  <td>{{ $key+ 1}}</td> 
                  <td>{{ $rc_order->order_no }}</td> 
                  <td>{{ $rc_order->user->name }}</td>
                  <td>{{ $rc_order->user->phone }}</td>
                  <td>{{ $rc_order->user->email }}</td>
                  {{-- E:\ZnnServer\shoppyjapan\storage\app\public\upload\brand_images\6284e47fe55aewomen.jpg --}}

                  <td>{{ \Carbon\Carbon::parse($rc_order->submit_at)->format('d-m-Y h:i:s A')}}</td>
                  <td class="text-center">
                    <a href="{{ route('admin.order.items',$rc_order->id) }}" type="button" class="btn btn-info btn-sm">View Order</a>
                  </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          <div class="clearfix"></div>
        </div>
      </div>

    </div>
    <br />
</div>
        

      

        {{-- </div> --}}

        <!-- /page content -->

@endsection
