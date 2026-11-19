<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <span class="pp-brand-mark">PP</span>
        <span class="pp-brand-text">
            <strong>PRABHAT</strong>
            <small>Printing Press</small>
        </span>
    </a>

    <div class="sidebar">
        <!-- Signed-in user -->
        <div class="pp-sidebar-user">
            <span class="pp-avatar">{{ $ppInitials ?? '' }}</span>
            <div>
                <strong>{{ Auth::user()->name }}</strong>
                <small>Signed in</small>
            </div>
        </div>

        <nav class="mt-1">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-header">Overview</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link @yield('dashboard')">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report.index') }}" class="nav-link @yield('report')">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Reports</p>
                    </a>
                </li>

                <li class="nav-header">Business</li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link @yield('orders')">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sale.index') }}" class="nav-link @yield('sales')">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link @yield('customers')">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <li class="nav-header">Finance</li>
                <li class="nav-item">
                    <a href="{{ route('expenses.index') }}" class="nav-link @yield('expenses')">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Expenses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link @yield('supplier')">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Suppliers</p>
                    </a>
                </li>

                <li class="nav-header">Administration</li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link @yield('users')">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link pp-logout-link"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Log Out</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
