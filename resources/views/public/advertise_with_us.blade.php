@extends('layouts.master', ['title' => 'Advertise With Us'])
@Section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h1 style="color:#e35e25;">Advertise With Us</h1>
            </div>
            <div class="col-md-12 my-2">
                <div class="card">
                    <div class="card-body">
                        @if ($advertise_with_us->advertise_with_us)
                        {!! $advertise_with_us->advertise_with_us !!}
                        @else
                            <p class="text-danger text-center">No Data Found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
