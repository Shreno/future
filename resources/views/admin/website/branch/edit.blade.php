@extends('layouts.master')
@section('pageTitle', 'Edit branch')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'branch', 'type' => 'Edit', 'iconClass' => 'fa fa-first-order', 'url' =>
  route('branches.index'), 'multiLang' => 'true'])

  <!-- Main content -->
  <section class="content">
    <div class="row">

        <form role="form" action="{{route('branches.update', $branch->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-12 col-xs-12">
              <!-- general form elements -->
              <div class="box box-primary" style="padding: 10px;">
                <div class="box-header with-border">
                  <h3 class="box-title"> Add branch</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="en">title En</label>
                    <label for="exampleInputEmail1" class="ar">title Ar</label>
                    <input type="text" name="title_en" class="form-control en" value="{{$branch->title_en}}" id="exampleInputEmail1" placeholder="title ">
                    <input type="text" name="title_ar" class="form-control ar" value="{{$branch->title_ar}}" id="exampleInputEmail1"
                      placeholder="العنوان ">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1" class="en">address En</label>
                    <label for="exampleInputEmail1" class="ar">address Ar</label>
                    <textarea class="form-control en" name="address_en" id="exampleInputEmail1">{{$branch->address_en}}</textarea>
                    <textarea class="form-control ar" name="address_ar" id="exampleInputEmail1">{{$branch->address_ar}}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" value="{{$branch->email}}" id="exampleInputEmail1"></input>
                  </div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Phone</label>
                      <input type="text" class="form-control" name="phone" value="{{$branch->phone}}" id="exampleInputEmail1"></input>
                  </div>
                  <div class=" footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </form> 
    </div>
  </section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection