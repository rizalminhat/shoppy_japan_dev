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
use PDF;
class PdfController extends Controller
{
    public function getOrderHistory()
    {
        $order = Order::all();
        // return view('pdf.order_history', compact('order'));
        $pdf = PDF::loadView('pdf.order_history', compact('order'));
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }	
}