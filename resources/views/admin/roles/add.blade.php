@extends('layouts.master')
@section('pageTitle', 'أضافة دور')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'دور', 'type' => 'أضافة', 'iconClass' => 'fa-lock', 'url' =>
    route('roles.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('roles.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> أضافة دور</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">أسم</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="Role Name" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>العنوان</th>
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i> عرض</th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> أضافة</th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> تعديل</th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i> مسح </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>صلاحيات الأدمن</h4> <input type="checkbox" id="checkAll">تحديد الكل
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>الحالات</td>
                                        <td><input type="checkbox" name="permissions[]" value="1"></td>
                                        <td><input type="checkbox" name="permissions[]" value="2"></td>
                                        <td><input type="checkbox" name="permissions[]" value="3"></td>
                                        <td><input type="checkbox" name="permissions[]" value="4"></td>
                                    </tr>
                                    <tr>
                                        <td>المدن</td>
                                        <td><input type="checkbox" name="permissions[]" value="5"></td>
                                        <td><input type="checkbox" name="permissions[]" value="6"></td>
                                        <td><input type="checkbox" name="permissions[]" value="7"></td>
                                        <td><input type="checkbox" name="permissions[]" value="8"></td>
                                    </tr>
                                    <tr>
                                        <td>الأحياء</td>
                                        <td><input type="checkbox" name="permissions[]" value="71"></td>
                                        <td><input type="checkbox" name="permissions[]" value="72"></td>
                                        <td><input type="checkbox" name="permissions[]" value="73"></td>
                                        <td><input type="checkbox" name="permissions[]" value="74"></td>
                                    </tr>
                                    <tr>
                                        <td>المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="9"></td>
                                        <td><input type="checkbox" name="permissions[]" value="10"></td>
                                        <td><input type="checkbox" name="permissions[]" value="11"></td>
                                        <td><input type="checkbox" name="permissions[]" value="12"></td>
                                    </tr>
                                    <tr>
                                        <td>المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="75"></td>
                                        <td><input type="checkbox" name="permissions[]" value="76"></td>
                                        <td><input type="checkbox" name="permissions[]" value="77"></td>
                                        <td><input type="checkbox" name="permissions[]" value="78"></td>
                                    </tr>
                                    <tr>
                                        <td>مناديب المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="17"></td>
                                        <td><input type="checkbox" name="permissions[]" value="18"></td>
                                        <td><input type="checkbox" name="permissions[]" value="19"></td>
                                        <td><input type="checkbox" name="permissions[]" value="20"></td>
                                    </tr>

                                    <tr>
                                        <td>مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="79"></td>
                                        <td><input type="checkbox" name="permissions[]" value="80"></td>
                                        <td><input type="checkbox" name="permissions[]" value="81"></td>
                                        <td><input type="checkbox" name="permissions[]" value="82"></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="13"></td>
                                        <td><input type="checkbox" name="permissions[]" value="14"></td>
                                        <td><input type="checkbox" name="permissions[]" value="15"></td>
                                        <td><input type="checkbox" name="permissions[]" value="16"></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="91"></td>
                                        <td><input type="checkbox" name="permissions[]" value="92"></td>
                                        <td><input type="checkbox" name="permissions[]" value="93"></td>
                                        <td><input type="checkbox" name="permissions[]" value="94"></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة مناديب المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="95"></td>
                                        <td><input type="checkbox" name="permissions[]" value="96"></td>
                                        <td><input type="checkbox" name="permissions[]" value="97"></td>
                                        <td><input type="checkbox" name="permissions[]" value="98"></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="99"></td>
                                        <td><input type="checkbox" name="permissions[]" value="100"></td>
                                        <td><input type="checkbox" name="permissions[]" value="101"></td>
                                        <td><input type="checkbox" name="permissions[]" value="102"></td>
                                    </tr>
                                    <tr>
                                        <td>الفواتير</td>
                                        <td><input type="checkbox" name="permissions[]" value="83"></td>
                                        <td><input type="checkbox" name="permissions[]" value="84"></td>
                                        <td><input type="checkbox" name="permissions[]" value="85"></td>
                                        <td><input type="checkbox" name="permissions[]" value="86"></td>
                                    </tr>
                                    <tr>
                                        <td>التقارير اليومية</td>
                                        <td><input type="checkbox" name="permissions[]" value="103"></td>
                                        <td><input type="checkbox" name="permissions[]" value="104"></td>
                                        <td><input type="checkbox" name="permissions[]" value="105"></td>
                                        <td><input type="checkbox" name="permissions[]" value="106"></td>
                                    </tr>
                                
                                    <tr>
                                        <td>طلبات المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="21"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="22"></td>
                                        <td><input type="checkbox" name="permissions[]" value="23"></td>
                                    </tr>
                                    <tr>
                                        <td>طلبات المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="87"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="89"></td>
                                        <td><input type="checkbox" name="permissions[]" value="90"></td>
                                    </tr>
                                    <tr>
                                        <td>طلب الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="24"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="25"></td>
                                    </tr>
                                    <tr>
                                        <td>تتبع المناديب</td>
                                        <td><input type="checkbox" name="permissions[]" value="26"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>إعدادات الأدمن</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="27"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>الأدوار</td>
                                        <td><input type="checkbox" name="permissions[]" value="28"></td>
                                        <td><input type="checkbox" name="permissions[]" value="29"></td>
                                        <td><input type="checkbox" name="permissions[]" value="30"></td>
                                        <td><input type="checkbox" name="permissions[]" value="31"></td>
                                    </tr>
                                    <tr>
                                        <td>المستخدمين</td>
                                        <td><input type="checkbox" name="permissions[]" value="32"></td>
                                        <td><input type="checkbox" name="permissions[]" value="33"></td>
                                        <td><input type="checkbox" name="permissions[]" value="34"></td>
                                        <td><input type="checkbox" name="permissions[]" value="35"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>صلحيات الموقع</h4>
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Slider</td>
                                        <td><input type="checkbox" name="permissions[]" value="36"></td>
                                        <td><input type="checkbox" name="permissions[]" value="37"></td>
                                        <td><input type="checkbox" name="permissions[]" value="38"></td>
                                        <td><input type="checkbox" name="permissions[]" value="39"></td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td><input type="checkbox" name="permissions[]" value="40"></td>
                                        <td><input type="checkbox" name="permissions[]" value="41"></td>
                                        <td><input type="checkbox" name="permissions[]" value="42"></td>
                                        <td><input type="checkbox" name="permissions[]" value="43"></td>
                                    </tr>
                                    <tr>
                                        <td>Posts</td>
                                        <td><input type="checkbox" name="permissions[]" value="44"></td>
                                        <td><input type="checkbox" name="permissions[]" value="45"></td>
                                        <td><input type="checkbox" name="permissions[]" value="46"></td>
                                        <td><input type="checkbox" name="permissions[]" value="47"></td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td><input type="checkbox" name="permissions[]" value="48"></td>
                                        <td><input type="checkbox" name="permissions[]" value="49"></td>
                                        <td><input type="checkbox" name="permissions[]" value="50"></td>
                                        <td><input type="checkbox" name="permissions[]" value="51"></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td><input type="checkbox" name="permissions[]" value="52"></td>
                                        <td><input type="checkbox" name="permissions[]" value="53"></td>
                                        <td><input type="checkbox" name="permissions[]" value="54"></td>
                                        <td><input type="checkbox" name="permissions[]" value="55"></td>
                                    </tr>
                                    <tr>
                                        <td>Waht We Do</td>
                                        <td><input type="checkbox" name="permissions[]" value="56"></td>
                                        <td><input type="checkbox" name="permissions[]" value="57"></td>
                                        <td><input type="checkbox" name="permissions[]" value="58"></td>
                                        <td><input type="checkbox" name="permissions[]" value="59"></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input type="checkbox" name="permissions[]" value="60"></td>
                                        <td><input type="checkbox" name="permissions[]" value="61"></td>
                                        <td><input type="checkbox" name="permissions[]" value="62"></td>
                                        <td><input type="checkbox" name="permissions[]" value="63"></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Us</td>
                                        <td><input type="checkbox" name="permissions[]" value="64"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="65"></td>
                                    </tr>
                                    <tr>
                                        <td>Website Setting</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="66"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i> Show</th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> Add</th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> Edit</th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i> Delete </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
    <script>
    $("#checkAll").click(function(){
       
    $('input:checkbox').not(this).prop('checked', this.checked);
       
});
    </script>
@endsection
