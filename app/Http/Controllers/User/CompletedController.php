<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

//namespace App\Http\Controllers\User;

//use App\Http\Controllers\Controller;

class CompletedController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function ordercompleted(){
		$draftorder = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		//dd($draftorder);
		
		$listsubmitorder = DB::table('orders')
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			->select(DB::raw("couriers.name as courier_name, couriers.url as url, tracking_no as tracking_no,order_shipping as order_shipping, order_no as order_no,order_shipping, order_complete_date, submit_at as submit_at,order_status as order_status,orders.id as order_id, (SELECT SUM(items.item_total) from items where items.item_order_id=orders.id and items.item_status_id = 1 ) as totalpay"))
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			
			//->select(DB::raw("(SUM(items.item_total) as totalpay from items where items.item_order_id=orders.id)"))
			//select(DB::raw("sum(items.item_total) as totalpay from items where items.item_order_id=orders.id"))
			->join('order_status','order_status.id','orders.status_id')
			->leftJoin('couriers', 'couriers.id', '=', 'orders.courier_id')
			->where('user_id', Auth::user()->id)
			->where('status_id', '4')
			//->where('status_id','1')
			->orderBy('submit_at','ASC')
			->get();
		$orderlist = DB::table('orders')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('items','items.item_order_id','orders.id')
			->where('user_id', Auth::user()->id)
			->where('status_id','4')
			->orderBy('submit_at','ASC')
			->get();
		//dd($listsubmitorder);
		
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
		
		
        return view('user.completed.currentcompleted',['listsubmitorder'=>$listsubmitorder, 'draftorder'=>$draftorder]);
    }
	
	public function completedpay(){
		$draftorder = DB::table('orders')
			->where('user_id', Auth::user()->id)
			->where('status_id','0')
			->orderBy('id', 'DESC')
			->first();
		//dd($draftorder);
		
		$listsubmitorder = DB::table('orders')
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			->select(DB::raw("couriers.name as courier_name, couriers.url as url, tracking_no as tracking_no,order_shipping as order_shipping, order_no as order_no,order_shipping, order_complete_date, submit_at as submit_at,order_status as order_status, order_class, orders.id as order_id, (SELECT SUM(items.item_total) from items where items.item_order_id=orders.id and items.item_status_id = 1 ) as totalpay, online_order.online_order_created as transcreated, online_order_amount, online_order_type"))
			//->select('order_no as order_no','submit_at as submit_at','order_status as order_status','orders.id as order_id')
			
			//->select(DB::raw("(SUM(items.item_total) as totalpay from items where items.item_order_id=orders.id)"))
			//select(DB::raw("sum(items.item_total) as totalpay from items where items.item_order_id=orders.id"))
			->join('order_status','order_status.id','orders.status_id')
			->join('online_order','online_order.online_batch_code','orders.order_no')
			->leftJoin('couriers', 'couriers.id', '=', 'orders.courier_id')
			->where('user_id', Auth::user()->id)
			//->where('status_id', '4')
			->where('online_order.online_user_id', Auth::user()->id)
			->where('online_order_status', '1')
			//->where('status_id','1')
			->orderBy('online_order.online_order_created','DESC')
			->get();
		//dd($listsubmitorder);
		$orderlist = DB::table('orders')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('items','items.item_order_id','orders.id')
			->where('user_id', Auth::user()->id)
			->where('status_id','4')
			->orderBy('submit_at','ASC')
			->get();
		//dd($listsubmitorder);
		
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
		
		
        return view('user.completed.currentcompletedpay',['listsubmitorder'=>$listsubmitorder, 'draftorder'=>$draftorder]);
    }
	
	public function viewcomorder($id)
    {
        //$item = Item::find($id);
		/*$item = DB::table('items')
			->where('item_user_id', Auth::user()->id)
			->where('id',$id)
			->first();*/
		
		$orderinfo = DB::table('orders')
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
		
		
		
		
        return view('user.completed.viewcomorder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'addressdelivery'=>$addressdelivery,  'orderstatus'=>$orderstatus, 'listitemorderavailable'=>$listitemorderavailable, 'listitemordernotavailable'=>$listitemordernotavailable, 'totalavailableorder'=>$totalavailableorder, 'totalnotavailableorder'=>$totalnotavailableorder]);
    }
	/*
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
		
		
		$orderinfo = DB::table('orders')
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
		
		
		
		
        return view('user.order.vieworder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'addressdelivery'=>$addressdelivery,  'orderstatus'=>$orderstatus, 'listitemorderavailable'=>$listitemorderavailable, 'listitemordernotavailable'=>$listitemordernotavailable, 'totalavailableorder'=>$totalavailableorder, 'totalnotavailableorder'=>$totalnotavailableorder]);
    }
	
	public function paymentorder($id)
    {
        //$item = Item::find($id);
		
		
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
		$mailingaddress = DB::table('addresses')
			//->select(DB::raw("SUM(item_total) as total"))
			//->select('orbt_childindex as id','orba_shortname as name')
			->join('inf_state','inf_state.state_in','addresses.state')
			->join('inf_countries','inf_countries.country_id','addresses.country')
			->where('user_id', Auth::user()->id)
			->where('status','1')
			
			->first();
		
		//$configinfo = DB::table('configs')
		//	->where('id','1')
		//	->first();
		
		
		
        return view('user.order.paymentorder', ['orderinfo'=>$orderinfo, 'listitemorder'=>$listitemorder, 'totalorder'=>$totalorder, 'liststate'=>$liststate, 'mailingaddress'=>$mailingaddress]);
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
		//return redirect()->route('user.neworder',['order_no'=>$noorder]);
		
        //return view('user.order.neworder');
    }
	
	public function createitem(Request $request){
		$data = new Item();
		 $currentdate = date("Ymdhis");
		 $subtotal = ($request->quantity * $request->price) + $request->services;
		 $subtotalitem = $request->quantity * $request->price;
		 //$noorder = $currentdate.'-'.Auth::user()->id;
         $data->item_url = $request->url_address;
		 $data->item_yenprice = $request->price;
		 //$data->item_rmprice = $request->myprice;
		 $data->item_quantity = $request->quantity;
		 $data->item_currency = $request->item_currency;
		 $data->item_services = $request->services;
		 //$data->item_subtotal_services = $request->subtotalservise;
		 $data->item_subtotal_item = $subtotalitem;
		 $data->item_subtotal = $subtotal;
		 $data->item_total = $request->total;
		 
         $data->item_user_id = Auth::user()->id;
		 $data->item_order_id = $request->item_order_id;
		 $data->created_by = Auth::user()->id;
		
		 $data->save();
        Session::pull('order_url');
		Session::pull('order_price');
		//dd(session()->all());
       
        return redirect()->route('user.neworder');
		//return redirect()->route('user.neworder',['order_no'=>$noorder]);
		
        //return view('user.order.neworder');
    }
	
	
	
	
*/	
	
}
