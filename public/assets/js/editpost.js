$(document).ready(function () {
    // Build editor.
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });

    // Code for questionarie.
    // $(".select_questionarie").hide();
    $("#add_questionnarie").change(function () {
        if (this.value == 'Yes') {
            $(".select_questionarie").show();
            $(".select_questionarie").removeAttr('style');
        }
        else {
            $(".select_questionarie").hide();
        }
    });

    // Code for salary disclosed.
    $("#sal_disclosed").change(function () {
        var isSalaryDisclosed = this.value;
        if (isSalaryDisclosed == 'No') {
            $(".salarydisclosed").attr('disabled', 'disabled');
        }
        else {
            $(".salarydisclosed").removeAttr('disabled');
        }
    });

    $("#job_state_id").change(function () {
        var stateid = this.value;
        $.ajax({
            url : SITE_URL+'/employer/get-cities/data/'+stateid,
            type : 'GET',
            success : function(data) {
                var html = '<option>Select City</option>';
               $.each(data.data, function(key, value) {
                html += '<option value="'+value.id+' ">' + value.cities_name + '</option>';
               });
                $("#job_city_id").html(html);
            }
        });
    });

    // $("#client_id").change(function() {
    //     var clientid = this.value;
    //     if (this.value == 'add_client') {
    //         Swal.fire({
    //             icon: "error",
    //             title: "Oops...",
    //             text: "Invalid Client ! Please select valid client or add a new client",
    //             // footer: '<a href="#">Why do I have this issue?</a>'
    //           });
    //     }
    // });

});