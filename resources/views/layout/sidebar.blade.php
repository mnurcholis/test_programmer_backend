<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ active_class(['admin']) }}" href="{{ url('/admin') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ active_class(['admin/data/*']) }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse  {{ show_class(['admin/data/*']) }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/data/operator') }}" class="{{ is_active_route(['admin/data/operator']) }}">
                        <i class="bi bi-circle"></i><span>Operator</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/data/site') }}" class="{{ is_active_route(['admin/data/site']) }}">
                        <i class="bi bi-circle"></i><span>Site Name</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link {{ active_class(['admin/retribusi']) }}" href="{{ url('admin/retribusi') }}">
                <i class="bi bi-cash"></i>
                <span>Retribusi</span>
            </a>
        </li><!-- End Profile Page Nav --> 

        <li class="nav-item">
            <a class="nav-link {{ active_class(['admin/settings']) }}" href="{{ url('admin/settings') }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li><!-- End Profile Page Nav --> 

    </ul>

</aside><!-- End Sidebar-->
