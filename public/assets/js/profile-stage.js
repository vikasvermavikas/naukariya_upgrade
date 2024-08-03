$(document).ready(function () {
 

    var abc = 0;
    var bcd = [];

    // first name

    $('#fname').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#fname_error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#fname_error').html('please enter only character');
            return false;
        }
    });

    // last name


    $('#lname').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#lname_error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#lname_error').html('please enter only character');
            return false;
        }
    });

    // email  

    $(document).ready(function () {
        $('#email').on('input', function () {
            var email = $(this).val();
            var regex = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/;

            if (regex.test(email)) {
                $('#email_error').html('');
            } else {
                $('#email_error').html('Please enter a valid email');
            }
        });
    });


    // contact

    $('#phone').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            $('#phone_error').html('Please enter only digits.');
            return false;

        } else {
            $('#phone_error').html('');

        }
        if ($(this).val().length >= 10) {
            $('#phone_error').html('');
            return false;
        }
    });

    // Designation
    $('#Designation').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#Designation_error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#Designation_error').html('please enter only character');
            return false;
        }
    });

    // prefered loaction

    $('#Loaction').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#Loaction_error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#Loaction_error').html('please enter only character');
            return false;
        }
    });




    // Education validation for character

    // Qualification

    $('#qualification').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#qualification-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#qualification-error').html('please enter only character');
            return false;
        }
    });

    // course


    $('#course').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#course-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#course-error').html('please enter only character');
            return false;
        }
    });

    // passsing year
    $('#syear').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            $('#Syear-error').html('Please enter only digits.');
            return false;

        } else {
            $('#Syear-error').html('');

        }
        if ($(this).val().length >= 4) {
            $('#Syear-error').html('');
            return false;
        }
    });

    // university
    $('#college').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#college-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#college-error').html('please enter only character');
            return false;
        }
    });

    // Institute loaction

    $('#loaction').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#loaction-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#loaction-error').html('please enter only character');
            return false;
        }
    });

    // profssional Fieldset

    // Designation


    $('#designation').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#designation-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#designation-error').html('please enter only character');
            return false;
        }
    });

    // Organization Name
    $('#Organization').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#Organization-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#Organization-error').html('please enter only character');
            return false;
        }
    });

    // Job type
    $('#job').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#job-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#job-error').html('please enter only character');
            return false;
        }
    });


    // salary LPA

    $('#salary').keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
            $('#Syear-error').html('Please enter only digits.');
            return false;

        } else {
            $('#salary-error').html('');

        }
        if ($(this).val().length >= 7) {
            $('#salary-error').html('');
            return false;
        }
    });
    // key skills professional

    $('#skills').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#skills-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#skills-error').html('please enter only character');
            return false;
        }
    });
    // Responsblity

    // $('#Responsibility').keypress(function(e) {
    //     var regex = new RegExp("^[a-zA-Z]+$");
    //     var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    //     if (regex.test(str)) {
    //         $('#responsblity-error').html('');
    //         return true;
    //     } else {
    //         e.preventDefault();
    //         $('#responsblity-error').html('please enter only character');
    //         return false;
    //     }
    // });


    // Certificate inputs fields validation

    // Certificate Course name

    $('#CourseName').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            $('#CourseName-error').html('');
            return true;
        } else {
            e.preventDefault();
            $('#CourseName-error').html('please enter only character');
            return false;
        }
    });

    // Certificate Institute name

    // $('#institute-name').keypress(function(e) {
    //     var regex = new RegExp("^[a-zA-Z]+$");
    //     var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    //     if (regex.test(str)) {
    //         $('#institute-error').html('');
    //         return true;
    //     } else {
    //         e.preventDefault();
    //         $('#institute-error').html('please enter only character');
    //         return false;
    //     }
    // });


    function update_stage(stagevalue) {
        $.ajax({
            url: SITE_URL + "/jobseeker/skip-stage/" + stagevalue,
            type: 'GET',
            success: function (response) {

            }
        });
    }

    // $('#home-next').click(function() {
    $("form#msform").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        bcd = [];

        // Server side validation.
        $(".tab1").each(function (index) {

            if ($(this).val() == "") {
                var error = $(this).data('id');
                var id = $(this).attr('id');
                var classes = $(this).attr('class');
                //  alert(error)
                $('#' + error).html('Please fill ' + id);

                abc = 0;

                bcd.push(abc);
            } else {
                var id = $(this).attr('id');
                //  alert(id)
                var error = $(this).data('id');
                $('#' + error).html('');
                abc = 1;
                bcd.push(abc);

            }
        });

        if ($.inArray(0, bcd) > -1) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill all required fields",
            });
        } else {

            // Submit profile form.
            $.ajax({
                url: SITE_URL + "/jobseeker/persnol-save",
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.status) {

                        // Update stage.
                        update_stage(1);

                        Swal.fire({
                            icon: "success",
                            title: "Thank you!",
                            text: "Your profile updated successfully",
                        });
                    }
                    // // Reset the form
                    $('#field-2').show();
                    $('#field-1').hide();
                    $('#educationid').addClass('active');
                },
                cache: false,
                contentType: false,
                processData: false

            });


        }

    })

    // Home previous button

    $('#home-prev').click(function () {
        $('#field-2').hide();
        $('#field-1').show();
        $('#educationid').removeClass('active')

    })

    // Education next btn

    var abc = 0;
    var bcd = [];

    // $("#home-next-2").click(function() {
    $("form#education_form").submit(function (e) {
        e.preventDefault();

        // var formData = new FormData(this);

        // bcd = []
        // $(".tab2").each(function(index) {

        //     if ($(this).val() == "") {
        //         var error = $(this).data('id');
        //         var id = $(this).attr('id');
        //         var classes = $(this).attr('class');
        //         // alert(classes)
        //         // alert(id)
        //         $('#' + error).html('Please fill ' + id);
        //         abc = 0;
        //         bcd.push(abc);
        //     } else {
        //         $('#' + error).html('');
        //         var error = $(this).data('id');
        //         $('#' + error).html('');
        //         abc = 1;
        //         bcd.push(abc);


        //     }
        // });

        // if ($.inArray(0, bcd) > -1) {
        //     Swal.fire({
        //         icon: "error",
        //         title: "Oops...",
        //         text: "Please fill all required fields",
        //     });
        // } else {

        $.ajax({
            url: SITE_URL + "/jobseeker/add-education-detail",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    update_stage(2);

                    Swal.fire({
                        icon: "success",
                        title: "Thank you!",
                        text: response.message,
                    });
                    $('#field-3').show();
                    $('#field-2').hide();
                    $('#professionalid').addClass('active');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'Something went wrong',
                    });
                }
            }
        });


        // }

    })

    // Third Section nextbtn  ;
    // currently working code
    $(document).on('change', 'input:checkbox.currentwork', function () {
        // Enable all .pro_todate inputs
        //   $('.pro_todate').prop('disabled', false);

        if ($(this).is(':checked')) {
            // $(this).attr('value', 'truevalue');

            $(this).closest('.card-outer').find('.pro_todate').prop('disabled', true);
        } else {
            // $(this).attr('value', 'falsevalue');
            $(this).closest('.card-outer').find('.pro_todate').prop('disabled', false);
        }
    });
    // Add more experience elements code
    $("#addExperience").click(function () {
        $(".pro_main_node .pro_child_node:first").clone().appendTo(".pro_main_node");
        $(".pro_main_node .pro_child_node:last").find(".tab3").val(''); // Clear all text inputs.
        $(".pro_main_node .pro_child_node:last").find("input:checkbox.currentwork").prop('checked',
            false); // clear current work element
        $(".pro_main_node .pro_child_node:last").find(".pro_todate").prop('disabled',
            false); // clear to date element
        $(".pro_main_node .pro_child_node:last .container:last").after(
            "<div class='col-md-12 mb-5'><button class='btn float-right proremove'>Remove</button></div>"
        );

    });

    var ids_to_removed = [];
    $(document).on("click", ".proremove", function () {
        // Collect removed ids.
        var removedid = $(this).closest(".pro_child_node").find(".removedprofessional").val();
        if (removedid) {
            ids_to_removed.push(removedid);
        }
        $(this).closest(".pro_child_node").remove();
    });
    // End add more experience elements code

    // Collect form data and append unchecked checkboxes
    function removeToDateValues(formData) {
        return formData.filter(function (item) {
            return item.name !== 'todate[]';
        });
    }

    function serializeFormWithDisabledDate(form) {
        let serializedData = $(form).serializeArray();
        serializedData = removeToDateValues(serializedData);
        serializedData.push({
            name: 'removedprofessional[]',
            value: ids_to_removed.join(',')
        });
        $(form).find('.pro_todate').each(function () {
            if ($(this).prop('disabled')) {
                serializedData.push({
                    name: $(this).attr('name'),
                    value: '    '
                });
            } else {
                serializedData.push({
                    name: $(this).attr('name'),
                    value: $(this).val()
                });

            }
        });



        return serializedData;
    }

    var abc = 0;
    var bcd = [];
    $("form#professionalForm").submit(function (e) {
        e.preventDefault();

        bcd = []

        // $(".tab3").each(function(index) {

        //     if ($(this).val() == "") {
        //         var error = $(this).data('id');
        //         // var id = $(this).attr('id');
        //         var id = $(this).attr('name');
        //         var classes = $(this).attr('class');
        //         // alert(classes)
        //         $('#' + error).html('Please fill ' + id);
        //         abc = 0;
        //         bcd.push(abc);
        //     } else {
        //         $('#' + error).html('');
        //         var error = $(this).data('id');
        //         $('#' + error).html('');
        //         abc = 1;
        //         bcd.push(abc);


        //     }
        // });

        if ($.inArray(0, bcd) > -1) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill all required fields",
            });
        } else {
            let formData = serializeFormWithDisabledDate(this);

            $.ajax({
                url: SITE_URL + "/jobseeker/add-professional-detail-stage",
                type: "POST",
                data: $.param(formData),
                success: function (response) {
                    if (response.success) {
                        update_stage(3); // update stage.

                        Swal.fire({
                            icon: "success",
                            title: "Thank you!",
                            text: response.message,
                        });
                        $('#field-4').show();
                        $('#field-3').hide();
                        $('#skillid').addClass('active');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message,
                        });
                    }
                }
            });
            // $('#field-4').show();
            // $('#field-3').hide();
            // $('#confirm').addClass('active');

        }

    });

    $('#Third-prev').click(function () {
        $('#field-2').show();
        $('#field-3').hide();
        $('#professionalid').removeClass('active');


    })

    $("form.add_skill_form").submit(function (e) {
        e.preventDefault();

        let skill = $("#skills").val();
        let error = ("#skillstab-error");
        if (skill == "") {
            error.text("enter a skill")

        } else {
            // Now submit the form.

            $.ajax({
                url: SITE_URL + "/jobseeker/add-skill-detail",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        update_stage(4);  // Update the stage.
                        Swal.fire({
                            icon: "success",
                            title: "Thank you!",
                            text: response.message,
                        });
                        $('#field-5').show();
                        $('#field-4').hide();
                        $('#certificateid').addClass('active');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message,
                        });
                    }
                }
            });


        }

    });

    // fourth prev;

    $('#Fourth-prev').click(function () {
        $('#field-3 ').show();
        $('#field-4').hide();
        $('#skillid').removeClass('active')

    });

    $('#Fifth-prev').click(function () {
        $('#field-4 ').show();
        $('#field-5').hide();
        $('#certificateid').removeClass('active')

    })

    // subit btn

    var abc = 0;
    var bcd = [];

    // Code for certificate form.

    var removed_certificate_ids = [];
    // Remove certificate form.
    $(document).on("click", ".certremove", function () {
        // Collect removed ids.
        var removedid = $(this).closest(".child_certificate_card").find(".certificateid").val();
        if (removedid) {
            removed_certificate_ids.push(removedid);
        }
        $(this).closest(".child_certificate_card").remove();
    });

    // Add more experience elements code
    $("#addCertificate").click(function () {
        $(".parent_certificate_card .child_certificate_card:first").clone().appendTo(".parent_certificate_card");
        $(".parent_certificate_card .child_certificate_card:last").find(".tab5").val(''); // Clear all text inputs.
        $(".parent_certificate_card .child_certificate_card:last").find(".certificateid").val(''); // Clear all text inputs.
        $(".parent_certificate_card .child_certificate_card:last .container:last").after(  // Add remove button
            "<div class='col-md-12 mb-5'><button class='btn float-right certremove'>Remove</button></div>"
        );

    });

    $("form#certificate_form").submit(function (e) {
        e.preventDefault();
        bcd = []
        $(".tab5").each(function (index) {

            if ($(this).val() == "") {
                var error = $(this).data('id');
                var id = $(this).attr('id');
                var classes = $(this).attr('class');
                // alert(classes)
                $('#' + error).html('Please fill ' + id);
                abc = 0;
                bcd.push(abc);
            } else {
                $('#' + error).html('');
                var error = $(this).data('id');
                $('#' + error).html('');
                abc = 1;
                bcd.push(abc);


            }
        });
        if ($.inArray(0, bcd) > -1) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill all required fields",
            });
            // alert('please fill all values')
        } else {
            var formvalues = $(this).serializeArray();
            formvalues.push({
                name: 'removedids[]',
                value: removed_certificate_ids.join(',')
            });
            $.ajax({
                url: SITE_URL + "/jobseeker/add-certification-detail-stage",
                type: "POST",
                data: formvalues,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        update_stage(5);  // Update the stage.
                        Swal.fire({
                            icon: "success",
                            title: "Thank you!",
                            text: response.message,
                        });
                        window.location.href = SITE_URL + "/dashboard/jobseeker";
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: response.message,
                        });
                    }
                }
            });

            // alert("submit succcessfully Thankyou")

        }

    });

});