$(document).ready(function () {
    const token = $("meta[name=csrf-token]").attr('content');
    $(".delete").click(function () {
        var id = $(this).data("id");
        Swal.fire({
            title: "Are you sure you want to delete this blog?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e35e25",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: SITE_URL + '/employer/blog/delete_blog/' + id,
                    type: 'POST',
                    dataType: 'json',
                    data : {
                        _token: token
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    }
                });

            }
        });

    });
});