<?php

namespace App\Http\Controllers\User\ZPay;

use App\Models\OnlineOrder;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;
use App\Models\Wallet;
use App\Models\WalletOut;
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

use Mail;
use App\Mail\SuccessPayment;
use App\Mail\NewOrderMail;

//namespace App\Http\Controllers\User;

//use App\Http\Controllers\Controller;

class ZPayController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function index(){
		
    }
	
	public function sjpayrequest($request){
		
		//print_r($request->all());die();
		
		$ewallet = DB::select("SELECT 
			(IFNULL((SELECT SUM(wallet_in_amount) FROM sj_wallet_in WHERE wallet_in_user_id = ?),0) - IFNULL((SELECT SUM(wallet_out_amount) FROM sj_wallet_out WHERE wallet_out_user_id = ?),0)) as wall_balance",[Auth::user()->id,Auth::user()->id]);
		
		if($ewallet[0]->wall_balance >= $request->input('amount_pay')){
						
			if($request->input('type') == 'orderpayment'){
				
				
				WalletOut::updateOrInsert(
					['wallet_out_refcode' => $request->input('batch_code'), 'wallet_out_type' => $request->input('type')],
					[
						'wallet_out_user_id' => $request->input('user_id'),
						'wallet_out_amount' => $request->input('amount_pay'),
						'wallet_out_date' => date('Y-m-d H:i:s'),
						'wallet_out_created' => date('Y-m-d H:i:s'),
						'wallet_out_createdby' => Auth::user()->id,
						'wallet_out_status' => 1,
						'wallet_out_desc' => $request->input('desc'),
						'wallet_out_payment_reference' => $request->input('ref')
					]);
				
				DB::table("orderaddress")->updateOrInsert([
					"order_id" => $request->input('order_id'),
				],[
					"user_id" => $request->input('user_id'),
					"address1" => strtoupper($request->input('address1')),
					"address2" => strtoupper($request->input('address2')),
					"address3" => strtoupper($request->input('address3')),
					"postcode" => strtoupper($request->input('postcode')),
					"city" => strtoupper($request->input('city')),
					"state" => $request->input('state'),
					"country" => $request->input('country'),
					"created_at" => date('Y-m-d H:i:s')
				]);
				
				
				
				Order::updateOrInsert(
						['order_no' => $request->input('batch_code')],
						[
						 'status_id' => 1,
						 'submit_at' => NOW(),
							'order_pay_type' => 'zwallet',
						 'submit_user_id' => $request->input('user_id')	
						]);
				
				$qemailstatus =  DB::table('users')
						->where('id', $request->input('user_id'))
						->first();
						//$onOrder = OnlineOrder::where("online_order_token",$request->input('trans_code'))->first();

				//if($onOrder->online_order_mail == NULL && $onOrder->online_order_status == '1')
				//	{
							$details = [
							'order' => 'Order No : '.$request->input('batch_code'),
							'name' => 'Name : '.$qemailstatus->name,
							'type' => 'Payment Type : Shoppy Japan Pay (SJPay)',
							'ref' => 'Transaction Ref : '.$request->input('ref'),
							'amount' => 'Amount : RM '.$request->input('amount_pay'),
							'bank' => '',
							'email' => 'Email : '.$qemailstatus->email,
		
							'date' => 'Date : '.Carbon::parse(date('Y-m-d H:i:s'))->format('d-m-Y h:i:s A'),
		
							'url' => 'https://shoppyjapan.my/user',
							// 'url2' => 'https://shoppyjapan.my/admin',
							'admin' => 'https://shoppyjapan.my/admin',

						];
		
						$datanotify = json_decode($qemailstatus->user_notification);
						if($datanotify->notification1 == '1')
						{ //start if active submit email
							Mail::to($qemailstatus->email)->send(new SuccessPayment($details));

						}  

						
						$details2 = [
							'order' => 'Order No : '.$request->input('batch_code'),
							'name' => 'Name : '.$qemailstatus->name,
							'amount' => 'Amount : RM '.$request->input('amount_pay'),
							'email' => 'Email : '.$qemailstatus->email,		
							'admin' => 'https://shoppyjapan.my/admin',
						];
						Mail::to('shoppyjapan.noreply@gmail.com')->send(new NewOrderMail($details2));

				//		$onOrder->online_order_mail = '1';
				//		$onOrder->save();
				//	}
				
				
			}elseif($request->input('type') == 'courierpayment'){
				WalletOut::updateOrInsert(
					['wallet_out_refcode' => $request->input('batch_code'), 'wallet_out_type' => $request->input('type')],
					[
						'wallet_out_user_id' => $request->input('user_id'),
						'wallet_out_amount' => $request->input('amount_pay'),
						'wallet_out_date' => date('Y-m-d H:i:s'),
						'wallet_out_created' => date('Y-m-d H:i:s'),
						'wallet_out_createdby' => Auth::user()->id,
						'wallet_out_status' => 1,
						'wallet_out_desc' => $request->input('desc'),
						'wallet_out_payment_reference' => $request->input('ref')
					]);
				Order::updateOrInsert(
						['order_no' => $request->input('batch_code')],
						[
						 'shipping_payment_status' => 2,
						'shipping_pay_type' => 'zwallet',
						 'shipping_payment_date' => date('Y-m-d H:i:s')
						]);
			}
			if($request->input('type') == 'orderpayment'){
				return redirect()->route('user.dashboard')->with('success','SJPAY Method Payment Success');
			}else{
				return redirect()->route('user.dashboard')->with('success','SJPAY Method Payment Success');
			}
		}else{
			if($request->input('type') == 'orderpayment'){
				return redirect()->route('user.paymentorder',['id'=>$request->input('order_id')])->with('failed','SJPAY Method Payment Failed');
			}elseif($request->input('type') == 'courierpayment'){
				return redirect()->route('user.currentorder',$request->input('order_id'))->with('failed','Payment Failed');
			}
		}		
	}
	
	public function request($request){
		//use Auth;
		//print('<pre>');print_r($request->all());print('</pre>');die();
		//print('<pre>');print_r($request->all());print('</pre>');die();
		
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();
		if(Auth::check()){
			$users = Auth::user();	
			$inname = $users->name;
			$inmail = $users->email;
			$uid =  $users->id;
		}else{
			$inname = $request->input('trans_user');
			$inmail = $request->input('trans_email');
			$uid =  null;
		}
		if(null !== $request->input('bank_pay')){
			$banker = $request->input('bank_pay');
		}else{
			$banker = '';
		}
		        
		if(null !== $request->input('ref')){
			$refe = $request->input('ref');
		}else{
			$refe = $request->input('type').date('YmdHis').'-'.$uid;
		}
		
		if(null !== $request->input('batch_code')){
			$batch = $request->input('batch_code');
		}else{
			$batch = '';
		}
		
		if($request->input('type') == 'orderpayment'){
			DB::table("orderaddress")->updateOrInsert([
				"order_id" => $request->input('order_id'),
			],[
				"user_id" => $request->input('user_id'),
				"address1" => strtoupper($request->input('address1')),
				"address2" => strtoupper($request->input('address2')),
				"address3" => strtoupper($request->input('address3')),
				"postcode" => strtoupper($request->input('postcode')),
				"city" => strtoupper($request->input('city')),
				"state" => $request->input('state'),
				"country" => $request->input('country'),
				"created_at" => date('Y-m-d H:i:s')
			]);
		}
		
		
		//if(isset($request->input('mail')))
		 //  {
			  if($request->input('mail') == '999') 
			  {
				 DB::insert("INSERT INTO addresses(user_id, status, address1, address2, address3, postcode, city, state, country, created_at, updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?)",[$request->input('user_id'), '1',strtoupper($request->input('address1')), strtoupper($request->input('address2')), strtoupper($request->input('address3')), strtoupper($request->input('postcode')), strtoupper($request->input('city')), $request->input('state'), $request->input('country'), NOW(), NOW() ]); 
			  }
			  else
			  {
				  
			  }
			   
		  // }
		
		//$user_name = Auth::user()->name;
		
		/*$ch = curl_init();

		// set url
		curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/request_secure_api.php?token=".hash('sha256',date('Y-m-d'))."");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		curl_setopt($ch, CURLOPT_USERPWD, "8b3dd38a47ef09b6c49c7f07e56491f9d02ae2171894b0b68ba5adb137c3a874:TbXYirnVQ7JYoxJEqcEJAX9iqd2Ro9drfH0n");

		$data = array('amount'=>$request->input('amount_pay'),
              'code'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);     

		//echo $output;		
		$data = preg_split("/:/",$output);*/

		
		
		$ch = curl_init();
		$apptoken = hash('sha256',date('Y-m-d').$gwconf->gateway_conf_token);
		$data = array('amount'=>$request->input('amount_pay'),
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
		
		$data = preg_split("/:/",$output);
		
		//print_r($data);
		$inputer = array(
			"online_order_reference" => $refe,
			"online_order_type" => $request->input('type'),
			"online_order_ssl" => $data[2],
			"online_order_token" => $data[1],
			"online_order_trans_code" => $data[0],
			"online_order_bank_code" => $banker,
			"online_order_payer" => $inname,
			"online_order_desc" => $request->input('desc'),
			"online_order_email" => $inmail,
			"online_order_amount" => $request->input('amount_pay'),
			"online_order_status"=> "0",
			"online_user_id"=> $uid,
			"online_order_created"=> date('Y-m-d H:i:s'),
			"online_batch_code"=>$batch
		);
		
		OnlineOrder::create($inputer);
		
		$ttype = 'hidden';
		//$ttype = 'text';
		print('<form id="zpayform" method="post" action="https://fpx.zpay.my/indirect_payment.php?ssl='.$data[2].'&token='.$data[1].'">
			<input type="'.$ttype.'" name="trans_code" value="'.$data[0].'">
			<input type="'.$ttype.'" name="trans_bank" value="'.$banker.'">
			<input type="'.$ttype.'" name="trans_user" value="'.$inname.'">
			<input type="'.$ttype.'" name="trans_desc" value="openpay_'.$request->input('type').'">
			<input type="'.$ttype.'" name="trans_email" value="'.$inmail.'">
			</form><script>document.getElementById(\'zpayform\').submit();</script>');
		
		
		
		//$query = $conn->query("INSERT INTO online_order (online_order_reference, online_order_type, online_order_ssl, online_order_token, online_order_trans_code, online_order_bank_code, online_order_payer, online_order_desc, online_order_email, online_order_amount, online_order_status) VALUES ('".$_POST['order_code']."', '".$_POST['type']."', '".$data[2]."', '".$data[1]."', '".$data[0]."', '".$_POST['bankpay']."', '".$_POST['stname']."', '".$_POST['item']."', '".$_POST['st_email']."', '".$_POST['totalprice']."', 1)") or die(mysqli_error( $conn));
		
		//print_r($request->all());
    }
	
	public function retrieval(Request $request){
		//print_r($request->all());
		
		$ch = curl_init();
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();
		curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/status_api_secure.php?token=".hash('sha256',date('Y-m-d'))."");
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "".$gwconf->gateway_conf_token.":".$gwconf->gateway_conf_secret."");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"account=".$gwconf->gateway_conf_user."&trans_code=".$request->input('trans_code')."&type=status");
		//'account'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);     

		$trandata = json_decode($output,true);
		//print('<pre>');print_r($trandata);print('</pre>');
		//echo "sdfsdfsdf";
		
		$inorder = OnlineOrder::where("online_order_token",$request->input('trans_code'))->first();
		if($inorder->online_order_type == 'topup'){
			$norder = OnlineOrder::where("online_order_token",$request->input('trans_code'))->first();
			//print('<pre>');print_r($trandata);print('</pre>');
			if($request->input('trans_status') == 'success'){
				OnlineOrder::updateOrInsert(
					['online_order_id' => $norder->online_order_id],
					[
					'online_order_status' => 1,
					'online_order_bank_code' => $trandata['trans_status_trid'],
					'online_order_status_name' => $trandata['trans_status'],
					'online_order_bank' => $trandata['trans_status_bank'],
					'online_order_dateexec' => $trandata['trans_status_datetime'],
					'online_order_status_code' => $trandata['trans_status_code']
					]);
				Wallet::updateOrInsert(
					['wallet_in_refcode' => $trandata['trans_status_trid']],
					[
						'wallet_in_user_id' => $norder->online_user_id,
						'wallet_in_type' => 'IN',
						'wallet_in_amount' => $norder->online_order_amount,//$trandata['trans_status_amount'],
						'wallet_in_date' => $trandata['trans_status_datetime'],
						'wallet_in_created' => date('Y-m-d H:i:s'),
						'wallet_in_createdby' => Auth::user()->id,
						'wallet_in_status' => 1
					]);
				if($request->has('process_type') && $request->input('process_type') == 'admin'){
					return redirect()->route('admin.attempt_transaction');
				}else{
					return redirect()->route('user.dashboard')->with('success','Topup Success');
				}
			}else{
				OnlineOrder::updateOrInsert(
					['online_order_id' => $norder->online_order_id],
					[
					'online_order_status' => 0,
					'online_order_bank_code' => $trandata['trans_status_trid'],
					'online_order_status_name' => $trandata['trans_status'],
					'online_order_bank' => $trandata['trans_status_bank'],
					'online_order_dateexec' => $trandata['trans_status_datetime'],
					'online_order_status_code' => $trandata['trans_status_code']
					]);
				if($request->has('process_type') && $request->input('process_type') == 'admin'){
					return redirect()->route('admin.attempt_transaction');
				}else{
					return redirect()->route('user.dashboard')->with('failed','Topup Failed');
				}
			}
			
		}else{
			if($request->input('trans_status') == 'success'){
				$order = OnlineOrder::where("online_order_token",$request->input('trans_code'))->first();
					//print_r($order);
				OnlineOrder::updateOrInsert(
						['online_order_id' => $order->online_order_id],
						[
						'online_order_status' => 1,
						'online_order_bank_code' => $trandata['trans_status_trid'],
						'online_order_status_name' => $trandata['trans_status'],
						'online_order_bank' => $trandata['trans_status_bank'],
						'online_order_dateexec' => $trandata['trans_status_datetime'],
						'online_order_status_code' => $trandata['trans_status_code']
						]);
						
				if($order->online_order_type == 'courierpayment'){
					Order::updateOrInsert(
						['order_no' => $order->online_batch_code],
						[
						 'shipping_payment_status' => 2,
						'shipping_pay_type' => 'zpay',
						 'shipping_payment_date' => date('Y-m-d H:i:s')
						]);
				}else{

					Order::updateOrInsert(
						['order_no' => $order->online_batch_code],
						[
						 'status_id' => 1,
						 'submit_at' => NOW(),
						 'order_pay_type' => 'zpay',
						 'submit_user_id' => $order->online_user_id		
						]);

						$onOrder = OnlineOrder::where("online_order_token",$request->input('trans_code'))->first();

						if($onOrder->online_order_mail == NULL && $onOrder->online_order_status == '1')
					{
							$details = [
							'order' => 'Order No : '.$onOrder->online_batch_code,
							'name' => 'Name : '.$onOrder->online_order_payer,
							'type' => 'Payment Type : '.$onOrder->online_order_type,
							'ref' => 'Transaction Ref : '.$onOrder->online_order_bank_code,
							'amount' => 'Amount : RM '.$onOrder->online_order_amount,
							'bank' => 'Bank : '.$onOrder->online_order_bank,
							'email' => 'Email : '.$onOrder->online_order_email,
		
							'date' => 'Date : '.Carbon::parse($onOrder->online_order_dateexec)->format('d-m-Y h:i:s A'),
		
							'url' => 'https://shoppyjapan.my/user',
							// 'url2' => 'https://shoppyjapan.my/admin',
							'admin' => 'https://shoppyjapan.my/admin',

						];
		
		
					
						$qemailstatus =  DB::table('users')
						->where('id', $order->online_user_id)
						->first();
		
						$datanotify = json_decode($qemailstatus->user_notification);
						if($datanotify->notification1 == '1')
						{ //start if active submit email
							Mail::to($onOrder->online_order_email)->send(new SuccessPayment($details));

						}  

						
						$details2 = [
							'order' => 'Order No : '.$onOrder->online_batch_code,
							'name' => 'Name : '.$onOrder->online_order_payer,
							'amount' => 'Amount : RM '.$onOrder->online_order_amount,
							'email' => 'Email : '.$onOrder->online_order_email,		
							'admin' => 'https://shoppyjapan.my/admin',
						];
						Mail::to('shoppyjapan.noreply@gmail.com')->send(new NewOrderMail($details2));

						$onOrder->online_order_mail = '1';
						$onOrder->save();
					}
				}

					//$order->online_order_status = 1;
					//$order->online_order_bank_code = $request->input('trans_status_trid');
					//$order->online_order_status_name = $request->input('trans_status');
					//$order->save();
					//return redirect()->route('dashboard.member')->with('success',$tie.' Berjaya');
					//print_r($request->all());
					//print_r($order);

				if($request->has('process_type') && $request->input('process_type') == 'admin'){
					return redirect()->route('admin.attempt_transaction');
				}else{
					if($order->online_order_type == 'courierpayment'){
						return redirect()->route('user.dashboard',$order->id)->with('success','Payment Success');
					}else{
						return redirect()->route('user.dashboard',$order->id)->with('success','Payment Success');
					}
				}

			}elseif($request->input('trans_status') == 'cancel'){
				$order = OnlineOrder::join('orders','online_batch_code','order_no')->where("online_order_token",$request->input('trans_code'))->first();
				//return redirect()->route('user.paymentorder',$order->id)->with('failed','Payment Failed');
				if($order->online_order_type == 'courierpayment'){
					return redirect()->route('user.currentorder',$order->id)->with('failed','Payment Failed');
				}else{
					return redirect()->route('user.paymentorder',$order->id)->with('failed','Payment Failed');	
				}
			}else{
				$order = OnlineOrder::join('orders','online_batch_code','order_no')->where("online_order_token",$request->input('trans_code'))->first();
				OnlineOrder::updateOrInsert(
						['online_order_id' => $order->online_order_id],
						[
						'online_order_status' => 0,
						'online_order_bank_code' => $trandata['trans_status_trid'],
						'online_order_status_name' => $trandata['trans_status'],
						'online_order_bank' => $trandata['trans_status_bank'],
						'online_order_dateexec' => $trandata['trans_status_datetime'],
						'online_order_status_code' => $trandata['trans_status_code']
						]);
				if($request->has('process_type') && $request->input('process_type') == 'admin'){
					//print('<pre>');print_r($order);print('</pre>');//die();
					
					return redirect()->route('admin.attempt_transaction');
						//->with('failed','Payment Failed');
				}else{
					if($order->online_order_type == 'courierpayment'){
						return redirect()->route('user.currentorder',$order->id)->with('failed','Payment Failed');
					}else{
						return redirect()->route('user.paymentorder',$order->id)->with('failed','Payment Failed');	
					}	
				}
				
				//return redirect()->route('user.paymentorder',$order->id)->with('failed','Payment Failed');
			}
		}
	}
	
	public function topup(){
		$ch = curl_init();
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();
		curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/request_secure_api.php?token=".hash('sha256',date('Y-m-d'))."");
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "".$gwconf->gateway_conf_token.":".$gwconf->gateway_conf_secret."");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"account=".$gwconf->gateway_conf_user."&type=banklist");
		//'account'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);     

		$bankdata = preg_split("/,/",$output);
		
		$walletin = Wallet::select('wallet_in_refcode as reference', 'wallet_in_type as type', 'wallet_in_amount as amount', 'wallet_in_date as date')->where('wallet_in_user_id',Auth::user()->id)->get(); 
		
		$walletout = WalletOut::select('wallet_out_refcode as reference', 'wallet_out_type as type', 'wallet_out_amount as amount', 'wallet_out_date as date')->where('wallet_out_user_id',Auth::user()->id)->get(); 
		
		//$walletall = $walletin->merge($walletout);
		$tempCollection = collect([$walletin, $walletout]);
		//combined collection 
		$walletall = $tempCollection->flatten(1)
					  ->sortBy(function ($item) {
    return strtotime($item->date);
});
		return view('user.order.zpayorder',compact('bankdata','walletall'));
	}
	
	public function topuprequest(Request $request){
		$this->request($request);
	}
	
	
	public function requeryZpay(Request $request)
	{
		$ch = curl_init();
		$gwconf = DB::table('gateway_conf')->where('gateway_conf_status',1)->first();
		curl_setopt($ch, CURLOPT_URL, "https://fpx.zpay.my/status_api_secure.php?token=".hash('sha256',date('Y-m-d'))."");
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "".$gwconf->gateway_conf_token.":".$gwconf->gateway_conf_secret."");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
		"account=".$gwconf->gateway_conf_user."&trans_code=".$request->trans_code."&type=status");
		//'account'=>$gwconf->gateway_conf_user,'hashtoken'=>$apptoken,'item'=>'ShoppyJapan Payment');
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);     

		$trandata = json_decode($output,true);
		
		//orderpay
		
		$order = OnlineOrder::join('orders','online_batch_code','order_no')->where("online_order_token",$request->trans_code)->first();
		
		OnlineOrder::updateOrInsert(
		['online_order_id' => $order->online_order_id],
		[
			'online_order_status' => 1,
			'online_order_bank_code' => $trandata['trans_status_trid'],
			'online_order_status_name' => $trandata['trans_status'],
			'online_order_bank' => $trandata['trans_status_bank'],
			'online_order_dateexec' => $trandata['trans_status_datetime'],
			'online_order_status_code' => $trandata['trans_status_code'],
		]);
		
		if($order->online_order_type == 'courierpayment')
		{
			$try = Order::updateOrInsert(
				['order_no' => $order->online_batch_code],
				[
				'shipping_payment_status' => 2,
				'shipping_pay_type' => 'zpay',
				'shipping_payment_date' => $order->online_order_created,
				]);
		}
		
		if($try)
		{
			return 'success';
		}
		//courierpay
	}
}
