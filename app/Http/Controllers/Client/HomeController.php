<?php

namespace App\Http\Controllers\Client;
use App\Status;
use App\ClientTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Charts\OrderChart;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('terms');
    }
   public function index()
   {
        $user = Auth()->user();
        $latestOrders = $user->orders()->orderBy('updated_at','DESC')->get();

        $balance = DB::table('client_transactions')->select(array(DB::raw('SUM(debtor - creditor) as total')))
       ->where('user_id', $user->id)
       ->where('deleted_at', null)
       ->first();
        $balance = $balance->total;
        $ordersLastSixMonths  = DB::select("select DATE_FORMAT(created_at, '%Y-%m') as date, count(created_at) as count from orders where user_id=".auth()->user()->id." group by DATE_FORMAT(created_at, '%Y-%m') ORDER BY updated_at DESC limit 6");
        $orderdate = collect([]);
        $ordercount = collect([]);
        for ($i=0; $i < count($ordersLastSixMonths) ; $i++) {
            $orderdate[] = $ordersLastSixMonths[$i]->date  ;
            $ordercount[]= $ordersLastSixMonths[$i]->count;
        }

        $orderChart = new OrderChart;
        $orderChart->labels($orderdate);
        $orderChart->dataset(__('app.orders', ['attribute' => '']), 'bar', $ordercount)->options([
           'backgroundColor' => '#f39c12',
        ]);
        
        $statuses = Status::get();
        return view('client.dashboard', compact('latestOrders', 'orderChart', 'balance','statuses'));
   }

    public function transactions(Request $request )
    {
        $from               = $request->get('from');
        $to                 = $request->get('to');
        
        
        $client = Auth()->user();
        if ($client) {
            $transactions = ClientTransactions::where('user_id', $client->id)->orderBy('id','DESC');
            if($from != null  && $to != null ){
                $transactions = $transactions->whereDate('created_at', '>=', $from)
                           ->whereDate('created_at', '<=', $to);
            }
            $count_creditor =  $transactions->sum('creditor');
            $count_debtor = $transactions->sum('debtor');

            
            
            $transactions = $transactions->get();
            return view('client.balance-transactions', compact('transactions', 'client','from','to','count_debtor','count_creditor'));
        } else {
            abort(404);
        }
    }
}
