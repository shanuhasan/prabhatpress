<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" align="center">
        <span class="brand-text font-weight-light">PRESS MUSHEEDA</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('dashboard')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.company.index') }}" class="nav-link @yield('company')">
                        <i class="nav-icon  fas fa-building"></i>
                        <p>Company</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="nav-link @yield('user')">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.employee.index') }}" class="nav-link @yield('employee')">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Employee</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
