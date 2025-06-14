<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>Resume Details</title>

</head>

<body>
    <div class="container">
        <div class="row border shadow mt-2">
            <div class="col-md-12 mt-3 d-flex justify-content-center">
                <h2 class="animate__zoomIn">Resume Details</h2>
            </div>

            <div class="table-responsive my-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>File Name</th>
                            <th>status</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                        </tr>
                        @foreach($candidates as $candidate)
                        <tr>
                            <td>{{ isset($candidate['data']) ? $candidate['data']['id'] : '' }}</td>
                            <td>{{ isset($candidate['filename']) ? $candidate['filename'] : '' }}</td>
                            <td>{{ isset($candidate['data']) ? $candidate['data']['attributes']['status'] : '' }}</td>
                            <td>{{ isset($candidate['data']) && $candidate['data']['attributes']['status'] == 'success' ? $candidate['data']['attributes']['result']['candidate_name'] : '' }}</td>
                            <td>{{ isset($candidate['data']) && $candidate['data']['attributes']['status'] == 'success' ? $candidate['data']['attributes']['result']['candidate_email'] : '' }}</td>
                            <td>{{ isset($candidate['data']) && $candidate['data']['attributes']['status'] == 'success' ? $candidate['data']['attributes']['result']['candidate_phone'] : '' }}</td>
                        </tr>
                        @endforeach
                    </thead>
                </table>
            </div>


        </div>
    </div>
</body>

</html>
