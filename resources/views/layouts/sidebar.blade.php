<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0" style="z-index:5000 !important;">
    <div class="container-xxl d-flex">
        <ul class="menu-inner">
        <li class="menu-item">
                    <a href="{{ route('dashboard.index') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-smart-home"></i>
                      <div data-i18n="Dashboards">Dashboard</div>
                    </a>
            </li>
            @if(( Auth::user()->email_verified_at) == "")

            <li class="menu-item">
                    <a href="{{ route('verification.resend') }}" class="menu-link menu-toggle">
                      <i class="icon-mail nav-icon"></i>
                      <div data-i18n="Layouts">Resend Link</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link menu-toggle" href="{{ route('admin.logout') }}">
                        <i class="icon-lock nav-icon"></i>
                        Logout
                    </a>
                </li>
            @else
                @if(Auth::user()->email == 'taiwo@enabledgroup.net')
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('createFolders') }}">
                            <i class="icon-folder nav-icon"></i>
                            Create Folders
                        </a>
                    </li>
                @endif
                @if (Gate::allows('SuperAdmin', auth()->user()))
                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="javascript:void(0)">
                            <i class="icon-business_center nav-icon"></i>
                            Companies
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('company.create') }}">Add a Company</a>
                            </li>
                            <li>
                                <a class="menu-link" href="{{ route('company.index') }}">View all Companies</a>
                            </li>
                            <li>
                                <a class="menu-link" href="{{ route('employer.create') }}">Company Staff</a>
                            </li>
                        </ul>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="javascript:void(0)">
                            <i class="icon-users nav-icon"></i>
                            Clients
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('client.index') }}">All Clients</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('contact.list') }}">Client Contacts</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.index') }}">Clients RFQs</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('po.index') }}">Clients POs</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.history') }}">Clients RFQ history</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('po.reports') }}">Client PO Reports</a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('shipper.index') }}">
                            <i class="icon-local_shipping nav-icon"></i>
                            Shipper
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('vendor.index') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            Suppliers
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="javascript:void(0)">
                            <i class="icon-settings nav-icon"></i>
                            Warehouse
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('warehouse.index') }}">Add Warehouses</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('inventory.user.index') }}">Warehouse Users</a>
                            </li>
                        </ul>
                    <!-- </li>
                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="javascript:void(0)">
                            <i class="icon-report nav-icon"></i>
                            RFQ Reports
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.weekly') }}">Weekly Reports</a>
                            </li>

                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart') }}">Monthly Charts</a>
                            </li>

                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart.supplier') }}">Supplier Charts</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart.shipper') }}">Shippers Charts</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart.company') }}">Companies Charts</a>
                            </li>

                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart.client') }}">Clients Charts</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('rfq.chart.employer') }}">Employers Charts</a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="javascript:void(0)">
                            <i class="icon-settings nav-icon"></i>
                            Config
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('industry.index') }}">Industries</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('unit.index') }}">Unit of Measurements</a>
                            </li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ route('users.index') }}">Super Users</a>
                            </li>
                        </ul>
                    </li>

                @endif

                @if(Auth::user()->hasRole('Warehouse User'))
                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="{{ route('inventory.create') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            Add Inventory
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link menu-toggle" href="{{ route('inventory.index') }}">
                            <i class="icon-list nav-icon"></i>
                            View Inventory
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('SuperAdmin'))

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('employer.create') }}">
                            <i class="icon-user-x nav-icon"></i>
                            Company Staff
                        </a>
                    </li>
                @endif

                    @if (Auth::user()->hasRole('Admin'))
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('client.index') }}">
                            <i class="icon-users nav-icon"></i>
                            Clients
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('shipper.index') }}">
                            <i class="icon-local_shipping nav-icon"></i>
                            Shipper
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('vendor.index') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            Suppliers
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('po.index') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            POs
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('po.report') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            PO Reports
                        </a>
                    </li>


                @endif

                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')) OR(Auth::user()->hasRole('Admin')) OR
                    (Auth::user()->hasRole('Client')) OR (Auth::user()->hasRole('Contact')))

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('rfq.index') }}">
                            <i class="icon-list nav-icon"></i>
                            RFQ
                        </a>
                    </li>

                    

                @endif

                @if (Auth::user()->hasRole('Employer') OR(Auth::user()->hasRole('HOD')))
                    
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('shipper.index') }}">
                            <i class="icon-local_shipping nav-icon"></i>
                            Shipper
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('vendor.index') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            Suppliers
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('client.index') }}">
                            <i class="icon-list nav-icon"></i>
                            Clients
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('po.index') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            POs
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('po.reports') }}">
                            <i class="icon-shopping_cart nav-icon"></i>
                            PO Reports
                        </a>
                    </li>

                @endif

                @if (Auth::user()->hasRole('Shipper'))

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('shipper.index') }}">
                            <i class="icon-user nav-icon"></i>
                            My Details
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('rfq.index') }}">
                            <i class="icon-list nav-icon"></i>
                            RFQ
                        </a>
                    </li>

                @endif

                @if (Auth::user()->hasRole('Supplier'))

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('vendor.index') }}">
                            <i class="icon-user nav-icon"></i>
                            My Details
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('rfq.index') }}">
                            <i class="icon-list nav-icon"></i>
                            RFQ
                        </a>
                    </li>

                @endif

                @if (Auth::user()->hasRole('Client') OR (Auth::user()->hasRole('Contact')))
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('client.index') }}">
                            <i class="icon-users nav-icon"></i>
                            Clients
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('Client'))

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('contact.index',Auth::user()->email)}}">
                            <i class="icon-users nav-icon"></i>
                            Contact
                        </a>
                    </li>
                @endif

                <li class="menu-item">
                    <a class="menu-link menu-toggle" href="javascript:void(0)">
                        <i class="icon-report nav-icon"></i>
                        Reports
                    </a>
                    <ul class="menu-sub">
                        <li>
                            <a class="menu-link" href="{{ route('po.report.weekly') }}">Weekly Reports</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('po.report.monthly') }}">Monthly Reports</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('po.report.index') }}">Yearly Reports</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('po.report.custom') }}">Custom Reports</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('po.report.rfq') }}">RFQ/PO Reports</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('po.report.clientPo') }}">Client PO Reports</a>
                        </li>

                    </ul>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('log') }}">
                        <i class="icon-activity nav-icon"></i>
                        Activity Log
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('admin.logout') }}">
                        <i class="icon-lock nav-icon"></i>
                        Logout
                    </a>
                </li>



            @endif

        </ul>
    </div>
</aside>
