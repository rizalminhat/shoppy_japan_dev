<?php 


namespace App\Http\Controllers;

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
use PDF;
class PdfController extends Controller
{
    public function getOrderHistory($id)
    {
        $data['items'] = Item::where('item_order_id',$id)->where('item_status_id', '1')->get();

        $data['total'] = DB::table('items')
        ->SELECT('*')
        // ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
        // ->where('orders.status_id', '!=','0')
        ->where('items.item_status_id', '1')
        ->where('items.item_order_id', $id)
        ->get()
        ->sum("item_total");
        // $data['order'] = Order::with('orderAddress')->get();
        $data['order'] = DB::table('orders')
        ->select('orders.*', 'couriers.name AS courier_name', 'couriers.url AS courier_url', 'orderaddress.address1 AS order_address1', 'orderaddress.address2 AS order_address2','orderaddress.address3 AS order_address3','orderaddress.postcode AS order_postcode', 'orderaddress.city AS order_city','inf_state.state_name AS order_state','users.name AS user_name','users.email AS user_email')

        ->join('users', 'orders.user_id', '=', 'users.id')
        ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
        ->leftJoin('orderaddress', 'orderaddress.order_id', '=' , 'orders.id')
        ->leftJoin('inf_state','orderaddress.state','=','inf_state.state_in')
        ->where('orders.id', $id)
        ->first();

       

        $data['online'] = DB::table('online_order')
        ->where('online_batch_code',$data['order']->order_no)
        ->where('online_order_status_name', 'success')
        ->where('online_order_type','orderpayment')
        ->first();
        // return view('pdf.order_history', compact('order'));

        // dd($data);
        $pdf = PDF::loadView('pdf.order_history', $data);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }	
}