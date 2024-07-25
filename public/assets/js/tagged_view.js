$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search);
    function get_tags() {

        $.ajax({
            url: SITE_URL + '/employer/tags/get-tag',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var html = '<option value="">Select Tags</option>';
                $.each(response.data, function (index, item) {
                    if (urlParams.has('tag') && urlParams.get('tag') == item.id) {

                        html += '<option value="' + item.id + '" selected>' + item.tag + '</option>';
                    }
                    else {

                        html += '<option value="' + item.id + '">' + item.tag + '</option>';
                    }
                });
                $("#tag").html(html);
            }
        });
    }
    get_tags();

    // Code for iframe resume modal

    $('#viewResumemodal').on('show.bs.modal', function (event) {
        var modal = $(this);
        // modal.find('.modal-body iframe').attr("src", '');
        var button = $(event.relatedTarget) // Button that triggered the modal
        var documenturl = button.data('whatever') // Extract info from data-* attributes
        modal.find('.modal-body iframe').attr("src", documenturl);
    })

    // Reset search.
    $(".resetsearch").click(function() {
        window.location.href = SITE_URL + '/employer/tags/gettagresume';
    });
});