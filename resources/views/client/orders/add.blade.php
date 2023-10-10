@extends('layouts.master')
@section('pageTitle', 'Add order')
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('app.order', ['attribute' => '']), 'type' => __('app.add'), 'iconClass' => 'fa-truck', 'url' =>
    route('orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>@lang('app.add') @lang('app.order', ['attribute' => ''])

                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <form action="{{route('orders.store')}}" method="POST">
                @csrf
                <div class="col-sm-6 invoice-col">
                    @lang('app.from') (@lang('app.sender'))
                    <address>
                        <div class="form-group">
                            <label>@lang('app.select', ['attribute' => __('app.address')])</label>
                            <select class="form-control select2" id="sender_address" name="sender_city" required>
                                @if (count($addresses) > 1)
                                <option value="">@lang('app.select', ['attribute' => __('app.address')])</option>
                                @endif
                                @foreach ($addresses as $address)
                                <option value="{{$address->city->id}}" data-city="{{$address->city->title}}"
                                    data-address1="{{$address->address}}" data-address2="{{$address->description}}"
                                    data-phone="{{$address->phone}}">{{$address->address}} | {{$address->city->title}}
                                </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" id="sender_phone"
                                name="sender_phone" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.city')</label>
                            <input type="text" class="form-control" placeholder="City" id="sender_city" readonly
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.address')</label>
                            <input type="text" class="form-control" placeholder="Addres" id="sender_address1"
                                name="sender_address" readonly required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control" id="sender_address_2" name="sender_address_2" readonly
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.ship_date')</label>
                            <input type="date" class="form-control" id="date" name="pickup_date" value=" " placeholder="date"
                                required>
                        </div>
                       
                        <div class="form-group">
                            <label>@lang('app.Number')</label>
                            <input type="number" class="form-control" min="1" value="1" name="number_count"  >
                        </div>
                         <div class="form-group">
                            <label>@lang('app.reference_number')</label>
                            <input type="text" class="form-control"  name="reference_number" value=""  >
                        </div>
                        
                        <div class="form-group">
                            <label>@lang('app.weight')</label>
                            <input type="number" class="form-control" min="0" value="0" name="order_weight"  >
                        </div>
                         
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    @lang('app.to') (@lang('app.receiver'))
                    <address>
                        <div class="form-group">
                            <label>@lang('app.name', ['attribute' => ''])</label>
                            <input type="text" class="form-control" name="receved_name" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.phone')</label>
                            <input type="text" class="form-control" name="receved_phone"  placeholder='رقم الجوال يبدأ ب 966' >
                        </div>
                        <div class="form-group">
                            <label>@lang('app.select', ['attribute' => __('app.city')])</label>
                            <select  class="form-control select2" id="city_id" name="receved_city" required>
                                <option class="" value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                @foreach ($cities as $city)
                                <option  value="{{$city->id}}" {{ $city->id == 101 ? 'selected' : ''}}>{{$city->title}}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="form-group">
                            <label>أختر الحى </label>
                            <select class="form-control select2" id="region_id" name="region_id" required>
                               
                            </select>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label>@lang('app.address')</label>-->
                        <!--    <input type="text" class="form-control"  name="receved_address" placeholder="الرجاء كتابة اسم الحي) ">-->
                        <!--</div>-->
                        <div class="form-group">
                            <label>@lang('app.detials', ['attribute' => __('app.address')])</label>
                            <textarea class="form-control " name="receved_address_2" placeholder="الرجاء كتابه تفاصيل العنوان "></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('app.email')</label>
                            <input type="text" class="form-control" name="receved_email">
                        </div>
                        <div class="form-group">
                            <label>@lang('app.amount')</label>
                            <input type="number" class="form-control" min="0" value="0" name="amount"  >
                        </div>
                        
                        
                        <div class="form-group">
                            <label>@lang('app.order', ['attribute' => __('app.contents')])</label>
                            <textarea class="form-control" name="order_contents"></textarea>
                        </div>
                        <div class="form-group">
                            <label>ملاحظات  </label>
                            <textarea class="form-control" name="receved_notes"></textarea>
                        </div>
                    </address>
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
                        <input type="submit" class="btn btn-success pull-right" value="{{__('app.order', ['attribute' => __('app.add')])}}">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.row -->
   </div>


        <!-- this row will not appear when printing -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(document).ready(()=>{
    var selected =  $("#sender_address").find('option:selected');
var phone = selected.data('phone');
var city = selected.data('city');
var address_1 = selected.data('address1');
var address_2 = selected.data('address2');

$('#sender_phone').val(phone);
$('#sender_city').val(city);
$('#sender_address1').val(address_1);
$('#sender_address_2').val(address_2);
        });
$('#sender_address').on('change', function() {
var selected = $(this).find('option:selected');
var phone = selected.data('phone');
var city = selected.data('city');
var address_1 = selected.data('address1');
var address_2 = selected.data('address2');

$('#sender_phone').val(phone);
$('#sender_city').val(city);
$('#sender_address1').val(address_1);
$('#sender_address_2').val(address_2);

});

$(function () {
         $('.select2').select2()
});
var today = new Date();
var tomorrow = new Date(new Date().getTime()  );

// Set values
$("#date").val(getFormattedDate(today));
$("#date").val(getFormattedDate(tomorrow));
$("#date").val(getFormattedDate(anydate));

// Get date formatted as YYYY-MM-DD
function getFormattedDate (date) {
    return date.getFullYear()
        + "-"
        + ("0" + (date.getMonth() + 1)).slice(-2)
        + "-"
        + ("0" + date.getDate()).slice(-2);
}
</script>


@endsection
