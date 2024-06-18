
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
                                        <li><a href={{ route('job_listing') }}>Find a Jobs </a></li>
                                        <li><a href={{ route('about') }}>About</a></li>
                                        <li><a href='#'>Page </a>
                                            <ul class="submenu">
                                                <li><a href={{ route('blog') }}>Blog</a></li>
                                                <li><a href={{ route('single-blog') }}>Blog Details</a></li>
                                                <li><a href={{ route('elements') }}>Elements</a></li>
                                                <li><a href={{ route('job_details') }}>job Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href={{ route('contact') }}>Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                       
                            <!-- Header-btn -->
                            @guest('jobseeker')
                                <div class="header-btn d-none f-right d-lg-block">
                                    <a href={{ route('register') }} class="btn head-btn1">Register</a>
                                    <a href={{ route('login') }} class="btn head-btn1">Login</a>
                                </div>
                            @else
                                <span>
                                    {{ Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}</span>

                                <form id="logout-form" action="{{ route('jobseekerlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn head-btn2">Logout</button>
                                </form>
                            @endguest
                            <div class="header-btn d-none f-right d-lg-block">
                                <div class="dropdown">
                                    <a  href="#" class="btn head-btn1 dropdown-toggle employer" data-bs-toggle="dropdown" aria-expanded="false">
                                      Employer
                                    </a>
                                    <ul class="dropdown-menu show-employer">
                                      <li><a class="dropdown-item" href="">Sign In</a></li>
                                      <li><a class="dropdown-item" href="{{ route('employer-register') }}">Sign Up</a></li>
                                    </ul>
                                  </div>
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
    <!-- Header End -->
</header>
