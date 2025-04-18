$(document).ready(function () {
    // $('#submit_contact_form').on('click', function(e) {
    $('form#myForm').on('submit', function(e) {
        e.preventDefault(); 

        // Clear previous errors
        $('#nameerror').html('');
        $('#emailerror').html('');
        $('#contact_no_error').html('');
        $('#remarkserror').html('');

        var remarks = $('#remarks').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var contact_no = $('#contact_no').val();

        var hasError = false;

        if(name == ''){
            $('#nameerror').html('Name field is required');
            hasError = true;
        }

        if(email == ''){
            $('#emailerror').html('Email field is required');
            hasError = true;
        }

        if(contact_no == ''){
            $('#contact_no_error').html('Contact Number field is required');
            hasError = true;
        }

        if(remarks == ''){
            $('#remarkserror').html('Remarks field is required');
            hasError = true;
        }

        // If any error, return without proceeding to AJAX
        if (hasError) {
            return;
        }
        Swal.fire('Please wait...');
        Swal.showLoading();

        // Submit the form.
        $.ajax({
            type: "POST",
            url: SITE_URL+"/add-contactus-detail",
            data: {
                name: name, 
                email: email, 
                contact_no: contact_no, 
                remarks: remarks,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.hideLoading()
                $('#myForm')[0].reset();

                Swal.fire(response.message);
            },
            error: function(xhr, status, error) {
                Swal.hideLoading()
                var response = JSON.parse(xhr.responseText);
                
                if (response.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.message,
                      });
                }
               
            }
        });
    });
});
