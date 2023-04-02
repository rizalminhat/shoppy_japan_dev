@extends('user.layouts.main')
@section('content')
<!-- page content -->
<li class="breadcrumb-item active">Other Setting</li>
{{-- <li class="breadcrumb-item active">Add</li> --}}
{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
</ol>
</nav>

{{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Other Setting</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">
            <div class="col-md-3 col-6">
              <p>Announcement</p>
            </div>
            <div class="col-md-6 col-6">
              <div class="">
                <label>
                  <input type="checkbox" class="js-switch" id="act"  {{($user->user_announce == '1') ? 'checked':'
                  '}}/> ON
                </label>
              </div>
            </div>
          </div> {{-- end row--}}
        </div>
      </div>
		</div>
	</div>
</div>

<!-- /top tiles -->


<br />


<!-- /page content -->

@endsection
@section('scripts')

<script>
$(document).ready(function() {

// var user = @json($user);
// let ann = user['user_announce'];

// if(ann == '0')
// {
//   $("#act").prop("checked", false)
// }
// else{
//   $("#act").prop("checked", true)
// }


$('#act').click(function(){
    if(this.checked) {
      // alert('check');
      $.ajax({  
      url:"{{route('user.status.annouce')}}",
      type:"POST",
      data:{
          status:"active",
          _token: "{{ csrf_token() }}",
      },
          success:function(data)
          {  
            new PNotify({
            title: data[0],
            // text: 'That thing that you were trying to do worked!',
            type: data[1],
            styling: 'bootstrap3',
            delay: 1400,
            // hide:false,
            });
          }  
      });
    }
    else {
      $.ajax({  
      url:"{{route('user.status.annouce')}}",
      type:"POST",
      data:{
          status:"not",
          _token: "{{ csrf_token() }}",
      },
          success:function(data)
          {  
            new PNotify({
            title: data[0],
            // text: 'That thing that you were trying to do worked!',
            type: data[1],
            styling: 'bootstrap3',
            delay: 1400,
            // hide:false,
            });
          }  
      });
    }
});
});
</script>
@endsection