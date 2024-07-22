$(document).ready(function () {

    // Setup CKeditor instance.
    ClassicEditor
    .create( document.querySelector( '#emailDescription' ) )
    .catch( error => {
    console.error( error );
    });
    
    // Code for save url.
    $("#save_search_form").submit(function (e) {
        e.preventDefault();
        var search_term = $("#save_Search").val();
        var token = $('meta[name="csrf-token"]').attr('content');
        const currentUrl = window.location.href;
        $.ajax({
            url: '../add/save/search',
            type: "POST",
            data: {
                searchname: search_term,
                url: currentUrl,
                _token: token
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $("#save_search_form")[0].reset();  // Reset the form.
                    $('#savesearch').modal('hide'); // Hide the modal   
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: true,
                    });
                }
                else {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: true,
                    });
                }

            }
        });


    });

    function restore_addTag_button() {
        $("#tag_id").attr('disabled', false);
        $("#add_new_tag").html('<span class="marginleft"><i class="fas fa-plus"></i> Add new</span>');
    }

    function set_addTag_button() {
        $("#tag_id").attr('disabled', true);
        $("#add_new_tag").text('Back');
    }

    $("#add_new_tag").click(function () {
        var textvalue = $(this).text();
        $("#newTagForm").toggleClass("d-none");
        if (textvalue == 'Back') {
            restore_addTag_button();
        }
        else {
            set_addTag_button();
        }

    });

    // Code for Show existing tags.

    function show_existing_tags() {
        $.ajax({
            url: '../tags/get-tag',
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.data) {
                    var html = '<option value="">Select Tag</option>';
                    response.data.forEach(function (tag) {
                        html += '<option value="' + tag.id + '">' + tag.tag + '</li>';
                    });
                    $("#tag_id").html(html);
                }
            }
        });
    }

    // Close modal.

    function resetModalForm(tag) {
        tag.closest('form')[0].reset();
    }

    $(".resetform").click(function () {
        resetModalForm($(this));
    });

    // Add New tag.
    $("#create_tag").click(function (e) {
        // e.preventDefault();

        var tag_name = $("#tag").val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (tag_name) {
            $.ajax({
                url: '../tags/add-new-tag',
                type: "POST",
                data: {
                    tag: tag_name,
                    _token: token
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $("#tag").val('');  // Reset the form.
                        $("#newTagForm").toggleClass("d-none");
                        restore_addTag_button();
                        show_existing_tags();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: true,
                        });
                    }
                    else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: true,
                        });
                    }

                }
            });
        }
    });

    $("#add_tag_form").submit(function (e) {
        e.preventDefault();
        var tagid = $("#tag_id").val();
        var jobseeker_id = [];
        $("input:checkbox[name=jobseeker_id]:checked").each(function () {
            jobseeker_id.push($(this).val());
        });
        if (jobseeker_id.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please select jobseeker!",
            });
            return false;
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '../tags/add-resume-tag',
            type: 'POST',
            data: {
                jobseeker_id: jobseeker_id,
                tag_id: tagid,
                _token: token
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $("#add_tag_form")[0].reset();  // Reset the form.
                    $("#addTagModal").modal('hide');
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: true
                    });
                }
            }
        });
    });
    // For upload comment.
    $(".comment").click(function () {
        $(this).closest('.card').find('.post-comment-section').toggleClass('d-none');
    });

    show_existing_tags();

    // Export excel.

    $("#export_excel").click(function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var jobseeker_id = [];
        $("input:checkbox[name=jobseeker_id]:checked").each(function () {
            jobseeker_id.push($(this).val());
        });
        if (jobseeker_id.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please select jobseeker!",
            });
            return false;
        }

        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Resume Exported",
            showConfirmButton: false,
            timer: 1500
        });
        window.open("../tags/export-resumes/" + jobseeker_id, "_blank");
    });


    // Send email notification.

    $("#send_email_form").submit(function (e){
        e.preventDefault();
        var jobseeker_id = [];
        $("input:checkbox[name=jobseeker_id]:checked").each(function () {
            jobseeker_id.push($(this).val());
        });
        if (jobseeker_id.length == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please select jobseeker!",
            });
            return false;
        }
        var empEmail = $("#empEmail").val();
        var input_subject = $("#input_subject").val();
        var description = $('#emailDescription').val();
       
        // Validate required fields.
        if(!empEmail ||!input_subject || !description) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill all required fields!",
            });
            return false;
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        $(".disablemail").attr('disabled', 'disabled');
        $(".disablemail").text("Sending...");

        $.ajax({
            url: '../tags/send/bulk/mail',
            type: 'POST',
            data: {
                jobseeker_id: jobseeker_id,
                empEmail: empEmail,
                input_subject: input_subject,
                description: description,
                _token: token
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $(".disablemail").attr('disabled', false);
                    $(".disablemail").text("Save changes");
                    $("#send_email_form")[0].reset();  // Reset the form.
                    $("#sendEmailModal").modal('hide');
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.status,
                        showConfirmButton: true
                    });
                }
            }
        });

    });

    // Get single comments.

    function get_resume_comments(user, element){
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url : '../comment/resume-comments',
            type : 'POST',
            data : {
                js_id : user,
                _token : token
            },
            dataType : 'json',
            success : function (response) {
                    var comments = response.data;
                    var html = '';
                    comments.forEach(function (comment) {
                        html += '<li>'+comment.comment+'</li>';
                    });
                    element.closest('.post-comment-section').find("#comment_listing").html(html);
                
            }

        });
    }

    // Submit comment.

    $(".commentform").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var commentarea = form.find("textarea[name='commentarea']").val();
        var js_id = form.find("input[name='js_id']").val();
        var token = $('meta[name="csrf-token"]').attr('content');
        
        // If all required fields is given.
        if (commentarea && js_id) {
            $.ajax({
                url: '../comment/save/comment/user',
                type: 'POST',
                data: {
                    comment: commentarea,
                    jsid: js_id,
                    _token: token
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status =='success') {
                        form.find("textarea[name='commentarea']").val('');  // Reset the form.
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: true
                        });
                        get_resume_comments(js_id, form);
                        
                    }
                }
            });
        }
    });

});