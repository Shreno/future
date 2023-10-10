@extends('layouts.master')
 
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
 
    <!-- Main content -->
    <section class="content">
<div class="col-md-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="nav-tabs-custom">
                                        <form  enctype="multipart/form-data"  action="{{route('clients.store')}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf
                  <input type="hidden" min="0" value="15" name="tax" class="form-control" placeholder="Tax" > 

                  @if($work==1)

                  <input type="hidden" value="1" name="work">

                  @elseif($work==2)
                  <input type="hidden" value="2" name="work">
                  @endif
                  
                    <ul class="nav nav-tabs" >
                        <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i class="fa fa-shop"></i>بيانات العميل</a></li>
                        <li class=""><a href="#setting" data-toggle="tab" aria-expanded="false"><i class="fa fa-usd"></i> بيانات التسجيل</a></li>
                        <li class=""><a href="#statuses" data-toggle="tab" aria-expanded="false"><i class="fa fa-bookmark"></i>الدفع</a></li>
                        . <li class=""><a href="#address" data-toggle="tab" aria-expanded="false"><i class="fa fa-bookmark"></i> االتكلفة </a></li>
                        <li><a href="#provider" data-toggle="tab"><i class="fa fa-bookmark"></i> المرفقات</a>
                    </li></ul>
                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="bank">
                               <div class="col-xs-12 form-group">
                                    <label for="store name" class="control-label">
                                    @if($work==1)

                                        *  اسم المتجر 
                                        @elseif($work==2)
                                        *  اسم المطعم 

                                        @endif

                                    </label>

                                    <div class="">
                                        <input type="text" name="store_name" class="form-control" id="store name"
                                            placeholder="name" required>
                                            @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                          <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label">  * اسم  المدير</label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="أدخل أسم المدير" required>
                                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                
                                 <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">الرقم الضريبى</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="tax_Number"
                                            placeholder="الرقم الضريبي يتكون من 15 رقم يبدا 3 و ينتهى 3" >
                                            @error('tax_Number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                 <div class="col-xs-12 form-group">
                                    <label for="website" class="control-label">رابط الموقع</label>

                                    <div class="">
                                        <input type="text" name="website" class="form-control" id="website"
                                            placeholder="website">
                                    </div>
                                </div>
                                 <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label"> * المدينة</label>
                                        <div class="">
                                            <select class="form-control select2" name="city_id" required>
                                                <option value="">Select City</option>
                                                @foreach ($cities as $city)
                                                <option value="{{$city->id}}">{{$city->title}}</option>
                                                @endforeach
    
                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                    <label for="num_branches" class="control-label">   عدد الفروع </label>

                                    <div class="">
                                        <input id="num_branches" type="number" class="form-control"
                                            placeholder="أدخل عدد الفروع " name="num_branches" >
                                    </div>
                                </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="setting">
                             <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label"> رقم الجوال</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="phone">
                                    </div>
                                </div>
                                     <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label"> * البريد الالكتروني</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="Email" required>
                                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                    
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">password * كلمة المرور </label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="password" required>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="password-confirm" class="control-label"> * تاكيد كلمه المرور </label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation" required>
                                    </div>
                                </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="statuses">

                                 <div class="col-xs-12 form-group">
                                         <label for="firstname" class="control-label">  فترة الدفع</label>
                                    <div class="">
                                        <select name="Payment_period" class="form-control select2" required>
                                                <option value="1">يومى</option>
                                                <option value="2">أسبوعى</option>
                                                <option value="3">شهرى</option>
                                    
                                            </select>
                                    
                                            @error('work')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> أسم البنك</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="bank_name"
                                            placeholder="Enter the name of bank" >
                                            @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label">رقم الحساب</label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id=""
                                        value=""  placeholder="Account Number">
                                        @error('bank_account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                                    <label for="" class="control-label"> ايبان</label>

                                    <div class="">
                                        <input type="text" min="0" class="form-control" name="bank_swift"
                                            placeholder="Enter the bank swift code" >
                                            @error('bank_swift')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                </div>
                       
                          
                        </div>
                        <div class="tab-pane" id="address">
                            
                                        <div class="col-xs-6 form-group">
                                            @if($work==1)
                                            <label for="" class="control-label">السعر  داخل المدينة</label>
        
        
                                            @else
                                            <label for="" class="control-label">   سعر التوصيل</label>
        
        
                                            @endif
        
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="cost_inside_city"
                                                    placeholder="Cost inside same City" required>
                                                    @error('cost_inside_city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                            </div>
                                        </div>
                                           
                                            @if($work==1)
                                     <div class="col-xs-6 form-group">
                                            <label for="" class="control-label"> * السعر خارج المدينة </label>
        
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="cost_outside_city"
                                                    placeholder="Cost Outside City" required>
                                                    @error('cost_outside_city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
        
                                    <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">Cost For Reshipping In the same City *  سعر اعاده الشحن </label>
                                            <div class="">
                                                <input type="number" min="0" name="cost_reshipping" class="form-control"
                                                    placeholder="Cost For Reshipping">
                                                    @error('cost_reshipping')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                          <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">Cost For Reshipping Outside City *  سعر اعاده الشحن </label>
                                            <div class="">
                                                <input type="number" min="0" name="cost_reshipping_out_city" class="form-control"
                                                    placeholder="Cost For Reshipping">
                                                    @error('cost_reshipping_out_city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                           <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">fees for (cash on delivery in same city) * رسوم عند الدفع عند التسليم  داخل المدينة</label>
        
                                            <div class="">
                                                <input type="number" min="0" name="fees_cash_on_delivery" class="form-control"
                                                    placeholder="fees for (cash on delivery) in the same city" required>
                                                    @error('fees_cash_on_delivery')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                          
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">fees for (cash on delivery Outside) * رسوم عند الدفع عند التسليم  خارج المدينة</label>
        
                                            <div class="">
                                                <input type="number" min="0" name="fees_cash_on_delivery_out_city" class="form-control"
                                                    placeholder="fees for (cash on delivery) out city" required>
                                                    @error('fees_cash_on_delivery')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                    
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">سعر استلام  الطلبات من المتجر    </label>
        
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="pickup_fees"
                                                    placeholder="Cost Collect Orders" required>
                                                    @error('pickup_fees')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label"> سعر الكيلو الزائد عن المحدد داخل المدينه</label>
        
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="over_weight_per_kilo"
                                                    placeholder="Over weight Price Per Kilo" required>
                                                    @error('over_weight_per_kilo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label"> سعر الكيلو الزائد عن المحدد خارج المدينه</label>
        
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="over_weight_per_kilo_outside"
                                                    placeholder="Over weight Price Per Kilo" required>
                                                    @error('over_weight_per_kilo_outside')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">الوزن المثالي داخل المدينه   </label>
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="standard_weight"
                                                    placeholder="Standard weight" required>
                                                    @error('standard_weight')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">الوزن المثالي خارج المدينه   </label>
                                            <div class="">
                                                <input type="number" min="0" class="form-control" name="standard_weight_outside"
                                                    placeholder="Standard weight Outside" required>
                                                    @error('standard_weight_outside')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                            @else
        
                                               <input type="hidden"  value="0" min="0" class="form-control" name="cost_outside_city"
                                                    placeholder="Cost Outside City" >
                                                    <input type="hidden" value="0" min="0" name="cost_reshipping" class="form-control"
                                                    placeholder="Cost For Reshipping">
                                                     <input type="hidden" value="0" min="0" name="cost_reshipping_out_city" class="form-control"
                                                    placeholder="Cost For Reshipping">
                                                    
                                                       <div class="col-xs-6 form-group">
                                            <label for="" class="control-label">رسوم دفع عند الاستلام</label>
        
                                            <div class="">
                                                <input type="number" min="0" name="fees_cash_on_delivery" class="form-control"
                                                    placeholder="fees for (cash on delivery) in the same city" required>
                                                    @error('fees_cash_on_delivery')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                            @endif
        


         
                                       
                                        
                                      
                                      
                                 
        
        
                                        <div class="col-xs-12 form-group">
                                            <label for="lastname" class="control-label">start to calculate shipping cost  (in city) from this
                                                status * يحسب تكلفه التوصيل</label>
                                            <div class="">
                                                <select class="form-control" name="cost_calc_status_id" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                        <!---->
                                        <!---->
                        
                                        <div class="col-xs-12 form-group">
                                            <label for="lastname" class="control-label">status after saving an order * حفظ الطلب عند الحالة</label>
                                            <div class="">
                                                <select class="form-control" name="default_status_id" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="lastname" class="control-label">start to calculate shipping cost (outside city)  from
                                                this
                                                status *</label>
                                            <div class="">
                                                <select class="form-control" name="cost_calc_status_id_outside" required>
                                                    <option value="">Select Status</option>
                                                   @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="lastname" class="control-label">start to calculate reshipping cost from this status * تكلفه اعاده الشحن مره اخرى </label>
                                            <div class="">
                                                <select class="form-control" name="cost_reshipping_calc_status_id" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="lastname" class="control-label">start to calculate fees for (cash on delivery) from this
                                                status * يحسب تكلفه استلام المبلغ من العميل</label>
                                            <div class="">
                                                <select class="form-control" name="calc_cash_on_delivery_status_id" required>
                                                    <option value="">Select Status</option>
                                                   @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="lastname" class="control-label">available edit and update order in this status * الحاله الخاصه بالتعديل على الطلب     </label>
                                            <div class="">
                                                <select class="form-control" name="available_edit_status" required>
                                                    <option value="">Select Status</option>
@foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="lastname" class="control-label">available delete order in this status * الحاله الخاصه بحذف الطلب عند المتجر لو مفيش   الاولى </label>
                                            <div class="">
                                                <select class="form-control" name="available_delete_status" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="available_overweight_status" class="control-label">overweight price  (In City) calculate in this status * الحاله الخاصه بحساب سعر الوزن الزائد     </label>
                                            <div class="">
                                                <select class="form-control" name="available_overweight_status" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="available_overweight_status_outside" class="control-label">overweight price (Outside City) calculate in this status * الحاله الخاصه بحساب سعر الوزن الزائد     </label>
                                            <div class="">
                                                <select class="form-control" name="available_overweight_status_outside" required>
                                                    <option value="">Select Status</option>
                                                    @foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                                            <label for="available_collect_order_status" class="control-label"> Collect Orders in this status * الحاله الخاصه بحساب سعر استلام الشحنه من العميل     </label>
                                            <div class="">
                                                <select class="form-control" name="available_collect_order_status" required>
                                                    <option value="">Select Status</option>
@foreach ($statuses as $status)
                                                    @if($work==1)
                                                     @if($status->shop_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    @else
                                                    @if($status->restaurant_appear==1)

                                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                                    @endif
                                                    
                                                    
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
                        <div class="tab-pane" id="provider">
                                   <div class="col-xs-6 form-group">
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
                    <!-- /.tab-content -->
                          <div class=" footer col-lg-12">
                                <button type="submit" class="btn btn-primary">تسجيل</button>
                            </div>
                     </form>
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
 
 
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>

@endsection