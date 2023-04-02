@extends('user.layouts.main')
@section('content')
        <!-- page content -->
        <div class="page-title">
  <div class="title_left">
    <h3>Tracking Status</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>
						
						
							
							
						
					  <!--<button type="button" class="btn btn-primary">Create Order</button>--></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					  

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order No.</th>
                          <th>Date</th>
                          <th>Item Amount (MYR)</th>
						  <th>Delivery Charge (MYR)</th>
						  <th>Total (MYR)</th>
						  <th>Status</th>
						  <th>Tracking No.</th>
						  <th>Courier</th>
							
						  <th>Action</th>	
                        </tr>
                      </thead>
                      <tbody>
						  <?php $i=1 ?>
						  
						   @foreach($listsubmitorder as $listsubmitorder)
						   @php
						  $vartotalpay = $listsubmitorder->order_shipping+$listsubmitorder->totalpay;
						   @endphp
                        <tr>
                          <th scope="row"><?php echo $i;?></th>
                          <td><b><a href="{{ url('user/order/view-order/'.$listsubmitorder->order_id) }}">{{$listsubmitorder->order_no}}</a></b></td>
                          <td>{{$listsubmitorder->submit_at}}</td>
                          <td>{{$listsubmitorder->totalpay}}</td>
						  <td>{{$listsubmitorder->order_shipping}}</td>
						  <td>{{number_format($vartotalpay, 2)}}</td>
						  <td>{{$listsubmitorder->order_status}}</td>
						  <td>{{$listsubmitorder->tracking_no}}</td>
							<td>{{$listsubmitorder->courier_name}}</td>
							
						  <td><a href="{{$listsubmitorder->url}}{{$listsubmitorder->tracking_no}}" target="_blank" class="btn btn-primary btn-sm">View Tracking</a></td>
                        </tr>
						  <?php $i++ ?>
						  @endforeach 
                       <!-- <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                        </tr> -->
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
</div>

        <!-- /page content -->

@endsection
