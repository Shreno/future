@extends('layouts.master')
@section('pageTitle', 'Edit Status')
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
    @include('layouts._header-form', ['title' => 'Status', 'type' => 'Edit', 'iconClass' => 'fa-bookmark-o', 'url' => route('statuses.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form  action="{{route('statuses.update', $status->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Edit Status</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" name="title" value="{{$status->title}}" id="exampleInputEmail1"
                                    placeholder="Title" >
                                    @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Color status:</label>
                
                                <div class="input-group my-colorpicker2">
                                  <input type="text" class="form-control" name="color" value="{{$status->color}}">
                
                                  <div class="input-group-addon">
                                    <i></i>
                                  </div>
                                </div>
                                <!-- /.input group -->
                              </div>

                              <div class="form-group col-md-3">
                                <label for="delegate_appear">Appear in Delegate</label>
                                <select name="delegate_appear" class="form-control" >
                                        <option value="1" {{$status->delegate_appear == 1 ? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{$status->delegate_appear == 0 ? 'selected' : ''}}>No</option>
                                </select>
                            </div>

                            <!--<div class="form-group col-md-3">-->
                            <!--    <label for="client_appear">Appear in Client</label>-->
                            <!--    <select name="client_appear" class="form-control" >-->
                            <!--            <option value="1" {{$status->client_appear == 1 ? 'selected' : ''}}>Yes</option>-->
                            <!--            <option value="0" {{$status->client_appear == 0 ? 'selected' : ''}}>No</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            
                                     <div class="form-group col-md-6">
                                <label for="restaurant_appear">إظهار للمطعم</label>
                                <select name="restaurant_appear" class="form-control" >
                                        <option value="1" {{$status->restaurant_appear == 1 ? 'selected' : ''}}>Yes</option>
                                  <option value="0" {{$status->restaurant_appear == 0 ? 'selected' : ''}}>No</option>
                                </select>
                            </div>    <div class="form-group col-md-6">
                                <label for="shop_appear">إظهار للمتجر</label>
                                <select name="shop_appear" class="form-control" >
                                  <option value="1" {{$status->shop_appear == 1 ? 'selected' : ''}}>Yes</option>
                                  <option value="0" {{$status->shop_appear == 0 ? 'selected' : ''}}>No</option>
                                  </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea name="description" class="form-control" id="exampleInputEmail1"
                                    placeholder="Description">{{$status->description}}</textarea>
                            </div>

                            <div class=" footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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