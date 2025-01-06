@if (Auth::guard('jobseeker')->check())
    <header>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jobseeker/header.css') }}">
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        {{-- <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                        </div> --}}
                        <div class="col-lg-12 col-md-12 d-flex">
                            {{-- Naukriya Logo --}}
                            <div class="logo companylogo">
                                <a href={{ route('AllDataForJobSeeker') }}><img
                                        src={{ asset('assets/images/naukriyan-logo.png') }} style="width: 227px;"
                                        alt="Naukriyan-Logo" class=""></a>
                            </div>
                            <div class="menu-wrapper d-flex justify-content-end w-100">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation" class="navbar-nav-new">
                                            <li><a href={{ route('AllDataForJobSeeker') }}>Dashboard</a></li>
                                            <li><a href='{{ route('loadJoblistPage') }}'>Jobs </a>
                                                <ul class="submenu jobsubmenu">
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
                                                            ">{{ isset($notifications) ? count($notifications) : 0 }}</span></a>
                                                <ul class="submenu">

                                                    @forelse($notifications as $notification)
                                                        <li><a
                                                                href="{{ route('job_details', ['id' => $notification->id]) }}">Requirement
                                                                for {{ $notification->title }}</a></li>
                                                    @empty
                                                        <li class="text-center text-danger">No Notifications</li>
                                                    @endforelse
                                                    <div class="dropdown-divider"></div>
                                                    <li class="text-center"> <a
                                                            href="{{ route('job_notifications') }}">Show all
                                                            notifications</a></li>

                                                </ul>
                                            </li>
                                            <li class="nav-item dropdown open">
                                                <a href="#" data-toggle="dropdown" role="button"
                                                    aria-expanded="false" class="nav-link">
                                                    @if (Auth::guard('jobseeker')->user()->profile_pic_thumb)
                                                        <img src={{ asset('jobseeker_profile_image/' . Auth::guard('jobseeker')->user()->profile_pic_thumb . '') }}
                                                            class="mini-photo img-fluid rounded-circle mx-auto"
                                                            style="width: 45px;">
                                                    @else
                                                        <img src={{ asset('assets/images/default-image.png') }}
                                                            class="mini-photo img-fluid rounded-circle mx-auto"
                                                            style="width: 45px;">
                                                    @endif
                                                </a>
                                                <ul class="dropdown-menu user-menu usermenu_custom">

                                                    <div class="profile-highlight text-center">

                                                        @if (Auth::guard('jobseeker')->user()->profile_pic_thumb)
                                                            <img src={{ asset('jobseeker_profile_image/' . Auth::guard('jobseeker')->user()->profile_pic_thumb . '') }}
                                                                class="mini-photo img-fluid rounded-circle text-center"
                                                                style="width: 50px;">
                                                        @else
                                                            <img src={{ asset('assets/images/default-image.png') }}
                                                                class="mini-photo img-fluid rounded-circle text-center"
                                                                style="width: 50px;">
                                                        @endif

                                                        <div class="details text-center">
                                                            <div id="profile-name">
                                                                <small>{{ Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}
                                                                </small>
                                                            </div>
                                                            {{-- <div id="profile-footer text-center">
                                                                <small>{{ Auth::guard('jobseeker')->user()->email }}</small>
                                                            </div> --}}
                                                        </div>
                                                    </div>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="{{ route('jobseekerProfile') }}"
                                                            class="user-menu-link p-0">
                                                            <div class="text-color"><i class="fas fa-user-circle"></i>
                                                                My Profile
                                                            </div>
                                                        </a>
                                                         <a href="{{ route('profile-stages') }}"
                                                            class="user-menu-link p-0 mt-2">
                                                            <div class="text-color"><i class="fas fa-edit"></i>
                                                                Edit Profile
                                                            </div>

                                                        </a>
                                                    </li>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="#" class="user-menu-link p-0">
                                                            <div class="text-color text-center">
                                                                <form id="logout-form"
                                                                    action="{{ route('jobseekerlogout') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn rounded">Logout</button>
                                                                </form>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>




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

        {{-- Warning Div --}}
        <!-- Header End -->
    </header>

    @if (get_profile_completion() != 100)
        <div style="background:#EAEDFF;margin-bottom: -14px;">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Your profile is <span id="profile_stage"> {{ get_profile_completion() }}% </span> complete, please
                complete
                your profile for apply job.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
@elseif(Auth::guard('employer')->check())
    <style>
        /* style for mobile only */
        @media only screen and (max-width: 992px) {
            ul.slicknav_nav {
                height: 200px;
                overflow-y: scroll;
            }
        }

        @media only screen and (min-width: 992px) {
            .company-logo {
                margin-top: 14px;
            }
        }
    </style>
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        {{-- <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                        </div> --}}
                        <div class="col-lg-12 col-md-12 d-flex">
                            <div class="logo company-logo">
                                <a href={{ route('dashboardemployer') }}><img
                                        src={{ asset('assets/images/naukriyan-logo.png') }} style="width: 227px;"
                                        alt="Naukriyan-Logo"></a>
                            </div>
                            <div class="menu-wrapper w-100">
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
                                                    <li><a href={{ route('questionnaires') }}>Questionnaries</a></li>
                                                    <li><a href={{ route('get_subusers') }}>Sub User</a></li>
                                                    <li><a href={{ route('venue_list') }}>Venues</a></li>
                                                    <li><a href={{ route('get_tagged_resumes') }}>Tagged Candidates</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li><a href={{ route('loadJoblistPage') }}>Packages</a></li>
                                            <li><a href={{ route('employer_search_resume') }}>Search Database</a></li>
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
                                          ">{{ isset($notifications) ? count($notifications) : 0 }}</span></a>


                                                <ul class="submenu notificationsubmenu">

                                                    @forelse($notifications as $notification)
                                                        <li><a
                                                                href="{{ route('job_ats', ['id' => $notification->id]) }}">{{ $notification->fname . ' ' . $notification->lname }}
                                                                applied for {{ $notification->title }}</a></li>
                                                    @empty
                                                        <li class="text-center text-danger">No Notifications</li>
                                                    @endforelse
                                                    <div class="dropdown-divider"></div>
                                                    <li class="text-center"> <a
                                                            href="{{ route('employer_job_notifications') }}">Show all
                                                            notifications</a></li>
                                                </ul>

                                            </li>

                                            <li class="nav-item dropdown open">
                                                <a href="#" data-toggle="dropdown" role="button"
                                                    aria-expanded="false" class="nav-link dropdown-toggle">
                                                    {{-- <img src={{ asset('assets/images/default-image.png') }} width="36"
                                                        height="36" class="mini-photo rounded-circle"> --}}
                                                    @if (Auth::guard('employer')->user()->profile_pic_thumb)
                                                        <img src="{{ asset('emp_profile_image/' . Auth::guard('employer')->user()->profile_pic_thumb . '') }}"
                                                            class="mini-photo rounded-circle text-center"
                                                            width="36" height="36">
                                                    @else
                                                        <img src="{{ asset('assets/images/default-image.png') }}"
                                                            class="mini-photo rounded-circle text-center"
                                                            width="36" height="36">
                                                    @endif
                                                </a>

                                                <ul class="dropdown-menu user-menu" style="left:-10px;">
                                                    <div class="profile-highlight text-center">

                                                        {{-- <img src={{ asset('assets/images/default-image.png') }} width="36"
                                                            height="36" class="mini-photo rounded-circle text-center"> --}}
                                                        @if (Auth::guard('employer')->user()->profile_pic_thumb)
                                                            <img src="{{ asset('emp_profile_image/' . Auth::guard('employer')->user()->profile_pic_thumb . '') }}"
                                                                class="mini-photo rounded-circle text-center"
                                                                width="36" height="36">
                                                        @else
                                                            <img src="{{ asset('assets/images/default-image.png') }}"
                                                                class="mini-photo rounded-circle text-center"
                                                                width="36" height="36">
                                                        @endif

                                                        <div class="details text-center">
                                                            <div id="profile-name">
                                                                <small>
                                                                    {{ Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname }}</small>
                                                            </div>
                                                            {{-- <div id="profile-footer text-center">
                                                                <small>{{ Auth::guard('employer')->user()->email }}</small>
                                                            </div> --}}
                                                        </div>
                                                    </div>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="{{ route('employer_view_profile') }}"
                                                            class="user-menu-link  p-0">
                                                            <div class="text-color"><i class="fas fa-user-circle"></i>
                                                                My profile
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="#" class="user-menu-link p-0">
                                                            <div class="text-color">
                                                                <form id="logout-form"
                                                                    action="{{ route('jobseekerlogout') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn head-btn2">Logout</button>
                                                                </form>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>


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
@elseif (Auth::guard('subuser')->check())
   
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/subuser/header.css')}}">
    <header class="border">
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        {{-- <div class="col-lg-2 col-md-2">
                            <!-- Logo -->
                           
                        </div> --}}
                        <div class="col-lg-12 col-md-12 d-flex">
                            <div class="logo customlogo">
                                <a href={{ route('subuser-dashboard') }}><img
                                        src={{ asset('assets/images/naukriyan-logo.png') }} style="width: 227px;"
                                        alt="Naukriyan-Logo"></a>
                            </div>
                            <div class="menu-wrapper w-100 d-flex justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href={{ route('subuser-dashboard') }}>Dashboard</a></li>
                                            <li><a href={{ route('subuser-tracker-list') }}>Tracker</a></li>
                                            <li class="nav-item dropdown open">
                                                <a href="#" data-toggle="dropdown" role="button"
                                                    aria-expanded="false" class="nav-link dropdown-toggle">

                                                    @if (Auth::guard('subuser')->user()->profile_image)
                                                        <img src="{{ asset('subuser_profile_image/' . Auth::guard('subuser')->user()->profile_image . '') }}"
                                                            class="mini-photo rounded-circle text-center"
                                                            width="36" height="36">
                                                    @else
                                                        <img src="{{ asset('assets/images/default-image.png') }}"
                                                            class="mini-photo rounded-circle text-center"
                                                            width="36" height="36">
                                                    @endif
                                                </a>

                                                <ul class="dropdown-menu user-menu usermenu_custom">
                                                    <div class="profile-highlight text-center">

                                                        {{-- <img src={{ asset('assets/images/default-image.png') }} width="36"
                                                            height="36" class="mini-photo rounded-circle text-center"> --}}
                                                        @if (Auth::guard('subuser')->user()->profile_image)
                                                            <img src="{{ asset('subuser_profile_image/' . Auth::guard('subuser')->user()->profile_image . '') }}"
                                                                class="mini-photo rounded-circle text-center"
                                                                width="36" height="36">
                                                        @else
                                                            <img src="{{ asset('assets/images/default-image.png') }}"
                                                                class="mini-photo rounded-circle text-center"
                                                                width="36" height="36">
                                                        @endif

                                                        <div class="details text-center">
                                                            <div id="profile-name">
                                                                <small>
                                                                    {{ Auth::guard('subuser')->user()->fname . ' ' . Auth::guard('subuser')->user()->lname }}</small>
                                                            </div>
                                                            {{-- <div id="profile-footer text-center">
                                                                <small>{{ Auth::guard('subuser')->user()->email }}</small>
                                                            </div> --}}
                                                        </div>
                                                    </div>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="{{ route('subuser-profile') }}"
                                                            class="user-menu-link p-0">
                                                            <div class="text-color"><i class="fas fa-user-circle"></i>
                                                                Profile/Password
                                                            </div>
                                                        </a>
                                                    </li>

                                                    <li class="user-menu__item mt-2">
                                                        <a href="#" class="user-menu-link p-0">
                                                            <div class="text-color">
                                                                {{-- <i class="fas fa-sign-out-alt"></i> --}}
                                                                <form id="logout-form"
                                                                    action="{{ route('subuser-logout') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn head-btn2">Logout</button>
                                                                </form>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>


                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
@else
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/guest_header.css')}}">
  
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparrent">
            <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-2 logocontent">
                            <!-- Logo -->
                            <div class="logo">
                                <a href={{ route('home') }}><img src={{ asset('assets/images/naukriyan-logo.png') }}
                                        style="width: 227px;" alt="Naukriyan-Logo"></a>
                            </div>
                        </div>
                        <div class="col-md-10 menucontent">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href={{ route('home') }}>Home</a></li>
                                            <li><a href={{ route('loadJoblistPage') }}>Find a Jobs </a></li>

                                            <li><a href={{ route('about') }}>About Us</a></li>
                                            <li><a href={{ route('blog') }}>Blogs </a>
                                               <!--  <ul class="submenu">
                                                    {{-- <li><a href={{ route('single-blog') }}>Single Blog</a></li> --}}
                                                    <li><a href={{ route('blog') }}>Blog Details</a></li>
                                                    {{-- <li><a href={{ route('job_details') }}>job Details</a></li> --}}
                                                </ul> -->
                                            </li>
                                            <li><a href='#'>Career Services </a>
                                                <ul class="submenu carrermenu">
                                                    <li>
                                                        <a class="dropdown-item dropdown-toggle" href="#">Video
                                                            Resume</a>
                                                        <ul class="submenu carrersubmenu">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('how-to-make-resume') }}">How to
                                                                    make Video
                                                                    Resume</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('video-resume') }}">Content of
                                                                    Video
                                                                    Resume</a>
                                                            </li>

                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('sample-video-resume') }}">Sample
                                                                    Video Resume</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                  <!--   <li class="dropdown-submenu">
                                                        <a class="dropdown-item dropdown-toggle" href="#">How to
                                                            make Effective Resume</a>
                                                        <ul class="submenu">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="http://blog.naukriyan.com/category/articles/"
                                                                    target="_blank">Articles</a>
                                                            </li>
                                                        </ul>
                                                    </li> -->
                                                    {{-- <li>
                                                        <a class="dropdown-item" href="#">Interview
                                                            Preparation</a>
                                                    </li> --}}
                                                </ul>
                                            </li>
                                            {{-- <li><a href={{ route('contact') }}>Contact</a></li> --}}
                                            </li>
                                            <li>
                                            <li style="display: inline-table;">
                                                <a href={{ route('register') }}
                                                    class="btn head-btn1 p-3 rounded text-light">Register</a>
                                            </li>
                                            <li style="display: inline-table;">
                                                <a href={{ route('login') }}
                                                    class="btn head-btn1 p-3 rounded text-light">Login</a>
                                            </li>

                                            <li>
                                                <div class="dropdown">
                                                    <a href="#"
                                                        class="text-dark head-btn1 dropdown-toggle employer"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Employer
                                                    </a>
                                                    <ul class="dropdown-menu show-employer">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('loadLoginPage') }}">Sign
                                                                In</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('employer-register') }}">Sign
                                                                Up</a></li>
                                                    </ul>
                                                </div>
                                            </li>

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
                                    <div class="header-btn d-none f-right">
                                        <a href={{ route('register') }} class="btn head-btn1">Register</a>
                                        <a href={{ route('login') }} class="btn head-btn1">Login</a>
                                    </div>
                                    <div class="header-btn d-none f-right    ">
                                        <div class="dropdown">
                                            <a href="#" class="text-dark head-btn1 dropdown-toggle employer"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Employer
                                            </a>
                                            <ul class="dropdown-menu show-employer">
                                                <li><a class="dropdown-item" href="{{ route('loadLoginPage') }}">Sign
                                                        In</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('employer-register') }}">Sign
                                                        Up</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>

@endif
