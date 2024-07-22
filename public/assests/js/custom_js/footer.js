$(document).ready(function() {
    // Event listener for form submission
    $('#newsletterform').submit(function(event) {
        event.preventDefault(); // Prevent form submission
        var email = $("#newsletter-form-email").val();

        $.ajax({
            url : SITE_URL+'/add-newsletter',
            method : 'POST',
            dataType : "json",
            data : {
                email : email,
                _token : $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                if (response.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                      });
                      $("#newsletter-form-email").val('');
                }
                else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
      }

    function UnFollow(email){
        $.ajax({
            url : SITE_URL+'/unfollow-newsletter',
            method : 'POST',
            dataType : "json",
            data : {
                email : email,
                _token : $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                if (response.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }
    // UnFollow the registered user.
    $("#unfollow").click(function(){
        var email = $("#newsletter-form-email").val();
        var err = '';
        var submission = true;
        if (email == "") {
            err = 'Email is required';
            submission = false;
        }
       else if (!isEmail(email)) {
            err = 'Please provide valid Email';
            submission = false;
        }

        if (submission) {
            $("#email_error").text('');
            UnFollow(email);
        $("#newsletter-form-email").val('');

        }
        else {
            $("#email_error").text(err);
        }
    });
});