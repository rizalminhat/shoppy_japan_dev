<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Item;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:admin.verification.notice');
    }


    public function index(){

        $now = Carbon::now();
        $currDate = $now->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->endOfWeek()->format('Y-m-d');  
        // $currMonth = $now->month;
        $currYear = date('Y');

        $currMonth = date('m');
        $prevMonth = now()->subMonthWithoutOverflow()->format('m'); // 8

        $prevYear = now()->subYear()->format('Y');


        $data['users'] = User::all()->count();
        $data['neworders']= Order::where('status_id', '1')
        ->where('order_purchase',NULL)
        ->get()
        ->count();

        $data['purchaseOrder'] = Order::where('status_id','1')
        ->where('order_purchase','=','1')
        ->get()
        ->count();

        $data['process_orders']= Order::where('status_id', '2')
        ->get()
        ->count();
        
        $data['in_courier']= Order::where('status_id', '3')->get()->count();

        $data['completeOrder'] = Order::where('status_id', '4')->get()->count();

        $data['todayLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('item_status_id', '1')
        ->whereDate('submit_at', $currDate)
        ->get()
        ->count();
        // dd($data['today_links']);
        // $data['totalLinks'] = Item::where('item_status_id', '1')
        // ->get()
        // ->count();

        $data['totalLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereNotNull('submit_at')
        ->where('item_status_id', '1')
        ->get()
        ->count("id");


        $data['total_orders']= Order::whereNotIn('status_id', [0,5])->get()->count();

        $data['buyers'] = User::has('buyer')->get()->count(); 
        $data['recent_orders'] = Order::with('user')
        ->where('status_id', '=', '1')
        ->where('order_purchase',NULL)
        ->orderBy('submit_at', 'DESC')
        // ->limit(5)
        ->get();

       $data['todayUser'] = User::whereDate('created_at', $currDate)->get()->count();
       
       $data['yesterdaySales'] = DB::table('orders')
        ->SELECT('*')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereDate('orders.submit_at', $yesterday)
        ->where('orders.status_id', '!=', '0')
        ->where('items.item_status_id', '1')
        ->get()
        ->sum("item_total");

        $data['todaySales'] = DB::table('orders')
        ->SELECT('*')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereDate('orders.submit_at', $currDate)
        ->where('orders.status_id', '!=','0')
        // ->where('items.item_status_id', '1')
        ->get()
        ->sum("item_total");
        
        $data['totalSales'] = DB::table('orders')
        ->SELECT('*')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        // ->where('orders.status_id', '!=', '0')
        ->where('items.item_status_id', '1')
        ->whereNotNull('orders.submit_at')
        ->get()
        ->sum("item_total");

        $data['sumByWeek'] = DB::table('orders')
        ->SELECT('*')
        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
        ->whereBetween('orders.submit_at', [$start,$end])
        // ->where('orders.status_id', '!=','0')
        ->where('items.item_status_id', '1')
        ->get()
        ->sum("item_total");

            
        $data['sumByMonth'] = DB::table('orders')
        ->SELECT('*')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereMonth('orders.submit_at',  $currMonth)
        ->whereYear('orders.submit_at', $currYear)
        ->where('orders.status_id', '!=','0')
        ->where('items.item_status_id', '1')
        ->get()
        ->sum("item_total");


        $data['monthlyLinks'] = DB::table('orders')
        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
        ->whereMonth('submit_at',  $currMonth)
        ->whereYear('submit_at', $currYear)
        ->where('item_status_id', '1')
        ->get()
        ->count("items.id");
        


        //prev month link

        $data['preMonth'] = now()->subMonthWithoutOverflow()->format('M');


        $qryPrevLinks = DB::table('orders')
        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
        ->whereMonth('submit_at',  $prevMonth);

        if($prevMonth>$currMonth)
        {
            
            $qryPrevLinks = $qryPrevLinks->whereYear('submit_at', $prevYear);
			$myYear = $prevYear;
        }else{

            $qryPrevLinks = $qryPrevLinks->whereYear('submit_at', $currYear);
			$myYear = $currYear;
        }

        $data['myYear'] = $myYear;
        $data['prevMonLinks'] = $qryPrevLinks->where('item_status_id', '1')
        ->get()
        ->count('items.id');

        if(Auth::user()->id == 3)
        {
            // dd($data);
        }
        return view('admin.dashboard', $data);

        
    }
}
