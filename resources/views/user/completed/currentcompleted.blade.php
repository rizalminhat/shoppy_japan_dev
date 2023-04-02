@extends('user.layouts.main')
@section('content')
        <!-- page content -->
<li class="breadcrumb-item"><a href="">Completed Order</a></li>
</ol>
</nav>
        <div class="page-title">
  <div class="title_left">
    <h3>Completed Order</h3>
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
<div class="card-box table-responsive">
                    <!--<table class="table table-bordered">-->
	 <!--<table id="datatable-checkbox" class="table table-striped table-bordered bulk_action" style="width:100%">-->
	<table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order No.</th>
                          <th>Submit Date</th>
						  <th>Completed Date</th>
                          <th>Amount (MYR)</th>
						  <th>Courier Fee (MYR)</th>
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
						  <td>{{ \Carbon\Carbon::parse($listsubmitorder->submit_at)->format('d-m-Y h:i:s A')}}</td>
                          <td>{{ \Carbon\Carbon::parse($listsubmitorder->order_complete_date)->format('d-m-Y h:i:s A')}}</td>
                          <td class="text-right">{{number_format($listsubmitorder->totalpay,2)}}</td>
						  <td class="text-right">{{number_format($listsubmitorder->order_shipping,2)}}</td>	 
						  <td><span class="badge badge-success">Completed Order</span>
							  
							  
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
@section('scripts')
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
    $(document).ready(function() {
      $('#datatable-buttons_filter').css({"position":"relative","left":"-100px"});
      $('#myTable').DataTable( {
          "scrollX": true,
          //lengthMenu: [[100, 250, 500, 1000, -1],[100, 250, 500, 1000, "Semua"]],
          lengthMenu: [[10, 100, 1000, -1],[10, 100, 1000, "All"]],
          dom: 'Blfrtip',
          //"dom": '<"top"<"left-col"B><"center-col"l><"right-col"f>>rtip',
          //"dom": '<"top"<"left-col"l><"center-col"f><"right-col"B>>rtip',
          //--"dom": '<"top"<"left-col"l><"center-col"B><"right-col"f>>rtip',
          //<<l><f><B>>rtip

          buttons: [
          {
              extend: "collection",
              //float: "right",
              //position: "relative",
              className: "btn btn-dark dropdown-toggle mt-50 text-right",
              text: feather.icons["printer"].toSvg({class: "font-small-4 me-50" }) + "Cetak",
              buttons: [
                {
                  extend: "print",
                  footer: true,
                    text: feather.icons.globe.toSvg({class: "font-small-4 me-50"}) + "WEB",
                    className: "dropdown-item",
                  exportOptions: {
                        columns: [0,1,2,3],
                        rows: function ( idx, data, node ) {
                          var table = $('.laporan-list-table').DataTable();
                          var selected = [];
                          $(".dt-checkboxes:checked").each(function() {
                            console.log(table.row($(this).closest('tr')).index());
                            selected.push(table.row($(this).closest('tr')).index());
                          });
                          if( selected.length === 0 || $.inArray(idx, selected) !== -1)
                            return true;
                          return false;
                      }
                    }
                },
                {
                  extend: "excel",
                  footer: true,
                  text: feather.icons.file.toSvg({class: "font-small-4 me-50"}) + "EXCEL",
                  className: "dropdown-item",
                  exportOptions: {
                      columns: [0,1,2,3],
                      rows: function ( idx, data, node ) {
                      var table = $('.laporan-list-table').DataTable();
                      var selected = [];
                      $(".dt-checkboxes:checked").each(function() {
                        console.log(table.row($(this).closest('tr')).index());
                        selected.push(table.row($(this).closest('tr')).index());
                      });
                      if( selected.length === 0 || $.inArray(idx, selected) !== -1)
                        return true;
                      return false;
                    }
                  }
                },
                {
                  extend: "pdf",
                  footer: true,
                  text: feather.icons.file.toSvg({class: "font-small-4 me-50"}) + "PDF",
                  className: "dropdown-item",
                    orientation: "landscape",
                    pageSize: 'LEGAL', // TABLOID OR LEGAL
                  exportOptions: {
                      columns: [0,1,2,3],
                      rows: function ( idx, data, node ) {
                      var table = $('.laporan-list-table').DataTable();
                      var selected = [];
                      $(".dt-checkboxes:checked").each(function() {
                        console.log(table.row($(this).closest('tr')).index());
                        selected.push(table.row($(this).closest('tr')).index());
                      });
                      if( selected.length === 0 || $.inArray(idx, selected) !== -1)
                        return true;
                      return false;
                    }
                  }
                }   
              ],  
              /*init: function(e, t, a) {
                $(t).removeClass("btn-secondary"), setTimeout((function() {
                  $(t).closest(".dt-buttons").addClass("btn-group").addClass("flex-wrap")
                }), 50)
                if(!copy) 
                his.remove();
              }*/
          }],
          /*"language": {
            "lengthMenu": "Papar _MENU_ Entri",
            //"lengthMenu": [[100, 250, 500, 1000, -1], [100, 250, 500, 1000, "Semua"]]
            "search": "Cari:",
            paginate: {
              previous: "&nbsp;",
              next: "&nbsp;"
            },
            "zeroRecords": "Tiada Data - Maaf",
            //"info": "Paparan mukasurat _PAGE_ daripada _PAGES_",
            "info": "Paparan _START_ hingga _END_ daripada _TOTAL_ entri",
            "infoEmpty": "Tiada Rekod",
            "infoFiltered": "(Ditapis daripada _MAX_ jumlah rekod)",
            "pageLength": 100

          }*/
      } );
    } );/**/
  </script>

  <script>
    $(document).ready(function() {
      //$('#datatable-buttons_filter').css({"position":"relative","left":"-100px"});
      $('#datatable-buttons').DataTable( {
        buttons: [
              'copy', 'excel', 'pdf'
        ]
      } );
    } );/**/
  </script>

  <script>
    $(document).ready(function () {
      $('#datatable-buttons').DataTable({
          footerCallback: function (row, data, start, end, display) {
              var api = this.api();
   
              // Remove the formatting to get integer data for summation
              var intVal = function (i) {
                  return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
              };
   
              // Total over all pages
              total = api
                  .column(4)
                  .data()
                  .reduce(function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0);
   
              // Total over this page
              pageTotal = api
                  .column(4, { page: 'current' })
                  .data()
                  .reduce(function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0);
   
              // Update footer
              $(api.column(4).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
          },
      });
    });
  </script>
  
@endsection
