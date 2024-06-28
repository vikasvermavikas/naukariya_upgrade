@if(Auth::guard('jobseeker')->user())
<header>
    <!-- Header Start -->
    <div class="header-area header-transparrent">
        <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2">
                        <!-- Logo -->
                        <div class="logo">
                            <a href={{ route('home') }}>
                                <img src={{ asset('assets/images/naukriyan-logo.png') }}
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
@elseif(Auth::guard('employer')->user())
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
                                                <li><a href={{ route('blog') }}>Client List</a></li>
                                                <li><a href={{ route('single-blog') }}>Post New Job</a></li>
                                                <li><a href={{ route('elements') }}>Manage Job</a></li>
                                                <li><a href={{ route('elements') }}>Questionnaries</a></li>
                                                <li><a href={{ route('elements') }}>Sub User</a></li>
                                                <li><a href={{ route('elements') }}>Venues</a></li>
                                                <li><a href={{ route('elements') }}>Tagged Candidates</a></li>
                                            </ul>
                                        </li>

                                        <li><a href={{ route('loadJoblistPage') }}>Packages</a></li>
                                        <li><a href={{ route('about') }}>Search Database</a></li>
                                        <li><a href='#'>Consultant </a>
                                            <ul class="submenu">
                                                <li><a href={{ route('blog') }}>Post New JD(s)</a></li>
                                                <li><a href={{ route('blog') }}>Manage JD(s)</a></li>
                                            </ul>
                                        </li>
                                        <li> 
                                            <a  href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="fas fa-bell faa-ring animated"></i><span class="
                                            badge
                                            badge-pill
                                            badge-default
                                            badge-danger
                                            badge-default
                                            badge-up
                                          ">0</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                            <li  class="nav-item dropdown open">
                                <a  href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                    <img  src={{ asset('assets/images/naukriyan-logo.png') }} width="36" height="36" class="mini-photo rounded-circle"></a>
                                    <ul  class="dropdown-menu user-menu">
                                        <div  class="profile-highlight text-center">
                                            <img  src={{ asset('assets/images/naukriyan-logo.png') }} width="36" height="36" class="mini-photo rounded-circle text-center">
                                            <div  class="details text-center"><div  id="profile-name">
                                                Sahasha
                                            </div> 
                                        <div  id="profile-footer text-center">
                                            sahasha@prakharsoftwares.com
                                        </div>
                                    </div>
                                </div> 
                                <li  class="user-menu__item">
                                    <a  href="#/editemployer" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-user-edit"></i> Edit profile</div>
                                    </a>
                                </li> 
                                <li  class="user-menu__item">
                                    <a  href="#/viewemployeeprofile" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-user-circle"></i> My profile</div>
                                    </a>
                                </li> 
                                <li  class="user-menu__item">
                                    <a  href="#/vieworganization" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-sitemap"></i> Organisation</div>
                                    </a>
                                </li> 
                                <li  class="user-menu__item">
                                    <a href="#/emp-inbox" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-inbox"></i> Inbox</div>
                                    </a>
                                </li>
                                <li  class="user-menu__item">
                                    <a  href="#/employer-changepassword" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-key"></i> Change password</div>
                                    </a>
                                </li>
                                <li  class="user-menu__item">
                                    <a  href="#" class="user-menu-link">
                                        <div class="text-color"><i  class="fas fa-sign-out-alt"></i>   
                                            <form id="logout-form" action="{{ route('jobseekerlogout') }}" method="POST">
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
