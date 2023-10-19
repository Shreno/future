<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
       
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header strong">الفوائم الرئيسية</li>
            <li class="active">
                <a href="/{{Auth()->user()->user_type}}">
               <i class="fa-solid fa-house"></i> <span>لوحة التحكم</span>
                    </span>
                </a>
            </li>
       
          


            <!-- end client -->

            <li class="treeview">
                <a href="#">
                   <i class="fa-regular fa-circle-user"></i> <span>إدارة الحسابات</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (in_array('add_client', $permissionsTitle))
                    <li><a href="{{ route('companies.create') }}"><i class="fa-solid fa-circle-plus"></i> أضافة شركة </a></li>
                @endif
                @if (in_array('show_client', $permissionsTitle))

                    <li><a href="{{route('companies.index')}}"><i class="fa-solid fa-basket-shopping"></i> الشركات</a></li>
                @endif
                </ul>
            </li>
            <li><a href="{{route('appSettings.edit')}}"><i class="fa fa-cog"></i> إعدات التطبيق</a></li>

       
           
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-globe"></i> <span>الموقع</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (in_array('show_slider', $permissionsTitle))
                    <li><a href="{{route('sliders.index')}}"><i class="fa fa-window-restore"></i> Slider</a></li>
                    @endif
                    @if (in_array('show_page', $permissionsTitle))
                    <li><a href="{{route('pages.index')}}"><i class="fa fa-file-text"></i> pages</a></li>
                    @endif
                    @if (in_array('show_post', $permissionsTitle))
                    <li><a href="{{route('posts.index')}}"><i class="fa fa-newspaper-o"></i> Posts</a></li>
                    @endif
                    @if (in_array('show_category', $permissionsTitle))
                    <li><a href="{{route('categories.index')}}"><i class="fa fa-th"></i> Categories</a></li>
                    @endif
                    @if (in_array('show_service', $permissionsTitle))
                    <li><a href="{{route('services.index')}}"><i class="fa fa-first-order"></i> Service</a></li>
                    @endif
                    @if (in_array('show_whatWeDo', $permissionsTitle))
                    <li><a href="{{route('what-we-do.index')}}"><i class="fa fa-question-circle"></i> What We Do</a></li>
                    @endif
                    @if (in_array('show_branch', $permissionsTitle))
                    <li><a href="{{route('branches.index')}}"><i class="fa fa-map"></i> Branches</a></li>
                    @endif
                    @if (in_array('show_contactUs', $permissionsTitle))
                    <li><a href="{{route('contacts.index')}}"><i class="fa fa-envelope-o"></i> Contact us</a></li>
                    @endif
                    
                   
                 
                 
                    @if (in_array('edit_websiteSetting', $permissionsTitle))
                    <li><a href="{{route('settings.edit')}}"><i class="fa  fa-cog"></i> Settings</a></li>
                    @endif
                    
                    
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>