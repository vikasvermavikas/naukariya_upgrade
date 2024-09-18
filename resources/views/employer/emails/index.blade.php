@extends('layouts.master', ['title' => 'Emails'])
@section('content')
<div class="container">
    <div class="row border my-4">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{session()->get('message')}}
              </div>
            @endif
             @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{session()->get('message')}}
              </div>
            @endif
        </div>
        <div class="col-md-12 d-flex justify-content-center">
            <h1>Inbox Mails</h1>
        </div>
        <div class="col-md-12">
           <div class="table-responsive">
            <table class="table hover border">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Sender</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Exported By</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $mail)
                    <tr>
                        <th scope="row">{{$mail['message']['messageid']}}</th>
                        <td>{{ isset($mail['message']['received']) ?  Illuminate\Support\Str::words($mail['message']['received']['value'], 3, '...') : ''}}</td>
                        <td>{{ isset($mail['message']['subject']) ?  $mail['message']['subject']['value'] : ''}}</td>
                        <td>{{ isset($mail['message']['date']) ?  $mail['message']['date']['value'] : ''}}</td>

                        <!-- If mail is fetched and saved then show Exported status otherwise pending. -->
                        @if($mail['exported'])
                        <td class="text-success">Exported</td>
                        <td>{{$mail['exported_by']}}</td>
                         <td class="text-center">
                            <a href="{{ route('emails.read', ['messageid' => $mail['message']['messageid']]) }}" class="btn p-3 rounded">Read</a>
                        </td>
                        @else
                        <td class="text-warning">Pending</td>
                        <td>{{$mail['exported_by']}}</td>
                         <td>
                            <a href="{{ route('emails.read', ['messageid' => $mail['message']['messageid']]) }}" class="btn p-3 rounded">Fetch & Save</a>
                        </td>
                        @endif

                       
                    </tr>
                    @endforeach
            </table>
           </div>
        </div>

    </div>
</div>
@endsection

