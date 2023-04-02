<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class ProfileController extends Controller
{
    //
	
	public function viewChangePwd()
	{
		return view('admin.change_pwd');
	}
	
	public function updateChangePwd(Request $request)
	{
		$validate = $request->validate(
			[
				'newPwd' => 'required|min:8',
				'confirmPwd' => 'required|min:8',
			],
			[
				'newPwd.required' => 'The new password must be at least 8 characters.',
			]
		);

		$admin = Auth::guard('admin')->user();

		if (Hash::check($request->currPwd, $admin->password)) {
			if($request->newPwd == $request->confirmPwd)
			{
				$hashpwd = Hash::make($request->confirmPwd);
				$upAdmin = Admin::where('id', $admin->id)->update([
					'password' => $hashpwd,
				]);
				
				if($upAdmin)
				{
					Auth::guard('admin')->logout();

					$request->session()->invalidate();

					$request->session()->regenerateToken();

					return redirect('/');
				}else{
						$notifikasi = array(
						'message' => 'Please check your password again',
						'alert-type' => 'warning',
					);
					return back()->with($notifikasi);
				}
			}else{
				$notifikasi = array(
					'message' => 'Please check your password again',
					'alert-type' => 'warning',
				);
				return back()->with($notifikasi);
			}
			
		}else{
			$notifikasi = array(
				'message' => 'Please check your old current password',
				'alert-type' => 'warning',
			);
			return back()->with($notifikasi);
		}
		// dd($admin->password);
	}
}
