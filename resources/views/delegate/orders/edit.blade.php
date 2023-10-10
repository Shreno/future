@extends('layouts.master')
@section('pageTitle', 'Order')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'order', 'type' => 'edit', 'iconClass' => 'fa-truck', 'url' =>
    route('delegate-orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                    <div class="col-sm-12 invoice-col">
                            <div class="col-sm-6 ">
                                <b>Order #{{$order->order_id}}</b><br>
                                <b>Ship Date:</b> {{$order->pickup_date}}<br>
                            </div>
                            <div style="background-color:{{$order->status->color}}" class="col-sm-6 pull-right">
                                <b>Status:</b> {{$order->status->title}}<br>
                            </div>
                            <br><br>
                            <br>
                            <br>
                        </div>
                    <div class="col-sm-6 invoice-col">
                            <strong class="h2" style="padding: 15px;">From </strong>
                            <address>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Name : </span>{{Auth()->user()->store_name}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Phone : </span>{{$order->sender_phone}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Email : </span>{{Auth()->user()->email}}</p>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 invoice-col">
                            <strong class="h2" style="padding: 15px;">To </strong>
                            <address>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Name : </span>{{$order->receved_name}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Phone : </span>{{$order->receved_phone}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">City : </span>{{! empty($order->recevedCity) ? $order->recevedCity->title : '' }}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Address : </span>{{$order->receved_address}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">Email : </span>{{$order->receved_email}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">details Address : </span>{{$order->receved_address_2}}</p>
                            </address>
                        </div>
            </div>
            <!-- /.col -->
        </div>
        @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
          <div class="row invoice-info">
            <form action="{{route('delegate-orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-12 invoice-col">
                        <div class="form-group col-md-4">
                            <select class="form-control" id="status_id" name="status_id" required>
                                <option value="">Select status</option>
                                @foreach ($statuses as $status)
                                <option value="{{$status->id}}" >{{$status->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" value="Change Status">
                        
                </div>
            </form>
        </div>  
        @endif
        <!-- info row -->
        
        <!-- /.row -->



        <!-- this row will not appear when printing -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection