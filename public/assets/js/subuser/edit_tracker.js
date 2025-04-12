$(document).ready(function () {
    // Get designations.
    $('.designation').autocomplete();

    function get_cities(stateid = '') {
        var cityid = '';
        if (!stateid) {
            var stateid = $("#hometown_state").val();
            cityid = $("#cityid").val();
        }

        // If stateid is not empty, then return cities.
        if (stateid) {
            $.ajax({
                url: SITE_URL + '/subuser/get-cities/data/' + stateid,
                type: 'GET',
                success: function (data) {
                    var html = '<option value="">Select City</option>';
                    $.each(data.data, function (key, value) {
                        if (value.cities_name == cityid || value.id == cityid) {
                            html += '<option value="' + value.cities_name + ' " selected>' + value.cities_name + '</option>';
                        }
                        else {
                            html += '<option value="' + value.cities_name + '">' + value.cities_name + '</option>';
                        }
                    });
                    $("#hometown_city").html(html);
                }
            });
        }
    }

    function get_reference_list() {
        var referenceid = $("#referenceid").val();
        $.ajax({
            url: SITE_URL + '/subuser/reference-list',
            type: 'GET',
            success: function (data) {
                var html = '<option value="">Select Reference Name</option>';
                $.each(data.data, function (key, value) {
                    if (referenceid && (value.name == referenceid)) {
                        html += '<option value="' + value.name + '" selected>' + value.name + '</option>';
                    }
                    else {
                        html += '<option value="' + value.name + '">' + value.name + '</option>';
                    }

                });
                html += '<option value="add_reference">Others</option>';
                $('#reference').html(html);
            }
        });
    }
    get_reference_list();
    get_cities();
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
            "<div class='col-md-12 mb-2'><button type='button' class='btn-secondary rounded float-right removecompany'>Remove</button></div>"
        );

    });

    // Remove company details.
    var removed_exp = [];
    $(document).on("click", ".removecompany", function () {
        $(this).closest(".childcompany").remove();

        // Removed experiences.
        var removedExperience = $(this).closest(".childcompany").find("#experiencedid").val();
        removed_exp.push(removedExperience);
        $("#removedexperiences").val(removed_exp);
        console.log($("#removedexperiences").val());
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
        get_cities(stateid);
    });

     $(document).on('click', function (e) {
        const $input = $('input.designation');
        const $dropdown = $input.closest('div').find('div.dropdown-menu');

    // If click is NOT on input or dropdown
    if (!$input.is(e.target) && !$dropdown.is(e.target) && $dropdown.has(e.target).length === 0) {
        $dropdown.removeClass('show');
    }

    });
});