$(document).ready(function() {
    $("#location").on("keyup", function() {
        var location = $(this).val();
        $.ajax({
            url: "/get-locations/" + location + "",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var html = "";
                $.each(data, function(key, value) {
                    html += "<option value='" + value.cities_name + "'>"+value.cities_name+"</option>";
                })
                $("#locationlist").html(html);
            }
        })
    })
})