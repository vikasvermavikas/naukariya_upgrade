$(document).ready(function () {
	// const token = $("meta[name=csrf-token]").content();
	 $("form#resetform").submit(function (e) {
        e.preventDefault();
        Swal.showLoading();
        $.ajax({
            url : SITE_URL + '/forgot-password',
            type : 'POST',
            dataType : 'json',
            data : $(this).serialize(),
            success : function(response) {
				Swal.hideLoading();
				$(this).hide();
				if (response.success) {
					Swal.fire({
				  title: "Congratulations",
				  text: response.messages,
				  icon: "success"
				})
				.then((result) => {
					window.location.href = response.redirect;
				});

				}
				else {
					Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: response.messages,
					  footer: '<a href="#">Why do I have this issue?</a>'
					});
				}
				
            }
        });
    });
});