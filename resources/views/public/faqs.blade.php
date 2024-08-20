@extends('layouts.master', ['title' => 'FAQs'] )
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 my-3">
            <h1 style="color: #e35e25;">FAQs</h1>
        </div>
        <div class="col-md-12">
            @forelse($faqs as $faq)
                <div class="card mb-3">
                    <div class="card-header font-weight-bold text-light" style="background:#e35e25;">
                        Q - {{ $faq->question }}
                    </div>
                    <div class="card-body">
                        <b>Answer:</b>  <p class="card-text">{!! $faq->answer !!}</p>
                    </div>
                </div>
                @empty
                <p class="text-danger text-center">No FAQs found.</p>
            @endforelse
        
        </div>
    </div>
</div>
@endsection