@extends('layouts.master')
@if($client->work==1)

@section('pageTitle', 'تعديل المتجر')
@else
@section('pageTitle', 'تعديل المطعم')



@endif
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
    @if($client->work==1)

    @include('layouts._header-form', ['title' => 'المتجر', 'type' => 'تعديل', 'iconClass' => 'fa-black-tie', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @else

    @include('layouts._header-form', ['title' => 'المطعم', 'type' => 'تعديل', 'iconClass' => 'fa-black-tie', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @endif


    <!-- Main content -->
    <section class="content">

        <div class="row">
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


            <div class="col-md-10 col-md-offset-1">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#member" data-toggle="tab"><i class="fa fa-id-card"></i> المعلومات
                                الرئيسة
                            </a></li>
                        <li><a href="#bank" data-toggle="tab"><i class="fa fa-money"></i> معلومات البنك</a></li>
                        <li><a href="#setting" data-toggle="tab"><i class="fa fa-usd"></i> التوصيل</a></li>
                        <li><a href="#statuses" data-toggle="tab"><i class="fa fa-bookmark"></i> أعدادات الحالات</a>
                        </li>
                        <li><a href="#files" data-toggle="tab"><i class="fa fa-bookmark"></i> المرفقات</a>
                        </li>


                    </ul>

                    <form action="{{route('clients.update', $client->id)}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-xs-12">

                            <div class="active tab-pane col-xs-12" id="member">

                                <input type="hidden" value="{{$client->work}}" name="work">
                                <input type="hidden" min="0" value="15" name="tax" class="form-control"
                                    placeholder="Tax">

                              

                                <div class="col-xs-12 form-group">
                                    <label for="store name" class="control-label">
                                        @if($client->work==1)

                                        * اسم المتجر
                                        @elseif($client->work==2)
                                        * اسم المطعم

                                        @endif

                                    </label>

                                    <div class="">
                                        <input type="text" name="store_name" class="form-control" id="store name"
                                            placeholder="store name" value="{{$client->store_name}}" required>
                                        @error('store_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label">أسم المدير *</label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="full name" value="{{$client->name}}" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label">البريد الإلكترونى *</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="Email" value="{{$client->email}}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الرقم الضريبى</label>

                                    <div class="">
                                        <input value="{{$client->tax_Number}}" type="text" min="0" class="form-control"
                                            name="tax_Number"
                                            placeholder="الرقم الضريبي يتكون من 15 رقم يبدا 3 و ينتهى 3">
                                        @error('tax_Number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label">الهاتف</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            value="{{$client->phone}}" placeholder="phone">
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="website" class="control-label">الموقع</label>

                                    <div class="">
                                        <input type="text" name="website" class="form-control" id="website"
                                            value="{{$client->website}}" placeholder="website">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="lastname" class="control-label">المدينة *</label>
                                    <div class="">
                                        <select class="form-control select2" name="city_id" required>
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                            <option {{($client->city_id == $city->id) ? 'selected' : ''}}
                                                value="{{$city->id}}">
                                                {{$city->title}}</option>
                                            @endforeach

                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <h4><i class="fa fa-key"></i> Password Area</h4>
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">الرقم السري *</label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="password-confirm" class="control-label">تأكيد الرقم السري *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="num_branches" class="control-label"> عدد الفروع </label>

                                    <div class="">
                                        <input value="{{$client->num_branches}}" id="num_branches" type="number"
                                            class="form-control" placeholder="أدخل عدد الفروع " name="num_branches">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label"> فترة الدفع</label>

                                    <div class="">
                                        <select name="Payment_period
                                   " class="form-control select2" required>
                                            @if($client->Payment_period==1)

                                            <option selected value="1">يومى</option>
                                            <option value="2">أسبوعى</option>
                                            <option value="3">شهرى</option>



                                            @elseif($client->Payment_period==2)
                                            <option value="1">يومى</option>

                                            <option selected value="2">أسبوعى</option>
                                            <option value="3">شهرى</option>



                                            @else
                                            <option value="1">يومى</option>

                                            <option value="2">أسبوعى</option>
                                            <option selected value="3">شهرى</option>


                                            @endif

                                        </select>

                                        @error('work')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class=" tab-pane col-xs-12" id="bank">

                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">أسم البنك</label>

                                    <div class="">
                                        <input type="text" name="bank_name" class="form-control" id=""
                                            value="{{$client->bank_name}}" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">رقم الحساب</label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id=""
                                            value="{{$client->bank_account_number}}" placeholder="Account Number">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الأيبان</label>

                                    <div class="">
                                        <input type="text" name="bank_swift" class="form-control" id=""
                                            value="{{$client->bank_swift}}" placeholder="Swift Code">
                                    </div>
                                </div>


                            </div>

                            <div class=" tab-pane col-xs-12" id="setting">

                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label">سعر الشحن داخل المدينة*</label>

                                    <div class="">
                                        <input type="number" min="0" class="form-control" name="cost_inside_city"
                                            value="{{$client->cost_inside_city}}" placeholder="Cost inside same City"
                                            required>
                                        @error('cost_inside_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                  

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">Cost Outside City *</label>

                                        <div class="">
                                            <input type="number" min="0" class="form-control" name="cost_outside_city"
                                   
                                            value="{{$client->cost_outside_city}}" placeholder="Cost Outside City"
                                                required>
                                            @error('cost_outside_city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                               <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">Cost For Reshipping In the same City
                                            *</label>

                                        <div class="">
                                            <input type="number" min="0" name="cost_reshipping" class="form-control"
                                                value="{{$client->cost_reshipping}}" placeholder="Cost For Reshipping">
                                            @error('cost_reshipping')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                               <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">Cost For Reshipping Outside City * سعر اعاده
                                            الشحن </label>
                                        <div class="">
                                            <input type="number" min="0" name="cost_reshipping_out_city"
                                                class="form-control" placeholder="Cost For Reshipping"
                                                value="{{$client->cost_reshipping_out_city}}">
                                            @error('cost_reshipping_out_city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">fees for (cash on delivery in same city) *
                                            رسوم عند الدفع
                                            عند التسليم داخل المدينة</label>

                                        <div class="">
                                            <input type="number" min="0" name="fees_cash_on_delivery"
                                                class="form-control"
                                                placeholder="fees for (cash on delivery) in the same city"
                                                value="{{$client->fees_cash_on_delivery}}" required>
                                            @error('fees_cash_on_delivery')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">fees for (cash on delivery Outside) * رسوم
                                            عند الدفع عند
                                            التسليم خارج المدينة</label>

                                        <div class="">
                                            <input type="number" min="0" name="fees_cash_on_delivery_out_city"
                                                value="{{$client->fees_cash_on_delivery_out_city}}" class="form-control"
                                                placeholder="fees for (cash on delivery) out city" required>
                                            @error('fees_cash_on_delivery')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 



                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">سعر استلام الطلبات من المتجر </label>

                                        <div class="">
                                            <input type="number" min="0" class="form-control"
                                                value="{{$client->pickup_fees}}" name="pickup_fees"
                                                placeholder="Cost Collect Orders" required>
                                            @error('pickup_fees')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label"> سعر الكيلو الزائد عن المحدد داخل
                                            المدينه</label>

                                        <div class="">
                                            <input type="number" min="0" class="form-control"
                                                value="{{$client->over_weight_per_kilo}}" name="over_weight_per_kilo"
                                                placeholder="Over weight Price Per Kilo" required>
                                            @error('over_weight_per_kilo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label"> سعر الكيلو الزائد عن المحدد خارج
                                            المدينه</label>

                                        <div class="">
                                            <input type="number" min="0" class="form-control"
                                                value="{{$client->over_weight_per_kilo_outside}}"
                                                name="over_weight_per_kilo_outside"
                                                placeholder="Over weight Price Per Kilo" required>
                                            @error('over_weight_per_kilo_outside')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">الوزن المثالي داخل المدينه </label>
                                        <div class="">
                                            <input type="number" min="0" value="{{$client->standard_weight}}"
                                                class="form-control" name="standard_weight"
                                                placeholder="Standard weight" required>
                                            @error('standard_weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-6 form-group">
                                        <label for="" class="control-label">الوزن المثالي خارج المدينه </label>
                                        <div class="">
                                            <input type="number" min="0" value="{{$client->standard_weight_outside}}"
                                                class="form-control" name="standard_weight_outside"
                                                placeholder="Standard weight Outside" required>
                                            @error('standard_weight_outside')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                            </div>
                            <div class=" tab-pane col-xs-12" id="statuses">
                             

                                <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">status after saving an order
                                            *</label>
                                        <div class="">
                                            <select class="form-control" name="default_status_id" required>
                                                <option value="">Select Status</option>
                                                @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach
                                               

                                            </select>
                                            @error('default_status_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                 </div> 
                                

                                <div class="col-xs-12 form-group">
                                    <label for="lastname" class="control-label">start to calculate shipping cost (In
                                        city) from
                                        this
                                        status *</label>
                                    <div class="">
                                        <select class="form-control" name="cost_calc_status_id" required>
                                            <option value="">Select Status</option>
                                            @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                        </select>
                                        @error('cost_calc_status_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">start to calculate shipping cost
                                            (outside city) from
                                            this
                                            status *</label>
                                        <div class="">
                                            <select class="form-control" name="cost_calc_status_id_outside" required>
                                                <option value="">Select Status</option>
                                             @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('cost_calc_status_id_outside')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">start to calculate fees for (cash on
                                            delivery) from
                                            this
                                            status *</label>
                                        <div class="">
                                            <select class="form-control" name="calc_cash_on_delivery_status_id"
                                                required>
                                                <option value="">Select Status</option>
                                                @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('calc_cash_on_delivery_status_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">start to calculate reshipping cost
                                            from
                                            this status *</label>
                                        <div class="">
                                            <select class="form-control" name="cost_reshipping_calc_status_id" required>
                                                <option value="">Select Status</option>
                                                @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('cost_reshipping_calc_status_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 
                                   <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">available edit and update order in
                                            this
                                            status *</label>
                                        <div class="">
                                            <select class="form-control" name="available_edit_status" required>
                                                <option value="">Select Status</option>
                                              @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('available_edit_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                 <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">available delete order in this
                                            status *</label>
                                        <div class="">
                                            <select class="form-control" name="available_delete_status" required>
                                                <option value="">Select Status</option>
                                             @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('available_delete_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-12 form-group">
                                        <label for="available_overweight_status" class="control-label">overweight price
                                            (In City)
                                            calculate in this status * الحاله الخاصه بحساب سعر الوزن الزائد </label>
                                        <div class="">
                                            <select class="form-control" name="available_overweight_status" required>
                                                <option value="">Select Status</option>
                                               @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('available_overweight_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 

                                 <div class="col-xs-12 form-group">
                                        <label for="available_overweight_status_outside"
                                            class="control-label">overweight price (Outside
                                            City) calculate in this status * الحاله الخاصه بحساب سعر الوزن الزائد
                                        </label>
                                        <div class="">
                                            <select class="form-control" name="available_overweight_status_outside"
                                                required>
                                                <option value="">Select Status</option>
                                               @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('available_overweight_status_outside')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> 



                                 <div class="col-xs-12 form-group">
                                        <label for="available_collect_order_status" class="control-label"> Collect
                                            Orders in this status
                                            * الحاله الخاصه بحساب سعر استلام الشحنه من العميل </label>
                                        <div class="">
                                            <select class="form-control" name="available_collect_order_status" required>
                                                <option value="">Select Status</option>
                                             @foreach ($statuses as $status)
                                                    @if($client->work==1)
                                                     @if($status->shop_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option>@endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option
                                                    {{($client->default_status_id == $status->id) ? 'selected' : ''}}
                                                    value="{{$status->id}}">{{$status->title}}</option> @endif
                                                    
                                                    
                                                    @endif
                                                    @endforeach

                                            </select>
                                            @error('available_collect_order_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                </div>
                            </div>
                            <div class=" tab-pane col-xs-12" id="files">

                            <div class="col-xs-6 form-group">
                                @if($client->Tax_certificate !=NULL)
                                <a href="{{asset('storage/'.$client->Tax_certificate)}}"><img style="height: 50px;width:50px" src="{{asset('storage/'.$client->Tax_certificate)}}" alt=""></a>


                                @endif
                                
                                    <label for="Tax_certificate" class="control-label">   الشهادة الضريبة </label>
                                    <div class="">
                                        <input type="file" name="Tax_certificate" id="">
                                       
                                        @error('Tax_certificate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-6 form-group">
                                @if($client->commercial_register !=NULL)
                                <a href="{{asset('storage/'.$client->commercial_register)}}"><img style="height: 50px;width:50px" src="{{asset('storage/'.$client->commercial_register)}}" alt=""></a>


                                @endif
                                    <label for="commercial_register" class="control-label">    السجل التجارى </label>
                                    <div class="">
                                        <input type="file" name="commercial_register" id="">
                                       
                                        @error('commercial_register')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                </div>
                </form>

                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>

@endsection