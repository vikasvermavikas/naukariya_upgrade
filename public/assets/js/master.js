$(document).ready(function () {

    function realTimeUpdates() {
        $.ajax({
            url: SITE_URL + '/get_realtime_updates',
            type: 'GET',
            dataType: 'json',
            dataType : 'json',
            success: function (data) {
                    $("#naukriyan_jobs").text(data.jobs);
                    $("#naukriyan_employers").text(data.employers);
                    $("#naukriyan_jobseekers").text(data.jobseeker);
            }
        });
    }

    realTimeUpdates();


});