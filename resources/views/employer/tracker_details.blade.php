@extends('layouts.master', ['title' => 'Tracker Details'])
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Tracker Details</h2>
		</div>
		<div class="col-md-8 my-3">
			<div class="embed-responsive embed-responsive-4by3">
  <iframe class="embed-responsive-item" src={{'https://docs.google.com/gview?url='.asset("tracker/resume/".$tracker->resume).'&embedded=true'}} allowfullscreen></iframe>
</div>
		</div>

		<div class="col-md-4 justify-content-center">
	<div class="card shadow w-75 mx-auto" >
  <div class="card-header text-center" style="background-color: #e35e25;">
   	<img src="{{asset('default_images/no_image_available.png')}}" class="img-fluid rounded-circle" />
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action h4">{{$tracker->name}}</li>
    @if($tracker->current_designation)
    <li class="list-group-item list-group-item-action">{{$tracker->current_designation}}</li>
    @endif
    <li class="list-group-item list-group-item-action"><i class="far fa-envelope"></i> {{$tracker->email}}</li>
    <li class="list-group-item list-group-item-action"><i class="fas fa-phone"></i> {{$tracker->contact}}</li>
    <li class="list-group-item list-group-item-action"><i class="fas fa-briefcase"></i> {{$tracker->experience." years"}}</li>
    <li class="list-group-item list-group-item-action"><i class="fas fa-rupee-sign"></i> {{$tracker->current_ctc." LPA"}}</li>
    <li class="list-group-item list-group-item-action"><i class="fas fa-graduation-cap"></i>{{$tracker->graduation ? $tracker->graduation : 'Null'}} {{$tracker->post_graduation ? ", ".$tracker->post_graduation : ''}}</li>
    <li class="list-group-item list-group-item-action"><i class="fas fa-cogs"></i> : {{$tracker->key_skills}}</li>

  </ul>

</div>

		<div class="mt-3">
			<p class="text-center"><a href="{{asset('tracker/resume/'.$tracker->resume.'')}}" class="btn rounded shadow" download>Download resume <i
                      class="fas fa-download"></i></a></p>
		</div>


		</div>
	</div>
</div>
@endsection