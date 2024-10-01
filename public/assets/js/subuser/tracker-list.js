$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const referenceparam = urlParams.get('source');
    const csrftoken = $("meta[name=csrf-token]").attr('content'); 

    function get_references() {
        $.ajax({
            url: SITE_URL + '/subuser/reference-list',
            type: 'GET',
            success: function (data) {
                var html = '<option value="">Select Source</option>';
                $.each(data.data, function (key, value) {
                    if (referenceparam && (value.name == referenceparam)) {
                        html += '<option value="' + value.name + '" selected>' + value.name + '</option>';
                    }
                    else {
                        html += '<option value="' + value.name + '">' + value.name + '</option>';
                    }

                });
                $('#source').html(html);
            }
        });

    }
    // get references.
    get_references();

    $(".exportexcel").click(function () {
      
        var trackerids = [];
        $(".trackerids").each(function () {
            if ($(this).is(":checked")) {
                trackerids.push($(this).val());
            }
        });

        Swal.fire({
            title: "Are you sure you want to download?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, export it!"
        }).then((result) => {
            if (result.isConfirmed) {
                const url =  SITE_URL + '/subuser/trackers/export/tracker/' + trackerids.toString() + '?' +urlParams.toString();

                window.open(url, "_blank");
                    
                // $.ajax({
                //     url: SITE_URL + '/subuser/trackers/export/tracker',
                //     type: 'POST',
                //     data: {
                //         _token: csrftoken,
                //         tracker_ids: trackerids 
                //     },
                //     success: function (data) {
                //     }
                // });
                Swal.fire({
                    title: "Export Sent!",
                    text: "Your data is exported.",
                    icon: "success"
                });
            }
        });


    });
});