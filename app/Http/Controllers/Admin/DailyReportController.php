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
use App\ClientTransactions;
use App\Order;
use App\Daily_report;

class DailyReportController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');

    }
 


    public function index(Request $request)
    {
        $reports=Daily_report::orderBy('id','DESC');
        if($request->exists('type'))
        {

            $delegate_id        = $request->get('delegate_id');
            $client_id        = $request->get('client_id');
            $from        = $request->get('from');
            $to        = $request->get('to');




        
        if($request->delegate_id != null){
            $reports->where('delegate_id', $request->delegate_id);
        }
        if($request->client_id != null){
            $reports->where('client_id', $request->client_id);
        }
        if($from != null && $to != null){
            $reports = $reports->whereDate('date', '>=', $from)
                           ->whereDate('date', '<=', $to);

        }

        $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
        $clients = User::where('user_type', 'client')->orderBy('id', 'desc')->get();
        $reports=$reports->paginate(25);

        return view('admin.DailyReport.index', compact('reports','to','from','clients', 'client_id','delegates','delegate_id',));

    }




      
      $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
      $clients = User::where('user_type', 'client')->orderBy('id', 'desc')->get();

      $reports=$reports->paginate(25);


      return view('admin.DailyReport.index', compact('delegates','clients','reports'));
    }

    public function create()
    {
      
      $from=date('Y-m-d');
      $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();

      return view('admin.DailyReport.create', compact('delegates','from'));
    }
    
    public function store(request $request)
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

        return redirect()->route('DailyReport.index')->with($notification);
        
    }
    public function edit($id)
    {
        $Daily_report = Daily_report::findOrFail($id);
        if ($Daily_report) {
            $from=date('Y-m-d');
            $delegates = User::where('user_type', 'delegate')->orderBy('id', 'desc')->get();
            $client=User::where('id',$Daily_report->client_id)->first();

            return view('admin.DailyReport.edit', compact('Daily_report','delegates','from','client'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request, $id)
    {  
        
        $delegateData = $request->all();
        $Daily_report = Daily_report::findOrFail($id);
        $Daily_report->update($request->all());

        if ($Daily_report) {
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

        return redirect()->route('DailyReport.index')->with($notification);
        
    }
    public function destroy($id)
    {
        Daily_report::findOrFail($id)->delete();
        $notification = array(
            'message' => '<h3>Delete Successfully</h3>',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

}
