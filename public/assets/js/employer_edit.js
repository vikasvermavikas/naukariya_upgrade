$(document).ready(function() {
    // Get cities from states.
    $("#company_state").change(function () {
        var stateid = this.value;
        $.ajax({
            url : '/employer/get-cities/data/'+stateid,
            type : 'GET',
            success : function(data) {
                var html = '<option>Select City</option>';
               $.each(data.data, function(key, value) {
                html += '<option value="'+value.id+' ">' + value.cities_name + '</option>';
               });
                $("#company_cities").html(html);
            }
        });
    });
});