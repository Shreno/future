@extends('layouts.master')
@section('pageTitle', 'Posts')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'post', 'iconClass' => 'fa fa-newspaper-o', 'addUrl' =>
  route('posts.create'), 'multiLang' => 'true'])

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
                  <th>image</th>
                  <th>status</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($posts as $post)
               
                <tr>
                  <th>{{$count}}</th>
                  <td class="en ">{{$post->title_en}}</td>
                  <td class="ar ">{{$post->title_ar}}</td>
                  <td>
                    @if ($post->image)
                    <img src="{{asset('storage/'.$post->image)}}" height="75" width="120">
                    @endif
                  </td>
                  
                  <td>{{$post->status}}</td>
                  <td>{{$post->dateFormatted()}}</td>
                  <td>
                    @if (in_array('edit_post', $permissionsTitle))
                        
                    <a href="{{route('posts.edit', $post->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                    
                    @endif
                    @if (in_array('delete_post', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('posts.destroy', $post->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>  
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
                    <th>image</th>
                    <th>status</th>
                    <th>Created at</th>
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