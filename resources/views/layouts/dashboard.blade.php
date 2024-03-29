<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>

        <!-- Messenger Css -->
        <link href="{{ asset('plugins/messenger/css/messenger.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{ asset('plugins/messenger/css/messenger-theme-future.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{ asset('plugins/messenger/css/messenger-theme-flat.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <!-- Messenger - END -->

        <!-- Styles -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('css/my.css') }}" rel="stylesheet">
{{--        <link href="css/styles.css" rel="stylesheet" />--}}
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

        @yield('header')
    </head>
    <body class="sb-nav">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route('home') }}">Employer Service</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
{{--            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">--}}
{{--                <div class="input-group">--}}
{{--                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <!-- Navbar-->
{{--            <ul class="navbar-nav ml-auto ml-md-0">--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>--}}
{{--                </li>--}}
{{--                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">--}}
{{--                    <a class="dropdown-item" href="#!">Settings</a>--}}
{{--                    <a class="dropdown-item" href="#!">Activity Log</a>--}}
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a class="dropdown-item" href="login.html">Logout</a>--}}
{{--                </div>--}}
{{--            </ul>--}}
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        @if(Auth::check())
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link @if(Route::current()->getName() == 'home') active @endif" href="{{route('home')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <div class="sb-sidenav-menu-heading">Employee</div>
                            <a class="nav-link @if(Route::current()->getName() == 'add_new_employee') active @endif" href="{{route('add_new_employee')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                                Add New Employee
                            </a>
                            <a class="nav-link
                                @if(Route::current()->getName() == 'view_all_employees' && $action == 'view_all') active @endif"
                               href="{{route('view_all_employees', ['action' => 'view_all'])}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                View All Employees
                            </a>

                            <div class="sb-sidenav-menu-heading">Hours</div>
                            <a class="nav-link
                                @if(Route::current()->getName() == 'view_all_employees' && $action == 'add_hours') active @endif"
                               href="{{route('view_all_employees', ['action' => 'add_hours'])}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-clock"></i></div>
                                Add Hours
                            </a>
                            <a class="nav-link
                                @if(Route::current()->getName() == 'view_all_employees' && $action == 'view_hours_history') active @endif"
                               href="{{route('view_all_employees', ['action' => 'view_hours_history'])}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                                View Hours History
                            </a>

                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link @if(Route::current()->getName() == 'paystubs_form') active @endif" href="{{route('paystubs_form')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                                paystubs
                            </a>
                            <a class="nav-link @if(Route::current()->getName() == 'pd7a') active @endif" href="{{route('pd7a')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                                pd7a
                            </a>
                            <a class="nav-link @if(Route::current()->getName() == 'settings') active @endif" href="{{route('settings')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Settings
                            </a>

                            <div class="sb-sidenav-menu-heading">Account</div>
                            <a class="nav-link @if(Route::current()->getName() == 'profile') active @endif" href="{{route('profile')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                Profile
                            </a>
                            <a class="nav-link @if(Route::current()->getName() == 'password.request') active @endif" href="{{route('password.request')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                                Reset Password
                            </a>
                            <a class="nav-link @if(Route::current()->getName() == 'login') active @endif" href="{{route('logout')}}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                                {{ __('Logout') }}

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>


{{--                            <a class="nav-link @if(Route::current()->getName() == 'add_new_employer') active @endif" href="{{route('add_new_employer')}}">--}}
{{--                                <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>--}}
{{--                                Add New Employer--}}
{{--                            </a>--}}
{{--                            <a class="nav-link @if(Route::current()->getName() == 'view_all_employers') active @endif" href="{{route('view_all_employers')}}">--}}
{{--                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>--}}
{{--                                View All Employers--}}
{{--                            </a>--}}


<!--
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    -->
                            <div class="sb-sidenav-footer">
                                <div class="small">Logged in as:</div>
                                @if(Auth::check())
                                    {{ Auth::user()->name }}
                                @else
                                    Guest
                                @endif
                            @endif
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
               <!-- <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer> -->
            </div>
        </div>

{{--        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>--}}
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
{{--        <script src="{{ asset('js/datatables-demo.js') }}"></script>--}}

        <!-- Messenger js -->
        <script src="{{ asset('plugins/messenger/js/messenger.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/messenger/js/messenger-theme-future.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/messenger/js/messenger-theme-flat.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/messenger.js') }}" type="text/javascript"></script>

    @yield('after_load')
    </body>
</html>
