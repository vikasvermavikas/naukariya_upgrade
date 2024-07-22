$(document).ready(function () {

    $("#close_modal").click(function () {
        $("#subuser_form")[0].reset();
    });
    $('#updateSubuser').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var subuserid = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#subuserid').val(subuserid);
        var genderlist = ['Male', 'Female', 'Other']; //
        $.ajax({
            url: SITE_URL+"/employer/subuser/get-single-subuserdata/" + subuserid,
            type: "GET",
            success: function (data) {
                modal.find('#updatefname').val(data.fname);
                modal.find('#updatelname').val(data.lname);
                modal.find('#updatecontact').val(data.contact);
                modal.find('#updatedesignation').val(data.designation);
                modal.find('#updateemail').val(data.email);
                var genderoption = '<option>Select Gender</option>';
                $.each(genderlist, function (index, value) {
                    if (value == data.gender) {
                        genderoption += '<option value="' + value + '" selected>' + value + '</option>';
                    }
                    else {
                        genderoption += '<option value="' + value + '">' + value + '</option>';
                    }
                });
                modal.find('#update-gender').html(genderoption);
            }
           
        });
    })
});