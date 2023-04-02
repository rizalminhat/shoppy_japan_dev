<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Admin\BrandContoller;
use App\Http\Controllers\Admin\BuyerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnnoucementController;
use App\Http\Controllers\Admin\ShoppingsiteController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\ZPay\ZPayController;

	
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:admin');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:admin')
        ->name('dashboard');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('guest:admin')
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest:admin');

  

    // Route::post('/login', [AuthenticatedSessionController::class, 'getUrl'])
    //     ->middleware('guest:admin')
    //     ->name('login.url');


    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:admin')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:admin', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:admin')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:admin');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('logout');

    Route::prefix('profile')->name('profile.')->middleware('auth:admin')->group(function() {
        Route::get('/change-password/view', [ProfileController::class, 'viewChangePwd'])->name('changepwd');
        Route::post('/change-password/update', [ProfileController::class, 'updateChangePwd'])->name('updatepwd');
    });

    Route::prefix('item')->middleware('auth:admin')->group(function () {
        // Route::get('/list_brand', [BrandController::class, 'index'])->name('brand.view');
        Route::get('/add_shoppingsite', [ShoppingsiteController::class, 'create'])->name('shoppingsite.create');
        Route::get('/list_shoppingsite', [ShoppingsiteController::class, 'index'])->name('shoppingsite.view');

        Route::post('/store_shoppingsite', [ShoppingsiteController::class, 'store'])->name('shoppingsite.store');
        Route::get('/show_shoppingsite/{id}', [ShoppingsiteController::class, 'show'])->name('shoppingsite.show');
        Route::post('/update_shoppingsite/{id}', [ShoppingsiteController::class, 'update'])->name('shoppingsite.update');
        Route::post('/delete_shoppingsite', [ShoppingsiteController::class, 'destroy'])->name('shoppingsite.delete');


        Route::get('/list_product', [ProductController::class, 'index'])->name('product.view');
        Route::get('/add_product', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store_product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/show_product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/update_product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/delete_product', [ProductController::class, 'destroy'])->name('product.delete');

    });

    Route::prefix('order')->middleware('auth:admin')->group(function () {
        Route::get('/list_order', [OrderController::class, 'index'])->name('order.view');
        Route::get('/list_items/{id}', [OrderController::class, 'show'])->name('order.items');
        Route::get('/details_item/{id}', [OrderController::class, 'detailsItem'])->name('order.detailsItem');
        Route::post('/check_order', [OrderController::class, 'checkOrder'])->name('order.check');
        // Route::post('/process_order/{id}', [OrderController::class, 'processOrder'])->name('order.process');
        Route::post('/process_item', [OrderController::class, 'processItem'])->name('order.processItem');
        Route::get('/details_process_order/{id}', [OrderController::class, 'detailsProcessOrder'])->name('order.detailsProcessOrder');
       
        Route::post('/process_order/{id}', [OrderController::class, 'processOrder'])->name('order.process');
        Route::post('/process_order', [OrderController::class, 'cancelOrder'])->name('order.cancel');
        Route::post('/process_order_all', [OrderController::class, 'processOrderAll'])->name('order.process.all');
        Route::post('/process_order_all2', [OrderController::class, 'processOrderAll2'])->name('order.process.all2');
		
        Route::post('/process_shipping', [OrderController::class, 'processShipped'])->name('order.processShipping');
        Route::post('/process_refund', [OrderController::class, 'processRefund'])->name('order.processRefund');
        Route::post('/process_recieved', [OrderController::class, 'processRecieved'])->name('order.processRecieved');
        Route::post('/process_purchase', [OrderController::class, 'processPurchase'])->name('order.purchase');

        Route::post('/find-order', [OrderController::class, 'findOrder'])->name('findorder');
        Route::post('/item_image', [OrderController::class, 'OderItemImage'])->name('itemimage');

        //modal
        Route::post('/modal_status', [OrderController::class, 'modalStatusItem'])->name('order.modalStatus');
        Route::post('/modal_process', [OrderController::class, 'modalProcess'])->name('order.modalProcess');
        Route::post('/modal_purchase', [OrderController::class, 'modalPurchase'])->name('order.modalPurchase');
        Route::post('/modal_shipping', [OrderController::class, 'modalShipping'])->name('order.modalShipping');
        Route::post('/modal_refund', [OrderController::class, 'modalRefund'])->name('order.modalRefund');
        Route::post('/modal_received', [OrderController::class, 'modalReceived'])->name('order.modalReceived');

        Route::get('/pdf_order_history/{id}', [PdfController::class, 'getOrderHistory'])->name('pdf.order');	


    });

    Route::prefix('buyer')->middleware('auth:admin')->group(function () {
        Route::get('/buyer_list', [BuyerController::class, 'index'])->name('buyer.view');
        Route::get('/buyer_detail/{id}', [BuyerController::class, 'show'])->name('buyer.detail');
        Route::get('/resend_activate_email/{id}', [BuyerController::class, 'resendActivateEmail'])->name('resend_activate_email');

    });

    Route::prefix('user')->middleware('auth:admin')->group(function(){
        Route::get('user_list', [BuyerController::class, 'UserView'])->name('user.view');
    });

    Route::prefix('config')->middleware('auth:admin')->group(function () {
        Route::get('/list_config', [SettingController::class, 'index'])->name('config.view');
        Route::post('/update_config/{id}', [SettingController::class, 'update'])->name('config.update');

        Route::get('courier/type/list', [SettingController::class, 'CourierTypeView'])->name('couriertype.view');
        // Route::get('courier/type/add', [SettingController::class, 'CourierTypeAdd'])->name('couriertype.add');
        Route::post('courier/type/store', [SettingController::class, 'CourierTypeStore'])->name('couriertype.store');
        Route::get('courier/type/edit/{id}', [SettingController::class, 'CourierTypeEdit'])->name('couriertype.edit');
        Route::post('courier/type/update/{id}', [SettingController::class, 'CourierTypeUpdate'])->name('couriertype.update');
        Route::post('courier/type/delete', [SettingController::class, 'CourierTypeDelete'])->name('couriertype.delete');
    });

    Route::prefix('annoucement')->middleware('auth:admin')->group(function(){
        Route::get('/list_annoucement', [AnnoucementController::class, 'AnnocuementView'])->name('annouce.view');
        Route::post('/store_annoucement', [AnnoucementController::class, 'AnnocuementStore'])->name('annouce.store');
        Route::post('/update_annoucement/{id}', [AnnoucementController::class, 'AnnocuementUpdate'])->name('annouce.update');
        Route::post('/delete_annoucement', [AnnoucementController::class, 'AnnocuementDelete'])->name('annouce.delete');
        Route::get('/testing', [AnnoucementController::class, 'Testing'])->name('testing.part');
    });


    
    Route::prefix('report')->middleware('auth:admin')->group(function () {
        Route::get('/report_financial', [ReportController::class, 'view'])->name('report_financial');
        Route::get('/fetch_report_financial', [ReportController::class, 'fetchCustomizeReport'])->name('report.hasil_report_financial');
        Route::get('/weekly_sales', [ReportController::class, 'weeklySales'])->name('weekly_sales');
        Route::get('/monthly_sales', [ReportController::class, 'monthlySales'])->name('monthly_sales');
        //Route::get('/add_shoppingsite', [ShoppingsiteController::class, 'create'])->name('shoppingsite.create');
        //Route::post('/store_shoppingsite', [ShoppingsiteController::class, 'store'])->name('shoppingsite.store');
        //Route::get('/list_shoppingsite', [ShoppingsiteController::class, 'index'])->name('shoppingsite.view');
        Route::get('/service_commission', [ReportController::class, 'commission'])->name('service_commission');
        Route::get('/hasil_service_commission', [ReportController::class, 'hasilServiceCommission'])->name('report.hasil_service_commission');

        Route::get('/sales_report', [ReportController::class, 'viewSalesReport'])->name('view_sales_report');
    });


   
	
	Route::prefix('trans')->middleware('auth:admin')->group(function () {
        Route::get('/list_transaction', [OrderController::class, 'listtrans'])->name('list_transaction');
		Route::get('/attempt_transaction', [OrderController::class, 'listtrans'])->name('attempt_transaction');
		Route::get('/walletin_transaction', [OrderController::class, 'listwallet'])->name('walletin_transaction');
		Route::get('/walletout_transaction', [OrderController::class, 'listwallet'])->name('walletout_transaction');
		Route::post('/requery', [OrderController::class, 'requery'])->name('requery');
		Route::get('/retrieval', [ZPayController::class, 'retrieval'])->name('inretrieval');
		Route::get('/requery-zpay', [ZpayController::class, 'requeryZpay']);
    });

});
