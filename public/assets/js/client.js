$(document).ready(function () {

    $("#close_modal").click(function () {
        $("#client_form")[0].reset();
    });
    $('#updateClient').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var clientid = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#clientid').val(clientid);

        $.ajax({
            url: SITE_URL+"/employer/get-clientdata/" + clientid,
            type: "GET",
            success: function (data) {
                modal.find('#updateclientname').val(data.name);
                modal.find('#updateclientemail').val(data.email);
                modal.find('#updateclientcontact').val(data.contact);
                modal.find('#updateclientaddress').val(data.address);
            }
           
        });
    })
});