@extends('layouts.master')
@section('pageTitle', 'Edit page')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'page', 'type' => 'Edit', 'iconClass' => 'fa fa-newspaper-o', 'url' =>
  route('pages.index'), 'multiLang' => 'true'])

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('pages.update', $page->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-7 ">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="box-header with-border en">
                <h3 class="box-title "> page Title EN</h3>
              </div>
              <div class="box-header with-border ar">

                <h3 class="box-title "> page Title AR</h3>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">The title for your page</label>
                <input type="text" class="form-control en" id="title_en" name="title_en" id="exampleInputEmail1"
                  placeholder="title en" value="{{$page->title_en}}" required>
                <input type="text" class="form-control ar" name="title_ar" id="exampleInputEmail1"
                  placeholder="title ar" value="{{$page->title_ar}}" required>
              </div>

            </div>
          </div>
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="box-header with-border">
                <h3 class="box-title en"> page Content en</h3>
                <h3 class="box-title ar"> page Content ar</h3>
              </div>
              <div class="form-group en">
                <textarea class="textarea wysiwyg" name="content_en" placeholder="Place some text here"
                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$page->content_en}}</textarea>
              </div>
              <div class="form-group ar">
                <textarea class="textarea wysiwyg" name="content_ar" placeholder="Place some text here"
                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$page->content_ar}}</textarea>
              </div>
            </div>
          </div>
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="box-header with-border">
                <h3 class="box-title en"> Excerpt En </h3>
                <h3 class="box-title ar"> Excerpt Ar </h3>
              </div>
              <div class="form-group en">
                <textarea class="form-control" name="excerpt_en">{{$page->excerpt_en}}</textarea>

              </div>
              <div class="form-group ar">
                <textarea class="form-control" name="excerpt_ar">{{$page->excerpt_ar}}</textarea>

              </div>
            </div>
          </div>

        </div>
        <div class="col-md-5">
          <div class="box box-primary no-border">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-header  bg-yellow">
              <h3 class="box-title">page Details</h3>
            </div>
            <div class="box-body">

              <div class="form-group">
                <label for="exampleInputEmail1">URL slug </label>
                <input type="text" id="slug" value="{{$page->slug}}" name="slug" class="form-control" id="exampleInputEmail1"
                  placeholder="slug">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">page Status </label>
                <select class="form-control" name="status" required>
                  <option {{($page->status == 'published')? 'selected' : ''}} value="published">published</option>
                  <option {{($page->status == 'draft')? 'selected' : ''}} value="draft">draft</option>
                </select>
              </div>

            </div>
          </div>
          <div class="box box-primary no-border">
            <div class="box-header bg-green">
              <h3 class="box-title">page Image</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <img src="{{asset('storage/'.$page->image)}}" height="250" width="100%" alt="">
                <input type="file" name="image" class="form-control" id="exampleInputEmail1">

              </div>
            </div>
          </div>
          <div class="box box-primary no-border">


            <div class="box-header bg-aqua">
              <h3 class="box-title">SEO Content </h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Description </label>
                <textarea class="form-control" name="meta_description">{{$page->meta_description}}</textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Keywords</label>
                <textarea class="form-control" name="meta_keywords">{{$page->meta_keywords}}</textarea>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class=" footer">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </form> <!-- /.row -->
</div>

</section>
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
    <script>
    $('#title_en').on('blur', function(){
            var theTitle    = this.value.toLowerCase().trim(),
                slugInput   = $('#slug'),
                theSlug     = theTitle.replace(/&/g, '-and-')
                                    .replace(/[^a-z0-9-ءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكکگليمنوهی]+/g, '-')
                                    .replace(/\-\-+/g, '-')
                                    .replace(/^-+|-+$/g, '');
                slugInput.val(theSlug); 
        });
    </script>
@endsection