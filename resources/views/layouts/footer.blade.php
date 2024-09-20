<style>
     /* Wrapper */
  .icon-button {
    background-color: white !important;
    ;
    border-radius: 3.6rem;
    cursor: pointer;
    display: inline-block;
    font-size: 24px;
    height: 40px;
    /* line-height: 3px; */
    margin: 0 5px;
    position: relative;
    text-align: center;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    width: 40px;
  }

  /* Circle */
  .icon-button span {
    border-radius: 0;
    display: block;
    height: 0;
    left: 50%;
    margin: 0;
    position: absolute;
    top: 50%;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
    width: 0;
  }

  .twitterspan:hover {
    position: absolute !important;
  }

  .icon-button:hover span {
    width: 3.6rem;
    height: 3.6rem;
    border-radius: 3.6rem;
    margin: -1.8rem;
  }

  .twitter span {
    /* position: static !important; */
    background-color: #c8232c;
  }

  .facebook span {
    background-color: #3B5998;
  }

  .linkedin span {
    background-color: #007bff;
  }

  .instagram span {
    background-color: #d6249f;
  }

  .pinterest span {
    background-color: #c8232c;
  }

  /* Icons */
  .icon-button i {
    background: none;
    color: #7a7a7a;
    /* height: 3.6rem; */
    left: 9px;
    line-height: 42px;
    position: sticky;
    top: 0;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    z-index: 10;
  }

  .icon-button .icon-twitter {
    /* color: #efeff0; */
    fill: #c8232c;
    padding-right: 7px;
    position: absolute !important;
    left: 9px !important;
    top: 10px !important;
  }

  .icon-button .icon-facebook {
    color: #3B5998;
  }
  .icon-youtube {
    position: absolute !important;
    left: 7px !important;
    top: -1px !important;
    color: #c8232c !important;
}
  .icon-button .icon-linkedin {
    color: #007bff;
  }

.newsletteremail{
    width: 80% !important;
}
  .icon-button .icon-instagram {
    color: #d6249f;
  }

  .icon-button .icon-pinterest {
    color: #c8232c;
  }

  .icon-button:hover .icon-facebook,
  .icon-button:hover .icon-linkedin,
  .icon-button:hover .icon-instagram,
  .icon-button:hover .icon-youtube {
    color: white !important;
  }
  .icon-button:hover .icon-twitter {
    position: absolute !important;
    z-index: 10;
    fill: white;
}

    .footer-area ul li:before {
        font-family: Font Awesome\ 5 Free;
        content: "\F0A4 ";
        margin-right: 10px;
        color: #a7a7a7;
    }
    .fa-x-twitter:before{
        content:"\e61b"
    }
    .footer-social a i,
    .twittericon {
        /* margin-top: 15px;
        color: #888888;
        margin-left: 23px;
        font-size: 27px;
        -webkit-transition: .4s;
        -moz-transition: .4s;
        -o-transition: .4s;
        transition: .4s; */
    }

    @media only screen and (max-width:700px) {
        .footer-area .footer-form form .form-icon button {
            top: 10px;
        }

    }

    @media only screen and (min-width:576px) and (max-width:1199px) {
        /* .footer-social {
            position: relative;
            right: 17px;
        } */
        .icon-button{
            margin: 0%;
            margin-right: 1%;
        }

    }
</style>
<footer>
    <!-- Footer Start-->
    @if (!auth('subuser')->check())
        <div class="footer-area footer-bg footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    {{-- Candidate Section --}}
                    @if (!Auth::guard('employer')->check())
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="single-footer-caption mb-50">
                                <div class="single-footer-caption mb-30">
                                    <div class="footer-tittle">
                                        <h4>CANDIDATE</h4>
                                        <div class="footer-pera">
                                            <ul>
                                                <li><a href="{{ route('loadJoblistPage') }}">Search Jobs</a></li>
                                                {{-- <li><a href="{{route('jobseekerProfile')}}">My Account</a></li> --}}
                                                <li><a href="{{ route('loadJoblistPage') }}">Find Employer</a></li>
                                                <li><a href="{{ route('video-resume') }}">Video Resumes</a></li>
                                                {{-- <li><a href="{{route('show_faqs')}}">Job Search Techniques</a></li> --}}
                                                {{-- <li><a>Premium Services <span class="text-danger small">(Coming Soon..)</span></a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                    {{-- Employer Section --}}
                    @if (!auth('jobseeker')->check())
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>EMPLOYER</h4>
                                    <ul>
                                        <li>
                                            <a href="{{ route('new_job_form') }}">Post jobs</a>
                                        </li>
                                        <li><a href="{{ route('resume_filter') }}">Search for right candidate</a></li>
                                        <li><a href="{{ route('questionnaires') }}">Customized Job questionnaires</a>
                                        </li>
                                        {{-- <li><a href="#">Subscription</a></li> --}}
                                    </ul>
                                </div>

                            </div>
                        </div>
                    @endif
                    {{-- Quick Links Section --}}
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Quick Links</h4>
                                <ul>
                                    @if(is_guest())
                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                    <li><a href="{{ route('advertise_with_us') }}">Advertise with Us</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                    <li><a href="{{ route('blog') }}">Blogs</a></li>
                                    @endif
                                    <li><a href="{{ route('show_faqs') }}">Guidelines/FAQs</a></li>
                                    <li><a href="{{ route('get_terms_conditions') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('get_privacy_policies') }}">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- Newsletter --}}
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>NEWSLETTER Subscription</h4>
                                {{-- <div class="footer-pera footer-pera2">
                             <p>Heaven fruitful doesn't over lesser in days. Appear creeping.</p>
                            </div> --}}
                                <!-- Form -->
                                <div class="footer-form">
                                    <div id="mc_embed_signup">
                                        <form action="{{ route('addNewsletter') }}" method="POST" id="newsletterform"
                                            class="subscribe_form relative mail_part">
                                            @csrf
                                            <input type="email" name="newsleeteremail" id="newsletter-form-email"
                                                placeholder="Email Address" class="placeholder newsletteremail hide-on-focus" 
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Email Address'" required>
                                            @error('newsleeteremail')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                            <div class="form-icon">
                                                <button type="submit" name="submit" id="newsletter-submit"
                                                    class="email_icon newsletter-submit button-contactForm"><img
                                                        src={{ asset('assets/img/icon/form.png') }}
                                                        alt=""></button>
                                            </div>

                                            {{-- <span class="btn mt-4" id="unfollow">UnFollow</span><br>
                                     <span id="email_error" class="text-danger"></span>
                                     <div class="mt-10 info"></div> --}}
                                        </form>
                                        <div class="footer-social d-flex mt-3">
                                            <a href="{{ !empty(get_social_links()) ? get_social_links()->facebook_links : '' }}"
                                                title="Facebook" data-toggle="tooltip" data-placement="top"  class="icon-button facebook"><i
                                                    class="fab fa-facebook-f icon-facebook"></i><span></span></a>
                                            <a
                                                href="{{ !empty(get_social_links()) ? get_social_links()->twitter_links : '' }}" class="icon-button twitter" title="Twitter" data-toggle="tooltip" data-placement="top">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-twitter"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                                                <span></span>
                                              </a>
                                            <a href="{{ !empty(get_social_links()) ? get_social_links()->linkedin_links : '' }}"
                                                title="Linkedin" data-toggle="tooltip" data-placement="top"  class="icon-button linkedin "><i
                                                    class="fab fa-linkedin icon-linkedin" aria-hidden="true"></i><span></span></a>
                                            <a href="{{ !empty(get_social_links()) ? get_social_links()->instagram_links : '' }}"
                                                title="Instagram" data-toggle="tooltip" data-placement="top"  class="icon-button instagram  "><i
                                                    class="fab fa-instagram icon-instagram"></i><span></span></a>
                                            <a href="{{ !empty(get_social_links()) ? get_social_links()->youtube_links : '' }}"
                                                title="Youtube" data-toggle="tooltip" data-placement="top"  class="icon-button pinterest"><i
                                                    class="fab fa-youtube icon-youtube"></i><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="row footer-wejed justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <!-- logo -->
                        <div class="footer-logo mb-20">
                            <span class="text-light h4">Real Time Updates :</span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="footer-tittle-bottom">
                            <span id="naukriyan_jobseekers"></span>
                            <p class="h4">Jobseekers</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="footer-tittle-bottom">
                            <span id="naukriyan_employers"></span>
                            <p class="h4">Employers</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <!-- Footer Bottom Tittle -->
                        <div class="footer-tittle-bottom">
                            <span id="naukriyan_jobs"></span>
                            <p class="h4">Jobs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- footer-bottom area -->
    <div class="footer-bottom-area footer-bg">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xl-10 col-lg-10 ">
                        <div class="footer-copy-right text-center">
                            <p>©
                                {{ date('Y') }} All Rights Reserved by Naukriyan. Design & Developed by <a
                                    href="http://prakharsoftwares.com/" target="_blank">
                                    Prakhar Software Solutions Pvt Ltd</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2">
                        <div class="footer-social f-right">
                            <a class="text-muted" href="{{ route('unsubscribe') }}">UnSubscribe</a>
                            {{-- <a href="#"><i class="fab fa-facebook-f"></i></a>
                             <a href="#"><i class="fab fa-twitter"></i></a>
                             <a href="#"><i class="fas fa-globe"></i></a>
                             <a href="#"><i class="fab fa-behance"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
