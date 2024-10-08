$(document).ready(function () {

    // Build editor.
    ClassicEditor
        .create(document.querySelector('#interview_info'))
        .catch(error => {
            console.error(error);
        });

    // Modal Js.
    $('#interview_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var applicationId = button.data('whatever'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
          modal.find('#applicationid').val(applicationId);
        //   modal.find('.modal-body input').val(recipient)
    })
});