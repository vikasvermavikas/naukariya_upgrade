$(document).ready(function () {
    // Show data on click of modal.
    $('#updateVenueModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var venuid = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
   // Hide error messages for other data.
   modal.find('#venueid').val(venuid);

   var oldvenueid = modal.find('#oldvenueid').val();
   if (oldvenueid) {
       if (venuid != oldvenueid) {
           modal.find(".updateerror").addClass('d-none');
       }
       else {
           modal.find(".updateerror").removeClass('d-none');
       }
   }
        $.ajax({
            url: SITE_URL + '/employer/venue/get-venuedata/' + venuid,
            type: "GET",
            success: function (data) {
                modal.find('form').attr('action', SITE_URL + '/employer/venue/update-venue/' + venuid);
                modal.find('#update_venue_name').val(data.venue_name);
                modal.find('#update_venue_address').val(data.venue_address);
                modal.find('#update_contact_email').val(data.email);
                modal.find('#update_contact_person').val(data.contact_person);
                modal.find('#update_contact_no').val(data.contact_no);
                modal.find('#update_instructions').val(data.instructions);
            }
        });
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })

    // Delete venue.
    $(".deletebutton").click(function () {
        var id = $(this).attr('value');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                var url = SITE_URL + '/employer/venue/venues/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        if (response.status) {
                            swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Venue deleted!",
                                text: "Your venue has been deleted.",
                                showConfirmButton: true
                            }).then((result) => {
                                location.reload();
                            });

                        } else {
                            alert('Failed to delete venue');
                        }
                    }
                });
            }
        });

    });

    // Deactivate venue.
    $(".deactivatebtn").click(function () {
        var id = $(this).attr('value');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Deactivate it!"
        }).then((result) => {
            if (result.isConfirmed) {

                var url = SITE_URL + '/employer/venue/deactive-venues/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        if (response.status) {
                            swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Venue Deactivated!",
                                text: "Your venue has been deactivated.",
                                showConfirmButton: true
                            }).then((result) => {
                                location.reload();
                            });

                        } else {
                            alert('Failed to delete venue');
                        }
                    }
                });
            }
        });

    });

    // Activate the venue.
    $(".activatebtn").click(function () {
        var id = $(this).attr('value');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Activate it!"
        }).then((result) => {
            if (result.isConfirmed) {

                var url = SITE_URL + '/employer/venue/active-venues/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        if (response.status) {
                            swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Venue Activated!",
                                text: "Your venue has been Activated.",
                                showConfirmButton: true
                            }).then((result) => {
                                location.reload();
                            });

                        } else {
                            alert('Failed to delete venue');
                        }
                    }
                });
            }
        });

    });

    // Reset Search Form.
    $(".resetsearch").click(function () {
        window.location.href = SITE_URL + '/employer/venue';
    });

});