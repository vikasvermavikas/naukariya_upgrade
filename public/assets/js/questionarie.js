$(document).ready(function () {
    const token = $("meta[name=csrf-token]").attr('content');
    var urlParams = new URLSearchParams(window.location.search);

    // Get questionarie names.
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
                let questionnairesHTML = '<option value="">Select</option>';
                questionnaires.forEach(function (questionnaire) {
                    if (urlParams.has('questionary') && urlParams.get('questionary') == questionnaire.id) {
                        questionnairesHTML += `<option value="${questionnaire.id}" selected>${questionnaire.name}</option>`;
                    }
                    else {
                        questionnairesHTML += `<option value="${questionnaire.id}">${questionnaire.name}</option>`;
                    }
                });
                $('#questionary').html(questionnairesHTML);
            } else {
                alert('Error retrieving questionnaires');
            }
        }
    });

    $(".searchreset").click(function (){
        window.location.href = SITE_URL+'/employer/questionnaires/list';
    });
    // Delete question from questionnaire.
    $(".delete_question").on("submit", function (event) {
        event.preventDefault();
        const form = $(this);
        const questionnaireId = form.find('input[name="questionid"]').val();
        var uri = SITE_URL + "/employer/questionnaires/question-emp/" + questionnaireId;

        swal
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: uri,
                        type: 'get',
                        data: {
                            _token: token,
                        },
                        success: function (response) {
                            if (response.message) {
                                swal.fire("Deleted!", response.message, "success");
                                form.closest('tr').remove();
                            } else {
                                alert('Error deleting question');
                            }
                        }
                    });
                }
            });
    });

    
});