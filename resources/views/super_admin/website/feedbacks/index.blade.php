@extends('layouts.master')
@section('pageTitle', 'contacts')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-index', ['title' => 'feedbacks', 'iconClass' => 'fa-envelope-o', 'addUrl' => '', 'multiLang' => 'false'])

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
                  <th>Sender Name</th>
                  <th>Sender Mobile</th>
                  <th>Sender Address</th>
                  
                  <th>Receiver Name</th>
                  <th>Receiver Mobile</th>
                  <th>Receiver Address</th>
                  
                  <th>Content</th>
                  
                  <th>date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($contacts as $contact)
                <tr>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$count}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->sender_name}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->sender_mobile}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->sender_address}}</td>
                  
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->receiver_name}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->receiver_mobile}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->receiver_address}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->content}}</td>
                  <td style="{{($contact->is_readed == 0)? 'font-weight: bold' : ''}}">{{$contact->dateFormatted()}}</td>
                  <td>
                  
                    <a href="{{route('feedbacks.show', $contact->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">View</span> </a>
               
                    <form class="pull-right" style="display: inline;" action="{{route('feedbacks.destroy', $contact->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> Delete
                        </button>
                      </form>  
       
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>date</th>
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