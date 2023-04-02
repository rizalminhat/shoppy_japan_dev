<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>shoppyJapan </title>

    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{ asset('vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet" />
    <link href="{{ asset('vendors/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet" />
		<link href="{{ asset('vendors/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="{{asset('build/css/custom.min.css')}}" rel="stylesheet">

    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet" />

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;background-color:#ededed;" >
              <a href="#" class="site_title"><img class="img-fluid mx-auto" src="{{ asset('main/img/logoshoppyJapan.png')}}" alt="Image" width="80%"></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{(!empty(Auth::user()->user_image) ? asset('storage/upload/user_image/'.Auth::user()->user_image) : asset('main/img/person_icon.png'))}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Str::ucfirst(Auth::user()->name)}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            @include('user.layouts.sidebar')
            <!-- /sidebar menu -->


          </div>
        </div>

        <!-- top navigation -->
        @include('user.layouts.topnavigation')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <nav aria-label="breadcrumb" >
            <ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home mr-2"></i><img width="100px" src="{{asset('main/img/logoshoppyJapan.png')}}"></a></li>
				
              
              @yield('content')

        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include('user.layouts.footer');
        <!-- /footer content -->
      </div>
    </div>
	  
	   
   
   
    
    
  

	  
	  
	  
	  

    <!-- jQuery -->
    <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    {{-- <script src="{{asset('vendors/nprogress/nprogress.js')}}"></script> --}}
    <!-- Chart.js -->
    {{-- <script src="{{asset('vendors/Chart.js/dist/Chart.min.js')}}"></script> --}}
    <!-- gauge.js -->
    {{-- <script src="{{asset('vendors/gauge.js/dist/gauge.min.js')}}"></script> --}}
	 
	 <!-- morris.js -->
    {{-- <script src="{{asset('vendors/raphael/raphael.min.js')}}"></script> --}}
    {{-- <script src="{{asset('vendors/morris.js/morris.min.js')}}"></script>  --}}
	  
    <!-- bootstrap-progressbar -->
    <script src="{{asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    {{-- <script src="{{asset('vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('vendors/Flot/jquery.flot.resize.js')}}"></script> --}}
    <!-- Flot plugins -->
    {{-- <script src="{{asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script> --}}
    {{-- <script src="{{asset('vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script> --}}
    {{-- <script src="{{asset('vendors/flot.curvedlines/curvedLines.js')}}"></script> --}}
    <!-- DateJS -->
    <script src="{{asset('vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    {{-- <script src="{{asset('vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script> --}}
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{asset('build/js/custom.min.js')}}"></script>

	 
	  
	 
	
	
	
	
	
	<!-- jQuery Tags Input -->
	<script src="{{asset('vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
	<!-- Switchery -->
	<script src="{{asset('vendors/switchery/dist/switchery.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
	<!-- Parsley -->
	<script src="{{asset('vendors/parsleyjs/dist/parsley.min.js')}}"></script>
	<!-- Autosize -->
	<script src="{{asset('vendors/autosize/dist/autosize.min.js')}}"></script>
	<!-- jQuery autocomplete -->
	<script src="{{asset('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
	<!-- starrr -->
	<script src="{{asset('vendors/starrr/dist/starrr.js')}}"></script>
  <script src="{{ asset('vendors/pnotify/dist/pnotify.js')}}"></script>
  <script src="{{ asset('vendors/pnotify/dist/pnotify.buttons.js')}}"></script>
  <script src="{{ asset('vendors/pnotify/dist/pnotify.nonblock.js')}}"></script>

  <!-- Datatables -->
    <script src="{{asset('/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

  <script src="{{ asset('vendors/switchery/dist/switchery.min.js')}}"></script>

  @yield('scripts') 
  </body>
</html>
<script>
$(document).ready( function () {
        @if(Session::has('message'))
      new PNotify({
          title: '{{ Session::get('message')}}',
          // text: 'That thing that you were trying to do worked!',
          type: '{{ Session::get('alert-type')}}',
          styling: 'bootstrap3',
          delay: 1300,
          // hide:false,
          
      });
    @endif
  });
</script>
 <script>
    $(document).ready(function() {
    
    
    
    const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9,10];
    // let txt = "";
    // numbers.forEach(myFunction);
    
    for (let i = 1; i < numbers.length; i++) {
        
        var count = 'datatable'+[i];
    
        count = $('#datatable-checkbox'+[i]);
    
        var $dt = count;
        $dt.dataTable({
        order: [[1, 'asc']],
        columnDefs: [{ orderable: false, targets: [0] }],
        });
        
        $dt.on('draw.dt', function () {
        $('checkbox input').iCheck({
            checkboxClass: 'icheckbox_flat-green',
        });
        });
        
    
        var checkTest = ".checkboxtest"+[i];
        var checkAll = "#checkall"+[i];
    
        $("#checkall"+[i]).change(function()
        {
        $(".checkboxtest"+[i]).prop("checked", $(this).prop("checked"))
        })
        
    
        $(".checkboxtest"+[i]).change(function()
        {
        if($(this).prop("checked")==false){
            $("#checkall"+[i]).prop("checked", false)
        }
        if($(".checkboxtest"+[i]+":checked").length == $(".checkboxtest"+[i]).length){
            $("#checkall"+[i]).prop("checked", true)
        }
        })
    
    }
    
    
    });
    </script>