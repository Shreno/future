@extends('layouts.master')
@section('pageTitle', 'Add branch')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'branch', 'type' => 'Add', 'iconClass' => 'fa fa-map', 'url' =>
  route('branches.index'), 'multiLang' => 'true'])


  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('branches.store')}}" method="POST">
        @csrf

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
                <input type="text" name="title_en" class="form-control en" id="exampleInputEmail1" placeholder="title ">
                <input type="text" name="title_ar" class="form-control ar" id="exampleInputEmail1"
                  placeholder="العنوان ">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">address En</label>
                <label for="exampleInputEmail1" class="ar">address Ar</label>
                <textarea class="form-control en" name="address_en" id="exampleInputEmail1"></textarea>
                <textarea class="form-control ar" name="address_ar" id="exampleInputEmail1"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1"></input>
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">Phone</label>
                  <input type="text" class="form-control" name="phone" id="exampleInputEmail1"></input>
              </div>
              <div class=" footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form> <!-- /.row -->
    </div>
  </section>

</div><!-- /.content-wrapper -->
@endsection