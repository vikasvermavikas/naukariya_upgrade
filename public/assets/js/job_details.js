$(document).ready(function (){
	$("form.apply_job_form").submit(function (e) {
		e.preventDefault();
		var jobid = $(this).find(".jobid").val();
		$(this).find(".confirm_apply").attr('disabled', 'disabled');
		Swal.showLoading();
		var formData = new FormData(this);

		$.ajax({
			url : SITE_URL + '/apply-job/'+jobid,
			type : 'post',
			dataType : 'json',
			data: formData,
			success : function (res){
				if (res.success) {
				Swal.hideLoading();
				Swal.fire({
				  title: "Congratulations!",
				  text: res.message,
				  icon: "success"
				})
				.then((result) => {
				  if (result.isConfirmed) {
				   	location.reload();
				  }
				});
				}
				else if (res.error) {
					$(this).find(".confirm_apply").removeAttr('disabled');

					Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: res.message,
					})
					.then((result) => {
					  if (result.isConfirmed) {
					   	location.reload();
					  }
					});	
				}			
			},
			error : function(err){
				Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: 'Server Error',
					})
					.then((result) => {
					  if (result.isConfirmed) {
					   	location.reload();
					  }
					});	
			},
			cache: false,
        	contentType: false,
        	processData: false
		})
	})

	$("form.save_job_form").submit(function (e) {
		e.preventDefault();
		var jobid = $(this).find(".jobid").val();
		var formData = new FormData(this);

		$.ajax({
			url : SITE_URL + '/saved-job/'+jobid,
			type : 'post',
			dataType : 'json',
			data: formData,
			success : function (res){
				if (res.success) {
				Swal.fire({
				  title: "Congratulations!",
				  text: res.message,
				  icon: "success"
				})
				.then((result) => {
				  if (result.isConfirmed) {
				   	location.reload();
				  }
				});
				}
				else if (res.error) {
					Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: res.message,
					})
					.then((result) => {
					  if (result.isConfirmed) {
					   	location.reload();
					  }
				});	
				}			
			},
			cache: false,
        	contentType: false,
        	processData: false
		})
	})

	$("form.follow_job_form").submit(function (e) {
		e.preventDefault();
		var jobid = $(this).find(".jobid").val();
		var companyid = $(this).find(".companyid").val();
		var formData = new FormData(this);

		$.ajax({
			url : SITE_URL + '/follow/'+companyid+'/'+jobid,
			type : 'post',
			dataType : 'json',
			data: formData,
			success : function (res){
				if (res.success) {
				Swal.fire({
				  title: "Congratulations!",
				  text: res.message,
				  icon: "success"
				})
				.then((result) => {
				  if (result.isConfirmed) {
				   	location.reload();
				  }
				});
				}
				else if (res.error) {
					Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: res.message,
					})
					.then((result) => {
					  if (result.isConfirmed) {
					   	location.reload();
					  }
				});	
				}			
			},
			cache: false,
        	contentType: false,
        	processData: false
		})
	})
})