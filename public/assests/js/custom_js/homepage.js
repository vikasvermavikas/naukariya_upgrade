document.addEventListener('DOMContentLoaded', e => {
    $('#searchkeyword').autocomplete()

}, false);
$(document).ready(function () {
    $('.js-example-basic-single').select2();
    

  // function getLocations(search = '') {
  //       $.ajax({
  //           url: SITE_URL+"/get-locations/" + search,
  //           method: "GET",
  //           dataType: "json",
  //           success: function (data) {
  //               var html = "<option value='' >Select Location</option>";
  //               $.each(data, function (key, value) {
  //                   html += "<option value='" + value.cities_name + "'>" + value.cities_name + "</option>";
  //               })
  //               $("#location").html(html);
  //           }
  //       })
  //   };
  //   getLocations();

    // Welcome Alert.

    // Swal.fire({
    //     position: "center",
    //     imageUrl: PUBLIC_PATH+"/assets/images/naukriyan-logo.png",
    //     customClass:{
    //         image: 'img-fluid'
    //     },
    //     imageAlt: "Naukriyan",
    //     title: "Welcome to Naukriyan",
    //     showConfirmButton: true
    // });

    function getCategoriesJobs(){
        $.ajax({
            url: "get-categories-jobs",
            method: "GET",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) {
                   var html = "<h5><a href='"+SITE_URL+"/job-listing?industry="+value.industries+"'>"+value.category_name+"</a></h5><span>"+value.count+"</span>";
                    $("#"+value.category).html(html);
                });
                // $("#accounts_count").text("("+data.accounts+")");
                // $("#agriculture_count").text("("+data.agriculture+")");
                // $("#chemicals_count").text("("+data.chemicals+")");
                // $("#electricals_count").text("("+data.electricals+")");
                // $("#hotels_count").text("("+data.hotel+")");
                // $("#it_count").text("("+data.it+")");
                // $("#laws_count").text("("+data.laws+")");
                // $("#recruitment_count").text("("+data.recruitment+")");
            }

        });
    }

    // Call on load functions.

    // getCategoriesJobs();  // commented because now dynamically categories are loaded.
})