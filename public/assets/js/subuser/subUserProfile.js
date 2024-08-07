$(document).ready(function () {
    $("#change-pas").click(function () {
        $(this).addClass("personal");
        $("#personal-pera").removeClass("personal");
        $("#form-right").hide();
        $("#right-update-btn").hide();
        $("#form-fieldSet2").show();
        $("#second-forn-btn").show();


    });
    $("#personal-pera").click(function () {
        $(this).addClass("personal")
        $("#change-pas").removeClass("personal");
        $("#form-right").show();
        $("#right-update-btn").show();
        $("#form-fieldSet2").hide();
        $("#second-forn-btn").hide();
    });

    // Preview Image by button

    // Upload profile image.
    $('#upload-btn').click(function () {
        $('<input type="file" accept=".jpg,.jpeg,.png" name="image" required>').on('change', function (event) {
            var form = $("form.imageform");
            var formData = new FormData(form[0]);
            var files = $(this)[0].files[0];
            formData.append('image', files);
            $.ajax({
                url: SITE_URL + '/subuser/update/subuser/profileimage',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (response) {
                        if (response.status) {
                            $("#error-image").text(''); // Empty error message.
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#imgPreview').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(files);    // Set image.

                            Swal.fire({
                                title: "Congratulations",
                                text: response.message,
                                icon: "success"
                              });
                            }
                            else {
                            Swal.fire({
                                title: "Failed",
                                text: response.message,
                                icon: "error"
                              });
                        }
                    
                },
                error: function (error) {
                    if (error.responseJSON.errors.image) {
                        $("#error-image").text(error.responseJSON.errors.image[0]);
                        return false;
                    }
                }
            });

        }).click();
    });

});