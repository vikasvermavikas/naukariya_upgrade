$(document).ready(function () {

	const token = $('meta[name="csrf-token"]').attr('content');

	// Build editor.
	ClassicEditor
		.create(document.querySelector('#interview_info'))
		.catch(error => {
			console.error(error);
		});

	function upgrade_tracker(jobid, trackerid, status) {
		Swal.showLoading();
		$.ajax({
			url: SITE_URL + '/employer/tracker/ats/upgrade-selection',
			type: 'post',
			dataType: 'json',
			data: {
				_token: token,
				job_id: jobid,
				tracker_id: trackerid,
				status: status,
			},
			success: function (response) {
				if (response.success) {
					Swal.hideLoading();
					Swal.fire({
						title: response.title,
						text: response.text,
						icon: "success"
					})
						.then((result) => {
							Swal.showLoading();
							location.reload();
						});
				}
			}
		});
	}

	// When user click on shortlist.

	$(".shortlist").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure you want to shortlist?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'shortlist');
			}
		});
	});

	// When user click on intersted.

	$(".interested").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'interested');
			}
		});
	});
	
	// When user click on not intersted.

	$(".not-interested").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'not-interested');
			}
		});
	});

	// When user click on reject.

	$(".reject").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'rejected');
			}
		});
	});

	// When user click on send offer mail.

	$(".send_offer_mail").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'offer-mail-sent');
			}
		});
	});

	// When user click on accept offer.
	$(".hire_applicant").click(function () {
		var trackerid = $(this).attr("data-id");
		var jobid = $(this).attr("job-id");
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				upgrade_tracker(jobid, trackerid, 'applicant_hired');
			}
		});
	});

	// Modal Js.
	$('#interview_modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var tracker_id = button.data('whatever');
		var job_id = button.data('id');

		var modal = $(this);
		modal.find('#job_id').val(job_id);
		modal.find('#tracker_id').val(tracker_id);
	})

	$('#view_interview').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var trackerid = button.data('whatever');
		var jobid = button.data('id');
		var modal = $(this);

		// Get interview details.
		$.ajax({
			url: SITE_URL + '/employer/tracker/ats/get-interview-details',
			type: 'post',
			dataType: 'json',
			data: {
				_token: token,
				tracker_id: trackerid,
				job_id: jobid,
			},
			success: function (response) {
				if (response.success) {
					modal.find('.modal-body .interview_date').text(new Date(response.details.interview_date).toLocaleString());
					modal.find('.modal-body .interview_details').html(response.details.interview_details);
				}
				else {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: response.message,
					})
						.then((result) => {
							modal.modal('hide');

						});
				}
			}
		});


	})
});