$(document).ready(function () {

        
   if ($(".employer")[0]) {
            $('.employer').click(function() {
                $('.show-employer').toggle();
            });
        }

        // Code for showing tooltip.
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

$(".slicknav_icon-bar:last").after('<svg xmlns="http://www.w3.org/2000/svg" fill="#e35e25" id="close-icon" class="d-none" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>');

 $(".slicknav_btn").click(function () {
    $(".slicknav_icon-bar").toggleClass("d-none");
    $("#close-icon").toggleClass("d-none");
 });   

    function realTimeUpdates() {
        $.ajax({
            url: SITE_URL + '/get_realtime_updates',
            type: 'GET',
            dataType: 'json',
            dataType : 'json',
            success: function (data) {
                    $("#naukriyan_jobs").html(data.jobs);
                    $("#naukriyan_employers").html(data.employers);
                    $("#naukriyan_jobseekers").html(data.jobseeker);
            }
        });
    }

    realTimeUpdates();


});