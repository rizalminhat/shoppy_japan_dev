<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Item;
use App\Models\Order;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use App\Mail\ItemMail;
use App\Models\Refund;
use App\Models\Courier;
use App\Mail\CourierFee;
use App\Mail\OrderShipped;
use App\Traits\OrderTrait;
use App\Models\inf_item_status;
use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:admin.verification.notice');
		
		
    }

    public function index(){
        return view('admin.report.report_financial');
        //
    }

    public function months(){
    	//$monthNow = Carbon::now()->format('m');
		$monthName = array("January","February","March","April","May","June","July","August","September","October","November","December");
		return $monthName;
    }

	public function view(){
		//return 'hello txt';
		// $monthss = $this->months();
		$monthss = DB::table('inf_month')->get();

		return view('admin.report.report_financial', compact('monthss'));
		//
	}

	public function fetchreportfinancial(Request $request){	
		$reportTypeId = $request->input('report_type');
		//$report = DB::table('me_status')->select('mest_index','mest_status')->where('mest_index',$reportTypeId)->first();
		$filter = "";
		if($reportTypeId == 'r_date'){
			$fromDates = Carbon::createFromFormat('Y-m-d', $request->input('fromdate'))->format('d/m/Y');
			$toDates = Carbon::createFromFormat('Y-m-d', $request->input('todate'))->format('d/m/Y');
			$reportName = 'Report By Date ('.$fromDates.' - '.$toDates.')';
			$filter = " HAVING (dates >= '".$fromDates."' AND dates <= '".$toDates."')";

		}else if($reportTypeId == 'r_month'){
			$bymonthId = $request->input('bymonth');
			$reportName = 'Report By Month ('.$bymonthId.')';
			$filter = " HAVING months = '".$bymonthId."'";

		}else if($reportTypeId == 'r_year'){
			$byyearId = $request->input('byyear');
			$reportName = 'Report By Year ('.$byyearId.')';
			$filter = " HAVING years = '".$byyearId."'";

		}else{
			$reportName = '';
			$filter = "";
		}

		$data = DB::select(DB::raw("SELECT *, name as user_name, DATE_FORMAT(i.created_at, '%d/%m/%Y') as dates, 
			MONTHNAME(i.created_at) as months, YEAR(i.created_at) as years  
			FROM orders o 
			INNER JOIN users u ON u.id = o.user_id 
			LEFT JOIN items i on o.id = i.item_order_id 
			WHERE o.status_id != 0 
			AND i.item_status_id = 1 
			AND i.created_at IS NOT NULL
			".$filter." 
			ORDER BY i.created_at DESC"));

		/*dd(DB::table('orders')
	        ->SELECT('*')
	        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
	        ->whereDate('items.created_at', $yesterday)
	        ->where('orders.status_id', '!=', '0')
	        ->where('items.item_status_id', '1')->toSql());*/

		//return view('admin.report.hasil_report_financial', view('reportTypeId','fromdateId','todateId','bymonthId','byyearId'));
		return view('admin.report.hasil_report_financial', compact('reportName'), array('data' => $data));
	}



	public function fetchCustomizeReport(Request $request)
	{
		$reportTypeId = $request->input('report_type');

		$query = DB::table('orders')
			->select('orders.id AS order_id','orders.user_id', 'orders.submit_at','users.name AS user_name','orders.order_no', 'orders.order_local', 'orders.order_international', 
			DB::raw('SUM(items.item_total) AS sum_item_total'))
			->join('items', 'items.item_order_id', '=', 'orders.id')
			->join('users', 'orders.user_id', '=', 'users.id')
			->where('items.item_status_id', '1')
			->where('orders.status_id', '!=','0');

		if($reportTypeId == 'r_date'){
			$fromDates = Carbon::createFromFormat('Y-m-d', $request->input('fromdate'))->format('d/m/Y');
			$toDates = Carbon::createFromFormat('Y-m-d', $request->input('todate'))->format('d/m/Y');
			$data['reportName'] = 'Report By Date ('.$fromDates.' - '.$toDates.')';
		
			$query = $query->whereBetween('orders.submit_at', [$request->fromdate, $request->todate]);	

		}else if($reportTypeId == 'r_month'){
			$data['reportName'] = 'Report By Month ('.$request->input('bymonth').')';
			$query = $query->whereMonth('orders.submit_at', $request->input('bymonth'));

		}else if($reportTypeId == 'r_year'){
			$byyearId = $request->input('byyear');
			$data['reportName'] = 'Report By Year ('.$byyearId.')';
			$query = $query->whereYear('orders.submit_at', $byyearId);
		}else{

			$getMonth = DB::table('inf_month')->where('month_code', $request->bymonth)->first();
			$data['reportName'] = 'Report By Month ('.$getMonth->month_name.') And Year ('.$request->byyear.') ';

			$query = $query->whereMonth('orders.submit_at', $request->bymonth);
			$query = $query->whereYear('orders.submit_at', $request->byyear);

		}
		$data['results'] = $query->groupBy('items.item_order_id')->orderBy('orders.submit_at', 'DESC')->get();

	
		return view('admin.report.hasil_report_financial', $data);

	}

	public function weeklySalesOld(){
		//get this week date
			$now = Carbon::now();
			$weekStartDate = $now->startOfWeek()->format('d/m/Y');
			$weekEndDate = $now->endOfWeek()->format('d/m/Y');
			$start = $now->startOfWeek()->format('Y-m-d');
	        $end = $now->endOfWeek()->format('Y-m-d'); 
			$currMonth = $now->month;
	        $currYear = $now->year;

        //TOP BOXES
	        // TOTAL SALES
			$data['sumByWeek'] = DB::table('orders')
		        ->SELECT('*')
		        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		        ->whereBetween('items.created_at', [$start,$end])
		        ->where('orders.status_id', '!=','0')
		        ->where('items.item_status_id', '1')
		        ->get()->sum("item_total");

		    //TOTAL ORDERS   
	        $total_orders = Order::selectRaw('DATE_FORMAT(submit_at,"%d/%m/%Y") as dates')->whereNotIn('status_id',[0])
	        	->havingRaw('dates >= "'.$weekStartDate.'" AND dates <= "'.$weekEndDate.'" ')->get()
	        	->count();

			//NEW ORDERS
	        $neworders = Order::selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as dates')->where('status_id','1')
	        	->havingRaw('dates >= "'.$weekStartDate.'" AND dates <= "'.$weekEndDate.'" ')->get()->count();

			//TOTAL BUYERS
			$data['buyers'] = User::has('buyer')->get()->count(); //nanti tambah date 

			//WEEKLY LINKS
			$data['weeklyLinks'] = DB::table('items')->selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as dates')
		        ->whereMonth('items.created_at',  $currMonth)
		        ->whereYear('items.created_at', $currYear)
		        ->where('item_status_id', '1')
				->havingRaw('dates >= "'.$weekStartDate.'" AND dates <= "'.$weekEndDate.'" ')
				->get()->count();
		
		//TOTAL SALES DAILY
  			$startDate = Carbon::createFromFormat('d/m/Y', $weekStartDate);
        	$endDate = Carbon::createFromFormat('d/m/Y', $weekEndDate);	
  
        	$dateRange = CarbonPeriod::create($startDate, $endDate);
        	$data['dateDaily'] = [];
			foreach ($dateRange as $date) {
			    array_push( $data['dateDaily'], $date->format('d/m/Y'));
			}

			$data['totalDaily'] = [];
			foreach($data['dateDaily'] as $daily){
				$totalSaleDaily = DB::table('orders')
					->SelectRaw('DATE_FORMAT(submit_at, "%d/%m/%Y") as dates') //
					->whereNotIn('status_id', [0])
					->HavingRaw('(dates = "'.$daily.'")')
					->count();
				array_push( $data['totalDaily'], $totalSaleDaily);
			}
			
		//ORDER STATUS
			//LIST
				$data['status_name'] = DB::table('order_status')
			        ->SELECT('*')
			        ->get(); 
			    $data['status_weekly'] = DB::table('order_status as os')
			    	->SelectRaw('os.*, (CASE WHEN b.totals > 0 THEN b.totals ELSE "0" END) AS total')
			    	->leftJoin(DB::raw('(SELECT *, COUNT(*) as totals FROM orders WHERE (updated_at >= "'.$start.'" AND updated_at <= "'.$end.'") group by status_id) as b'), DB::raw('os.id'), '=', DB::raw('b.status_id'))
			    	->groupBy(DB::raw('os.order_status'))
			    	->orderBy(DB::raw('os.id'))
			    	->get();

		   	//CHART 
			    $data['nameOrderStatuses'] = [];
			    foreach($data['status_name'] as $stat_name){
			    	array_push( $data['nameOrderStatuses'], $stat_name->order_status);
			    }
			    $data['totalOrderStatuses'] = [];
			    foreach($data['status_name'] as $stat_name){				
					$totalOrderStatusss = DB::table('orders')
						->SelectRaw('COUNT(*) as cntStat') 
						->whereBetween('updated_at', [$start,$end])
						->where('status_id','=',$stat_name->id)
						->groupBy('status_id')->count();
					array_push( $data['totalOrderStatuses'], $totalOrderStatusss);
				}

		return view('admin.report.weekly_sales', compact('weekStartDate','weekEndDate', 'neworders','total_orders'), $data);
	}
	
	public function  weeklySales()
	{
	 	$now = Carbon::now();
	 	$data['weekStartDate'] = $now->startOfWeek()->format('d-m-Y');
        $data['weekEndDate'] = $now->endOfWeek()->format('d-m-Y');
		
		
		$data['sumByWeek'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereBetween('submit_at',  [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
			->get()
			->sum('item_total');
		
		$data['total_orders'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereBetween('submit_at',  [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
			->groupBy('orders.id')
			->get()
			->count();
		
		$data['buyers'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereBetween('submit_at',  [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
			->groupBy('user_id')
			->get()
			->count();
		
		$data['weeklyLinks'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereBetween('submit_at',  [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
			->get()
			->count();
		
//		dd($data['weeklyLinks']);
		$data['statusWeekly'] = DB::table('order_status')
		 	->select('order_status.*', DB::raw('COUNT(order_status.id) as total'))
			->join('orders', 'order_status.id', '=', 'orders.status_id')
//			->where('orders.status_id', '!=','0')
//			->where('items.item_status_id', '1')
			->whereBetween('submit_at',  [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
			->groupBy('order_status.id')
			->get();
			
		
  
		$dateRange = CarbonPeriod::create($now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d'));
		$data['dateDaily'] = [];
		foreach ($dateRange as $date) {
			array_push( $data['dateDaily'], $date->format('Y-m-d'));
		}

		$data['totalDaily'] = [];
		foreach($data['dateDaily'] as $daily){
			$totalSaleDaily = DB::table('orders')
//				->select(DB::raw( "SUM(items.item_total) as total" ))
				->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
				->where('items.item_status_id', '1')
				->whereDate('submit_at', $daily)
				->whereNotIn('orders.status_id', [0,5])
				->get()
				->sum('item_total');
				
			array_push( $data['totalDaily'], $totalSaleDaily);
		}
		
//		dd($data['dateDaily'],$data['totalDaily']);
		return view('admin.report.weekly_sales', $data);
	}

	public function monthlySalesOld(){ //not used anymore
		//get this month
	        $now = Carbon::now();
			$monthNow = Carbon::now()->format('m');
			$currMonth = date('m');
			$currYear = date('Y');

		switch($monthNow) {
		  	case '01':  	$monthName = 'January';	    break;
		  	case '02':  	$monthName = 'February';    break;
		  	case '03':  	$monthName = 'March';    	break;
		  	case '04':	  	$monthName = 'April';		break;
		  	case '05':	  	$monthName = 'May';		 	break;
		  	case '06':	  	$monthName = 'June';		break;
		  	case '07':	  	$monthName = 'July';		break;
		  	case '08':	    $monthName = 'August';		break;
		  	case '09':	  	$monthName = 'September';	break;
		  	case '10':		$monthName = 'October';		break;
		  	case '11':		$monthName = 'November';	break;
		  	case '12':		$monthName = 'December';	break;
		  	default:
		}
		$monthName = strtoupper($monthName);

		//TOP BOX
		    $data['sumByMonth'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('submit_at',  $currMonth)
			->whereYear('submit_at', $currYear)
			->get()
			->sum("item_total");
		
			$data['total_orders']= 	DB::table('orders')
				->SELECT('*')
		        ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		        ->whereMonth('items.created_at',  $currMonth)
		        ->whereYear('items.created_at', $currYear)
		        ->where('orders.status_id', '!=','0')
		        ->where('items.item_status_id', '1')
				->get()->count();

			$data['buyers'] = User::has('buyer')->get()->count(); 
			$data['neworders']= Order::where('status_id', '1')->get()->count();
			//$data['total_orders']= Order::whereNotIn('status_id', [0])
			$data['monthlyLinks'] = DB::table('items')->SELECT('*')
		        // ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		        ->whereMonth('items.created_at',  $currMonth)
		        ->whereYear('items.created_at', $currYear)
		        // ->where('orders.status_id', '1')
		        ->where('items.item_status_id', '1')
		        ->get()
		        ->sum("item_status_id");

		//TOTAL ORDER FOR A MONTH BY DATES
			$monthStartDate = $now->firstOfMonth()->format('d/m/Y');
			$monthEndDate = $now->endOfMonth()->format('d/m/Y');
  			$startDate = Carbon::createFromFormat('d/m/Y', $monthStartDate);
        	$endDate = Carbon::createFromFormat('d/m/Y', $monthEndDate);
  
        	$dateRange = CarbonPeriod::create($startDate, $endDate);
        	$data['monthByDate'] = [];
			foreach ($dateRange as $date) {
			    array_push( $data['monthByDate'], $date->format('d/m/Y'));
			}
			//dd($data['monthByDate']);
			$data['totalSalesDaily'] = [];
			foreach($data['monthByDate'] as $daily){
				$totalSaleDaily = DB::table('orders')
					->SelectRaw('DATE_FORMAT(items.created_at, "%d/%m/%Y") as dates') 
					//SUM(items.item_total) as tots
					->leftJoin('items','orders.id','=','items.item_order_id')
					->Where('orders.status_id','!=','0')
					->Where('items.item_status_id','=','1')
					//->GroupBy('dates')
					->HavingRaw('(dates = "'.$daily.'")')->count();//->sum("tots");

				$totalLinkDaily = DB::table('items')
					->SelectRaw('DATE_FORMAT(items.created_at, "%d/%m/%Y") as dates') 
			        ->whereMonth('items.created_at',  $currMonth)
			        ->whereYear('items.created_at', $currYear)
			        ->where('items.item_status_id', '1')
			        ->HavingRaw('(dates = "'.$daily.'")')->get()->count();

				array_push( $data['totalSalesDaily'], $totalSaleDaily);
			}
			//dd($data['totalDaily']);/**/

		//ORDER STATUS
			//LIST
				$data['status_name'] = DB::table('order_status')
			        ->SELECT('*')
			        ->get(); 
			    $data['status_monthly'] = DB::table('order_status as os')
			    	->SelectRaw('os.*, COUNT(*) AS total')
			    	->leftJoin(DB::raw('(SELECT * FROM orders) as b'), DB::raw('os.id'), '=', DB::raw('b.status_id'))
			    	->groupBy(DB::raw('os.order_status'))
			    	->orderBy(DB::raw('os.id'))
			    	->get();
			    	//(CASE WHEN b.totals > 0 THEN b.totals ELSE "0" END)
			    	//,COUNT(*) as totals
			    	//WHERE (updated_at >= "'.$start.'" AND updated_at <= "'.$end.'" group by status_id

			    /* raw sql
					select status_id, COUNT(*) as cntStat, MONTH(updated_at) AS mnth
					from `orders` 
					-- where `status_id` = ? 
					where MONTH(updated_at) = '7'
					group by status_id, MONTH(updated_at)
					order by status_id, MONTH(updated_at)*/

					// $data['status_monthly'] = DB::table('order_status as os')
					 //    	->SelectRaw('os.*, COUNT(*) AS total')
					 //    	->leftJoin(DB::raw('(SELECT * FROM orders) as b'), DB::raw('os.id'), '=', DB::raw('b.status_id'))
					 //    	->groupBy(DB::raw('os.order_status'))
					 //    	->orderBy(DB::raw('os.id'))
					 //    	->get();

				/*LISTING SQL FOR WEEKLY ORDER STATUS (copy this into navicat)
					select os.*, (CASE WHEN b.totals > 0 THEN b.totals ELSE "0" END) AS total 
					from `order_status` as `os` 
					left join (
								SELECT *, COUNT(*) as totals FROM orders 
								WHERE (updated_at >= "2022-07-04" AND updated_at <= "2022-07-10") group by status_id
					) as b on os.id = b.status_id 
					group by os.order_status 
					order by os.id asc

					select os.*, COUNT(*) AS total 
					from `order_status` as `os` 
					left join (SELECT * FROM orders) as b on os.id = b.status_id 
					group by os.order_status 
					order by os.id 
					*/

		   	//CHART 
			    $data['nameOrderStatuses'] = [];
			    foreach($data['status_name'] as $stat_name){
			    	array_push( $data['nameOrderStatuses'], $stat_name->order_status);
			    }
			    $data['totalOrderStatuses'] = [];
			    foreach($data['status_name'] as $stat_name){
					/* raw sql
						select status_id, COUNT(*) as cntStat, MONTH(updated_at) AS mnth
						from `orders` 
						-- where `status_id` = ? 
						where MONTH(updated_at) = '7'
						group by status_id, MONTH(updated_at)
						order by status_id, MONTH(updated_at)*/
					$totalOrderStatusss = DB::table('orders')
						->SelectRaw('COUNT(*) as cntStat') //, MONTH(updated_at) AS mnth
						->where('status_id','=',$stat_name->id)
						->whereRaw('MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)')
						->groupBy('status_id',DB::raw('MONTH(updated_at)'))
						->orderBy('status_id')
						->orderBy(DB::raw('MONTH(updated_at)'))
						->count();
					array_push( $data['totalOrderStatuses'], $totalOrderStatusss);
				}

		return view('admin.report.monthly_sales', compact('monthNow','monthName'), $data);
	}
	
	public function monthlySales()
	{
		$currMonth = date('m');
		$currYear = date('Y');
		$data['monthName'] = now()->format('F');
		
		$startfff = new Carbon('first day of this month');
		$endfff = new Carbon('last day of this month');
		$dateRange = CarbonPeriod::create($startfff,$endfff);

		$daysInMonth = [];
		$data['fetchDays'] = [];
		foreach ($dateRange as $date) {
			array_push( $daysInMonth, $date->format('Y-m-d'));
			array_push($data['fetchDays'], $date->format('d'));
		}
		
		
		$data['totalSalesDaily'] = [];
		$data['totalLinkDaily'] = [];
		foreach($daysInMonth as $dailyDate){
			$totalSalesDaily = DB::table('orders')
			->join('items', 'orders.id', '=', 'items.item_order_id')
			->whereDate('submit_at',  $dailyDate)
			->where('item_status_id', '1')
//			->groupBy('orders.id')
			->get()
			->sum('item_total');

			array_push( $data['totalSalesDaily'], $totalSalesDaily);
			
			$totalLinkDaily = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereDate('submit_at',  $dailyDate)
			->get()
			->count();
			
			array_push( $data['totalLinkDaily'], $totalLinkDaily);
			
		}
		
		$data['sumByMonth'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('submit_at',  $currMonth)
			->whereYear('submit_at', $currYear)
			->get()
			->sum('item_total');
		
		
		$data['totalOrders'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('submit_at',  $currMonth)
			->whereYear('submit_at', $currYear)
			->groupBy('orders.id')
			->get()
			->count();
		
		$data['buyers'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('submit_at',  $currMonth)
			->whereYear('submit_at', $currYear)
			->groupBy('user_id')
			->get()
			->count();
		
		$data['monthlyLinks'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('submit_at',  $currMonth)
			->whereYear('submit_at', $currYear)
			->get()
			->count();
		

		return view('admin.report.monthly_sales',  $data);
	}

	public function commission(){
		$monthss = $this->months();
        $now = Carbon::now();
		$monthNow = Carbon::now()->format('m');
		$currMonth = date('m');
		$currYear = date('Y');
        $currDate = $now->format('Y-m-d');
		$weekStartDate = $now->startOfWeek()->format('d/m/Y');
		$weekEndDate = $now->endOfWeek()->format('d/m/Y');

		$start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->endOfWeek()->format('Y-m-d');  
		
		switch($monthNow) {
		  	case '01':  	$monthName = 'January';	    break;
		  	case '02':  	$monthName = 'February';    break;
		  	case '03':  	$monthName = 'March';    	break;
		  	case '04':	  	$monthName = 'April';		break;
		  	case '05':	  	$monthName = 'May';		 	break;
		  	case '06':	  	$monthName = 'June';		break;
		  	case '07':	  	$monthName = 'July';		break;
		  	case '08':	    $monthName = 'August';		break;
		  	case '09':	  	$monthName = 'September';	break;
		  	case '10':		$monthName = 'October';		break;
		  	case '11':		$monthName = 'November';	break;
		  	case '12':		$monthName = 'December';	break;
		  	default:
		}
		$monthName = strtoupper($monthName);

		//TOP BOX
		$data['todayLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('item_status_id', '1')
        ->whereDate('submit_at', $currDate)
        ->get()
        ->count();

		$data['weeklyLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereBetween('orders.submit_at', [$start,$end])
        ->where('items.item_status_id', '1')
        ->get()
        ->count('items.id');

		$data['monthlyLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereMonth('submit_at',  $currMonth)
        ->whereYear('submit_at', $currYear)
        ->where('item_status_id', '1')
        ->get()
        ->count("items.id");

		$data['yearlyLinks'] = DB::table('orders')
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereYear('submit_at', $currYear)
        ->where('item_status_id', '1')
        ->get()
        ->count("items.id");

		//TOTAL LINKS MONTHLY FOR A YEAR
		$monthNum = DB::table('inf_month')->get()->pluck('month_code');
		$data['totalLinksMonthly'] = [];
		foreach($monthNum as $monthNo){
			$linkMonthly = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->whereMonth('submit_at',  $monthNo)
			->whereYear('submit_at', $currYear)
			->where('item_status_id', '1')
			->get()
			->count("items.id");
			array_push( $data['totalLinksMonthly'], $linkMonthly);
		}



		// $firstDayInMonth = $now->firstOfMonth();  
		// $lastDayInMonth = $now->endOfMonth();

		$startfff = new Carbon('first day of this month');
		$endfff = new Carbon('last day of this month');
		$dateRange = CarbonPeriod::create($startfff,$endfff);

		$daysInMonth = [];
		foreach ($dateRange as $date) {
			array_push( $daysInMonth, $date->format('Y-m-d'));
		}

		$data['fetchDayInMonth'] = [];
		foreach ($dateRange as $date) {
			array_push($data['fetchDayInMonth'] , $date->format('d'));
		}
		
		
		$data['totalDaily'] = [];
		foreach($daysInMonth as $dailyDate){
			$totalLinkDaily = DB::table('orders')
			->join('items', 'orders.id', '=', 'items.item_order_id')
			->whereDate('submit_at',  $dailyDate)
			->where('item_status_id', '1')
			->get()
			->count("items.id");

			array_push( $data['totalDaily'], $totalLinkDaily);
		}

		$dateRange2 = CarbonPeriod::create($start, $end);
		$data['weekByDate'] = [];
		foreach ($dateRange2 as $weekly) {
			array_push( $data['weekByDate'], $weekly->format('Y-m-d'));
		}
	
		$data['totalLinksWeekly'] = [];
		foreach($data['weekByDate'] as $daily){
			$weeklyLinks = DB::table('orders')
			->join('items', 'orders.id', '=', 'items.item_order_id')
			->whereDate('submit_at',  $daily)
			->where('item_status_id', '1')
			->get()
			->count("items.id");

			array_push( $data['totalLinksWeekly'], $weeklyLinks);
		}

		 	// $data['weeklyLinks'] = DB::table('items')->selectRaw('DATE_FORMAT(created_at, "%d/%m/%Y") as dates')
		    //     ->whereMonth('items.created_at',  $currMonth)
		    //     ->whereYear('items.created_at', $currYear)
		    //     ->where('item_status_id', '1')
			// 	->havingRaw('dates >= "'.$weekStartDate.'" AND dates <= "'.$weekEndDate.'" ')
			// 	->get()->count();

			// $data['monthlyLinks'] = DB::table('items')->SELECT('*')
		    //     // ->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		    //     ->whereMonth('items.created_at',  $currMonth)
		    //     ->whereYear('items.created_at', $currYear)// ->where('orders.status_id', '1')
		    //     ->where('items.item_status_id', '1')
		    //     ->get()->sum("item_status_id");


		 	// $data['yearlyLinks'] = DB::table('items')->SELECT('*')
		    //     ->whereYear('items.created_at', $currYear)
		    //     ->where('items.item_status_id', '1')
		    //     ->get()->count("item_status_id");

		//TOTAL LINKS DAILY FOR A MONTH
			// $monthStartDate = $now->firstOfMonth()->format('d/m/Y');
			// $monthEndDate = $now->endOfMonth()->format('d/m/Y');
  			// $startDate = Carbon::createFromFormat('d/m/Y', $monthStartDate);
        	// $endDate = Carbon::createFromFormat('d/m/Y', $monthEndDate);
  
        	// $dateRange = CarbonPeriod::create($startDate, $endDate);
        	// $data['monthByDate'] = [];
			// foreach ($dateRange as $date) {
			//     array_push( $data['monthByDate'], $date->format('d/m/Y'));
			// }
			//dd($data['monthByDate']);
		

		
		
			// dd($data['totalLinksMonthly']);
		//TOTAL LINKS WEEKLY FOR A YEAR  
  			
		
			//dd($data['weekByDate']);
			
			//dd($data['totalLinksWeekly']);/**/

		$data['fetchMonth'] = DB::table('inf_month')->get()->pluck('month_short_name');
		return view('admin.report.service_commission', compact('monthss','monthNow','monthName','weekStartDate','weekEndDate','currYear','weekStartDate','weekEndDate'), $data);
	}

	public function hasilServiceCommission(Request $request){	
		$reportTypeId = $request->input('report_type');
		//$report = DB::table('me_status')->select('mest_index','mest_status')->where('mest_index',$reportTypeId)->first();
		$filter = "";
		if($reportTypeId == 'r_date'){
			$fromDates = Carbon::createFromFormat('Y-m-d', $request->input('fromdate'))->format('d/m/Y');
			$toDates = Carbon::createFromFormat('Y-m-d', $request->input('todate'))->format('d/m/Y');
			$reportName = 'Report By Date ('.$fromDates.' - '.$toDates.')';
			$filter = " HAVING (dates >= '".$fromDates."' AND dates <= '".$toDates."')";

		}else if($reportTypeId == 'r_month'){
			$bymonthId = $request->input('bymonth');
			$reportName = 'Report By Month ('.$bymonthId.')';
			$filter = " HAVING months = '".$bymonthId."'";

		}else if($reportTypeId == 'r_year'){
			$byyearId = $request->input('byyear');
			$reportName = 'Report By Year ('.$byyearId.')';
			$filter = " HAVING years = '".$byyearId."'";

		}else{
			$reportName = '';
			$filter = "";
		}

		/*$datas = DB::select(DB::raw("SELECT *, name as user_name, DATE_FORMAT(order_process_date, '%d/%m/%Y') as dates, MONTHNAME(order_process_date) as months, YEAR(order_process_date) as years  
			FROM orders o 
			INNER JOIN users u ON u.id = o.user_id WHERE order_process_date IS NOT NULL
			".$filter." 
			ORDER BY order_process_date DESC"));*/

		$datas = DB::select(DB::raw("SELECT *, DATE_FORMAT(created_at, '%d/%m/%Y') AS dates,  MONTHNAME(created_at) as months, YEAR(created_at) as years   
			FROM items 
			WHERE item_status_id = 1 ".$filter."
			ORDER BY dates DESC")); /**/// 

		$now = Carbon::now();
        $currDate = $now->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $start = $now->startOfWeek()->format('Y-m-d');
        $end = $now->endOfWeek()->format('Y-m-d');  
        // $currMonth = $now->month;
        $currYear = date('Y');

        $currMonth = date('m');

        $todayLinks = Item::where('item_status_id', '1')->whereDate('created_at', $currDate)->get()->count();

        // dd($data['today_links']);
        $totalLinks = Item::where('item_status_id', '1')->get()->count();

        $monthlyLinks = DB::table('items')
        ->whereMonth('created_at',  $currMonth)
        ->whereYear('created_at', $currYear)
        ->where('item_status_id', '1')
        ->get()
        ->sum("item_status_id");
        

		//return view('admin.report.hasil_report_financial', view('reportTypeId','fromdateId','todateId','bymonthId','byyearId'));
		return view('admin.report.hasil_service_commission', compact('reportName','todayLinks','totalLinks','monthlyLinks'), array('datas' => $datas));
	}



	public function viewSalesReport(){

		$year = now()->format('Y');
	
		$data['tsPrevYear'] = DB::table('orders')

        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->whereNotIn('orders.status_id', [0,5])
        ->where('items.item_status_id', '1')
		->whereYear('orders.submit_at', now()->subYear(1))
        ->get()
        ->sum("item_total");

		$data['tsCurrYear'] = DB::table('orders')
        
        ->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('orders.status_id', '!=','0')
        ->where('items.item_status_id', '1')
		->whereYear('orders.submit_at', now()->format('Y'))
        ->get()
        ->sum("item_total");

		// dd($data['tsCurrYear']);

		$currYear = date('Y');

        $currMonth = date('m');
        $prevMonth = now()->subMonthWithoutOverflow()->format('m'); // 8

        $prevYear = now()->subYear()->format('Y');

		
		if($prevMonth>$currMonth)
        {
            $data['tsPrevMonth'] = DB::table('orders')
			
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			// ->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
            ->whereMonth('orders.submit_at',  $prevMonth)
            ->whereYear('orders.submit_at', $prevYear)
            ->get()
            ->sum("item_total");

			$data['tlpm'] = DB::table('orders')
			->join('items', 'orders.id', '=', 'items.item_order_id')
			->where('item_status_id', '1')
            ->whereMonth('submit_at',  $prevMonth)
            ->whereYear('submit_at', $prevYear)
            ->get()
            ->count("items.id");

			$data['trpm'] = DB::table('refunds')
			->join('items', 'refunds.id', '=', 'items.refund_id')
			->whereMonth('refunds.created_at',  $prevMonth)
            ->whereYear('refunds.created_at', $prevYear)
			->get()
			->sum('refund_amount');


            $data['prevYear'] = $prevYear;
        
        }else{
            $data['tsPrevMonth'] = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			// ->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
            ->whereMonth('orders.submit_at',  $prevMonth)
            ->whereYear('orders.submit_at', $currYear)
            ->get()
            ->sum("item_total");

			$data['tlpm'] = DB::table('orders')
			->join('items', 'orders.id', '=', 'items.item_order_id')
			->where('item_status_id', '1')
            ->whereMonth('submit_at',  $prevMonth)
            ->whereYear('submit_at', $currYear)
            ->get()
            ->count('items.id');


			$data['trpm'] = DB::table('refunds')
			->join('items', 'refunds.id', '=', 'items.refund_id')
			->whereMonth('refunds.created_at',  $prevMonth)
            ->whereYear('refunds.created_at', $currYear)
			->get()
			->sum('refund_amount');


            $data['prevYear'] = $prevYear;
        }

		$data['tsCurrMonth'] = DB::table('orders')
		->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		->where('orders.status_id', '!=','0')
		->where('items.item_status_id', '1')
		->whereMonth('submit_at',  $currMonth)
		->whereYear('submit_at', $currYear)
		->get()
		->sum("item_total");

		$data['tlcm'] = DB::table('orders')
		->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
		->where('item_status_id', '1')
		->whereMonth('submit_at',  $currMonth)
		->whereYear('submit_at', $currYear)
		->get()
		->count('items.id');


		$data['currYear'] = $currYear;
		$data['currMonth'] = now()->format('F');
        $data['prevMonth'] = now()->subMonthWithoutOverflow()->format('F');
		


		
		$salesByMonth = [];
		$salesByMonth2 = [];
		$linksMonthCurrYear = [];
		$linksMonthPrevYear = [];
		for ($month = 1; $month <= 12; $month++) {
			$salesPrevYear= DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('orders.submit_at',  $month)
			->whereYear('orders.submit_at',  $prevYear)
			->get()
			->sum("item_total");
			
			$salesCurrYear= DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('orders.status_id', '!=','0')
			->where('items.item_status_id', '1')
			->whereMonth('orders.submit_at',  $month)
			->whereYear('orders.submit_at',  $currYear)
			->get()
			->sum("item_total");
			
			$totlcy = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('item_status_id', '1')
			->whereMonth('submit_at',   $month)
			->whereYear('submit_at', $currYear)
			->get()
			->count('items.id');
			
			$totlpy = DB::table('orders')
			->leftJoin('items', 'orders.id', '=', 'items.item_order_id')
			->where('item_status_id', '1')
			->whereMonth('submit_at',   $month)
			->whereYear('submit_at', $prevYear)
			->get()
			->count('items.id');

			
			array_push($salesByMonth, $salesPrevYear);

			array_push($salesByMonth2, $salesCurrYear);
			
			array_push($linksMonthCurrYear, $totlcy);
			
			array_push($linksMonthPrevYear, $totlpy);
			
			
		}

		$data['salesPrevYearByMonth'] = $salesByMonth;
		$data['salesCurrYearByMonth'] = $salesByMonth2;
		$data['linksMonthCurrYear'] = $linksMonthCurrYear;
		$data['linksMonthPrevYear'] = $linksMonthPrevYear;

		$data['tlpy'] = DB::table('orders')
		->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('item_status_id', '1')
		->whereYear('submit_at', now()->subYear(1))
        ->get()
        ->count("id");

		$data['tlcy'] = DB::table('orders')
		->join('items', 'orders.id', '=', 'items.item_order_id')
        ->where('item_status_id', '1')
		->whereYear('submit_at', now()->format('Y'))
        ->get()
        ->count('id');

		// dd($data['tlpy'], $data['tlcy']);


		//refund
		$data['trpy'] = DB::table('refunds')
        ->join('items', 'refunds.id', '=', 'items.refund_id')
		->whereYear('refunds.created_at', now()->subYear(1))
        ->get()
        ->sum('refund_amount');

		$data['trcy'] = DB::table('refunds')
		->join('items', 'refunds.id', '=', 'items.refund_id')
		->whereYear('refunds.created_at', now()->format('Y'))
		->get()
		->sum('refund_amount');


		$data['trcm'] = DB::table('refunds')
		->join('items', 'refunds.id', '=', 'items.refund_id')
		->whereMonth('refunds.created_at',  $currMonth)
		->whereYear('refunds.created_at', $currYear)
		->get()
		->sum('refund_amount');
		

		

		$data['fetchMonth'] = DB::table('inf_month')->get()->pluck('month_short_name');
		
		// if(Auth::user()->id == 3)
        // {
        //     dd($data);
        // }
		return view('admin.report.sales_report', $data);
	}

}
