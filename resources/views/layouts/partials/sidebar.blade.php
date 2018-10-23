<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
        <div class="nav-link">
            <div class="user-wrapper">
            <div class="profile-image">
                <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile image">
            </div>
            <div class="text-wrapper">
                <p class="profile-name">Richard V.Welsh</p>
                <div>
                <small class="designation text-muted">Manager</small>
                <span class="status-indicator online"></span>
                </div>
            </div>
            </div>
            <a href="{{ url('/purchases/new') }}" class="btn btn-success btn-block">New Purchase
            <i class="mdi mdi-plus"></i>
            </a>
        </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="menu-icon mdi mdi-television"></i>
            <span class="menu-title">Dashboard</span>
        </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/products') }}">
                <i class="menu-icon mdi mdi-backup-restore"></i>
                <span class="menu-title">Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/inventory') }}">
                <i class="menu-icon mdi mdi-backup-restore"></i>
                <span class="menu-title">Inventory</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/purchases') }}">
                <i class="menu-icon mdi mdi-backup-restore"></i>
                <span class="menu-title">Purchases</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/sales') }}">
                <i class="menu-icon mdi mdi-backup-restore"></i>
                <span class="menu-title">Sales</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-content-copy"></i>
                <span class="menu-title">Basic UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>