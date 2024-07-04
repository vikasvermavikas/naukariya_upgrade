<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-bg footer-padding">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                   <div class="single-footer-caption mb-50">
                     <div class="single-footer-caption mb-30">
                         <div class="footer-tittle">
                             <h4>CANDIDATE</h4>
                             <div class="footer-pera">
                                <ul>
                                    <li><a href="#">Search Jobs</a></li>
                                    <li><a href="#">My Account</a></li>
                                    <li><a href="#">Find Employer</a></li>
                                    <li><a href="#">Video Resumes</a></li>
                                    <li><a href="#">Job Search Techniques</a></li>
                                    <li><a href="#">Premium Services</a></li>
                                </ul>
                            </div>
                         </div>
                     </div>

                   </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>EMPLOYER</h4>
                            <ul>
                                <li>
                                    <a href="#">Post jobs</a>
                                </li>
                                <li><a href="#">Search for right candidate</a></li>
                                <li><a href="#">Customized Job questionnaires</a></li>
                                <li><a href="#">Subscription</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Quick Links</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Advertise with Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Guidelines/FAQs</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Privacy policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>NEWSLETTER</h4>
                            {{-- <div class="footer-pera footer-pera2">
                             <p>Heaven fruitful doesn't over lesser in days. Appear creeping.</p>
                            </div> --}}
                         <!-- Form -->
                         <div class="footer-form" >
                             <div id="mc_embed_signup">
                                 <form action="{{route('addNewsletter')}}"
                                 method="POST" id="newsletterform" class="subscribe_form relative mail_part">
                                 @csrf
                                     <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                                     class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                                     onblur="this.placeholder = 'Email Address'" required>
                                   @error('email')
                                       <span class="text-danger">{{$message}}</span>
                                   @enderror
                                  
                                     <div class="form-icon">
                                         <button type="submit" name="submit" id="newsletter-submit"
                                         class="email_icon newsletter-submit button-contactForm"><img src={{asset('assets/img/icon/form.png')}} alt=""></button>
                                     </div>
                                     <span class="btn mt-4" id="unfollow">UnFollow</span><br>
                                     <span id="email_error" class="text-danger"></span>
                                     <div class="mt-10 info"></div>
                                 </form>
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
                    <a href="{{ route('home') }}"><img src={{asset('assets/images/naukriyan-white-logo.png')}} alt=""></a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                <div class="footer-tittle-bottom">
                    <span>5000+</span>
                    <p>Talented Hunter</p>
                </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="footer-tittle-bottom">
                        <span>451</span>
                        <p>Talented Hunter</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <!-- Footer Bottom Tittle -->
                    <div class="footer-tittle-bottom">
                        <span>568</span>
                        <p>Talented Hunter</p>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <!-- footer-bottom area -->
    <div class="footer-bottom-area footer-bg">
        <div class="container">
            <div class="footer-border">
                 <div class="row d-flex justify-content-between align-items-center">
                     <div class="col-xl-10 col-lg-10 ">
                         <div class="footer-copy-right text-center">
                             <p>© <script>document.write(new Date().getFullYear());</script> All Rights Reserved by Naukriyan. Design & Developed by Prakhar Software Solutions Pvt Ltd</p>
                         </div>
                     </div>
                     <div class="col-xl-2 col-lg-2">
                         <div class="footer-social f-right">
                             <a href="#"><i class="fab fa-facebook-f"></i></a>
                             <a href="#"><i class="fab fa-twitter"></i></a>
                             <a href="#"><i class="fas fa-globe"></i></a>
                             <a href="#"><i class="fab fa-behance"></i></a>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>