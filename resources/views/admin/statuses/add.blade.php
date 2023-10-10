@extends('layouts.master')
@section('pageTitle', 'Add Status')
@section('css') 
<link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">  
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Status', 'type' => 'Add', 'iconClass' => 'fa-bookmark-o', 'url' =>
    route('statuses.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('statuses.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> أضف حالة جديدة</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="name">العنوان</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="Title">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>لون:</label>
                
                                <div class="input-group my-colorpicker2">
                                  <input type="text" class="form-control" name="color">
                
                                  <div class="input-group-addon">
                                    <i></i>
                                  </div>
                                </div>
                                <!-- /.input group -->
                              </div>

                            <div class="form-group col-md-6">
                                <label for="delegate_appear">إظهار للمندوب</label>
                                <select name="delegate_appear" class="form-control" >
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                </select>
                            </div>

                            <!--<div class="form-group col-md-6">-->
                            <!--    <label for="client_appear">Appear in Client</label>-->
                            <!--    <select name="client_appear" class="form-control" >-->
                            <!--            <option value="1">Yes</option>-->
                            <!--            <option value="0">No</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                                <div class="form-group col-md-6">
                                <label for="restaurant_appear">إظهار للمطعم</label>
                                <select name="restaurant_appear" class="form-control" >
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                </select>
                            </div>    <div class="form-group col-md-6">
                                <label for="shop_appear">إظهار للمتجر</label>
                                <select name="shop_appear" class="form-control" >
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">الوصف</label>
                                <textarea name="description" class="form-control" id="exampleInputEmail1"
                                    placeholder="Description"></textarea>
                            </div>

                            

                            

                            <div class=" footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
</script>
<script>
$(function () {
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    
  })
</script>
@endsection