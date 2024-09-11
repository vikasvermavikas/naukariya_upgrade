$(document).ready(function() {
    // After submit form.
    $("form#parseresume").submit(function(e){
        e.preventDefault();
        $(".submit").attr('disabled', 'disabled');
        Swal.showLoading();
        
        // AJAX request
        $.ajax({
            url: SITE_URL + "/employer/parse-resume",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                
                if(response.success) {
                    Swal.fire({
                        icon: "success",
                        title: 'Congratulations',
                        text: response.message,
                        confirmButtonText: "Continue"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = SITE_URL+"/employer/resume-details/"+response.jobid;
                        }
                    });
                } 
                else {
                    Swal.fire({
                        icon: "error",
                        title: response.message,
                        confirmButtonText: "Try again"
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: error.exception,
                    text: error.message,
                    confirmButtonText: "Try again"
                });
                $(".submit").removeAttr('disabled');
            }
        });
    });
});