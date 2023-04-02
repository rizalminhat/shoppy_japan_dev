<?php

namespace App\Http\Controllers\User\Auth;
use Mail;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Mail\ActivateUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
		$liststate = DB::table('inf_state')
			->where('state_in', '<=', '16')
			->orderBy('state_name','ASC')
			->get();
		$liststate2 = DB::table('inf_state')
			->where('state_in', '<=', '16')
			->orderBy('state_name','ASC')
			->get();
		
        return view('user.auth.register', ['liststate'=>$liststate, 'liststate2'=>$liststate2]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
			'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
			'peraddress1' => 'required|string|max:255',
			
			
			'perpostcode' => 'required|string|max:25',
			'percity' => 'required|string|max:50',
			'perstate' => 'required|string|max:10',
			'percountry' => 'required|string|max:10',
			'mailaddress1' => 'required|string|max:255',
			
			'mailpostcode' => 'required|string|max:25',
			'mailcity' => 'required|string|max:50',
			'mailstate' => 'required|string|max:10',
			'mailcountry' => 'required|string|max:10',
            'password' => 'required|string|confirmed|min:8',
			
        ]);
		//dd($request->mailaddress1);
		//dd($request->peraddress1);
		$listusernoti = DB::table('notifications')
		->get();
		$starto = '';
		foreach($listusernoti as $listusernoti) 
			
		{
			$starto .= '"notification'.$listusernoti->notification_id.'": "1",';
			
		}
		$newstarto = substr($starto, 0, -1);
		$newstarto2 = '{'.$newstarto.'}';

        Auth::guard('user')->login($user = User::create([
            'name' => $request->name,
			'phone' => $request->phone,
            'address1' => $request->peraddress1,
			'address2' => $request->peraddress2,
			'address3' => $request->peraddress3,
			'postcode' => $request->perpostcode,
			'city' => $request->percity,
			'state' => $request->perstate,
			'country' => $request->percountry,
			'email' => $request->email,
            'password' => Hash::make($request->password),
			'tokken' => Str::random(32),
			'active' => '0',
			'user_announce' => '1',
			'user_notification' => $newstarto2,
        ])); 
		//dd($request->all());

        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'user.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        }); 
		
		/*$userinfo = DB::table('users')
			->where('email', $request->email)
			->first();*/
		$id = $user->id; 
		
		 $data = new Address();
		 //$currentdate = date("Ymdhis");
		 //$noorder = $currentdate.'-'.Auth::user()->id;
         $data->user_id = $id;
         $data->address1 = $request->mailaddress1;
		 $data->address2 = $request->mailaddress2;
		 $data->address3 = $request->mailaddress3;
		 $data->postcode = $request->mailpostcode;
		 $data->city = $request->mailcity;
		 $data->state = $request->mailstate;
		 $data->country = $request->mailcountry;
		 $data->status = 1;
		 $data->save();	
		//DB::insert("INSERT INTO addresses(user_id,status,address1) VALUES(?,?,?)",['5', '1',$request->mailaddress1]);

        event(new Registered($user));
		
		$getUser = DB::table('users')
			->where('id', $id)
			->first();

            $details = [
                'title' => 'User Email : '.$getUser->email,
                'url' => 'https://shoppyjapan.my/user/activateuser/'.$getUser->tokken,
                'phone' => 'Phone : '.$getUser->phone,
            ];

            Mail::to($getUser->email)->send(new ActivateUser($details));
		    Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

       // return redirect('/');
		
		
		
        //dd('hh');
        return redirect(route('user.activate'));
		 //return view('user.activate');
    }
	
	public function activate()
    {
        
		//return redirect()->route('user.neworder');
		//return view('user.order.neworder');
        //return redirect()->back()->with('status','Student Updated Successfully');
		return view('user.auth.verify-email2');
		
    }
	
	public function activateuser($id)
    {
		
		
		//dd('activate');
        //$item = Item::find($id);
		$activeexist = DB::table('users')
			->where('tokken', $id)
			->first();
		
		if(isset($activeexist))
		{
	DB::update('update users set  
	 active = ?,
	 tokken = ?,
	 updated_at = ?
	 where id = ?
	 ',[ '1','',NOW(), $activeexist->id]); 
			
		}
		//dd($activeexist);
		
		//$latestorderinfo = DB::table('orders')
		//	->where('user_id', Auth::user()->id)
		//	->where('status_id','0')
		//	->where('id',$item->item_order_id)
			//->first();
		//$configinfo = DB::table('configs')
		//	->where('id','1')
		//	->first();
		
        return view('user.auth.activate-email', ['activeexist'=>$activeexist]);
    }
	
	
}
