<?php

namespace App\Http\Controllers\Admin;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Order;


use App\Models\Refund;
use App\Models\Announce;
use App\Mail\NewOrderMail;
use App\Models\OnlineOrder;
use Illuminate\Support\Arr;
use App\Mail\SuccessPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnoucementController extends Controller
{
    //
    public function AnnocuementView()
    {

        $data['annouce'] = Announce::all();
        if(Auth::user()->name != 'superadmin')
        {


            return view('admin.setting.list_annouce',$data);
        }else{




        // dd($data['newOrder']);

        // $order = OnlineOrder::where("online_order_token",'ojbQT')->first();
        // if($order->online_order_type == 'courierpayment'){

        //     echo 'test';
        // }elseif($order->online_order_type == 'orderpayment'){
        // if($order->online_order_type == 'courierpayment'){
        //     return redirect()->route('user.dashboard',$order->id)->with('success','Payment Success');
        // }elseif($order->online_order_type == 'orderpayment'){

        //     $onOrder = OnlineOrder::where("online_order_token",'ojbQT')->first();


        //     if($onOrder->online_order_mail == NULL && $onOrder->online_order_status == '1')
        //     {
        //             $details = [
        //             'order' => 'Order No : '.$onOrder->online_batch_code,
        //             'name' => 'Name : '.$onOrder->online_order_payer,
        //             'type' => 'Payment Type : '.$onOrder->online_order_type,
        //             'ref' => 'Transaction Ref : '.$onOrder->online_order_bank_code,
        //             'amount' => 'Amount : RM '.$onOrder->online_order_amount,
        //             'bank' => 'Bank : '.$onOrder->online_order_bank,
        //             'email' => 'Email : '.$onOrder->online_order_email,

        //             'date' => 'Date : '.Carbon::parse($onOrder->online_order_dateexec)->format('d-m-Y h:i:s A'),

        //             'url' => 'https://shoppyjapan.my/user',
        //             // 'url2' => 'https://shoppyjapan.my/admin',
        //             'admin' => 'https://shoppyjapan.my/admin',

        //         ];




                // $qemailstatus =  DB::table('users')
                // ->where('id', $order->online_user_id)
                // ->first();

                // $datanotify = json_decode($qemailstatus->user_notification);
                // if($datanotify->notification1 == '1')
                // { //start if active submit email

                // }

                // Mail::to('znntesting@gmail.com')->send(new SuccessPayment($details));

                // $details = [
                //     'order' => 'Order No : '.$onOrder->online_batch_code,
                //     'name' => 'Name : '.$onOrder->online_order_payer,
                //     'amount' => 'Amount : RM '.$onOrder->online_order_amount,
                //     'email' => 'Email : '.$onOrder->online_order_email,
                //     'admin' => 'https://shoppyjapan.my/admin',
                // ];

                // Mail::to('znntesting@gmail.com')->send(new NewOrderMail($details));

            //     $onOrder->online_order_mail = '1';
            //     $onOrder->save();
            //     return redirect()->back();
            // }
            // else{
            //     echo 'alreaddy send';
            // }


        // }else{
        //     return redirect()->back();
        // }
                    return view('admin.setting.list_annouce',$data);

        // }
        }
    }

    public function AnnocuementStore(Request $request)
    {
        // dd($request->all());
        $color = ['border-left-sj-red','border-left-sj-yellow','border-left-sj-green','border-left-sj-cyan','border-left-sj-blue','border-left-sj-violet'];
        $randomColor = Arr::random($color);

        $ann = new Announce();
        $ann->announce_type = $request->ann_type;
        $ann->announce_title =$request->ann_title;
        $ann->announce_description = $request->ann_desc;
        $ann->announce_color = $randomColor;
        $ann->announce_status = '1';
        $ann->admin_id = Auth::user()->id;

        $ann->save();

        $notifikasi = array(
            'message' => 'New anncoucement successfully inserted',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notifikasi);
    }


    public function AnnocuementUpdate(Request $request , $id)
    {

        $ann = Announce::find($id);
        $ann->announce_title = $request->ann_title;
        $ann->announce_type = $request->ann_type;
        $ann->announce_description = $request->ann_desc;
        $ann->announce_status = $request->ann_status;
        $ann->save();

        $notifikasi = [
            'message' => 'Anncoucement successfully updated',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notifikasi);
    }


    public function AnnocuementDelete(Request $request)
    {
        $ids = $request->select;

        $data = Announce::whereIn('id', $ids)->delete();

        return array('Data has been successfully deleted','success');

    }


    public function testing(){
        // $st = DB::table('orders')
        // ->select(DB::raw("(select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '1') as totalavailable, (select count(items.id) from items where items.item_order_id=orders.id and items.item_status_id = '0') as totalnotavailable"))
        // ->where('orders.id', '42')
        // ->toSql();

        // dd($st);
//        if(Auth::user()->name == 'superadmin')
//        {
//        $statusItem = Item::where('item_order_id','37')->whereIn('item_status_id', ['1','2'])->get();
//        // dd($statusItem);
//
//        $color = ['border-left-sj-red','border-left-sj-yellow','border-left-sj-green','border-left-sj-cyan','border-left-sj-blue','border-left-sj-violet'];
//        $random = Arr::random($color);
//
//        $refunds = Refund::with('items','users')->orderBy('refund_date', 'DESC')->get();
//
//        dd($refunds);
//        }
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();

		$ch = curl_init();
		$apptoken = hash('sha256',date('Y-m-d').$gwconf->gateway_conf_token);
		$data = array('amount'=>'amount_pay',
              'account'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');
        // set url
       	curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/request_secure_api.php?token=".hash('sha256',date('Y-m-d'))."");
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "".$gwconf->gateway_conf_token.":".$gwconf->gateway_conf_secret."");

		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_VERBOSE, true);
		//curl_setopt($ch, CURLOPT_STDERR, fopen('php://stderr', 'w'));
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);

		//echo $output;

		$data2 = preg_split("/:/",$output);

		// print_r($data2);
    }
}
