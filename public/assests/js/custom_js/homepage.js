$(document).ready(function () {
    $('.js-example-basic-single').select2();
    // $("#location").on("focus", function() {
    // var location = $(this).val();
    function getLocations(search = '') {
        $.ajax({
            url: "/get-locations/"+search,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var html = "<option value='' >Select Location</option>";
                $.each(data, function (key, value) {
                    html += "<option value='" + value.cities_name + "'>" + value.cities_name + "</option>";
                })
                $("#location").html(html);
            }
        })
    };
    getLocations();
    
    // Swal.fire({
    //     title: 'Error!',
    //     text: 'Do you want to continue',
    //     icon: 'error',
    //     confirmButtonText: 'Cool'
    //   });
    // })
})