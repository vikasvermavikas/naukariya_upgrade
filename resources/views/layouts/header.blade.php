@if (Auth::guard('jobseeker')->check())
    <header>
        <style>
            .navbar-nav-new li:hover>ul.dropdown-menu {
                display: block;
            }

            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
            }

            /* rotate caret on hover */
            .dropdown-menu>li>a:hover:after {
                text-decoration: underline;
                /* transform: rotate(-90deg); */
                margin-left: 10%;

            }
        </style>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                            <div class="logo">
                                <a href={{ route('home') }}><img src={{ asset('assets/images/naukriyan-logo.png') }}
                                        alt="Naukriyan-Logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation" class="navbar-nav-new">
                                            <li><a href={{ route('AllDataForJobSeeker') }}>Dashboard</a></li>
                                            <li><a href='#'>Jobs </a>
                                                <ul class="submenu">
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Ahmedabad">Jobs
                                                            in Ahmedabad</a></li>
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Bangalore/Bengaluru">Jobs
                                                            in Bangalore/Bangaluru</a></li>
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Chennai">Jobs
                                                            in Chennai</a></li>
                                                    <li><a href="{{ route('loadJoblistPage') }}?location=Jobs-in-Delhi">Jobs
                                                            in Delhi</a></li>
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Hyderabad/Secunderabad">Jobs
                                                            in Hyderabad/Secunderabad</a></li>
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Kolkata">Jobs
                                                            in Kolkata</a></li>
                                                    <li><a
                                                            href="{{ route('loadJoblistPage') }}?location=Jobs-in-Mumbai (All Areas)">Jobs
                                                            in Mumbai (All Areas)</a></li>
                                                    <li><a href="{{ route('loadJoblistPage') }}?location=Jobs-in-Pune">Jobs
                                                            in Pune</a></li>

                                                </ul>
                                            </li>

                                            <li><a href={{ route('loadJoblistPage') }}>Blog</a></li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="http://example.com"
                                                    id="navbarDropdownMenuLink" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Career Services
                                                </a>
                                                <ul class="dropdown-menu submenu" style="width: 130%;"
                                                    aria-labelledby="navbarDropdownMenuLink">

                                                    <li class="dropdown-submenu"><a
                                                            class="dropdown-item dropdown-toggle" href="#">Video
                                                            Resume</a>
                                                        <ul class="dropdown-menu submenu w-100"
                                                            style="margin-left: 100%;top:0%">
                                                            <li><a class="dropdown-item" href="#">How to make
                                                                    Video Resume</a></li>
                                                            <li><a class="dropdown-item" href="#">Content of Video
                                                                    Resume</a></li>
                                                            <li><a class="dropdown-item" href="#">Sample Video
                                                                    Resume</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="dropdown-submenu"><a
                                                            class="dropdown-item dropdown-toggle" href="#">How to
                                                            make effective resume</a>
                                                        <ul class="dropdown-menu submenu w-100"
                                                            style="margin-left: 100%;top:0%">
                                                            <li><a class="dropdown-item" href="#">Articles</a>
                                                            </li>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Interview Preperation</a></li>

                                        </ul>
                                        </li>


                                        <li>
                                            <a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i
                                                    class="fas fa-bell faa-ring animated"></i><span
                                                    class="
                                            badge
                                            badge-pill
                                            badge-default
                                            badge-danger
                                            badge-default
                                            badge-up
                                          ">0</span></a>
                                        </li>
                                        </ul>
                                    </nav>
                                </div>
                                <li class="nav-item dropdown open">
                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle">
                                        <img src={{ asset('assets/images/default-image.png') }}
                                            class="mini-photo img-responsive rounded-circle mx-auto"
                                            style="width: 45px;"></a>
                                    <ul class="dropdown-menu user-menu">
                                        <div class="profile-highlight text-center">
                                            <img src={{ asset('assets/images/default-image.png') }}
                                                class="mini-photo img-responsive rounded-circle text-center"
                                                style="width: 50px;">
                                            <div class="details text-center">
                                                <div id="profile-name">
                                                    <small>{{ Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}
                                                    </small>
                                                </div>
                                                <div id="profile-footer text-center">
                                                    <small>{{ Auth::guard('jobseeker')->user()->email }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <li class="user-menu__item mt-2">
                                            <a href="#/viewemployeeprofile" class="user-menu-link">
                                                <div class="text-color"><i class="fas fa-user-circle"></i> My profile
                                                </div>
                                            </a>
                                        </li>

                                        <li class="user-menu__item mt-2">
                                            <a href="#" class="user-menu-link">
                                                <div class="text-color">
                                                    <form id="logout-form" action="{{ route('jobseekerlogout') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn head-btn2">Logout</button>
                                                    </form>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- <!-- Header-btn -->
                            @if (Auth::guard('employer')->check() || Auth::guard('jobseeker')->check())
                                <span>
                                    {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname :  Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname}}</span>

                                <form id="logout-form" action="{{ route('jobseekerlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn head-btn2">Logout</button>
                                </form>
                            @else
                                <div class="header-btn d-none f-right d-lg-block">
                                    <a href={{ route('register') }} class="btn head-btn1">Register</a>
                                    <a href={{ route('login') }} class="btn head-btn1">Login</a>
                                </div>
                                <div class="header-btn d-none f-right d-lg-block">
                                    <div class="dropdown">
                                        <a href="#" class="btn head-btn1 dropdown-toggle employer"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Employer
                                        </a>
                                        <ul class="dropdown-menu show-employer">
                                            <li><a class="dropdown-item" href="{{ route('loadLoginPage') }}">Sign
                                                    In</a></li>
                                            <li><a class="dropdown-item" href="{{ route('employer-register') }}">Sign Up</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif --}}




                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
@elseif(Auth::guard('employer')->check())
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                            <div class="logo">
                                <a href={{ route('home') }}><img src={{ asset('assets/images/naukriyan-logo.png') }}
                                        alt="Naukriyan-Logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href={{ route('dashboardemployer') }}>Dashboard</a></li>
                                            <li><a href='#'>Employer </a>
                                                <ul class="submenu">
                                                    <li><a href={{ route('get_clients') }}>Client List</a></li>
                                                    <li><a href={{ route('new_job_form') }}>Post New Job</a></li>
                                                    <li><a href={{ route('managejobs') }}>Manage Job</a></li>
                                                    <li><a href={{ route('elements') }}>Questionnaries</a></li>
                                                    <li><a href={{ route('get_subusers') }}>Sub User</a></li>
                                                    <li><a href={{ route('elements') }}>Venues</a></li>
                                                    <li><a href={{ route('elements') }}>Tagged Candidates</a></li>
                                                </ul>
                                            </li>

                                            <li><a href={{ route('loadJoblistPage') }}>Packages</a></li>
                                            <li><a href={{ route('about') }}>Search Database</a></li>
                                            <li><a href='#'>Consultant </a>
                                                <ul class="submenu">
                                                    <li><a href={{ route('new_job_form') }}>Post New JD(s)</a></li>
                                                    <li><a href={{ route('new_job_form') }}>Manage JD(s)</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="dropdown"
                                                    class="nav-link nav-link-label"><i
                                                        class="fas fa-bell faa-ring animated"></i><span
                                                        class="
                                            badge
                                            badge-pill
                                            badge-default
                                            badge-danger
                                            badge-default
                                            badge-up
                                          ">0</span></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <li class="nav-item dropdown open">
                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                        class="nav-link dropdown-toggle">
                                        {{-- <img src={{ asset('assets/images/default-image.png') }} width="36"
                                            height="36" class="mini-photo rounded-circle"> --}}
                                            @if (Auth::guard('employer')->user()->profile_pic_thumb)
                                                <img src="{{ asset('emp_profile_image/' . Auth::guard('employer')->user()->profile_pic_thumb . '') }}"
                                                 class="mini-photo rounded-circle text-center" width="36" height="36">
                                            @else
                                                <img src="{{ asset('assets/images/default-image.png') }}"
                                                 class="mini-photo rounded-circle text-center" width="36" height="36">
                                            @endif
                                        </a>
                                            
                                    <ul class="dropdown-menu user-menu">
                                        <div class="profile-highlight text-center">

                                            {{-- <img src={{ asset('assets/images/default-image.png') }} width="36"
                                                height="36" class="mini-photo rounded-circle text-center"> --}}
                                            @if (Auth::guard('employer')->user()->profile_pic_thumb)
                                                <img src="{{ asset('emp_profile_image/' . Auth::guard('employer')->user()->profile_pic_thumb . '') }}"
                                                 class="mini-photo rounded-circle text-center" width="36" height="36">
                                            @else
                                                <img src="{{ asset('assets/images/default-image.png') }}"
                                                 class="mini-photo rounded-circle text-center" width="36" height="36">
                                            @endif

                                            <div class="details text-center">
                                                <div id="profile-name">
                                                    <small>
                                                        {{ Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname }}</small>
                                                </div>
                                                <div id="profile-footer text-center">
                                                    <small>{{ Auth::guard('employer')->user()->email }}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <li class="user-menu__item mt-2">
                                            <a href="{{route('employer_view_profile')}}" class="user-menu-link">
                                                <div class="text-color"><i class="fas fa-user-circle"></i> My profile
                                                </div>
                                            </a>
                                        </li>

                                        <li class="user-menu__item mt-2">
                                            <a href="#" class="user-menu-link">
                                                <div class="text-color"><i class="fas fa-sign-out-alt"></i>
                                                    <form id="logout-form" action="{{ route('jobseekerlogout') }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn head-btn2">Logout</button>
                                                    </form>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- <!-- Header-btn -->
                            @if (Auth::guard('employer')->check() || Auth::guard('jobseeker')->check())
                                <span>
                                    {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname :  Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname}}</span>

                                <form id="logout-form" action="{{ route('jobseekerlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn head-btn2">Logout</button>
                                </form>
                            @else
                                <div class="header-btn d-none f-right d-lg-block">
                                    <a href={{ route('register') }} class="btn head-btn1">Register</a>
                                    <a href={{ route('login') }} class="btn head-btn1">Login</a>
                                </div>
                                <div class="header-btn d-none f-right d-lg-block">
                                    <div class="dropdown">
                                        <a href="#" class="btn head-btn1 dropdown-toggle employer"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Employer
                                        </a>
                                        <ul class="dropdown-menu show-employer">
                                            <li><a class="dropdown-item" href="{{ route('loadLoginPage') }}">Sign
                                                    In</a></li>
                                            <li><a class="dropdown-item" href="{{ route('employer-register') }}">Sign Up</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif --}}




                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
@else
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                            <div class="logo">
                                <a href={{ route('home') }}><img src={{ asset('assets/images/naukriyan-logo.png') }}
                                        alt="Naukriyan-Logo"></a>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href={{ route('home') }}>Home</a></li>
                                            <li><a href={{ route('loadJoblistPage') }}>Find a Jobs </a></li>
                                            <li><a href={{ route('about') }}>About</a></li>
                                            <li><a href='#'>Page </a>
                                                <ul class="submenu">
                                                    <li><a href={{ route('blog') }}>Blog</a></li>
                                                    <li><a href={{ route('single-blog') }}>Blog Details</a></li>
                                                    <li><a href={{ route('elements') }}>Elements</a></li>
                                                    {{-- <li><a href={{ route('job_details') }}>job Details</a></li> --}}
                                                </ul>
                                            </li>
                                            <li><a href={{ route('contact') }}>Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>

                                <!-- Header-btn -->
                                @if (Auth::guard('employer')->check() || Auth::guard('jobseeker')->check())
                                    <span>
                                        {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname : Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}</span>

                                    <form id="logout-form" action="{{ route('jobseekerlogout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn head-btn2">Logout</button>
                                    </form>
                                @else
                                    <div class="header-btn d-none f-right d-lg-block">
                                        <a href={{ route('register') }} class="btn head-btn1">Register</a>
                                        <a href={{ route('login') }} class="btn head-btn1">Login</a>
                                    </div>
                                    <div class="header-btn d-none f-right d-lg-block">
                                        <div class="dropdown">
                                            <a href="#" class="text-dark head-btn1 dropdown-toggle employer"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Employer
                                            </a>
                                            <ul class="dropdown-menu show-employer">
                                                <li><a class="dropdown-item" href="{{ route('loadLoginPage') }}">Sign
                                                        In</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('employer-register') }}">Sign Up</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>

@endif
