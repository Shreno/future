<?php

namespace App\Http\Controllers\Admin;

use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charts\OrderChart;
use App\Charts\ClientChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;

use App\Order;
use App\Daily_report;


class HomeController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');

    }
    public function index(Request $request)
    {

      


        // orders chart
        $ordersLastSixMonths  = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from orders group by DATE_FORMAT(created_at, '%Y-%m') order by created_at desc limit 6");
        $orderdate = collect([]);
        $ordercount = collect([]);
      for ($i=0; $i < count($ordersLastSixMonths) ; $i++) {
        $orderdate[] = $ordersLastSixMonths[$i]->date  ;
        $ordercount[]= $ordersLastSixMonths[$i]->count;
    }
        $orderChart = new OrderChart;
        $orderChart->labels($orderdate);
        $orderChart->dataset('orders', 'bar', $ordercount)->options([
           'backgroundColor' => '#f39c12',
        ]);

        // clients chart

        $clientsLastSixMonths  = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from users where user_type='client' group by DATE_FORMAT(created_at, '%Y-%m') order by created_at desc limit 6");
        $clientdate = collect([]);
        $clientcount = collect([]);
      for ($i=0; $i < count($clientsLastSixMonths) ; $i++) {
        $clientdate[] = $clientsLastSixMonths[$i]->date  ;
        $clientcount[]= $clientsLastSixMonths[$i]->count;
    }
        $clientChart = new ClientChart;
        $clientChart->labels($clientdate);
        $clientChart->dataset('clients', 'bar', $clientcount)->options([
           'backgroundColor' => '#00c0ef',
        ]);

        // list of orders Today

        $ordersToday     = Order:: CreatedToday()->get();
        $ordersShipToday = Order:: PickupToday()->get();

        $statuses = Status::get();

        return view('admin.dashboard', compact('orderChart', 'clientChart', 'ordersToday', 'ordersShipToday', 'statuses'));
    }
     public function DailyReport()
    {
      
      $from=date('Y-m-d');
      $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
      $reports=Daily_report::orderBy('id','DESC')->get();

      return view('admin.DailyReport.index', compact('delegates','from','reports'));
    }
    public function store(request $request)
    {  
        $report=Daily_report::whereDate('date',$request->date)->where('delegate_id',$request->delegate_id)->where('client_id',$request->client_id)->first();
        if($report==NULL)
        {
            $delegateData = $request->all();
        $delegate = Daily_report::create($delegateData);

        if ($delegate) {
            $notification = array(
                'message' => '<h3>Saved Successfully</h3>',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => '<h3>Something wrong Please Try again later</h3>',
                'alert-type' => 'error'
            );
        }
            
        }else
        
        {
             $notification = array(
                'message' => '<h3>يوجد تقرير يومى بنفس اليوم</h3>',
                'alert-type' => 'error'
            );
            
        }
        
        

        return redirect()->route('DailyReport')->with($notification);
        
    }

}
