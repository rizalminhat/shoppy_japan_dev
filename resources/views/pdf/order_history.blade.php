<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Order History</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            h1,h2,h3,h4,h5,h6,p,span,div { 
                font-family: DejaVu Sans; 
                font-size:10px;
                font-weight: normal;
            }
            th,td { 
                font-family: DejaVu Sans; 
                font-size:10px;
            }
            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-default {
                border-color: #ddd;
            }
            .panel-body {
                padding: 15px;
            }
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
                border: 1px solid #ddd;
                padding: 6px;
            }
            td{
                text-align: left;
                vertical-align: middle;
            }
            .well {
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }

            .f-30{
                font-size: 20px;
            }

            .text-right{
                text-align:right !important;
            }
        </style>
      
         
       
    </head>
    <body>
        <header>
            <div style="position:absolute; left:0pt; width:250pt;">
                <img class="img-rounded" width="80%" src="{{asset('main/img/logoshoppyJapan.png')}}">
            </div>
            <div style="margin-left:300pt;">
                <b>Date : {{date('d-m-Y')}}</b> <br />
               
                    <b>Order date : {{Carbon\Carbon::parse($order->submit_at)->format('d-m-Y h:i:s A')}}</b><br />
              
                    <b>Order No : {{$order->order_no}}</b> 
               
                <br />
            </div>
            <br />
            <h2 class="f-30">Order No #{{$order->order_no}}</h2>
        </header>
        <main>
            <div>
                <div>
                    <h4>Customer Details:</h4>
                    <div class="panel panel-default" style="width:50%">
                        <div class="panel-body" >
                            <p>{{$order->user_name}}<br>{{$order->user_email}}</p>
                            
                            <p>{{$order->order_address1}}
                                @if(!empty($order->order_address2))
                                <br>{{$order->order_address2}}
                                @endif
                                @if(!empty($order->order_address3))
                                <br>{{$order->order_address3}}
                                @endif
                                <br>{{$order->order_postcode}}, {{strtoupper($order->order_state)}}
                                <br>{{$order->order_city}}</p>
                        </div>
                    </div>
                </div>
                {{-- <div style="margin-left: 300pt;">
                    <h4>Customer Details:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            
                        </div>
                    </div>
                </div> --}}
            </div>
            <h4>Items:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Item Link</th>
                        <th>Quantity</th>
                        <th>Price (RM)</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        
                       
                        
                        <td>{{$item->item_no}}</td>
                        <td>{{$item->item_url}}</td>
                        <td>{{$item->item_quantity}}</td>
                        <td class="text-right">{{$item->item_total}}</td>
                        
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <td class="text-right">{{number_format($total,2)}}</td>
                    </tr>
                </tbody>
            </table>
            <div style="clear:both; position:relative;">
             
                    <div style="position:absolute; left:0pt; width:250pt;">
                        <h4>Payment Details:</h4>
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <p>NAME : {{$online->online_order_payer}}<br>
                            TRANSACTION REF : {{$online->online_order_bank_code}}<br>
                            BANK NAME : {{$online->online_order_bank}}<br>
                            PAYMENT TYPE : {{strtoupper($online->online_order_type)}}</p>
                            </div>
                        </div>
                    </div>
               
                <div style="margin-left: 300pt;">
                    <h4>Total:</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Total Amount</td>
                                <td class="text-right">RM {{number_format($total,2)}}<</td>
                            </tr>
                            <tr>
                                <td>Transaction Charges</td>
                                <td class="text-right">RM 1.00<</td>
                            </tr>
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td class="text-right"><b>RM {{number_format($total+1.00,2)}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
       
                {{-- <br /><br />
                <div class="well"> --}}
                   
                </div>
           
        </main>

        <!-- Page count -->
        <script type="text/php">
            if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            }
        </script>
    </body>
</html>