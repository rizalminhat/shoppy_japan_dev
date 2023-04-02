<!-- sidebar !-->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    {{-- <a href="{{ url('/')}}"type></a> --}}
    <ul class="nav side-menu">
      <li><a href="{{ route('admin.dashboard')}}"><i class="fa fa-home"></i> Dashboard </a>
        {{-- <ul class="nav child_menu">
            <li><a href="index.html">Dashboard</a></li>
            <li><a href="index2.html">Dashboard2</a></li>
            <li><a href="index3.html">Dashboard3</a></li>
          </ul> --}}
      </li>
      <li><a><i class="fa fa-edit"></i>Order Management <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('admin.order.view')}}">Order List</a></li>
          {{-- <li><a href="form_advanced.html">Advanced Components</a></li>
          <li><a href="form_validation.html">Form Validation</a></li>
          <li><a href="form_wizards.html">Form Wizard</a></li>
          <li><a href="form_upload.html">Form Upload</a></li>
          <li><a href="form_buttons.html">Form Buttons</a></li> --}}
        </ul>
      </li>
      <li><a><i class="fa fa-desktop"></i> User Record <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('admin.user.view')}}">User List</a></li>
          
        </ul>
      </li>
      <li><a><i class="fa fa-desktop"></i> Buyer Record <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('admin.buyer.view')}}">Buyer List</a></li>
          
        </ul>
      </li>
      <li><a><i class="fa fa-table"></i> Item Management <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{ route('admin.shoppingsite.view')}}">Sites List</a></li>
          <li><a href="{{ route('admin.product.view')}}">Product List</a></li>
        </ul>
      </li>
                 
                  <li><a><i class="fa fa-clone"></i>Financial Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="{{ route('admin.list_transaction')}} ">List Transaction</a></li>
					  <li><a href="{{ route('admin.attempt_transaction')}} ">Attempt Transaction</a></li>
                      {{--<li><a href="{{ route('admin.report_financial')}} ">Sales Report</a></li>--}}
                      <li><a href="{{ route('admin.weekly_sales')}} ">Weekly Sales</a></li>
                      <li><a href="{{ route('admin.monthly_sales')}} ">Monthly Sales</a></li>
                      <li><a href="{{ route('admin.service_commission')}} ">Service Commission</a></li>
						<li><a href="{{ route('admin.walletin_transaction')}} ">User Wallet In</a></li>
						<li><a href="{{ route('admin.walletout_transaction')}} ">User Wallet Out</a></li>
                      {{-- <li><a href="fixed_footer.html">Fixed Footer</a></li> --}}
                      {{-- <li><a href="{{ route('admin.report_test')}}">Test Report</a></li>   --}}

                    </ul>
                  </li>
                 <li><a><i class="fa fa-bar-chart"></i> Sales Report<span class="fa fa-chevron-down"></span></a>
                     <ul class="nav child_menu">
					            <li><a href="{{ route('admin.view_sales_report')}} ">Dashboard Sales Report</a></li>
                      <li><a href="{{ route('admin.report_financial')}} ">Customize Report</a></li>

                    </ul>
                  </li>

                  <li><a><i class="fa fa-gear"></i>Configuration<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.config.view')}}">Currency Rate & Service Charges</a></li>
                      <li><a href="{{ route('admin.couriertype.view')}}">Courier Type</a></li>
                      <li><a href="{{ route('admin.annouce.view')}}">Announcement</a></li>
                      @if(Auth::user()->name == 'superadmin')
                      <li><a href="{{route('admin.testing.part')}}">Testing</a></li>
                      @endif
                      {{-- <li><a href="">Courier Fee</a></li> --}}
                      {{-- <li><a href="#">Currency Rate</a></li>
                      <li><a href="#">Service Rate</a></li>
                      <li><a href="fixed_footer.html">Fixed Footer</a></li> --}}
                    </ul>
                  </li>
                </ul>
              </div>
              {{-- <div class="menu_section">
                
              </div> --}}

            </div>
            {{-- end sidebar --}}