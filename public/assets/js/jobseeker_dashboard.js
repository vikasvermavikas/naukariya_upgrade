$(document).ready(function () {
    $.ajax({
        url : SITE_URL + '/jobseeker/profile/percentage',
        type : 'GET',
        success : function(response) {
            $("#profilepercentage").text(response.percentage + '%');
            $(".progress-class").text(response.percentage);
            $(".progress-class").attr('style', 'width: '+response.percentage+'% !important');
            var classdefine = '';
            if (response.percentage == 100) {
                classdefine = 'bg-success';
            }
            else if (response.percentage > 60 && response.percentage <= 99) {
                classdefine = 'bg-primary';
            }
            else if (response.percentage > 40 && response.percentage <= 60) {
                classdefine = 'bg-secondary';
            }
            else if (response.percentage > 20 && response.percentage <= 40) {
                classdefine = 'bg-warning';
            }
            else if (response.percentage <= 20) {
                classdefine = 'bg-danger';
            }
            else  {
                classdefine = '';
            }
          
            $(".progress-class").addClass(classdefine);
        }
    });
});