@extends('user.layouts.main')
@section('content')
        <!-- page content -->
<li class="breadcrumb-item"><a href="">Completed Payment</a></li>
</ol>
</nav>
        <div class="page-title">
  <div class="title_left">
    <h3>Completed Payment</h3>
  </div>

  
</div>
            
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
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
					<div class="text-right mb-3">
						
							
							
						
					  <!--<button type="button" class="btn btn-primary">Create Order</button>--></div>  
<div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order No.</th>
                          <th>Transaction Date</th>
						 
                          <th>Amount (MYR)</th>
						  <th>Type</th>
						  <th>Order Status</th>
						  
						  <th>Action</th>	
                        </tr>
                      </thead>
                      <tbody>
						  <?php $i=1 ?>
						  
						   @foreach($listsubmitorder as $listsubmitorder)
                        <tr>
                          <th scope="row"><?php echo $i;?></th>
                          <td>{{$listsubmitorder->order_no}}</td>
						  <td>{{ \Carbon\Carbon::parse($listsubmitorder->transcreated)->format('d-m-Y h:i:s A')}}</td>
                          
                          <td class="text-right">{{number_format($listsubmitorder->online_order_amount,2)}}</td>
						  <td class="text-right">
							  @if($listsubmitorder->online_order_type == 'orderpayment')
							  Order Payment
							  @elseif($listsubmitorder->online_order_type == 'courierpayment')
							  Courier Payment 
							  
							  @else
							  
							  @endif
							  </td>	 
						  <td>{!!$listsubmitorder->order_class!!}<!--<span class="badge badge-success">Completed Order</span>-->
							  
							  
							</td>
							
						  <td>
							<a href="{{ url('user/order/view-order/'.$listsubmitorder->order_id) }}" class="btn btn-primary btn-sm">View Order</a>
							</td>
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
</div>

        <!-- /page content -->

@endsection
