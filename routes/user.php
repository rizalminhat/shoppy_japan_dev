<?php

use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\TrackingController;
use App\Http\Controllers\User\CompletedController; 
use App\Http\Controllers\User\ZPay\ZPayController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->name('user.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:user');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:user')
        ->name('dashboard');
	
	 Route::get('/profile', [ProfileController::class, 'index'])
        ->middleware('auth:user')
        ->name('profile');
	 Route::get('/changepwd', [ProfileController::class, 'changepwd'])
        ->middleware('auth:user')
        ->name('changepwd');
	Route::get('/emailnotify', [ProfileController::class, 'emailnotify'])
        ->middleware('auth:user')
        ->name('emailnotify');
	Route::post('/status-notify', [ProfileController::class, 'StatusNotify'])->middleware('auth:user')->name('status.notify');
	Route::post('/updateprofile', [ProfileController::class, 'updateprofile'])->name('updateprofile');
	
	Route::post('/updatepwd', [ProfileController::class, 'updatepwd'])->name('updatepwd');
	
	Route::get('/profile_image', [ProfileController::class, 'viewProfileImg'])
		->middleware('auth:user')
		->name('viewprofileimg');
	Route::post('/update_img', [ProfileController::class, 'updateProfileImg'])
		->middleware('auth:user')
		->name('updateprofileimg');

	Route::get('/others', [ProfileController::class, 'OthersSetting'])->middleware('auth:user')->name('annouce.setting');
	Route::post('/status-annouce', [ProfileController::class, 'StatusAnnouncement'])->middleware('auth:user')->name('status.annouce');

	Route::prefix('order')->middleware('auth:user')->group(function () {
		Route::get('/currentorder', [OrderController::class, 'index'])
        ->name('currentorder');
	
		Route::get('/neworder', [OrderController::class, 'neworder'])
			->name('neworder');

		Route::post('/neworder', [OrderController::class, 'neworderurl'])
			->name('neworder2');


		Route::post('/createorder', [OrderController::class, 'createorder'])->name('createorder');	
		Route::post('/terimaorder', [OrderController::class, 'terimaorder'])->name('terimaorder');	

		Route::post('/createitem', [OrderController::class, 'createitem'])->name('createitem');	
		
		Route::post('/edititem2', [OrderController::class, 'edititem2'])->name('edititem2');	
		Route::get('completedorder', [OrderController::class, 'completedorder'])->name('completedorder');

		Route::get('edit-item/{id}', [OrderController::class, 'edititem'])->name('edititem');
		Route::put('update-item/{id}', [OrderController::class, 'updateitem'])->name('updateitem');

		Route::get('delete-item/{id}', [OrderController::class, 'deleteitem'])->name('deleteitem');
		Route::put('confirmdelete-item/{id}', [OrderController::class, 'confirmdeleteitem'])->name('confirmdeleteitem');

		Route::get('view-order/{id}', [OrderController::class, 'vieworder'])->name('vieworder');
		Route::get('received-order/{id}', [OrderController::class, 'received'])->name('receivedorder');

		Route::get('payment-order/{id}', [OrderController::class, 'paymentorder'])->name('paymentorder');
		
		Route::post('payment-process-order', [OrderController::class, 'processorder'])->name('processorder');
		
		Route::post('payment-process-courier', [OrderController::class, 'processcourier'])->name('processcourier');
		
		Route::post('payment-process-selection', [OrderController::class, 'paymentselection'])->name('paymentselection');

			// Route::get('/add_shoppingsite', [ShoppingsiteController::class, 'create'])->name('shoppingsite.create');
			//Route::get('/list_shoppingsite', [ShoppingsiteController::class, 'index'])->name('shoppingsite.view');

		Route::post('/find-order', [OrderController::class, 'findOrder'])->name('findorder');
		Route::get('/detail-item/{id}', [OrderController::class, 'detailsItem'])->name('detail.item');

	});
	
	Route::prefix('tracking')->middleware('auth:user')->group(function () {
			Route::get('/currenttracking', [TrackingController::class, 'index'])
			->name('currenttracking');	
		  

		  });
	Route::prefix('completed')->middleware('auth:user')->group(function () {
			Route::get('/currentcompleted', [CompletedController::class, 'ordercompleted'])
			->name('currentcompleted');	
	        Route::get('view-comporder/{id}', [CompletedController::class, 'viewcomorder'])->name('viewcomorder');	
		    Route::get('/currentcompletedpay', [CompletedController::class, 'completedpay'])
			->name('currentcompletedpay');

		  });
	
	Route::prefix('refund')->middleware('auth:user')->group(function () {
		Route::get('/refund-list', [OrderController::class, 'refunds'])->name('refunds');
	});
	Route::get('/register', [RegisteredUserController::class, 'create'])
		->middleware('guest:user')
		->name('register');
	
	Route::get('/activate', [RegisteredUserController::class, 'activate'])
		->middleware('guest:user')
		->name('activate');
	Route::get('/activateuser/{id}', [RegisteredUserController::class, 'activateuser'])
		->middleware('guest:user')
		->name('activateuser');

	Route::post('/register', [RegisteredUserController::class, 'store'])
		->middleware('guest:user');

	Route::get('/login', [AuthenticatedSessionController::class, 'create'])
		->middleware('guest:user')
		->name('login');

	Route::post('/login', [AuthenticatedSessionController::class, 'store'])
		->middleware('guest:user');

	Route::post('/login_order', [AuthenticatedSessionController::class, 'loginOrder'])
		->middleware('guest:user')
		->name('login.order');

	Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
		->middleware('guest:user')
		->name('password.request');

	Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
		->middleware('guest:user')
		->name('password.email');

	Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
		->middleware('guest:user')
		->name('password.reset');

	Route::post('/reset-password', [NewPasswordController::class, 'store'])
		->middleware('guest:user')
		->name('password.update');

	Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
		->middleware('auth:user')
		->name('verification.notice');

	Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
		->middleware(['auth:user', 'signed', 'throttle:6,1'])
		->name('verification.verify');

	Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
		->middleware(['auth:user', 'throttle:6,1'])
		->name('verification.send');

	Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
		->middleware('auth:user')
		->name('password.confirm');

	Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
		->middleware('auth:user');

	Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
		->middleware('auth:user')
		->name('logout');
	
	Route::prefix('zpay')->middleware('auth:user')->group(function () {
		Route::get('request-api', [ZPayController::class, 'request'])
			->name('zpay.request');

		Route::get('retrieval', [ZPayController::class, 'retrieval'])->name('zpay.retrieval');
	});
	
	Route::prefix('wallet')->middleware('auth:user')->group(function () {
		Route::get('topup', [ZPayController::class, 'topup'])
			->name('wallet.topup');
		Route::post('topup', [ZPayController::class, 'topuprequest'])
			->name('wallet.request');
		//Route::get('retrieval', [ZPayController::class, 'retrieval'])->name('zpay.retrieval');
	});
});

