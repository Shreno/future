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
             @if (in_array('show_dailyReport', $permissionsTitle)||in_array('add_dailyReport', $permissionsTitle) )

            <li class="treeview">
                <a href="#">
                   <i class="fa-solid fa-shop"></i> <span>التقارير اليومية</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (in_array('add_dailyReport', $permissionsTitle))
  
                <li class="">
                <a href="{{route('DailyReport.create')}}">
               <i class="fa-solid fa-house"></i> <span>  أضافة تقرير يومى  </span>
                    </span>
                </a>
            </li>
            @endif
            @if (in_array('show_dailyReport', $permissionsTitle))

            <li class="">
                <a href="{{route('DailyReport.index')}}">
               <i class="fa-solid fa-house"></i> <span> التقرير اليومى </span>
                    </span>
                </a>
            </li>
            @endif
                </ul>
            </li>
            @endif
             @if (in_array('show_client', $permissionsTitle)||in_array('add_client', $permissionsTitle)||  in_array('show_resturant', $permissionsTitle) ||  in_array('add_resturant', $permissionsTitle)        )

            <!-- client -->
            <li class="treeview">
                <a href="#">
                   <i class="fa-solid fa-shop"></i> <span>العملاء</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (in_array('add_client', $permissionsTitle))
                    <li><a href="{{ route('clients.create', ['type' => 1]) }}"><i class="fa-solid fa-circle-plus"></i> أضافة متجر </a></li>
                @endif
                @if (in_array('show_client', $permissionsTitle))

                    <li><a href="{{route('clients.index', ['type' => 1])}}"><i class="fa-solid fa-basket-shopping"></i> المتاجر</a></li>
                @endif
                @if (in_array('add_resturant', $permissionsTitle))


                    <li><a href="{{route('clients.create', ['type' => 2])}}"><i class="fa-solid fa-circle-plus"></i> أضافة مطعم</a></li>
                    @endif

                    @if (in_array('show_resturant', $permissionsTitle))

                    <li><a href="{{route('clients.index', ['type' => 2])}}"><i class="fa-solid fa-utensils"></i>  المطاعم</a></li>
                    @endif



                </ul>
            </li>
            @endif


            <!-- end client -->

            <!-- الموظفين  -->
            <li class="treeview">
                <a href="#">
                   <i class="fa-regular fa-circle-user"></i> <span>الموظفين</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (in_array('add_delegate', $permissionsTitle))
          
                 <li><a href="{{ route('delegates.create', ['type' => 1]) }}"><i class="fa-solid fa-circle-plus"></i>  أضافة مندوب متجر </a></li>
                @endif
                @if (in_array('add_delegate', $permissionsTitle))


                 <li> <a href="{{route('delegates.index', ['type' => 1])}}">
                     <i class="fa-solid fa-truck"></i><span>مناديب المتاجر</span>
                    </span> </a></li>  
                @endif
                @if (in_array('add_delegate_res', $permissionsTitle))

             <li><a href="{{ route('delegates.create', ['type' => 2]) }}"><i class="fa-solid fa-circle-plus"></i> أضافة مندوب مطعم </a></li>
             @endif
             @if (in_array('show_delegate_res', $permissionsTitle))


              <li>
                 <a href="{{route('delegates.index', ['type' => 2])}}">
                    <i class="fa-solid fa-truck-fast"></i> <span>مناديب المطاعم</span>
                    </span>
                </a> 
              </li>   
           @endif

            <li class="treeview">
                <a href="#">
                    <span>موظفين الشركة</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if (in_array('show_user', $permissionsTitle))
                    <li><a href="{{route('users.index')}}"><i class="fa  fa-users"></i> المستخدمين</a></li>
                    @endif
                    @if (in_array('edit_adminSetting', $permissionsTitle))
                    <li><a href="{{route('appSettings.edit')}}"><i class="fa fa-cog"></i> الإعدادت</a></li>
                    @endif

                    @if (in_array('show_role', $permissionsTitle))
                    <li><a href="{{route('roles.index')}}"><i class="fa  fa-lock"></i> الأدوار</a></li>
                    @endif

                  

                </ul>
            </li>
                </ul>
            </li>


            <!-- الموظفين  ->>
            <!-- الطلبات  -->
            <li class="treeview">
                <a href="#">
                    <i class="fa-solid fa-cart-plus"></i> <span> الطلبات</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">


                @if (in_array('show_order', $permissionsTitle))

                <li>
                     <a href="{{route('client-orders.index', ['work_type' => 1])}}">
                   <i class="fa-solid fa-basket-shopping"></i>طلبات المتاجر</span>
                    </span>
                </a>
               </li>
               @endif
               @if (in_array('show_order_res', $permissionsTitle))

                <li>
                     <a href="{{route('client-orders.index', ['work_type' => 2])}}">
                   <i class="fa-solid fa-utensils"></i><span>طلبات  المطاعم</span>
                    </span>
                </a>
                </li>
                @endif


            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('feedbacks.index')}}">
                  <i class="fa-regular fa-circle-user"></i><span>   طلبات الأفراد </span>
                   

                </a>
            </li>
            @endif

                </ul>
            </li>




            <!-- الطلبات  -->

            <!-- المحاسبه -->
            <li class="treeview">
                <a href="#">
                   <i class="fa-solid fa-file-invoice-dollar"></i> <span> المحاسبة</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                @if (in_array('show_balances', $permissionsTitle))
            <li>
                <a href="{{route('clients.balances', ['type' => 1])}}">
                    <i class="fa fa-money"></i> <span>محفظة المتاجر</span>
                    </span>
                </a>
            </li>
            @endif


            @if (in_array('show_balance_res', $permissionsTitle))
            <li>
                <a href="{{route('clients.balances', ['type' => 2])}}">
                    <i class="fa fa-money"></i> <span>محفظة المطاعم</span>
                    </span>
                </a>
            </li>
            @endif



            @if (in_array('show_invoice', $permissionsTitle))
            <li>
                <a href="{{route('report.index')}}">
                    <i class="fa fa-money"></i> <span> الفواتير</span>
                    </span>
                </a>
            </li>
            @endif

            @if (in_array('show_balance_delegate', $permissionsTitle))
            <li>
                <a href="{{route('delegates.balances', ['type' => 1])}}">
                    <i class="fa  fa-money"></i> <span>محفظة مناديب المتاجر</span>
                    </span>
                </a>
            </li>
            @endif
            @if (in_array('show_balance_delegate_res', $permissionsTitle))

              <li>
                <a href="{{route('delegates.balances', ['type' => 2])}}">
                    <i class="fa  fa-money"></i> <span>  محفظه مناديب المطاعم</span>
                    </span>
                </a>
            </li>
            @endif




                </ul>
            </li>




            <!-- المحاسبه -->
           


           
            
            
            

          

             
          
          
          
            @if (in_array('show_order', $permissionsTitle))
           
            <li>
                <a href="{{route('client-orders.index')}}/?notDelegated1">
                    <i class="fa fa-sitemap"></i> <span>طلبات مناديب المتاجر</span>
                    <?php $orderCount = \App\Order::NotDelegated()->count() ?>
                    @if ($orderCount > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$orderCount}}</small>
                    </span>
                    @endif
                </a>
            </li>
            @endif
                        @if (in_array('show_order_res', $permissionsTitle))

            
               <li>
                <a href="{{route('client-orders.index')}}/?notDelegated2">
                    <i class="fa fa-sitemap"></i> <span>طلبات مناديب المطاعم</span>
                    <?php $orderCount = \App\Order::NotDelegatedRes()->count() ?>
                    @if ($orderCount > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$orderCount}}</small>
                    </span>
                    @endif
                </a>
            </li>
            
            
            @endif
            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('request-joins.index')}}">
                    <i class="fa fa-handshake-o"></i> <span>طلب الخدمه</span>
                    <?php $requestCount = \App\RequestJoin::where('is_readed', 0)->count() ?>
                    @if ($requestCount > 0)
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">{{$requestCount}}</small>
                    </span>
                    @endif

                </a>
            </li>
            @endif
            @if (in_array('show_city', $permissionsTitle)||in_array('add_city', $permissionsTitle)||in_array('show_region', $permissionsTitle)||in_array('add_region', $permissionsTitle))
          
             <li class="treeview">
                <a href="#">
                   <i class="fa-solid fa-shop"></i> <span>المدن و المناطق</span>
                    <span class="pull-right-container">
                       <i class=" pull-right fa-solid fa-arrow-left"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    @if(in_array('add_city', $permissionsTitle))
                    <li><a href="{{route('cities.create')}}"><i class="fa-solid fa-circle-plus"></i> أضافة مدينة </a></li>
                    @endif
                                        @if(in_array('show_city', $permissionsTitle))

                    <li><a href="{{route('cities.index')}}"><i class="fa-solid fa-basket-shopping"></i> المدن</a></li>
                                        @endif

                    @if(in_array('add_region', $permissionsTitle))

                    <li><a href="{{route('regions.create')}}"><i class="fa-solid fa-circle-plus"></i> أضافة حى</a></li>
                                                           @endif

                                        @if(in_array('show_region', $permissionsTitle))

                    <li><a href="{{route('regions.index')}}"><i class="fa-solid fa-utensils"></i>  الأحياء</a></li
                                        @endif
>
                    


                </ul>
                
            </li>
            @endif

            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('clients.api')}}">
                    <i class="fa fa-handshake-o"></i> <span>  api المتاجر</span>
                   

                </a>
            </li>
            @endif

            
            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('rate_orders.index')}}">
                    <i class="fa fa-handshake-o"></i> <span>  تقييم العملاء </span>
                   

                </a>
            </li>
            @endif
          

            @if (in_array('show_requestJoin', $permissionsTitle))
            <li>
                <a href="{{route('delegates.tracking')}}">
                    <i class="fa fa-handshake-o"></i> <span> تتبع المناديب </span>
                   

                </a>
            </li>
            @endif
            
             <li>
                <a href="{{route('statuses.index')}}">
                    <i class="fa fa-sitemap"></i> <span>الحالات </span>
                   

                </a>
            </li>



 
 

       
           
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