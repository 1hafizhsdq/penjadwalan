<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ ($title == 'Dashboard') ? '' : 'collapsed' }}" href="{{ url('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @if (Auth::user()->role_id == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link {{ ($title == 'User') ? '' : 'collapsed' }}" href="{{ url('user') }}">
                            <i class="bi bi-circle"></i><span>User</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ ($title == 'Role') ? '' : 'collapsed' }}" href="{{ url('role') }}">
                            <i class="bi bi-circle"></i><span>Role</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->
        @endif
    </ul>
</aside>