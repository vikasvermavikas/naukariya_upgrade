<header>
    <!-- Header Start -->
   <div class="header-area header-transparrent">
       <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-2">
                        <!-- Logo -->
                        <div class="logo">
                            <a href={{route('home')}}><img src={{asset('assets/images/naukriyan-logo.png')}} alt="Naukriyan-Logo"></a>
                        </div>  
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="menu-wrapper">
                            <!-- Main-menu -->
                            <div class="main-menu">
                                <nav class="d-none d-lg-block">
                                    <ul id="navigation">
                                        <li><a href={{route('home')}}>Home</a></li>
                                        <li><a href={{route('job_listing')}}>Find a Jobs </a></li>
                                        <li><a href={{route('about')}}>About</a></li>
                                        <li><a href='#'>Page </a>
                                            <ul class="submenu">
                                                <li><a href={{route('blog')}}>Blog</a></li>
                                                <li><a href={{route('single-blog')}}>Blog Details</a></li>
                                                <li><a href={{route('elements')}}>Elements</a></li>
                                                <li><a href={{route('job_details')}}>job Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href={{route('contact')}}>Contact</a></li>
                                    </ul>
                                </nav>
                            </div>          
                            <!-- Header-btn -->
                            <div class="header-btn d-none f-right d-lg-block">
                              <a href={{route('register')}} class="btn head-btn1">Register</a>
                                <a href={{route('login')}} class="btn head-btn2">Login</a>
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