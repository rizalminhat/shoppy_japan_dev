@extends('admin.layouts.main')
@section('content')
<!-- page content -->

    <li class="breadcrumb-item active">Financial Report</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="">
  <div class="d-flex justify-content-between my-4">
        <h3>Sales {{ $reportName }}</h3>
    <a class="btn btn-primary" href="{{route('admin.report_financial')}}" type="button">Back To New Search</a>
  </div>
  <div class="clearfix"></div>
  <br>
  <!-- kotak atas -->
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
      <div class="card-box table-responsive">
        <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <!-- <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%"> -->
          <!-- id="datatable-responsive"  myTable  class="table table-striped table-bordered dt-responsive nowrap" -->
          <thead>
            <tr>
              <th>No.</th>
              <th>Order No</th>
              <th>Buyer Name</th>
              <th>Submit Order Date</th>
              <th>Order Total (RM)</th>
            </tr>
          </thead>
          <tbody>
            @php
              
              $sumSales = 0.00;
            @endphp
            @foreach($results as $key=>$data)
            <tr>
              <td>{{($key+1)}}</td>
              <td><a href="{{ route('admin.order.items', $data->order_id) }}" target="_blank">{{ $data->order_no }}</a></td>
              <td><a href="{{ route('admin.buyer.detail', $data->user_id )}}" target="_blank">{{ $data->user_name }}</a></td>
              <td>{{ Carbon\Carbon::parse($data->submit_at)->format('d-m-Y h:i:s A')}}</td>
              <td class="text-right">{{ number_format($data->sum_item_total,2) }}</td>
            </tr>
            @php
              $sumSales += $data->sum_item_total;
            @endphp
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="x_panel">
      <h2>Total: RM {{number_format($sumSales,2)}}</h2>
      </div>
    </div>
  </div>
</div>

<!-- /top tiles -->

{{-- </div> --}}

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