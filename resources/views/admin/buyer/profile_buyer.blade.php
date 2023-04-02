@extends('admin.layouts.main')
@section('content')

{{-- {{dd(Session::all())}} --}}

@if(url()->previous() == 'https://shoppyjapan.my/admin/user/user_list')
<li class="breadcrumb-item"><a href="{{ route('admin.user.view')}}">User List</a></li>

@else
<li class="breadcrumb-item"><a href="{{ route('admin.buyer.view')}}">Buyer List</a></li>
@endif


<li class="breadcrumb-item active">User Profile</li>
</ol>
</nav>
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>User Profile</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                {{-- <h2>User Report <small>Activity report</small></h2> --}}
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                    </li>
                    <li>
                        <a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            @if(!empty($user->user_image))
                            <img class="img-responsive avatar-view" src="{{asset('storage/upload/user_image/'.$user->user_image)}}" alt="Avatar" title="User avatar" width="150px"/>
                            @else
                            <img class="img-responsive avatar-view" src="{{asset('main/img/person_icon.png')}}" alt="Avatar" title="User avatar" width="100px"/>
                            @endif
                        </div>
                    </div>
                    <h2>{{ $user->name }}</h2>
                    <ul class="list-unstyled user_data">
                        <li class="m-top-xs">
                            <i class="fa fa-external-link user-profile-icon"></i>
                            <label for="">{{ $user->email }}</label>
                        </li>
                    </ul>

                    
                    <br />

                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="project_detail">
                        <p class="title">Address</p>
                        <p class="my-0">{{ $user->address1 }}</p>
                        <p class="my-0">{{ $user->address2 }}</p>
                        <p class="my-0">{{ $user->address3 }}</p>
                        <p class="my-0">{{ $user->postcode }}, {{$user->city}}</p>
                        <p>{{ strtoupper($user->state_name) }}</p>
                        <p class="title">No. Phone</p>
                        <p>{{ $user->phone }}</p>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-sm text-decoration-none text-white" href="{{route('admin.resend_activate_email',$user->id)}}" id="btnResendEmail">Resend Activate Email</button>
                        {{-- <button class="btn btn-success" id="">TEST</button> --}}
                       
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div> {{-- end row 1--}}

    @if(!$orders->isEmpty())
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Order</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                    </li>
                    <li>
                        <a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
                </div>
                <div class="col-sm-2">
                    <!-- required for floating -->
                    <!-- Nav tabs -->
                    <div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="neworder-tab" data-toggle="pill"  href="#neworder" role="tab" aria-controls="v-pills-home" aria-selected="true">All Order</a>
                        {{-- <a class="nav-link" id="process-tab" data-toggle="pill" href="#process" role="tab" aria-controls="v-pills-profile" aria-selected="false">Process</a>
                        <a class="nav-link" id="courier-tab" data-toggle="pill" href="#courier" role="tab" aria-controls="v-pills-messages" aria-selected="false">Courier</a>
                        <a class="nav-link" id="doneorder-tab" data-toggle="pill" href="#doneorder" role="tab" aria-controls="v-pills-settings" aria-selected="false" >Complete Order</a>
                        <a class="nav-link" id="cancel-tab" name="cancel-tab" data-toggle="pill" href="#cancel"  role="tab" aria-controls="v-pills-settings" aria-selected="false" >Cancel Items</a> --}}
                        <a class="nav-link" id="refund-tab" name="cancel-tab" data-toggle="pill" href="#refund"  role="tab" aria-controls="v-pills-settings" aria-selected="false" >Refund</a>
                    </div>
                </div>
                <div class="col-sm-10">
                    <!-- Tab panes -->
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        {{-- tab new order --}}
                        <div class="tab-pane fade show active" id="neworder" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="x_content">
                                <div class="text-right mb-3">
                                    {{-- <button class="btn btn-primary btn-sm" id="btnProcess1" href="{{ route('admin.order.modalProcess')}}">Process Order</button> --}}
                                    {{-- <button class="btn btn-danger btn-sm" id="buttonCancel" href="{{ route('admin.order.cancel')}}" >Cancel Order</button> --}}
                                </div>
                                <div class="row">
                                    {{-- <div class="col-sm-12"> --}}
                                        <div class="card-box table-responsive">
                                            <table id="datatable-checkbox1" class="table table-striped table-bordered bulk_action" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkall1" ></th>
                                                        <th>No</th>
                                                        {{-- <th>Item URL</th> --}}
                                                        <th>Order No</th>
                                                       
                                                        <th>Submit Order Date</th>
                                                        <th>Status</th>
                                                        <th>Order Total (RM)</th>
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $key=>$order)
                                                    <tr>
                                                        <td><input type="checkbox" class="checkboxtest1" value="{{ $order->order_id}}"></td>
                                                        <td>{{$key+1}}</td>  
                                                        <td>{{$order->order_no}}</td>
                                                        <td>{{ (!empty($order->submit_at) ? \Carbon\Carbon::parse($order->submit_at)->format('d-m-Y h:i:s A'):'No data')}}</td>   
                                                        <td>{!!$order->order_class!!}</td>
                                                        <td class="text-right">{{number_format($order->sum_item_total,2)}}</td>
                                                        <td>
                                                        <a href="{{ route('admin.order.items',$order->order_id) }}" type="button" class="btn btn-info btn-sm" target="_blank">View Order</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>

                        {{-- tab refund --}}
                        <div class="tab-pane fade show" id="refund" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="x_content">
                                <div class="text-right mb-3">
                                    {{-- <button class="btn btn-primary btn-sm" id="btnProcess1" href="{{ route('admin.order.modalProcess')}}">Process Order</button> --}}
                                    {{-- <button class="btn btn-danger btn-sm" id="buttonCancel" href="{{ route('admin.order.cancel')}}" >Cancel Order</button> --}}
                                </div>
                                
                                <div class="row">
                                    {{-- <div class="col-sm-12"> --}}
                                        <div class="card-box table-responsive">
                                            <table id="datatable-checkbox2" class="table table-striped table-bordered bulk_action" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkall2" ></th>
                                                        <th>No</th>
                                                        {{-- <th>Item URL</th> --}}
                                                        <th>Ref No.</th>
                                                       
                                                        <th>Amount (RM)</th>
                                                        <th>Date / Time</th>
                                                       
                                                        <th>Created At</th>
                                                        <th>Refund Item</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($refunds as $key=>$ref)
                                                    <tr>
                                                        <td><input type="checkbox" class="checkboxtest2" value="{{ $ref->id}}"></td>
                                                        <td>{{$key+1}}</td>  
                                                        <td>{{$ref->refund_refno}}</td>
                                                        <td>{{$ref->refund_amount}}</td>
                                                        <td>{{\Carbon\Carbon::parse($ref->refund_date)->format('d-m-Y')}} {{\Carbon\Carbon::parse($ref->refund_time)->format('h:i A')}}</td>
                                                        
                                                        <td>{{\Carbon\Carbon::parse($ref->created_at)->format('d-m-Y h:i:s A')}}</td>
                                                        <td>
                                                            @foreach($ref->items as $keys => $item)
                                                            <span>{{ $keys+1 }}.
                                                                <a href="{{ route('admin.order.detailsItem',$item->id) }}"> {{ $item->item_no}}</a>
                                                            </span>
                                                            <br>
                                                            @endforeach
                                                        </td>
                                                        
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- end row--}}
    @endif
</div>
@endsection
@section('scripts')
<script>
    $('document').ready(function () {
        $('#btnResendEmail').on('click',function() {
            var src = $(this).attr('href');
            $(this).attr("disabled", true);
            location.href = src;
        })
    });
</script>
@endsection