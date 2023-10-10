@extends('layouts.master')
@section('pageTitle', 'Order : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Order', 'type' => 'Show', 'iconClass' => 'fa-truck', 'url' =>
    route('client-orders.index'), 'multiLang' => 'false'])
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-6 " style="float:right">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> ORDER
                    <small class="pull-right">Created Date: {{$order->created_at}}</small>
                </h2>
            </div>
            <div class="col-xs-6" style="float:left">
                
                <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank"> ارسال دعوة للتقييم</a>
                
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">

            <!-- /.col -->
            <div class="col-sm-12 invoice-col">
                <div class="col-sm-6 ">
                    
                    {!! QrCode::size(150)->generate($order->order_id); !!}
                </div>
                <div class="col-sm-6 ">
                    <b>Order #{{$order->order_id}}</b><br>
                    <br>
                    <b>Tracking ID:</b> {{$order->tracking_id}}<br>
                    <b>Ship Date:</b> {{$order->pickup_date}}<br>
                </div>
            </div>
            <div class="col-sm-6 invoice-col">
                <strong class="h2" style="padding: 15px;">From </strong>
                <address>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Name : </span>{{ ! empty($order->user) ? $order->user->store_name : '' }}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Phone : </span>{{$order->sender_phone}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Email : </span>{{! empty($order->user) ?  $order->user->email : ''}}</p>
                </address>
            </div>
            <!-- /.col -->
          <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
                <strong class="h3" style="padding: 15px;">To </strong>
                <address>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Name : </span>{{$order->receved_name}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Phone : </span> <a href="https://web.whatsapp.com/send?text=السلام عليكم مندوب التوصيل من شركه اون ماب للشحن يرجى ارسال اللوكيشن&phone={{$order->receved_phone}}">{{$order->receved_phone}}</a></p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">City : </span>{{! empty($order->recevedCity) ?  $order->recevedCity->title : ''}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Address : </span>{{$order->receved_address}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Email : </span>{{$order->receved_email}}</p>
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">details Address : </span>{{$order->receved_address_2}}</p>
                          
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">Amount : </span>{{$order->amount}}</p>  
                                
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">Number : </span>{{$order->number_count}}</p>  
                    
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                style="padding-left: 10px">Reference Number : </span>{{$order->reference_number}}</p>            
                                
                            
                    <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                            style="padding-left: 10px">Order Contents : </span>{{$order->order_contents}}</p>
                </address>
            </div>

            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <a class="btn btn-info pull-right" href="{{route('delegate-orders.index')}}"><i class="fa fa-reply-all"></i> Back to Orders</a>
            </div>

        </div>
 
    </section>
    <!-- /.content -->

</div><!-- /.content-wrapper -->
@endsection