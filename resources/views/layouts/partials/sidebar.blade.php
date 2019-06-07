<div class="sidebar">
    <div class="sidebar-inner">
        <!-- ### $Sidebar Header ### -->
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="index.html">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <img src="{{ asset('images/logo.png') }}" alt="">
                                </div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text">Inventory Management</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### $Sidebar Menu ### -->
        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item mT-30 active">
                <a class="sidebar-link" href="/">
                <span class="icon-holder">
                  <i class="c-blue-500 ti-home"></i>
                </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                      <i class="c-red-500 ti-bar-chart"></i>
                    </span>
                    <span class="title">Reports</span>
                    <span class="arrow">
                        <i class="ti-angle-right"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class='sidebar-link' href="/report/monthly/purchase">Monthly Purchases</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/report/yearly/purchase">Yearly Purchases</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/report/monthly/sales">Monthly Sales</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/report/yearly/sales">Yearly Sales</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                      <i class="c-orange-500 ti-layout-list-thumb"></i>
                    </span>
                        <span class="title">Transactions</span>
                        <span class="arrow">
                        <i class="ti-angle-right"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class='sidebar-link' href="/purchases">Purchases</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/sales">Sales</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                      <i class="c-orange-500 ti-agenda"></i>
                    </span>
                    <span class="title">Tax Invoices</span>
                    <span class="arrow">
                        <i class="ti-angle-right"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class='sidebar-link' href="/taxinvoices/new">New</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/taxinvoices/year">This Year</a>
                    </li>
                    <li>
                        <a class='sidebar-link' href="/taxinvoices">All Tax Invoices</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item active">
                <a class="sidebar-link" href="/products">
                <span class="icon-holder">
                  <i class="c-blue-500 ti-home"></i>
                </span>
                    <span class="title">Inventory</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="sidebar-link" href="/customers">
                <span class="icon-holder">
                  <i class="c-blue-500 ti-home"></i>
                </span>
                    <span class="title">Customers</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="sidebar-link" href="/import">
                <span class="icon-holder">
                  <i class="c-blue-500 ti-home"></i>
                </span>
                    <span class="title">Import</span>
                </a>
            </li>
        </ul>
    </div>
</div>