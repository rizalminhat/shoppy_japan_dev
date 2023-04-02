<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {

        // dd($request->all());
        return view('admin.auth.login');
    }


    // public function getUrl(Request $request)
    // {
    //     // dd($request->all());
    //     // Session::set('url', $request->url);
    //     $data = $request->url;

    //     // dd($data);
    //     return view('admin.auth.login', compact('data'));
    // }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Admin\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $request->session()->put('url', $request->url);
         $request->session()->put('type','admin');
        // dd($request->all());

        return redirect(route('admin.dashboard'));

        // return redirect(route('admin.layouts.main'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
