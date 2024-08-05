$(document).ready(function () {
    
    // Get Certificates.
    $.ajax({
        url: SITE_URL + "/jobseeker/get-certification-detail",
        method: "GET",
        dataType: "json",
        success: function (response) {
            // Process response and populate the dropdown.
            var html = "";
            if (response.data.length > 0) {
                $(".certificates-details").removeClass('d-none');
                $.each(response.data, function (index, item) {
                    html += "<tr>";
                    html += "<td>" + item.cert_from_date +" - "+item.cert_to_date  + "</td>";
                    html += "<td>" + item.course + "</td>";
                    html += "<td>" + item.certificate_institute_name + "</td>";
                    if (item.certification_type == 1) {
                        html += "<td>Offline</td>";
                    }
                    else {
                        html += "<td>Online</td>";
                    }
                    html += "</tr>";
                });
                $("#certificatesDetails").html(html);
            }
        },
        error: function (xhr, status, error) {
            // console.error("Error retrieving certificates: " + error);
        }
    });

    // Get Education Details.
    $.ajax({
        url: SITE_URL + "/jobseeker/get-education-detail",
        method: "GET",
        dataType: "json",
        success: function (response) {
            // Process response and populate the dropdown.
            var html = "";
            if (response.data.length > 0) {
                $(".educationDetails").removeClass('d-none');
                $.each(response.data, function (index, item) {
                    html += "<tr>";
                    html += "<td>" + item.passing_year + "</td>";
                    html += "<td>" + item.degree_name + "</td>";
                    html += "<td>" + item.institute_name + "</td>";
                    html += "<td>" + item.course_type + "</td>";
                    html += "</tr>";
                });
                $("#education-data").html(html);
            }
        }
    });

    // Get skills.
    $.ajax({
        url: SITE_URL + "/jobseeker/get-user-skill",
        method: "GET",
        dataType: "json",
        success: function (response) {
            // Process response and populate the dropdown.
            var html = "";
            if (response.data.length > 0) {
                $(".skillsDetails").removeClass('d-none');
                $.each(response.data, function (index, item) {
                    html += "<span class='circle'>"+item.skill+"</span>";
                }); 
                $(".skill-details").html(html);
            }
        }
    });
});