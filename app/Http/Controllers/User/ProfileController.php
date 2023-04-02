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

class ProfileController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function index(){
		$userinfo = DB::table('users')
			->leftJoin('inf_state', 'inf_state.state_in', '=', 'users.state')
			->leftJoin('inf_countries', 'inf_countries.country_id', '=', 'users.country')
			->where('id', Auth::user()->id)
			->first();
		$liststate = DB::table('inf_state')
			->where('state_in', '<=', '16')
			->orderBy('state_name','ASC')
			->get();
		$listcountry = DB::table('inf_countries')
			->where('country_id',  '132')
			->orderBy('country_name','ASC')
			->get();
		$liststate2 = DB::table('inf_state')
			->where('state_in', '<=', '16')
			->orderBy('state_name','ASC')
			->get();
		$listcountry2 = DB::table('inf_countries')
			->where('country_id',  '132')
			->orderBy('country_name','ASC')
			->get();
		$mailingaddress = DB::table('addresses')
			->join('inf_state','inf_state.state_in','addresses.state')
			->join('inf_countries','inf_countries.country_id','addresses.country')
			->where('user_id', Auth::user()->id)
			->where('status','1')
			
			->first();
		
        return view('user.profile',['userinfo'=>$userinfo, 'liststate'=>$liststate, 'listcountry'=>$listcountry, 'mailingaddress'=>$mailingaddress, 'liststate2'=>$liststate2, 'listcountry2'=>$listcountry2]);
    }
	
	public function updateprofile(Request $request)
    {
         $id = $request->input('user_id');
		 DB::update('update users set  
	 name = ?,
	 phone = ?,
	 address1= ?,
	 address2= ?,
	 address3= ?,
	 postcode= ?,
	 city= ?,
	 state= ?,
	 country= ?
	 where id = ?',[ strtoupper($request->input('name')), $request->input('phone'), $request->input('address1'), $request->input('address2'), $request->input('address3'), $request->input('postcode'), $request->input('city'), $request->input('state'), $request->input('country'),$id]);	
		
		if(!empty($request->input('mailing_id')))
		{
			
			DB::update('update addresses set  
	 address1 = ?,
	 address2 = ?,
	 address3= ?,
	 postcode= ?,
	 city= ?,
	 state= ?,
	 country= ?
	 where id = ?',[ strtoupper($request->input('mailaddress1')), $request->input('mailaddress2'), $request->input('mailaddress3'), $request->input('mailpostcode'), $request->input('mailcity'), $request->input('mailstate'), $request->input('mailcountry'),$request->input('mailing_id')]);
	
			
		}
		else
		{
			
			
		}
		
		
        //$item->item_url = $request->input('url_address');
       /* $item->item_yenprice = $request->input('price');
        //$item->item_rmprice = $request->input('myprice');
        $item->item_quantity = $request->input('quantity');
		$item->item_currency = $request->input('item_currency');
        $item->item_services = $request->input('services');
		
		$item->item_subtotal_item = $subtotalitem;
		$item->item_total = $request->input('total');*/
		 //$data->item_total = $request->total;
		
		//$item->item_subtotal_services = $request->input('subtotalservise');
		//$item->item_subtotal = $request->input('totalrm');
		//$item->item_total = $request->input('total');
		
		
        //$item->update();
		return redirect()->route('user.profile');
		//return view('user.order.neworder');
        //return redirect()->back()->with('status','Student Updated Successfully');
    }
	
	public function changepwd(){
		$userinfo = DB::table('users')
			->leftJoin('inf_state', 'inf_state.state_in', '=', 'users.state')
			->leftJoin('inf_countries', 'inf_countries.country_id', '=', 'users.country')
			->where('id', Auth::user()->id)
			->first();
		//dd($request->input('password'));
	/*	$varoldpassword = $request->input('password');
		$userexist = DB::table('users')
			         ->where('id', Auth::user()->id)
			         ->first();	
		if (Hash::check($varoldpassword, $userexist->password)) {
			
			    $password = $request->input('basic-default-password');
				$hashedPassword = Hash::make($password);
				DB::update('update users set  
	            password = ?,
				updated_at =?
	            where id = ?',[ $hashedPassword, NOW(), $userexist->id]);
			 return back()->with('successchangepasswordadminuse','New Password '.$userexist->name.' Successfully Updated!!!');
			
		}  */
		
		
		
        return view('user.changepwd',['userinfo'=>$userinfo]);
    }
	public function updatepwd(Request $request){
		
		$request->validate([
    'password' => 'required|confirmed|min:8'
]);  
		//dd($rules);
		
		
		$userinfo = DB::table('users')
			->leftJoin('inf_state', 'inf_state.state_in', '=', 'users.state')
			->leftJoin('inf_countries', 'inf_countries.country_id', '=', 'users.country')
			->where('id', $request->input('user_id'))
			->first();
		//dd($request->input('password'));
		$varoldpassword = $request->input('account-old-password');
		$userexist = DB::table('users')
			         ->where('id', $request->input('user_id'))
			         ->first();	
		if (Hash::check($varoldpassword, $userexist->password)) {
			
			    $password = $request->input('password');
				$hashedPassword = Hash::make($password);
				DB::update('update users set  
	            password = ?,
				updated_at =?
	            where id = ?',[ $hashedPassword, NOW(), $userexist->id]);
			 return back()->with('successchangepasswordadminuse','New Password '.$userexist->name.' Successfully Updated!!!');
			
		}
		else
		{
			 return back()->with('unsuccesschangepassword','Invalid Current Password. Please Try Again!!!');
			
		}
		
		
		
        //return view('user.changepwd',['userinfo'=>$userinfo]);
    }
	
	
	public function emailnotify(){
		$listnotify = DB::table('notifications')
			
			->get();
		$listnotify2 = DB::table('notifications')
			
			->get(); 
		
		$user = User::find(Auth::user()->id);
		
		//dd($request->input('password'));
	/*	$varoldpassword = $request->input('password');
		$userexist = DB::table('users')
			         ->where('id', Auth::user()->id)
			         ->first();	
		if (Hash::check($varoldpassword, $userexist->password)) {
			
			    $password = $request->input('basic-default-password');
				$hashedPassword = Hash::make($password);
				DB::update('update users set  
	            password = ?,
				updated_at =?
	            where id = ?',[ $hashedPassword, NOW(), $userexist->id]);
			 return back()->with('successchangepasswordadminuse','New Password '.$userexist->name.' Successfully Updated!!!');
			
		}  */
		
		
		
        return view('user.emailnotify',['listnotify'=>$listnotify,'listnotify2'=>$listnotify2,'user'=>$user ]);
    }
	
	public function StatusNotify(Request $request)
	{
		// dd($request->all());
		//dd($request->id);

		$user = User::find(Auth::user()->id);
		
		$listnotify = DB::table('notifications')
			->where('notification_id', $request->id)
			
			->first();

		if($request->status == 'active')
		{
			//$datanotify = json_decode($user->user_notification);
			//dd($datanotify );
			
		$idnotifi = 'notification'.$request->id;	
		DB::table('users')
        ->where('id', Auth::user()->id)
        ->update(['user_notification->'.$idnotifi.'' =>'1']);
			
			//$user->user_announce = '1';
			$st = 'On';

			//$user->save();

			return array('Email Notification '.$listnotify->notification_name.' '.$st, 'success');
		}else{
			//$user->user_announce = '0';
			$st = 'Off';
		$idnotifi = 'notification'.$request->id;	
		DB::table('users')
        ->where('id', Auth::user()->id)
        ->update(['user_notification->'.$idnotifi.'' =>'0']);

			//$user->save();

			return array('Email Notification '.$listnotify->notification_name.' '.$st, 'error');
		}

		
	}
	
	public function viewProfileImg()
	{
		$data['user'] = User::findOrFail(Auth::user()->id);
		// dd($data);
		return view('user.image', $data);
	}

	public function updateProfileImg(Request $request)
	{
		// dd($request->all());

		$validate = $request->validate([
            'userImage' => 'mimes:jpg,png,jpeg,pdf|max:2000|required',
        ]);

		$data = User::find(Auth::user()->id);
        // // $data->user_image =

        if($request->file('userImage')){
            $file = $request->file('userImage');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            \Storage::delete('public/upload/user_image/'.$data->user_image);

            $filename =uniqid().'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $file->storeAs('public/upload/user_image/', $filename);
            $data->user_image = $filename;

        }

        $data->save();

        $notifikasi = array(
            'message' => 'Profile Image successfully updated',
            'alert-type' => 'success'
        );
        return redirect()->route('user.profile')->with($notifikasi);
	}
	
	public function OthersSetting()
	{
		$user = User::find(Auth::user()->id);
		

		return view('user.other_setting', compact('user'));
	}

	public function StatusAnnouncement(Request $request)
	{
		// dd($request->all());

		$user = User::find(Auth::user()->id);

		if($request->status == 'active')
		{
			$user->user_announce = '1';
			$st = 'On';

			$user->save();

			return array('Announcement '.$st, 'success');
		}else{
			$user->user_announce = '0';
			$st = 'Off';

			$user->save();

			return array('Announcement '.$st, 'error');
		}

		
	}
	
}
