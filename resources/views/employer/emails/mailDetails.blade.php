@extends('layouts.master', ['title' => 'Mail Details'])
@section('content')
<div class="container">
    <div class="row border my-4">
       
        <div class="col-md-12 d-flex justify-content-center">
            <h1>Mail Details</h1>
        </div>
        <div class="col-md-12">
            <span>Mail Body :</span>
            <p>{!! $body !!}</p>
        </div>
        <div class="col-md-12 my-2">
            <span>Mail Attachments (if any) :</span>
            @forelse ($attachments as $item)
            <ul>
                <li>Filename : {{$item['filename']}}</li>
                <li>Download Url : <a href="{{$item['downloadUrl']}}" class="btn p-3 rounded">View Resume</a> 
                
                     </li>
            </ul>
                
            @empty
                <p class="text-danger">Attachments Not Found</p>
            @endforelse
        </div>
    </div>
</div>
@endsection