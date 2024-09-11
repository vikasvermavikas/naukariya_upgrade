<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gmails</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row border my-4">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{session()->get('success')}}
              </div>
            @endif
        </div>
        <div class="col-md-12">
            <h1>Gmails</h1>
        </div>
        <div class="col-md-12">
           <p>Token : {{$token}}</p>
        </div>

    </div>
</div>
</body>
</html>