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
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="/{{Auth()->user()->user_type}}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('delegate-orders.index')}}?shipToday">
                        <i class="fa  fa-truck"></i> <span>Orders Ship today</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('delegate-orders.index')}}">
                        <i class="fa fa-shopping-bag"></i> <span>All My Orders</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('transactions.delegate')}}">
                        <i class="fa  fa-money"></i> <span>Balance Transactions</span>
                        </span>
                    </a>
                </li>
                 @if(Auth()->user()->show_report==1)

                 <li class="">
                    <a href="{{route('DayReport.index')}}">
                        <i class="fa fa-dashboard"></i> <span>التقرير اليومى</span>
                        </span>
                    </a>
                </li>
                @endif




            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
