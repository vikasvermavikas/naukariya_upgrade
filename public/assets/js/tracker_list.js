$(document).ready(function() {
    // Get url params.
    var urlParams = new URLSearchParams(window.location.search); // get query parameters.

    $.ajax({
        url : 'unique-source/tracker',
        type : 'GET',
        success : function(data) {
            var selectsource = '<option value="">Select Source</option>';
           $.each(data.data, function(key, value) {
            if(urlParams.get('source') == value.name){
                selectsource += '<option selected value="' + value.name + '">' + value.name + '</option>';
            }else{
                selectsource += '<option value="' + value.name + '">' + value.name + '</option>';
            }
            
           });
            $('#source').html(selectsource);
        }
    });
});