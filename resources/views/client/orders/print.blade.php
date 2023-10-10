@extends('layouts.master')
@section('pageTitle', 'Order : #')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.view'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])
    <!-- Main content -->
    <style>
      .page-logo{
    display:none;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 25px
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: RIGHT;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
span.h4 {
    float: right;
    highet:60px;
}

      @media print {
   .page-header {display:none;}
      .page-logo{
    display:block;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
 margin-bottom: 25px
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: RIGHT;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
span.h4 {
    float: right;
    highet:60px;
}


@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
.main-footer{display:none;}
.printhidden{display:none;}
#send-notification{display:none;}
}

  </style>
  
    <hr>
    
    <section class="invoice">
        <!-- this row will not appear when printing -->
        <div class="row no-print pull-left">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i> @lang('app.print')</a>
                
               
            </div>
        </div>        
        @if(! empty($orders) && count($orders) > 0)
        @foreach($orders as $order)
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                
                  <h2 class="page-logo text-center" >
                    <img src="https://www.onmap.sa/public/storage/website/logo/r93QyitpMa3ZswnJIW6dSh2hkk5DtwfYo342SYTu.png" class="img-responsive" style="padding-right:15px"/>
            </h2>
            </div>
            <!-- /.col -->
        </div>
          <div class="row invoice-info">

            <!-- /.col -->
            <div class="col-sm-12 invoice-col">
                
                <div class="col-sm-6 ">
                    {{-- <img src="https://www.onmap.sa/public/storage/website/logo/r93QyitpMa3ZswnJIW6dSh2hkk5DtwfYo342SYTu.png"
                        class="img-responsive" width="150" /> --}}
                    {!! QrCode::size(150)->generate($order->order_id); !!}
                </div>
                <div class="col-sm-6 ">
                    <b>@lang('app.order', ['attribute' => '']) #{{$order->order_id}}</b><br>
                    <br>
                    <b>@lang('app.tracking_id'):</b> {{$order->tracking_id}}<br>
                    <b>@lang('app.ship_date'):</b> {{$order->pickup_date}}<br>
                    
                    
                </div>
            </div>
                       <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
                
             <table>
  <tr>
    <th>اسم المتجر</th>
    <th> {{$order->user->store_name}}</th>
   
  </tr>
   <tr>
    <th>رقم الجوال</th>
    <th>{{ $order->sender_phone }}</th>
    
  </tr>
   <tr>
    <th>العنوان</th>
    <th>{{ $order->sender_address }}</th>
    
  </tr>
     <tr>
    <th>الرقم المرجعى</th>
    <th>{{$order->reference_number}}</th>
  </tr>
   <tr>
    <th>محتوى الطلب</th>
    <th>{{$order->order_contents}}</th>
    
  </tr>
     <tr>
    <th>عدد القطع</th>
    <th>  {{$order->number_count}}</th>
    
  </tr>
</table>
            </div>
         
            <!-- /.col -->
            <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
               
               <table>
  <tr>
    <th>اسم العميل</th>
    <th> {{$order->receved_name}}</th>
   
  </tr>
   <tr>
    <th>رقم الجوال</th>
    <th>{{ $order->receved_phone }}</th>
    
  </tr>
   <tr>
    <th>المدينة</th>
    <th>{{! empty($order->recevedCity) ? $order->recevedCity->title : ''}}</th>
    
  </tr>
     <tr>
    <th>العنوان</th>
    <th>{{$order->receved_address}}</th>
  </tr>
   <tr>
    <th>تفاصيل العنوان</th>
    <th>{{$order->receved_address_2}}</th>
    
  </tr>
     <tr>
    <th>مبلغ الدفع عند الاستلام</th>
    <th>  {{$order->amount}}</th>
    
  </tr>
</table>
            </div>

            <!-- /.col -->
        </div>
        
        @endforeach
        @endif
        <!-- /.row -->
        
    </section>

</div><!-- /.content-wrapper -->
@endsection
