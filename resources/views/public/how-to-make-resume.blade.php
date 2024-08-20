@extends('layouts.master', ['title' => 'How to make video resume'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h2>Video Resume</h2>
            </div>
            <div class="col-md-12 my-3">
                <div class="card mb-2">
                    <div class="card-header pt-1 pb-1" style="background:#e35e25;" class="text-light" id="howtomakeresume"
                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="mb-0">
                            <span class="text-light">
                                How to Make Resume
                            </span>
                        </h4>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="howtomakeresume" data-parent="#faqExample">
                        <div class="card-body">
                            <p>
                                A video resume is a tool that you can use to help you get
                                your dream job. It&rsquo;s more than just transforming
                                your paper resume into a video format. It&rsquo;s a way
                                for you to showcase your personality, create a great first
                                impression, and emphasise your talent and skills.
                            </p>
                            <p>
                                Just like a paper resume, you need to cover the
                                essentials: Education Experience Interests Video resume
                                reflects your all round personality. It shows your
                                confidence, gestures, dressing sense, communication skills
                                etc. Let's see the steps to create a video resume and post
                                at Naukriyan.com
                            </p>
                            <p>
                                1. Shoot your video explaining yourself. Explain briefly
                                about your academics, experience, skills, achievements and
                                interest.
                            </p>
                            <p>
                                2. Upload your video on youtube with your personal id.
                                Make the video public or unlisted while uploading.
                            </p>
                            <p>
                                3. Copy your video url from youtube and paste it in
                                <b>Naukriyan</b> update profile video resume section.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
