<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <h1>Your Mails</h1>
    <div class="container">
        <p>Total Messages : {{ count($messages) }}</p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>S No.</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Content Type</th>
                        <th>Download Status</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @forelse($messages as $message)
                        @php
                            
                            if ($message->hasAttachments()) {
                                $attachments = $message->getAttachments();
                            } else {
                                continue;
                            }
                        @endphp
                        <tr>
                            <td rowspan="{{ count($attachments) }}">{{ $loop->iteration }}</td>
                            <td rowspan="{{ count($attachments) }}">{{ $message->subject }}</td>
                            <td rowspan="{{ count($attachments) }}">{{$message->date}}</td>
                            @foreach ($attachments as $attachment)
                                @php
                                    $status = $attachment->save(public_path() . '/mail_attachments/', $filename = time()."_".$i.".".$attachment->getExtension());
                                    store_attachment([
                                        'date' => $message->date,
                                        'filename' => $attachment->name,
                                        'stored_file' => $filename,
                                        'download_status' => $status ? 'downloaded' : null
                                    ]);
                                    $i++;
                                @endphp
                                <td>{{ $attachment->content_type }}</td>
                                <td>{{ $status ? 'downloaded' : '' }}</td>
                                <td>{{ $attachment->name }}</td>
                            @endforeach
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>
