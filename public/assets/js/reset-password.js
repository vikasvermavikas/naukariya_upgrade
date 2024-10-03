$(document).ready(function(){
	$("form#reset-password").submit(function (e) {
		e.preventDefault();
		Swal.showLoading();
		$.ajax({
			url : SITE_URL+'/forget-password/user/reset',
			type : 'POST',
			dataType : 'json',
			data : $(this).serialize(),
			success : function (response) {
					Swal.hideLoading();
				if (response.success) {

					Swal.fire({
					  title: "Congratulations!",
					  text: response.message,
					  icon: "success"
					})
					.then((result) => {
						window.location.href = response.redirect
					});
				}
			
				else {
						Swal.fire({
						  icon: "error",
						  title: "Oops...",
						  text: response.message,
						  footer: '<a href="'+SITE_URL+'contact" class="text-dark">Why do I have this issue?</a>'
						});
				}
			},
			error : function (errors){
					if (errors.responseJSON.errors) {
					Swal.fire({
						  icon: "error",
						  title: "Oops...",
						  text: errors.responseJSON.errors.password[0],
						  footer: '<a href="'+SITE_URL+'contact" class="text-dark">Why do I have this issue?</a>'
						});
				}
			}

		});
	});
});