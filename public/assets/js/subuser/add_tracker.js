$(document).ready(function() {
    // Get designations.
    $('.designation').autocomplete();
    
    // Get cities based on selected state.
    $("#hometown_state").change(function () {
        var stateid = this.value;
        $.ajax({
            url : SITE_URL+'/subuser/get-cities/data/'+stateid,
            type : 'GET',
            success : function(data) {
                var html = '<option>Select City</option>';
               $.each(data.data, function(key, value) {
                html += '<option value="'+value.id+' ">' + value.cities_name + '</option>';
               });
                $("#hometown_city").html(html);
            }
        });
    });
});