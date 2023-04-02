<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Mail\ActivateUser;
use Mail;
class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data['buyers'] = User::has('buyer')->get(); 
        

        return view('admin.buyer.list_buyer', $data);
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
    public function show($id)
    {
        //

        // \DB::connection()->enableQueryLog();
        $data['user'] = DB::table('users')
        ->select('*')
        ->join('inf_state', 'users.state', '=', 'inf_state.state_in')
        ->where('users.id',$id)
        ->first();

        $data['orders'] = DB::table('orders')
        ->select('*','orders.id AS order_id', DB::raw('SUM(items.item_total) AS sum_item_total'))
        ->join('order_status','orders.status_id','=', 'order_status.id')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('orders.user_id', $id)
        ->where('items.item_status_id', '!=','0')
        ->groupBy('items.item_order_id')
        ->orderBy('orders.submit_at', 'DESC')
        ->get();

        
        $data['refunds'] = Refund::whereHas('items', function($q) use ($id)
        {
            $q->where('item_user_id', $id);
        })->with('items')->get();
        
        // dd($data['refunds']);

        return view('admin.buyer.profile_buyer', $data);
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

    public function UserView()
    {

        $users = User::all();
        return view('admin.buyer.list_user', compact('users'));
    }


    public function resendActivateEmail($id)
    {
        $user = User::find($id);

        $user->tokken = Str::random(32);
        $user->active = 0;
        $user->save();

        $details = [
            'title' => 'User Email : '.$user->email,
            'url' => 'https://shoppyjapan.my/user/activateuser/'.$user->tokken,
            'phone' => 'Phone : '.$user->phone,
        ];

        
        Mail::to($user->email)->send(new ActivateUser($details));

        if (Mail::failures()) {
            // return response showing failed emails
            $notifikasi = array(
                'message' => 'Activate user email unsuccessfully resend',
                'alert-type' => 'error',
            );
        }else{
            $notifikasi = array(
                'message' => 'Activate user email successfully resend',
                'alert-type' => 'success',
            );
        }
        
        return back()->with($notifikasi);
    }
}
