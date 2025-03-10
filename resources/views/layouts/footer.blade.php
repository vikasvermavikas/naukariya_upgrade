<link rel="stylesheet" type="text/css" href="{{asset('assets/css/footer.css')}}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
