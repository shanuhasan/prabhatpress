<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PRABHAT PRESS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link"
                        style="background: green;color:#fff;font-weight:bold;font-size:24px;text-align:center">
                        <p>{{ Auth::user()->name }}</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link @yield('dashboard')">
                        <i class="nav-icon  fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link @yield('users')">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('sale.index') }}" class="nav-link @yield('sales')">
                        <i class="nav-icon  fas fa-rupee-sign"></i>
                        <p>Sales</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link @yield('orders')">
                        <i class="nav-icon  fab fa-first-order"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link @yield('customers')">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('expenses.index') }}" class="nav-link @yield('expenses')">
                        <i class="nav-icon  fas fa-rupee-sign"></i>
                        <p>Expenses</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('report.index') }}" class="nav-link @yield('report')">
                        <i class="nav-icon  fas fa-file"></i>
                        <p>Report</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link @yield('supplier')">
                        <i class="nav-icon  fas fa-user"></i>
                        <p>Supplier</p>
                    </a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" class="nav-link"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>{{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
