@extends('user.layouts.main')
@section('content')
<!-- page content -->
<li class="breadcrumb-item active">Refunds List</li>
{{-- <li class="breadcrumb-item active">Add</li> --}}
{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
</ol>
</nav>

{{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Refunds List</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="text-right mb-3">
            {{-- <button type="button"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAnnouce">Add</button> --}}
            {{-- <a href="{{ route('admin.shoppingsite.create')}}" class="btn btn-primary">Add</a>
          <button class="btn btn-danger" id="delete" href="{{ route('admin.shoppingsite.delete')}}">Delete</button> --}}
          
          </div>
          <div class="row">
              <div class="card-box table-responsive">
                <table id="datatable-checkbox1" class="table table-striped table-bordered bulk_action" style="width:100%">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="checkall1" ></th>
                      <th>No</th>
                      <th>Reference No</th>
                      <th>Amount (RM)</th>
                      <th>Date / Time</th>
                      <th>Refund Item</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($refunds as $key=>$ref)
                    <tr>
                      <td><input type="checkbox" class="checkboxtest1" value="{{$ref->id}}"></td>
                      <td>{{($key+1)}}</td>  
                      <td>{{$ref->refund_refno}}</td>
                      <td class="text-right">{{number_format($ref->refund_amount,2)}}</td>
                      <td>{{ \Carbon\Carbon::parse($ref->refund_date)->format('d-m-Y') }} 
                          {{ \Carbon\Carbon::parse($ref->refund_time)->format('h:i A') }}</td>                      
                      <td>
                      @foreach($ref->items as $keys => $item)
                      {{ $keys+1 }}.  <a href="{{route('user.detail.item', $item->id)}}" class="btn btn-sm btn-danger">{{ (!empty($item->item_name) ? $item->item_name:'View Item')}}</a><br>
                      @endforeach
                      </td>  
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
           
          </div> {{-- end row--}}
        </div>
      </div>
		</div>
	</div>
</div>

<!-- /top tiles -->

<!-- /page content -->

@endsection
@section('scripts')
@endsection