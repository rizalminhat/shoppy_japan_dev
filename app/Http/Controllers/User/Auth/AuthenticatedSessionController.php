<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.auth.login');
    }
    
    public function loginOrder(Request $request)
    {

        $url =  $request->url;
        $price = $request->price;


        return view('user.auth.login', compact('url','price'));
    }
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\User\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $request->session()->put('type','user');

        $username = Auth::guard('user')->user()->name;
        $request->session()->put('name',$username);
        if(isset($request->order_url))
        {
            $request->session()->put('order_url', $request->order_url);
            $request->session()->put('order_price', $request->order_price);
            

            return redirect(route('user.neworder'));
        }else{
            // dd(session()->all());
            return redirect(route('user.dashboard'));
            
        }
        

      
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
