@extends('layouts.master')
@section('pageTitle', 'Order : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.view'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])
    <!-- Main content -->
  

  </style>
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header no-print">
                    <i class="fa fa-globe"></i> @lang('app.order', ['attribute' => ''])
                    <small class="pull-right">@lang('app.date'): {{$order->dateFormatted()}}</small>
                </h2>
                  <h2 class="page-logo text-center" >
                    <img src="https://www.onmap.sa/public/storage/website/logo/r93QyitpMa3ZswnJIW6dSh2hkk5DtwfYo342SYTu.png" class="img-responsive" style="padding-right:15px"/>
            </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
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
                    
                    <b>@lang('app.weight'):   {{$order->order_weight}}</b>
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
        <!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i> @lang('app.print')</a>
                <button type="button" class="btn btn-warning pull-center" data-toggle="modal"
                data-target="#send-notification">
                <i class="fa fa-bell"></i>
                    @lang('app.notifications', ['attribute' => __('app.send')])
            </button>
                @if (Auth()->user()->available_edit_status == $order->status_id)
                <a href="{{route('orders.edit', $order->id)}}" class="btn btn-success pull-right printhidden"><i class="fa fa-credit-card"></i> @lang('app.order', ['attribute' => __('app.edit')])
                </a>
                @endif
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="modal fade" id="send-notification">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> @lang('app.notifications', ['attribute' => __('app.send')])</h4>
                    </div>
                    <form action="{{route('notifications.store')}}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="name">@lang('app.title')</label>
                                <input type="text" class="form-control" name="title" placeholder="@lang('app.title')" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('app.message')</label>
                                <textarea rows="3" class="form-control" name="message" placeholder="@lang('app.message')" required></textarea>

                            </div>
                            <input type="hidden" name="notification_from" value="{{Auth()->user()->id}}">
                            <input type="hidden" name="notification_type" value="order">
                            <input type="hidden" name="notification_to_type" value="admin">
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('app.close')</button>
                            <button type="submit" class="btn btn-primary">@lang('app.send')</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div><!-- /.content-wrapper -->
@endsection
