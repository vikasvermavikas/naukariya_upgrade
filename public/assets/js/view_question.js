$(document).ready(function () {
    const token = $("meta[name=csrf-token]").attr('content');

    // Get questionarie names.
    function getQuestionarieNames() {
        $.ajax({
            url: SITE_URL + '/employer/questionnaires/questionnarie-name_emp',
            type: 'POST',
            data: {
                _token: token
            },
            dataType: 'json',
            success: function (response) {
                if (response.data) {
                    const questionnaires = response.data;
                    let questionnairesHTML = '<option value="">Select Questionnarie</option>';
                    questionnaires.forEach(function (questionnaire) {
                        questionnairesHTML += `<option value="${questionnaire.id}">${questionnaire.name}</option>`;
                    });
                    $('#tag').html(questionnairesHTML);
                } else {
                    alert('Error retrieving questionnaires');
                }
            }
        });
    }
    getQuestionarieNames();
    // Add questions to questionnaire.
    $("#add_question").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var tag = $('#tag').val();
        var questionids = [];
        $('.questions_ids:checked').each(function () {
            questionids.push($(this).val());
        });

        if (questionids.length > 0) {
            $.ajax({
                url: SITE_URL + '/employer/questionnaires/add-questionnarie_emp/' + tag + '/' + questionids.join(),
                type: 'POST',
                data: {
                    _token: token,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                            showConfirmButton: true
                        });
                        form[0].reset();  // Reset the form.
                        $("#questionnarieModal").modal('hide');
                        $('.questions_ids:checked').attr('checked', false); // Unchecks it
                    } else {
                        alert('Error adding questions to questionnaire');
                    }
                }
            });
        }
        else {

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please select a question !",
                showConfirmButton: true
            });
            form[0].reset();  // Reset the form.
            $("#questionnarieModal").modal('hide');
        }
    });

    // Show add questionarrie form.
    $("#add_new_questionarie").click(function () {
        var selfButton = $(this);
        $("#add_questionarie_form").toggleClass("d-none");

        if (selfButton.text() == 'Add New') {
            selfButton.text("back");
            $("#tag").attr("disabled", true);
        }
        else {
            selfButton.text("Add New");
            $("#tag").attr("disabled", false);
        }

    });

    // Add questionarrie.
    $("#save_new_questionarie").click(function () {
        var name = $("#newquestionnarie").val();
        if (name) {
            $("#questionarie_error").text("");
            $.ajax({
                url: SITE_URL + '/employer/questionnaires/add-new-questionnarie_emp/' + name,
                type: 'POST',
                data: {
                    name: name,
                    _token: token
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                            showConfirmButton: true
                        });
                        getQuestionarieNames();  // Refresh the questionnaire names.
                        $("#add_questionarie_form").toggleClass("d-none");
                        $("#add_new_questionarie").text("Add New");
                        $("#tag").attr("disabled", false);

                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        }
        else {
            $("#questionarie_error").text("Required field");
        }
    });
});