<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Announce;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function index(){

        $data['newOrder'] = Order::where('submit_user_id', Auth::user()->id)->where('status_id','1')->count();
        $data['processOrder'] = Order::where('submit_user_id', Auth::user()->id)->whereIn('status_id',['2','3'])->count();
        $data['completeOrder'] = Order::where('submit_user_id', Auth::user()->id)->where('status_id', '4')->count();


        $monthNum = array(
            '01',
            '02',
            '03',
            '04',
            '05',
            '06',
            '07',
            '08',
            '09',
            '10',
            '11',
            '12');


            $uId = Auth::user()->id;
            $data['arr'] = [];

        foreach($monthNum as $val)
        {
            $orderChart = Order::
            where('submit_user_id', $uId)
            ->whereYear('submit_at', '=', now()->year)
            ->whereMonth('submit_at', '=', $val)
            ->count();


            // dd($orderChart);
        
           
            array_push( $data['arr'], $orderChart);
    
        }

        $data['announce'] = Announce::whereIn('announce_type', ['user','both'])->where('announce_status','1')->get();
        // dd($data['announce']);
        return view('user.dashboard', $data);
    }
}
