@extends('layouts.master', ['title' => 'Sample Video Resume'])
@section('content')
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 mt-4">
                <div class="card mb-2">
                    <div class="card-header pt-1 pb-1" id="samplevideoresume" style="background:#e35e25;">
                        <h4 class="mb-0">
                            <span class="text-light" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="true" aria-controls="collapseThree">
                                Sample Video Resume
                        </span>
                        </h4>
                    </div>

                    <div id="collapseThree" class="collapse show" aria-labelledby="samplevideoresume"
                        data-parent="#faqExample">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-4 mb-2">
                                    <div class="embed-responsive embed-responsive-1by1">
                                        <iframe class="embed-responsive-item" width="317" height="237" src="https://www.youtube.com/embed/981p1wD7xc0" title="Umesh Soni - Video Resume" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>

                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="embed-responsive embed-responsive-1by1">
                                       
                                        <iframe class="embed-responsive-item" width="756" height="416" src="https://www.youtube.com/embed/-6xBXhrUZ-A" title="9 July 2021" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="embed-responsive embed-responsive-1by1">
                                        <iframe class="embed-responsive-item" width="317" height="237" src="https://www.youtube.com/embed/dxJAfBQ3T4k" title="RESUME OF MISS PEMA BUTI SONA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
