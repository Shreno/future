@extends('layouts.master')
@section('pageTitle', 'categories')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'category', 'iconClass' => 'fa fa-th', 'addUrl' =>
  route('categories.create'), 'multiLang' => 'true'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>title</th>
                  <th>Created at </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($categories as $category)

                <tr>
                  <th>{{$count}}</th>
                  <td class="en ">{{$category->title_en}}</td>
                  <td class="ar ">{{$category->title_ar}}</td>
                  <td>{{$category->dateFormatted()}}</td>
                  <td>
                    @if (in_array('edit_category', $permissionsTitle))

                    <a href="{{route('categories.edit', $category->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                    @endif
                    @if (in_array('delete_category', $permissionsTitle))
                    <a href="{{route('categories.confirm', $category->id)}}" title="Delete"
                      class="btn btn-sm btn-danger pull-right" style="margin: 2px;"><i class="fa fa-times"></i> <span
                        class="hidden-xs hidden-sm">Delete</span></a>
                    @endif


                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>title</th>
                  <th>Created at </th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection