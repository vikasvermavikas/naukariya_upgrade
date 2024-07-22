@extends('layouts.master', ['title' => 'Contant Us'])
@section('content')
 <!-- Hero Area Start-->
 <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Contact us</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Hero Area End -->
<!-- ================ contact section start ================= -->
<section class="contact-section">
        <div class="container">
            <div class="d-none d-sm-block mb-2 pb-2 card shadow">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14020.409158098062!2d77.210832!3d28.536645!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce1f700000001%3A0x68dca73f09d47c81!2sPrakhar%20Software%20Solutions%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1718702674922!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8 card text-color shadow">
                    <form class="form-contact contact_form p-2 " method="post" id="myForm">
                        @csrf
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
                                   
                                        <small class="text-danger" id="nameerror"></small>
                            
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                   
                                        <small class="text-danger" id="emailerror"></small>
                                  
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="contact_no" id="contact_no" type="contact_no" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Contact Number'" placeholder="Enter Contact Number">
                                    <small class="text-danger" id="contact_no_error"></small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="remarks" id="remarks" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
                                
                                            <small class="text-danger" id="remarkserror"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="button" id="submit_contact_form" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1 card shadow p-2">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Delhi, India</h3>
                            <p>C – 11, LGF, Opp. State Bank of India, Malviya Nagar, New Delhi - 110017</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>+91 11 4010 4369</h3>
                            <p>Mon to Sat 9:30 am to 6:30 pm</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>info@prakharsoftwares.com</h3>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- ================ contact section end ================= -->

@endsection
@section('script')

    <script src="{{ asset('assests/js/custom_js/contact.js') }}"></script>
@endsection
