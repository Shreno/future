@extends('layouts.master')
@section('pageTitle', 'Edit category')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'category', 'type' => 'Edit', 'iconClass' => 'fa fa-th', 'url' =>
  route('categories.index'), 'multiLang' => 'true'])

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('categories.update', $category->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-12 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 class="box-title"> Edit category</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">title En</label>
                <label for="exampleInputEmail1" class="ar">title Ar</label>
                <input type="text" name="title_en" value="{{$category->title_en}}" class="form-control en"
                  id="exampleInputEmail1" placeholder="title ">
                <input type="text" name="title_ar" value="{{$category->title_ar}}" class="form-control ar"
                  id="exampleInputEmail1" placeholder="العنوان ">
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">URL slug </label>
                  <input type="text" id="slug" name="slug" value="{{$category->slug}}" class="form-control" id="exampleInputEmail1" placeholder="slug">
                </div>
              <div class=" footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
      </form> <!-- /.row -->
    </div>
  </section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection