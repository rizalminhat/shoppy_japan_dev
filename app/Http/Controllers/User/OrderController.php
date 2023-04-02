<?php

namespace App\Http\Controllers\User;

use DB;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Notifications\VerifyEmail;


//namespace App\Http\Controllers\User;

//use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function index(){
		$draftorder = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		//dd($draftorder);
		
		$listsubmitorder = DB::table('orders')
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			->select(DB::raw("url as url,name,tracking_no as tracking_no,order_shipping,tracking_no as tracking_no,order_status.id as order_stat_id,shipping_payment_status as shipping_payment_status,order_class as order_class,order_no as order_no,DATE_FORMAT(submit_at,'%d/%m/%Y') AS submit_atnew,submit_at as submit_at, order_status as order_status,orders.id as order_id, (SELECT SUM(items.item_total) from items where items.item_order_id=orders.id) as totalpay,(SELECT SUM(items.item_total) from items where items.item_order_id=orders.id and items.item_status_id = '0') as deductpay, (select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '1') as totalavailable, (select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '2') as totalprocess, (select count(items.id) as totalnotavailable from items where items.item_order_id=orders.id and items.item_status_id = '0') as totalnotavailable"))
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			
			//->select(DB::raw("(SUM(items.item_total) as totalpay from items where items.item_order_id=orders.id)"))
			//select(DB::raw("sum(items.item_total) as totalpay from items where items.item_order_id=orders.id"))
			->join('order_status','order_status.id','orders.status_id')
			->leftJoin('couriers', 'couriers.id', '=', 'orders.courier_id')
			->where('user_id', Auth::user()->id)
			->where('status_id', '!=' , '0')
			->where('status_id', '!=' , '4')
			//->where('status_id','1')
			->orderBy('orders.id','DESC')
			->get();
		//dd($listsubmitorder);
		$orderlist = DB::table('orders')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('items','items.item_order_id','orders.id')
			->where('user_id', Auth::user()->id)
			->where('status_id','1')
			->orderBy('submit_at','ASC')
			->get();
		//dd($listsubmitorder);
		
		foreach($listsubmitorder as $ol)
		{
			$item = DB::table('items')
			->where('item_order_id',$ol->order_id)
			->get();

			if(!empty($item))
			{
				$ol->item_details = $item;
			}else{
				$ol->item_details = '';
			}
			
		}

		// dd($orderlist);
		/*$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$draftorder->id)
	    ->get();*/
		/*$orderlist = DB::table('orders')
			->select(DB::raw("SUM(item_total) as total"))
            ->join('items', 'items.item_order_id', '=', 'orders.id')
			->where('status_id','1')
			->orderBy('submit_at','ASC')
            //->join('orders', 'users.id', '=', 'orders.user_id')
			
           // ->select('users.*', 'contacts.phone', 'orders.price')
            ->get(); */
		//dd($orderlist);
		
		// dd($listsubmitorder);
		
//		if(Auth::user()->id == '140')
//		{
//			dd($listsubmitorder);
//		}else{
        return view('user.order.currentorder',['listsubmitorder'=>$listsubmitorder, 'draftorder'=>$draftorder]);
//		}
    }
	
	public function neworder(){
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		//dd($latestorderinfo);
		if(isset($latestorderinfo))
		{
			//dd('ada');
			$listitemorder = DB::table('items')
			
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$latestorderinfo->id)
			->orderBy('id','DESC')
			->get();
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$latestorderinfo->id)
	    ->first();
		
		$configinfo = DB::table('configs')
			->where('id','1')
			->first();
		//dd($configinfo);
		
		
		//(session()->all());
        return view('user.order.neworder',['latestorderinfo'=>$latestorderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'configinfo'=>$configinfo]);
		}
		else
		{
			//dd('tiada');
		 $data = new Order();
		 $currentdate = date("Ymdhis");
		 $noorder = $currentdate.'-'.Auth::user()->id;
         $data->order_no = $noorder ;
         $data->user_id = Auth::user()->id;
		 $data->status_id = 0;
		 $data->save();	
		 return redirect()->route('user.neworder');	
		}
		
		
    }

	public function neworderurl(Request $request){
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		if(isset($latestorderinfo))
		{
			$listitemorder = DB::table('items')
			
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$latestorderinfo->id)
			->orderBy('id','DESC')
			->get();
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$latestorderinfo->id)
	    ->first();
			
		$configinfo = DB::table('configs')
			->where('id','1')
			->first();


		$request->session()->put('order_url', $request->url);
		$request->session()->put('order_price', $request->price);
		//dd($configinfo);
		
		
		//(session()->all());
        return view('user.order.neworder',['latestorderinfo'=>$latestorderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'configinfo'=>$configinfo]);	
			
		}
		else
		{	
		$data = new Order();
		 $currentdate = date("Ymdhis");
		 $noorder = $currentdate.'-'.Auth::user()->id;
         $data->order_no = $noorder ;
         $data->user_id = Auth::user()->id;
		 $data->status_id = 0;
		 $data->save();	
			$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
			
			$listitemorder = DB::table('items')
			
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$latestorderinfo->id)
			->orderBy('id','DESC')
			->get();
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$latestorderinfo->id)
	    ->first();
			$configinfo = DB::table('configs')
			->where('id','1')
			->first();


		$request->session()->put('order_url', $request->url);
		$request->session()->put('order_price', $request->price);
		//dd($configinfo);
		
		
		//(session()->all());
        return view('user.order.neworder',['latestorderinfo'=>$latestorderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'configinfo'=>$configinfo]);
		}
		
		
		
    }
	
	public function edititem($id)
    {
        //$item = Item::find($id);
		$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();
		
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->where('id',$item->item_order_id)
			->first();
		$configinfo = DB::table('configs')
			->where('id','1')
			->first();
		
        return view('user.order.edititem', ['item'=>$item, 'latestorderinfo'=>$latestorderinfo, 'configinfo'=>$configinfo]);
    }
	
	public function vieworder($id)
    {
        //$item = Item::find($id);
		/*$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();*/
		$userinfo = DB::table('users')
			->where('id', Auth::user()->id)
			->first();
		
		$orderinfo = DB::table('orders')
			->select(DB::raw("id, order_no, user_id, created_at, updated_at, status_id, admin_id, submit_at, submit_user_id, order_shipping, order_process_date, shipping_payment_status, shipping_payment_date, tracking_no, courier_id, order_history, order_complete_date"))
			//->join('order_status','order_status.id','orders.status_id')
			//->join('order_status','order_status.id','orders.state')
			//->join('order_status','orders.status_id','order_status.id')
			->where('user_id', Auth::user()->id)
			//->where('status_id','1')
			->where('orders.id',$id)
			->first();
		//dd($orderinfo);
		
		$orderstatus = DB::table('order_status')
			->where('id',$orderinfo->status_id)
		    ->first();
		$listitemorder = DB::table('items')
			->leftJoin('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->orderBy('items.id','ASC')
			->get();
		
		$listitemorderavailable = DB::table('items')
			->Join('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->where('items.item_status_id','1')
			->orderBy('items.id','ASC')
			->get();
		
		
		$listitemordernotavailable = DB::table('items')
			->Join('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->where('items.item_status_id','0')
			->orderBy('items.id','ASC')
			->get();
		//dd($listitemordernotavailable);
		
		
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
	    ->first();
		
		$totalavailableorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
		->where('items.item_status_id','1')
	    ->first();
		
		$totalnotavailableorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
		->where('items.item_status_id','0')
	    ->first();
		
		$addressdelivery = DB::table('orderaddress')
			->join('inf_state','inf_state.state_in','orderaddress.state')
			->join('inf_countries','inf_countries.country_id','orderaddress.country')
			->where('user_id', Auth::user()->id)
			->where('order_id',$orderinfo->id)
			
			->first();
		
		//$configinfo = DB::table('configs')
		//	->where('id','1')
		//	->first();
		
		
		
		
        return view('user.order.vieworder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'addressdelivery'=>$addressdelivery,  'orderstatus'=>$orderstatus, 'listitemorderavailable'=>$listitemorderavailable, 'listitemordernotavailable'=>$listitemordernotavailable, 'totalavailableorder'=>$totalavailableorder, 'totalnotavailableorder'=>$totalnotavailableorder, 'userinfo'=>$userinfo]);
    }
	
	public function received($id)
    {
        //$item = Item::find($id);
		/*$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();*/
		$userinfo = DB::table('users')
			->where('id', Auth::user()->id)
			->first();
		
		$orderinfo = DB::table('orders')
			///->leftJoin('couriers', 'couriers.id', '=', 'orders.courier_id')
			//->join('order_status','order_status.id','orders.status_id')
			//->join('order_status','order_status.id','orders.state')
			//->join('order_status','orders.status_id','order_status.id')
			->where('user_id', Auth::user()->id)
			//->where('status_id','1')
			->where('orders.id',$id)
			->first();
		//dd($orderinfo);
		
		$courierinfo = DB::table('couriers')
		->where('id', $orderinfo->courier_id)
			//->where('status_id','1')
			
			->first();	
		
		$orderstatus = DB::table('order_status')
			->where('id',$orderinfo->status_id)
		    ->first();
		$listitemorder = DB::table('items')
			->leftJoin('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->orderBy('items.id','ASC')
			->get();
		
		$listitemorderavailable = DB::table('items')
			->Join('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->where('items.item_status_id','1')
			->orderBy('items.id','ASC')
			->get();
		
		
		$listitemordernotavailable = DB::table('items')
			->Join('item_status', 'item_status.id', '=', 'items.item_status_id')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->where('items.item_status_id','0')
			->orderBy('items.id','ASC')
			->get();
		//dd($listitemordernotavailable);
		
		
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
	    ->first();
		
		$totalavailableorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
		->where('items.item_status_id','1')
	    ->first();
		
		$totalnotavailableorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
		->where('items.item_status_id','0')
	    ->first();
		
		$addressdelivery = DB::table('orderaddress')
			->join('inf_state','inf_state.state_in','orderaddress.state')
			->join('inf_countries','inf_countries.country_id','orderaddress.country')
			->where('user_id', Auth::user()->id)
			->where('order_id',$orderinfo->id)
			
			->first();
		
		
		//$configinfo = DB::table('configs')
		//	->where('id','1')
		//	->first();
		
		
		
		
        return view('user.order.receivedorder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'addressdelivery'=>$addressdelivery,  'orderstatus'=>$orderstatus, 'listitemorderavailable'=>$listitemorderavailable, 'listitemordernotavailable'=>$listitemordernotavailable, 'totalavailableorder'=>$totalavailableorder, 'totalnotavailableorder'=>$totalnotavailableorder, 'userinfo'=>$userinfo, 'courierinfo'=>$courierinfo]);
    }
	
	public function processorder(Request $request){
		//use App\Http\Controllers\User\ZPay\ZpayController;
		$inorder = Order::join('items','orders.id','items.item_order_id')->where('orders.id',$request->input('order_id'))->get();
		//print('<pre>');print_r($inorder->get()->toArray());print('</pre>');
		//foreach($inorder->get()->toArray() as $ke => $ve){
		//	$request->merge([$ke,$ve]);
		//}
		$amount = 0;
		foreach($inorder as $io){
			$amount += $io->item_total;
		}
		if($request->input('paymentmethod') == 'ewallet'){
			$request->merge([
			"type"=>"orderpayment",
			"desc"=>"ShoppyJapan SJPAY ".$inorder[0]->order_no,
			"bank"=>"",
			"ref"=>'SJPAY'.$inorder[0]->order_no.'-'.uniqid(),
			"batch_code"=>$inorder[0]->order_no,
			"bank_pay"=>"",
			"amount_pay"=>$amount
						]);
			return $inpay = app('App\Http\Controllers\User\ZPay\ZPayController')->sjpayrequest($request);
		}else{
			$request->merge([
			"type"=>"orderpayment",
			"desc"=>"ShoppyJapan Batch ".$inorder[0]->order_no,
			"bank"=>"",
			"ref"=>$inorder[0]->order_no.'-'.uniqid(),
			"batch_code"=>$inorder[0]->order_no,
			"bank_pay"=>"",
			"amount_pay"=>$amount
						]);
			return $inpay = app('App\Http\Controllers\User\ZPay\ZPayController')->request($request);
		}
		//return view('user.order.zpayorder');
	}
	
	public function paymentselection(Request $request){
		//print('<pre>');print_r($request->input());print('</pre>');
		
		$inorder = Order::where('orders.id',$request->input('data_value'))->first();
		
		$ewallet = DB::select("SELECT 
			(IFNULL((SELECT SUM(wallet_in_amount) FROM sj_wallet_in WHERE wallet_in_user_id = ?),0) - IFNULL((SELECT SUM(wallet_out_amount) FROM sj_wallet_out WHERE wallet_out_user_id = ?),0)) as wall_balance",[Auth::user()->id,Auth::user()->id]);
		
		if($inorder->order_shipping <= 0){
			$div = '<div class="row">
			<div class="col-6">No Payment Needed</div>
			</div>';
			$btn = '';
		}else{
			if($ewallet[0]->wall_balance < $inorder->order_shipping){
				$diser = 'disabled';
			}else{
				$diser = '';
			}
			
			$div = '<form id="payform'.$request->input('data_value').'" method="POST" action="https://shoppyjapan.my/user/order/payment-process-courier" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
			<input id="order_id" class="form-control" type="hidden" name="order_id" value="'.$request->input('data_value').'">
			<input type="hidden" name="_token" value="'.csrf_token().'">
			<div class="row">
			<div class="col-6"><img class="img-fluid w-200" src="/main/img/zPay_sm.jpg"><br/><input type="radio" name="payment_method" value="zpay" checked/> zPay Payment (Online Bank)</div>
			<div class="col-6"><img class="img-fluid w-200" src="/main/img/SJ-Pay.jpg"><br/><input type="radio" name="payment_method" value="ewallet" '.$diser.'/> SJPay Payment (eWallet - '.number_format($ewallet[0]->wall_balance,2).')</div>
			</div></form>';
			$btn = '<button class="btn btn-success" id="thepay" type="button" data-payment="'.$request->input('data_value').'">Pay Courier</button>';
		}
		
		
		return array($div,'Payment Options',$btn);
	}
	
	public function processcourier(Request $request){
		//use App\Http\Controllers\User\ZPay\ZpayController;
		$inorder = Order::where('orders.id',$request->input('order_id'))->first();
		$amount = $inorder->order_shipping;
		
		if(NULL !== $request->input('payment_method') && $request->input('payment_method') == 'ewallet'){
			
			
			//print('<pre>');print_r($request->input());print('</pre>');
			$request->merge([
				"user_id"=>$inorder->user_id,
				"type"=>"courierpayment",
				"desc"=>"ShoppyJapan Courier ".$inorder->order_no,
				"bank"=>"",
				"ref"=> 'SJPAY'.$inorder->order_no.'-'.uniqid(),
				"batch_code"=>$inorder->order_no,
				"bank_pay"=>"",
				"amount_pay"=>$amount
							]);
			
			//print('<pre>');print_r($request->input());print('</pre>');
			return $inpay = app('App\Http\Controllers\User\ZPay\ZPayController')->sjpayrequest($request);
			//$inpay = app('App\Http\Controllers\User\ZPay\ZPayController')->request($request);
			
			
		}else{
			//print('<pre>');print_r($inorder->get()->toArray());print('</pre>');
			//foreach($inorder->get()->toArray() as $ke => $ve){
			//	$request->merge([$ke,$ve]);
			//}
			
			//foreach($inorder as $io){
			//	$amount += $io->item_total;
			//}
			$request->merge([
				"type"=>"courierpayment",
				"desc"=>"ShoppyJapan Courier ".$inorder->order_no,
				"bank"=>"",
				"ref"=>$inorder->order_no.'-'.uniqid(),
				"batch_code"=>$inorder->order_no,
				"bank_pay"=>"",
				"amount_pay"=>$amount
							]);
			$inpay = app('App\Http\Controllers\User\ZPay\ZPayController')->request($request);
		}
		
		//return view('user.order.zpayorder');
	}
	
	public function paymentorder($id)
    {
        //$item = Item::find($id);
		/*$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();*/
		$ewallet = DB::select("SELECT 
			(IFNULL((SELECT SUM(wallet_in_amount) FROM sj_wallet_in WHERE wallet_in_user_id = ?),0) - IFNULL((SELECT SUM(wallet_out_amount) FROM sj_wallet_out WHERE wallet_out_user_id = ?),0)) as wall_balance",[Auth::user()->id,Auth::user()->id]);
		
		$orderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			//->where('status_id','0')
			->where('id',$id)
			->first();
		
		$listitemorder = DB::table('items')
			
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$orderinfo->id)
			->orderBy('id','DESC')
			->get();
		//$totalorder = DB::table("items")->sum('item_subtotal');
		$totalorder = DB::table("items")
	    ->select(DB::raw("SUM(item_total) as total"))
		->where('item_user_id', Auth::user()->id)
		->where('item_order_id',$orderinfo->id)
	    ->first();
		
		$liststate = DB::table('inf_state')
			->where('state_in', '<=', '16')
			->orderBy('state_name','ASC')
			->get();

		$listCountry = DB::table('inf_countries')
		->where('country_is_active', '=', '1')
		->orderBy('country_name','ASC')
		->get();
		$mailingaddress = DB::table('addresses')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('inf_state','inf_state.state_in','addresses.state')
			->join('inf_countries','inf_countries.country_id','addresses.country')
			->where('user_id', Auth::user()->id)
			->where('status','1')
			->get();
		
		$mailingaddress2 = DB::table('addresses')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('inf_state','inf_state.state_in','addresses.state')
			->join('inf_countries','inf_countries.country_id','addresses.country')
			->where('user_id', Auth::user()->id)
			->where('status','1')
			->get();
			//->first();
		
		//$configinfo = DB::table('configs')
		//	->where('id','1')
		//	->first();
		
		
		
        return view('user.order.paymentorder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'liststate'=>$liststate, 'listCountry'=>$listCountry,'mailingaddress'=>$mailingaddress, 'mailingaddress2'=>$mailingaddress2,'ewallet'=>$ewallet]);
    }
	
	public function deleteitem($id)
    {
        //$item = Item::find($id);
		$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();
		
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->where('id',$item->item_order_id)
			->first();
		$configinfo = DB::table('configs')
			->where('id','1')
			->first();
		
        return view('user.order.deleteitem', ['item'=>$item, 'latestorderinfo'=>$latestorderinfo, 'configinfo'=>$configinfo]);
    }
	
	public function updateitem(Request $request, $id)
    {
        $item = Item::find($id);
		 $subtotal = ($request->input('quantity') * $request->input('price')) + $request->input('services');
		 $subtotalitem = $request->input('quantity') * $request->input('price');
		
        $item->item_url = $request->input('url_address');
        $item->item_yenprice = $request->input('price');
        //$item->item_rmprice = $request->input('myprice');
        $item->item_quantity = $request->input('quantity');
		$item->item_currency = $request->input('item_currency');
        $item->item_services = $request->input('services');
		
		$item->item_subtotal_item = $subtotalitem;
		$item->item_total = $request->input('total');
		$item->item_desc = $request->item_desc;
		$item->item_subtotal = $request->grand_totalyen;
		 //$data->item_total = $request->total;
		
		//$item->item_subtotal_services = $request->input('subtotalservise');
		//$item->item_subtotal = $request->input('totalrm');
		//$item->item_total = $request->input('total');
		
		
        $item->update();
		return redirect()->route('user.neworder');
		//return view('user.order.neworder');
        //return redirect()->back()->with('status','Student Updated Successfully');
    }
	
	
	
	
	public function confirmdeleteitem(Request $request, $id)
    {
        //$item = Item::find($id);
        //$item->item_url = $request->input('url_address');
        ////$item->item_yenprice = $request->input('price');
        //$item->item_rmprice = $request->input('myprice');
        //$item->item_quantity = $request->input('quantity');
		//$item->item_currency = $request->input('item_currency');
       // $item->item_services = $request->input('services');
		
		//$item->item_subtotal_services = $request->input('subtotalservise');
		//$item->item_subtotal = $request->input('totalrm');
		//$item->item_total = $request->input('total');
		
		
        //$item->update();
		DB::delete('delete from items where id = ?',[$id]);
      echo "Record deleted successfully.<br/>";
      //echo '<a href = "/delete-records">Click Here</a> to go back.';
		return redirect()->route('user.neworder');
		
	
		//return view('user.order.neworder');
        //return redirect()->back()->with('status','Student Updated Successfully');
    }
	
	
	public function createorder(Request $request){
		
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		//dd($latestorderinfo);
		if(isset($latestorderinfo))
		{
			return redirect()->route('user.neworder');	
		}
		else
		{
		
		 $data = new Order();
		 $currentdate = date("Ymdhis");
		 $noorder = $currentdate.'-'.Auth::user()->id;
         $data->order_no = $noorder ;
         $data->user_id = Auth::user()->id;
		 $data->status_id = 0;
		 $data->save();
		 //$request->session()->forget('order_url', $request->url_address);
		 //session::forget('order_url','order_price');
		

       
        return redirect()->route('user.neworder');
		}
		//return redirect()->route('user.neworder',['order_no'=>$noorder]);
		
        //return view('user.order.neworder');
    }
	
	
	public function terimaorder(Request $request){
		
		
		 $order = Order::find($request->input('order_id'));
		 //$subtotal = ($request->input('quantity') * $request->input('price')) + $request->input('services');
		 //$subtotalitem = $request->input('quantity') * $request->input('price');
		
        $order->status_id = '4';
        $order->order_complete_date = NOW();
       
		 //$data->item_total = $request->total;
		
		//$item->item_subtotal_services = $request->input('subtotalservise');
		//$item->item_subtotal = $request->input('totalrm');
		//$item->item_total = $request->input('total');
		
		
        $order->update();
		return redirect()->route('user.currentorder');
		//return redirect()->route('user.neworder',['order_no'=>$noorder]);
		
        //return view('user.order.neworder');
    } 
	
	public function createitem(Request $request){
		$data = new Item();
		 $currentdate = date("Ymdhis");
		 $subtotal = ($request->quantity * $request->price) + $request->services;
		 $subtotalitem = $request->quantity * $request->price;
		 //$noorder = $currentdate.'-'.Auth::user()->id;
		 //$last = DB::table('items')->latest()->first();
		 //$last = DB::table('items')->latest('id')->first();
		//$last = DB::table('items')
			//->orderBy('id', 'DESC')
			//->first();
		//$newid = $last;
         $data->item_url = $request->url_address;
		 $totalmax = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('item_order_id',$request->item_order_id)
			->orderBy('id', 'DESC')
			->first();
		if(empty($totalmax->id))
		{
			$newnum = 1;
			$itemno = $request->order_no.'-'.$newnum;
		}
		else
		{
			$explodeitem = explode("-", $totalmax->item_no);
			//dd($explodeitem[2]);
			$newnum = $explodeitem[2]+1;
			//dd($newnum);
			$itemno = $request->order_no.'-'.$newnum;
		}
		 $data->item_no = $itemno;
		 $data->item_yenprice = $request->price;
		 $data->item_quantity = $request->quantity;
		 $data->item_currency = $request->item_currency;
		 $data->item_services = $request->services;
		 $data->item_subtotal_item = $subtotalitem;
		 $data->item_subtotal = $subtotal;
		 $data->item_total = $request->total;
         $data->item_user_id = Auth::user()->id;
		 $data->item_order_id = $request->item_order_id;
		 $data->created_by = Auth::user()->id;
		 $data->item_desc = $request->item_desc;
		
		 $data->save();
        Session::pull('order_url');
		Session::pull('order_price');
		//dd(session()->all());
       
        return redirect()->route('user.neworder');
		//return redirect()->route('user.neworder',['order_no'=>$noorder]);
		
        //return view('user.order.neworder');
    }
	
	public function edititem2(Request $request)
	{
		//dd($request->input('item_id'));
		$id= $request->input('item_id');
		//$item = Item::find($id);
		$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();
		
		$latestorderinfo = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->where('id',$item->item_order_id)
			->first();
		$configinfo = DB::table('configs')
			->where('id','1')
			->first();
		
        return view('user.order.edititem', ['item'=>$item, 'latestorderinfo'=>$latestorderinfo, 'configinfo'=>$configinfo]);
		
		
	}
	
	/*public function store(Request $request)
    {
        
        $validate = $request->validate([
            'brandName' => 'required',
            'brandUrl' => 'required',
            'brandImage' => 'required|mimes:jpg,png,jpeg,pdf|max:2000',
            ],
            [
            'brandImage.max' => 'Image file must be less than 2MB' ,
            ]
        );

        $data = new Site();
        $data->site_name = $request->brandName;
        $data->site_url = $request->brandUrl;
        $data->admin_id = Auth::user()->id ;

        if($request->file('brandImage')){
            $file = $request->file('brandImage');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            $filename =uniqid().$request->brandName.'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $request->file('brandImage')->storeAs('public/upload/brand_images/', $filename);
            $data->site_img = $filename;
        }

        $data->save();

        $notifikasi = array(
            'message' => 'Shopping site successfully inserted',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.shoppingsite.view')->with($notifikasi);

    } */
	
	public function findOrder(Request $request)
	{

		$order = Order::where('order_no',$request->orderNo)->get();

		if($order->isNotEmpty())
		{
			$id = $order[0]->id;

			return $this->vieworder($id);
		}else{

			$notifikasi = array(
            'message' => 'Order not found',
            'alert-type' => 'warning'
		);
        return redirect()->back()->with($notifikasi);
		}
		// 

		
	}

	public function refunds()
	{
		$refunds = Refund::with('items')->where('refund_user_id', Auth::user()->id)->orderBy('refund_date', 'DESC')->get();

		// dd($refunds);
		return view('user.order.refunditem', compact('refunds'));
	}

	public function detailsItem($id)
	{
        $data['item'] = Item::with('order','user')
        ->select('items.*','item_status.id AS itemstatus_id', 'item_status.order_status AS itemstatus_orderstatus')
        ->leftJoin('item_status', 'items.item_status_id', '=', 'item_status.id')
		->where('item_user_id', Auth::user()->id)
        ->findorfail($id);

        // dd($data['item']);
        return view('user.order.detailitem', $data);
    }
}
