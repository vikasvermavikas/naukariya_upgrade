$(document).ready(function () {
    // Get designations.
    $('.designation').autocomplete();
    
    const csrf = $("meta[name=csrf-token]").attr('content');

    function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
    }
    
    function setEmailError(textvalue){
        $(".emailerror").text(textvalue);
    }

    function setEmailSuccess(textvalue){
        $(".emailsuccess").text(textvalue);
    }

    $("#email").focusout(function () {
        setEmailSuccess('');
            const element = $(this);
            var emailval = element.val();
            var emailerror = '';
            if (!emailval) {
                emailerror = 'Email field is required';
                setEmailError(emailerror);

                $(".savechanges").attr('disabled', true);
            }
            else if (!validateEmail(emailval)) {
                emailerror = 'Invalid Email';
                setEmailError(emailerror);
                element.val('');

                $(".savechanges").attr('disabled', true);

            }
            else{
                $.ajax({
                    url : SITE_URL+'/subuser/trackers/validate_email/'+emailval,
                    type : 'post',
                    dataType : 'json',
                    data : {
                        email : emailval,
                        _token : csrf
                    },
                    success : function (response){
                        if (response.success) {
                         setEmailError('');
                         setEmailSuccess('Available');
                        $(".savechanges").attr('disabled', false);

                        }
                        else {
                         setEmailSuccess('');
                         setEmailError(response.message);
                        element.val('');


                        }
                    },
                    error : function (e){
                $(this).val('');

                    }
                })
            }
        });

    function get_reference_list() {
        $.ajax({
            url: SITE_URL + '/subuser/reference-list',
            type: 'GET',
            success: function (data) {
                var html = '<option value="">Select Reference Name</option>';
                $.each(data.data, function (key, value) {
                    html += '<option value="' + value.name + '">' + value.name + '</option>';
                });
                html += '<option value="add_reference">Others</option>';
                $('#reference').html(html);
            }
        });
    }
    get_reference_list();
    // Call to add reference modal.
    $('#reference').change(function () {
        var referenceValue = $(this).val();
        if (referenceValue == 'add_reference') {

            $('#addReference').modal('show');
        }
    });

    // Save new reference.
    $("form.add_reference_form").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: "POST",
            url: SITE_URL + '/subuser/add-reference',
            data: form.serialize(),
            success: function (data) {
                if (data.success) {
                    $("#addReference").modal('hide');
                    get_reference_list();
                    form.trigger("reset");
                    Swal.fire({
                        title: 'Congratulations',
                        text: data.message,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message,
                    });
                }

            }
        });
    });

    // Add more functionality of company details.
    $(".addmore").click(function () {
        $(".parentcompany .childcompany:first").clone().appendTo(".parentcompany");
        $(".parentcompany .childcompany:last").find(".companydetails").val(''); // Clear all text inputs.
        $(".parentcompany .childcompany:last").find(".currenlyLog").remove(); // Clear all text inputs.
        $(".parentcompany .childcompany:last").find(".companydetails:last").prop("disabled", false); // Make todate field indisabled.
        // Add remove button
        $(".parentcompany .childcompany:last div:last").after(
            "<div class='col-md-12 mb-2'><button class='btn-secondary rounded float-right removecompany'>Remove</button></div>"
        );

    });

    // Remove company details.
    $(document).on("click", ".removecompany", function () {
        $(this).closest(".childcompany").remove();
    });

    // Disable currently working.
    $("input:checkbox.currentlyworking").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest(".childcompany").find('.companydetails:last').prop("disabled", true);
        } else {
            $(this).closest(".childcompany").find('.companydetails:last').prop("disabled", false);
        }
    });

    // Get cities based on selected state.
    $("#hometown_state").change(function () {
        var stateid = this.value;
        $.ajax({
            url: SITE_URL + '/subuser/get-cities/data/' + stateid,
            type: 'GET',
            success: function (data) {
                var html = '<option value="">Select City</option>';
                $.each(data.data, function (key, value) {
                    html += '<option value="' + value.cities_name + ' ">' + value.cities_name + '</option>';
                });
                $("#hometown_city").html(html);
            }
        });
    });

    // Remove dropdown designation on focus out.
    $(document).on('click', function (e) {
        const $input = $('input.designation');
        const $dropdown = $input.closest('div').find('div.dropdown-menu');

    // If click is NOT on input or dropdown
    if (!$input.is(e.target) && !$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
        $dropdown.removeClass('show');
    }

    });

    // Disable submit on form submit.
    $("form.add_tracker_form").submit(function () {
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
        Swal.fire({
            title: "processing...",
            html: "<b>please wait</b>",
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick : false
        });
    });


});