<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('storage/'.Auth()->user()->avatar)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth()->user()->name}}</p>

            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">القوائم الرئيسية</li>
            <li class="active">
                <a href="{{route('client.dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>@lang('app.dashboard')</span>
                    </span>
                </a>
            </li>
             <li>
                <a href="{{route('addresses.index')}}">
                    <i class="fa  fa-map-marker"></i> <span>@lang('app.alladdress')</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('orders.index')}}">
                    <i class="fa  fa-truck"></i> <span>@lang('app.orders', ['attribute' => ''])</span>
                    </span>
                </a>
            </li>
           
            <li>
                <a href="{{route('transactions.client')}}">
                    <i class="fa  fa-money"></i> <span>@lang('app.transactions', ['attribute' => __('app.balance', ['attribute' => '' ])])</span>
                    </span>
                </a>
            </li>
 



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
