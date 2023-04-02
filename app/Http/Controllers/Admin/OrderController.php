<?php

namespace App\Http\Controllers\Admin;


use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\OnlineOrder;
use App\Mail\ItemMail;
use App\Models\Refund;
use App\Models\Courier;
use App\Mail\CourierFee;
use App\Mail\OrderShipped;
use App\Traits\OrderTrait;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\inf_item_status;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    use OrderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
        $data['newOrder'] = Order::with('user')
        ->where('status_id','1')
        ->where('order_purchase',NULL)
        ->orderBy('submit_at', 'DESC')
        ->get();
        
        $data['purchaseOrder'] = Order::with('user','peritem')
        ->where('status_id','1')
        ->where('order_purchase','=','1')
        ->orderBy('submit_at', 'DESC')
        ->get();

        $data['processOrder'] = Order::with('user','peritem')->where('status_id','2')->orderBy('id', 'DESC')->get();
        $data['courierOrder'] = Order::with('user','courier','peritem')->where('status_id', '3')->orderBy('id','DESC')->get();
        $data['completeOrder'] = Order::with('user','courier','peritem')->where('status_id', '4')->orderBy('id','DESC')->get();

        $data['cancelOrder'] = Item::with('user','order')
        ->where('item_status_id','0')
        ->whereNull('refund_id')
        ->orderBy('item_order_id', 'DESC')->get();

        $data['refunds'] = Refund::with('items','user')->orderBy('refund_date', 'DESC')->get();

		
//         dd($data['newOrder']);
       
// dd($data['purchaseOrder'][0]);
        return view('admin.order.list_order', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
        
        $data['items'] = Item::where('item_order_id',$id)->get();

        // $data['order'] = Order::with('orderAddress')->get();
        $data['order'] = DB::table('orders')
        ->select('orders.*', 'couriers.name AS courier_name', 'couriers.url AS courier_url', 'orderaddress.address1 AS order_address1', 'orderaddress.address2 AS order_address2','orderaddress.address3 AS order_address3','orderaddress.postcode AS order_postcode', 'orderaddress.city AS order_city','inf_state.state_name AS state_name','users.name AS user_name')
       
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
        ->leftJoin('orderaddress', 'orderaddress.order_id', '=' , 'orders.id')
        ->leftJoin('inf_state','orderaddress.state','=','inf_state.state_in')
        ->where('orders.id', $id)
        ->first();
       
        
        
        // dd($data);
        return view('admin.order.list_items', $data);

    }

    public function detailsItem($id){
        $data['item'] = Item::with('order','user')
        ->select('items.*','item_status.id AS itemstatus_id', 'item_status.order_status AS itemstatus_orderstatus')
        ->leftJoin('item_status', 'items.item_status_id', '=', 'item_status.id')
        ->find($id);

        // dd($data['item']);
        return view('admin.order.detailsitems_order', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function checkOrder(Request $request){

        // dd($request->all());
        foreach($request->item_id as $key=>$itemId)
        {
            $item = Item::find($itemId);
            $item->item_status_id = $request->item_status[$key];
            $item->item_remark = $request->item_remark[$key];
            $item->save();
        }


        $data_id = Arr::first($request->item_id); //get 1st array element value

        $order_id = Item::find($data_id)->item_order_id;  //find order id

        $statusItem = Item::where('item_order_id',$order_id)->whereIn('item_status_id', ['1','2'])
        ->get();
        
        $order = Order::with('user')->find($order_id);

        if($statusItem->isEmpty())
        {
            $order->status_id = '5';
			$order->order_local =  null;
			$order->order_international =  null;
			$order->order_shipping =  null;
			$order->shipping_payment_status = null;
			$order->order_process_date =  null;
        }
        else{
            $order->status_id = '1';
        }

        $order->save();
        
        $user_email = $order->user->email;

        $status_item = DB::table('orders')
        ->select(DB::raw("(select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '1') as totalavailable, (select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '0') as totalnotavailable"))
        ->where('orders.id', $order->id)
        ->first();

        // dd($status_item);
        $details = [
                'title' => 'Order No : '.$order->order_no,
                'url' => 'https://shoppyjapan.my/user',
                'available' => 'Items Available : '.$status_item->totalavailable,
                'not' => 'Items Not Available : '.$status_item->totalnotavailable,
            ];
	//    $orderinfo =  DB::table('orders')
	// 		->where('order_no', $order->order_no)
	// 		->first();	

    //    $qemailstatus =  DB::table('users')
	// 		->where('id', $orderinfo->user_id)
	// 		->first();
			
			$datanotify = json_decode($order->user->user_notification);
			if($datanotify->notification2 == '1')
			{ //start if active submit email
                Mail::to($user_email)->send(new ItemMail($details));
			} //end if active submit email
            else 
			{ //start if not active not submit email
				
			} //end if not active not submit email

        $notifikasi = array(
            'message' => 'Item status changed successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifikasi);

        
    }


    public function processOrderAllOld(Request $request){
        

		
        $checkItem = Item::where('item_order_id', $request->id)
        ->where('item_status_id','1')
        ->get();

       
        if ($checkItem-> isEmpty())
        {
            $notifikasi = array(
                'message' => 'Check Status Item',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notifikasi);
        }else{

            $order = Order::find($request->id);
			

            if(($request->order_shipping == '0.00') && ($request->order_local == '0.00'))
            {
				//dd('dua2 kosong');
                $order->order_shipping = '0.00';
				$order->order_local = '0.00';
				$order->order_international = '0.00';
				
				
                $order->shipping_payment_status = '2';
            }else{
				//dd('salah satu ada value');
                $order->order_local = $request->order_local;
				$order->order_international = $request->order_shipping;
				$order->order_shipping = ($request->order_shipping+$request->order_local);
				

            }
            
            $order->order_process_date = Carbon::NOW();
            $order->status_id = '2';
			// $order->order_local = $request->order_local;
            $order->save();

            if((number_format($request->order_shipping+$request->order_local,2)) != '0.00')
            {
                $getOrder = Order::with('user')->find($request->id);

                $details = [
                    'title' => 'Order No : '.$getOrder->order_no,
                    'url' => 'https://shoppyjapan.my/user',
                    'courier_fee'=> 'Courier Fee (RM) : '.number_format($getOrder->order_shipping,2),
                ];
				
			$qemailstatus =  DB::table('users')
			->where('id', $getOrder->user->id)
			->first();
			
			$datanotify = json_decode($qemailstatus->user_notification);
			if($datanotify->notification3 == '1')
			{ //start if active submit email

                Mail::to($getOrder->user->email)->send(new CourierFee($details));
			} //end if active submit email
				else 
		    { //start if not active not submit email
					
		    } //end if not active not submit email

            }   
            
            $notifikasi = array(
                'message' => 'Shipping fee insert successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notifikasi);
        }
    }
	
	public function processOrderAll2(Request $request){
		
		$orderIds = $request->id;
		foreach($orderIds as $key => $orderId)
		{
			$checkItem = Item::where('item_order_id', $orderId)
			->where('item_status_id','1')
			->get();
			
			if ($checkItem-> isEmpty())
        	{
				$notifikasi = array(
					'message' => 'Check Status Item',
					'alert-type' => 'warning'
				);
				return redirect()->back()->with($notifikasi);
			}else{
				
			 	$order = Order::find($orderId);
				
				if(($request->order_shipping[$key] == '0.00') && ($request->order_local[$key] == '0.00'))
				{
					$order->order_shipping = '0.00';
					$order->order_local = '0.00';
					$order->order_international = '0.00';

					$order->shipping_payment_status = '2';
					
				}else{
					
				 	$order->order_local = $request->order_local[$key];
					$order->order_international = $request->order_shipping[$key];
					$order->order_shipping = ($request->order_shipping[$key]+$request->order_local[$key]);
					$order->shipping_payment_status = null;
				
				}
				
			 	$order->order_process_date = Carbon::NOW();
				$order->status_id = '2';
				// $order->order_local = $request->order_local;
				$order->save();
			}
		}
		
		$notifikasi = array(
			'message' => 'Shipping fee insert successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notifikasi);
	}

    public function processOrder(Request $request, $id){

        $order = Order::find($id);
        
        // if($request->order_shipping == '0.00')
        // {
        //     $order->order_shipping = '0.00';
        //     $order->shipping_payment_status = '2';
        // }else{
        // }

        $order->order_shipping = $request->order_shipping;
        $order->order_process_date = Carbon::NOW();
        $order->status_id = '2';
        $order->save();

        $notifikasi = array(
            'message' => 'Courier fee insert successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notifikasi);



    }

    public function oldprocessOrder(Request $request, $id){
       
        $time2  = Carbon::NOW()->format('d-m-Y H:i:s A');
        $item = Item::find($id);
        if($item->item_process == NULL)
        {
            $item->item_process = array(
                [
                    'desc' => $request->desc, 
                    'datetime' => $time2,
                ]
            );
           
        }
        else{

            $data = json_decode($item->item_process);
            $newEle = array_merge($data, [['desc' => $request->desc, 'datetime' => $time2]]);
            $item->item_process = json_encode($newEle);
        }

        $item->item_status_id = $request->item_status;
        $item->save();
     
        $notifikasi = array(
            'message' => 'Item Process inserted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifikasi);

       

    }

    public function processItem(Request $request){

        $ids = $request->select;
        $time2  = Carbon::NOW()->format('d-m-Y H:i:s A');
        
        foreach($ids as $id)
        {
            $item = Item::find($id);
            $item->item_status_id = '2';
           
            // $item->item_process = NOW();
            if($item->item_process == NULL)
            {
                $item->item_process = array(
                    [
                        'desc' => 'Orders has been process', 
                        'datetime' => $time2,
                    ]
                );
            }

            $item->save();
        }

        
        // $data = Site::whereIn('id', $ids)->delete();
        return array('Orders has been process','success');
    }

    public function detailsProcessOrder($id){
      
        $data['itemCourier'] = $this->orderProcess($id);

        // dd($data['itemCourier']);

        $data['itemStatus'] = inf_item_status::all();

        return view('admin.order.details_process', $data);
    }


    public function cancelOrder(Request $request){
        

        $ids = $request->select;
        foreach($ids as $id)
        {
            $orders = Order::find($id);
            $orders->status_id = '5';
           

            $items = Item::where('item_order_id', $id)->get();

            foreach($items as $item)
            {
                $item = Item::find($item->id);

                $item->item_status_id = '0';
                $item->save();
            }
            
            $orders->save();
        }

        
        // $data = Site::whereIn('id', $ids)->delete();
        return array('Orders has been cancel','success');
    }

    public function processShipped(Request $request){
        // $myEmail = 'aatmaninfotech@gmail.com';
   
		$validate = $request->validate([
			'order_tracking' => 'required',
			'order_courier' => 'required',
		]);
		
        $ids = $request->id;

		$countUser = User::whereIn('id', $request->user_id)->get();
		
		if(count($countUser) > 1)
		{
			$notifikasi = array(
				'message' => 'Please select only 1 buyer',
				'alert-type' => 'error'
			);
			return redirect()->back()->with($notifikasi);
			
		}else{
			
			foreach($ids as $key => $id)
			{
				$orderId = Order::find($id);
	            $orderId->status_id = '3';
	            $orderId->shipping_payment_date = NOW();
				$orderId->tracking_no = $request->order_tracking;
				$orderId->courier_id = $request->order_courier;
				$orderId->save();
			}
     
    		$getOrders = Order::with('user','courier')
				->where('tracking_no', $request->order_tracking)
				->where('courier_id', $request->order_courier)
				->get();
//
			$arrOrderNo = array();
			foreach($getOrders as $getOrder)
			{
				array_push($arrOrderNo,$getOrder->order_no);
			}


			$orderNo = implode(", ",$arrOrderNo);

			$courier = Courier::find($request->order_courier);

			$details = [
				'title' => 'Order No : '.$orderNo,
				'url' => 'https://shoppyjapan.my/user',
				'tracking'=> 'Tracking No : '.$request->order_tracking,
				'courier' => 'Courier : '.$courier->name,
			];


			$datanotify = json_decode($getOrders[0]->user->user_notification);
			if($datanotify->notification4 == '1')
			{
				Mail::to($getOrders[0]->user->email)->send(new OrderShipped($details));

			} 

			$notifikasi = array(
				'message' => 'Tracking Number Insert Successfully',
				'alert-type' => 'success'
			);


			return redirect()->back()->with($notifikasi);
		}

    }

    public function processRefund(Request $request){

        $ids = $request->id;

        $refund = new Refund();
        $refund->refund_refno  = $request->refund_refno;
        $refund->refund_amount = $request->refund_amount;
        $refund->refund_date = $request->refund_date;
        $refund->refund_time = $request->refund_time;
        $refund->refund_user_id = $request->user_id;

        $refund->save();

        $refundId = $refund->id;


        foreach($ids as $id)
        {
            $item = Item::find($id);
            $item->refund_id = $refundId;
            $item->save();
        }

        $notifikasi = array(
            'message' => 'Refunds data insert successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notifikasi);
    }

    public function processRecieved(Request $request){
        // dd($request->all());

        foreach($request->order_id as $id)
        {
            $order = Order::find($id);
            $order->status_id = '4';
            $order->order_complete_date = NOW();
            $order->save();
        }

        $notifikasi = array(
            'message' => 'Complete order successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notifikasi);
    }


    public function processPurchase(Request $request)
    {

        foreach($request->order_id as $orderId)
        {
            $order = Order::find($orderId);
            $order->order_purchase = '1';
            $order->save();
        }

        $notifikasi = array(
            'message' => 'Complete purchase order',
            'alert-type' => 'success',
        );


        return redirect()->back()->with($notifikasi);
    }


    public function findOrder(Request $request){

		$order = Order::where('order_no',$request->orderNo)->get();

		if($order->isNotEmpty())
		{
			$id = $order[0]->id;

			return $this->show($id);
		}else{

			$notifikasi = array(
            'message' => 'Order not found',
            'alert-type' => 'warning'
		);
        return redirect()->back()->with($notifikasi);
		}
		// 
	}

    public function OderItemImage(Request $request)
    {

        // dd($request->all());
        $validate = $request->validate([
            'item_image' => 'mimes:jpg,png,jpeg,pdf|max:2000',
        ],
        [
            'item_image.max' => 'Image file must be less than 2MB',
        ]);

        $data = Item::find($request->item_id);

        if($request->file('item_image')){
            $file = $request->file('item_image');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            if($data->item_img)
            {
                \Storage::delete('public/upload/item_images/'.$data->item_img);

            }
            $filename =uniqid().'.'.strtolower($file->getClientOriginalExtension());
            // $file->move(public_path('upload/brand_images/'), $filename);
            $file->storeAs('public/upload/item_images/', $filename);
            $data->item_img = $filename;

        }

        $data->item_name = $request->item_name;
        $data->save();

        $notifikasi = array(
            'message' => 'Item successfully updated',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifikasi);
    }





    //spacing
    // start all modal pop up using ajax
    public function modalStatusItem(Request $request){

       
        $ids = $request->select;


        $it_status = DB::table('item_status')->get();

        $html = '<div></div>';
        $tempKey = [];
        foreach($ids as $key=>$id)
        {
            $numEle = $key;
            $item = Item::find($id);


            $html .= '<input type="hidden" name="item_id[]" value="'.$id.'" readonly></input>';

            $html .='<div class="item form-group">
                        <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Code</label>
                        <div class="col-form-label col-md-10 col-sm-10 ">
                            <label class="text-black-50 font-weight-bold">'.$item->item_no.'</label>
                        </div>
                    </div>';
           
        $html .= '
                <div class="item form-group" >
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold">
                    Item Status<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                        <select name="item_status[]"  id="item-'.$numEle.'"class="form-control" required>
                            <option value="" disabled>--Select Item Status--</option>';
			
						if(isset($item->item_status_id))
						{
							 foreach($it_status as $status)
							{
//								 if($item->item_status_id == $status->id)
//								 {
									$html .= '<option value="'.$status->id.'" '.($status->id === $item->item_status_id ? 'selected' : '').'>'.$status->order_status.'</option>';

//								 }else{
//									$html .= '<option value="'.$status->id.'">'.$status->order_status.'</option>';
//
//								 }
							}
						}else{
							 foreach($it_status as $status)
							{
								$html .= '<option value="'.$status->id.'" '.($status->id == 1 ? 'selected' : '').'>'.$status->order_status.'</option>';
							}
						}
                       
                            					
                        $html .='</select>
                    </div>
                    
                </div>';
                
        $html .='<div class="item form-group d-none" id="hidden-'.$numEle.'">
                        <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Item Remark<span class="text-danger">*</span>
                        </label>
                        <div class="col-form-label col-md-10 col-sm-10 ">
                            <input type="text" name="item_remark[]"  class="form-control">
                        </div>
                        
                    </div>';
        $html .= '<hr>';
      

       
        }
        $html .= '<p class="text-danger font-italic">*After save please wait system try send an email to user</p>';
     
        return array($html);
    }

    public function modalProcess(Request $request){

        $html = '';
        if(!$request->select)
        {
            
            $html .= '<div class="item form-group">
                        <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Courier Fee (RM) <span class="text-danger"></span>
                        </label>
                        <div class="col-form-label col-md-10 col-sm-10 ">
                            <input type="number" name="order_shipping" min="1.00" step="0.01"  class="form-control">
                        </div>
                        
                    </div>';
        }
        else
        {
//            $id = implode(",",$request->select);

			foreach($request->select as $id)
			{
				$orders = Order::select('*')->join('users','orders.user_id','=','users.id')->where('orders.id',$id)->first();
			 $html .='<div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 text-black-50 font-weight-bold" for="first-name">Order No. <span class="text-danger"></span>
                        </label>
                        <div class="col-form-label col-md-8 col-sm-8 ">';

            // foreach($request->select as $id)
            // {
            
            $html .= '<input type="hidden" name="id[]" value="'.$id.'" readonly></input>';
            $html .= '<p class="text-black-50 font-weight-bolder">'.$orders->order_no.'</p>';

            // }

            $html .='</div>                       
                    </div>';
				
			 $html .='<div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 text-black-50 font-weight-bold" for="first-name">Buyer Name <span class="text-danger"></span>
                        </label>
                        <div class="col-form-label col-md-8 col-sm-8 ">';
				
			$html .= '<p class="text-black-50 font-weight-bolder">'.$orders->name.'</p></div></div>';
				
            $input = "this.value=this.value.replace(/[^0-9]/g, '');";

            $html .= '
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 text-black-50 font-weight-bold" for="first-name">International Courier Fee (RM) <span class="text-danger"></span>
                        </label>
                        <div class="col-form-label col-md-8 col-sm-8 ">
                            <input type="number" name="order_shipping[]" min="0.00" step="0.01"  class="form-control" required="required" value="0.00">
                        </div>
                        
                    </div>
					<div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 text-black-50 font-weight-bold" for="first-name">Local Courier Fee (RM) <span class="text-danger"></span>
                        </label>
                        <div class="col-form-label col-md-8 col-sm-8 ">
                            <input type="number" name="order_local[]" min="0.00" step="0.01"  class="form-control" required="required" value="0.00">
                        </div>
                        
                    </div><hr>
					';
			}
           return $html;
        }
        
        
    }

    public function modalShipping(Request $request){
        // $id = implode(",",$request->select);

        $couriers = Courier::where('status','1')->get();
        // dd($courier);
        $input = "this.value=this.value.replace(/[^0-9]/g, '');";
        
        $html = '';

		$html .= '<table class="table table-striped table-bordered">
				  <thead>
					  <tr>
						<th>No</th>
						<th>Buyer Name</th>
						<th>Oder No.</th>
						<th>Total Courier Fee (RM)</th>
					  </tr>
					</thead>
					<tbody>';
					foreach($request->select as $keys => $id)
					{
						$order = Order::find($id);
						
						$html .='<tr>
								<td>'.($keys+1).'<input type="hidden" name="id[]" value="'.$id.'" readonly></input></td>
								<td>'.$order->user->name.'<input type="hidden" name="user_id[]" value="'.$order->user->id.'" readonly></input></td>
								<td>'.$order->order_no.'</td>
								<td class="text-right">'.number_format($order->order_shipping,2).'</td>
								</tr>';
					}
					$html .='</tbody>
				  </table>';
       	   $html .= '<div class="item form-group">
                <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Tracking No<span class="text-danger">*</span>
                </label>
                <div class="col-form-label col-md-10 col-sm-10 ">
                    <input type="text" name="order_tracking"  class="form-control" required>
                </div>
                
            </div>';

            $html .= '<div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Courier Type<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                        
                    <select class="form-control" name="order_courier" required>';

                    foreach( $couriers as  $courier)
                    {
                        $html .= '<option value="'.$courier->id.'">'.$courier->name.'</option>';
                    }

            $html .=    '</select>
                        </div>      
                    </div>';
       
        return $html;
    }


    public function modalRefund(Request $request){

        $arrIt = [];
        $items = Item::whereIn('id',$request->select)->get();

        foreach($items as $item)
        {
            array_push($arrIt,$item->item_order_id);

        }


        if(count(array_unique($arrIt)) === 1)
        {
            $html = '';

            $html .= '<input type="hidden" name="user_id" value="'.$items[0]->item_user_id.'" readonly></input>';

            foreach($items as $item)
            {
                $html .= '<input type="hidden" name="id[]" value="'.$item->id.'" readonly></input>';

            }

           

            $html .= '
                    <div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Reference No.<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                        <input type="text" name="refund_refno"  class="form-control" required>
                    </div>

                    </div>';

            $html .= '<div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Amount<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                    <input type="number" name="refund_amount"  step="0.01" class="form-control" required>
                    </div>
                    </div>';
            $html .= '<div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Date<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                    <input type="date" name="refund_date"  class="form-control" required>
                    </div>
                    </div>';

            $html .= '<div class="item form-group">
                    <label class="col-form-label col-md-2 col-sm-2 text-black-50 font-weight-bold" for="first-name">Time<span class="text-danger">*</span>
                    </label>
                    <div class="col-form-label col-md-10 col-sm-10 ">
                    <input class="form-control" type="time" id="datetime" name="refund_time" required/>
                    </div>
                </div>';
                    
            // }

            return $html;
        }

    }


    public function modalReceived(Request $request){
        $orders = Order::with('user','courier')->whereIn('id',$request->select)->where('status_id', '3')->get();
        // $data['courierOrder'] = Order::with('user','courier')->where('status_id', '3')->orderBy('id','DESC')->get();

        $html ='<table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>No.</td>
                    <td>Order No.</td>
                    <td>Buyer Name</td>
                    <td>Tracking No.</td>
                </tr>
                </thead>
                <tbody>';
        
        foreach($orders as $key => $order)
        {
            $no = $key+1;
        $html .='<tr>
                    <td>'.$no.'</td>
                    <td>'.$order->order_no.'</td>
                    <td>'.$order->user->name.'</td>
                    <td>'.$order->tracking_no.'<input type="hidden" name="order_id[]" value='.$order->id.'></input></td>
                </tr>';
        }
                
            $html .= '</tbody>
                </table>';

        return $html;
    }


    public function modalPurchase(Request $request){
        
        $orders = Order::with('user')
        ->whereIn('id',$request->select)
        ->where('status_id', '1')
        ->where('order_purchase', NULL)
        ->orderBy('orders.id','DESC')
        ->get();
        // $data['courierOrder'] = Order::with('user','courier')->where('status_id', '3')->orderBy('id','DESC')->get();

        $html ='<table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>No.</td>
                    <td>Order No.</td>
                    <td>Buyer Name</td>
                    <td>Order Date</td>
                </tr>
                </thead>
                <tbody>';
        
        foreach($orders as $key => $order)
        {
            $no = $key+1;
            $html .='<tr>
                    <td>'.$no.'<input type="hidden" name="order_id[]" value="'.$order->id.'"></td>
                    <td>'.$order->order_no.'</td>
                    <td>'.$order->user->name.'</td>
                    <td>'.Carbon::parse($order->created_at)->format('d-m-Y h:i:s A').'</td>
                </tr>';
        }
                
            $html .= '</tbody>
                </table>';

        return $html;

    }
    
	public function listtrans(){
		
		if(Route::currentRouteName() == 'admin.list_transaction'){
			$order = OnlineOrder::join('users','id','online_user_id')->where('online_order_status_name','success')->orderby('online_order_created','DESC')->get();	
		}else{
			$order = OnlineOrder::join('users','id','online_user_id')->orderby('online_order_created','DESC')->get();
		}
    	
        return view('admin.trans.list_transaction', compact('order'));
	}
	
	public function requery(Request $request){
		//print_r($request->all());
		$order = OnlineOrder::join('users','id','online_user_id')->where('online_order_id',$request->input('data_value'))->first();
		
		$ch = curl_init();
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();
		curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/status_api_secure.php?token=".hash('sha256',date('Y-m-d'))."");
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "".$gwconf->gateway_conf_token.":".$gwconf->gateway_conf_secret."");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"account=".$gwconf->gateway_conf_user."&trans_code=".$order->online_order_token."&type=status");
		//'account'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);     

		$trandata = json_decode($output,true);
		$view = '<form id="transform" method="get" action="./retrieval">';$btn = '';$ce = '';
		$view .= csrf_field();
		foreach($trandata as $ke => $ve){
			if($ke == 'trans_status'){
				$ce = $ve;
			}
			$view .= '<div class="row"><div class="col-4">'.$ke.'</div><div class="col-4"><strong>'.$ve.'</strong></div></div>';
		}
		$view .= '<input type="hidden" name="trans_status" value="'.$ce.'"/>';
		$view .= '<input type="hidden" name="trans_code" value="'.$order->online_order_token.'"/>';
		$view .= '<input type="hidden" name="process_type" value="admin"/>';
		if($order->online_order_status_code == ''){
			$btn = '<input type="button" class="btn btn-primary" value="reProcess Transaction" id="reprocess"/>';
		}
		return array($view,"Transaction Status",$btn);
	}
	
	public function listwallet(){
		
		if(Route::currentRouteName() == 'admin.walletin_transaction'){
			//$order = DB::select("SELECT (IFNULL((SELECT SUM(wallet_in_amount) FROM sj_wallet_in WHERE wallet_in_user_id = ?),0) - IFNULL((SELECT SUM(wallet_out_amount) FROM sj_wallet_out WHERE wallet_out_user_id = ?),0)) as wall_balance",[Auth::user()->id,Auth::user()->id]);
			$data['wallet'] = DB::table('sj_wallet_in')->join('users','id','wallet_in_user_id')->orderby('wallet_in_created','DESC')->get();
			$data['title'] = 'User Wallet In';
		}else{
			//$order = OnlineOrder::join('users','id','online_user_id')->orderby('online_order_created','DESC')->get();
			$data['wallet'] = DB::table('sj_wallet_out')->join('users','id','wallet_out_user_id')->orderby('wallet_out_created','DESC')->get();
			$data['title'] = 'User Wallet Out';
		}
    	
        return view('admin.trans.list_wallet', $data);
	}
}
