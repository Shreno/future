@extends('layouts.master')
@section('pageTitle', 'تعديل الدور')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'الدور', 'type' => 'تعديل', 'iconClass' => 'fa-lock', 'url' =>
    route('roles.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('roles.update', $role->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> تعديل الدور</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">الأسم</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="Role Name" value="{{$role->title}}" required>
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
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i> عرض </th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> أضافة</th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> تعديل</th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i> مسح </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>صلحيات الأدمن</h4> <input type="checkbox" id="checkAll">تحديد الكل 
                                                
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>الحالات</td>
                                        <td><input type="checkbox" name="permissions[]" value="1" {{(in_array('1', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="2" {{(in_array('2', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="3" {{(in_array('3', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="4" {{(in_array('4', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المدن</td>
                                        <td><input type="checkbox" name="permissions[]" value="5" {{(in_array('5', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="6" {{(in_array('6', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="7" {{(in_array('7', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="8" {{(in_array('8', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>الأحياء</td>
                                        <td><input type="checkbox" name="permissions[]" value="71"{{(in_array('71', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="72"{{(in_array('72', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="73"{{(in_array('73', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="74"{{(in_array('74', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="9"  {{(in_array('9', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="10" {{(in_array('10', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="11" {{(in_array('11', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="12" {{(in_array('12', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="75"{{(in_array('75', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="76"{{(in_array('76', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="77"{{(in_array('77', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="78"{{(in_array('78', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>مناديب المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="17" {{(in_array('17', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="18" {{(in_array('18', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="19" {{(in_array('19', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="20" {{(in_array('20', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="79"{{(in_array('79', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="80"{{(in_array('80', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="81"{{(in_array('81', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="82"{{(in_array('82', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>

                                    <tr>
                                        <td>محاسبة المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="13" {{(in_array('13', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="14" {{(in_array('14', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="15" {{(in_array('15', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="16" {{(in_array('16', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="91"{{(in_array('91', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="92"{{(in_array('92', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="93"{{(in_array('93', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="94"{{(in_array('94', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة مناديب المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="95"{{(in_array('95', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="96"{{(in_array('96', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="97"{{(in_array('97', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="98"{{(in_array('98', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>محاسبة مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="99"{{(in_array('99', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="100"{{(in_array('100', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="101"{{(in_array('101', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="102"{{(in_array('102', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>الفواتير</td>
                                        <td><input type="checkbox" name="permissions[]" value="83"{{(in_array('83', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="84"{{(in_array('84', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="85"{{(in_array('85', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="86"{{(in_array('86', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>التقارير اليومية</td>
                                        <td><input type="checkbox" name="permissions[]" value="103"{{(in_array('103', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="104"{{(in_array('104', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="105"{{(in_array('105', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="106"{{(in_array('106', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                 
                                    <tr>
                                        <td>طلبات المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="21" {{(in_array('21', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="22" {{(in_array('22', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="23" {{(in_array('23', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>طلبات المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="87"{{(in_array('87', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="89"{{(in_array('89', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="90"{{(in_array('90', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>طلب الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="24" {{(in_array('24', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="25" {{(in_array('25', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>تتبع المناديب</td>
                                        <td><input type="checkbox" name="permissions[]" value="26" {{(in_array('26', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>إعدادات الأدمن</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="27" {{(in_array('27', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>الصلاحيات</td>
                                        <td><input type="checkbox" name="permissions[]" value="28" {{(in_array('28', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="29" {{(in_array('29', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="30" {{(in_array('30', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="31" {{(in_array('31', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المستخدمين</td>
                                        <td><input type="checkbox" name="permissions[]" value="32" {{(in_array('32', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="33" {{(in_array('33', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="34" {{(in_array('34', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="35" {{(in_array('35', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>Website Permissions</h4>
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Slider</td>
                                        <td><input type="checkbox" name="permissions[]" value="36" {{(in_array('36', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="37" {{(in_array('37', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="38" {{(in_array('38', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="39" {{(in_array('39', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td><input type="checkbox" name="permissions[]" value="40" {{(in_array('40', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="41" {{(in_array('41', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="42" {{(in_array('42', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="43" {{(in_array('43', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Posts</td>
                                        <td><input type="checkbox" name="permissions[]" value="44" {{(in_array('44', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="45" {{(in_array('45', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="46" {{(in_array('46', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="47" {{(in_array('47', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td><input type="checkbox" name="permissions[]" value="48" {{(in_array('48', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="49" {{(in_array('49', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="50" {{(in_array('50', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="51" {{(in_array('51', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td><input type="checkbox" name="permissions[]" value="52" {{(in_array('52', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="53" {{(in_array('53', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="54" {{(in_array('54', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="55" {{(in_array('55', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Waht We Do</td>
                                        <td><input type="checkbox" name="permissions[]" value="56" {{(in_array('56', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="57" {{(in_array('57', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="58" {{(in_array('58', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="59" {{(in_array('59', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input type="checkbox" name="permissions[]" value="60" {{(in_array('60', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="61" {{(in_array('61', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="62" {{(in_array('62', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="63" {{(in_array('63', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Us</td>
                                        <td><input type="checkbox" name="permissions[]" value="64" {{(in_array('64', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="65" {{(in_array('65', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Website Setting</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="66" {{(in_array('66', $arrPermissions)) ? 'checked' : ''}}></td>
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