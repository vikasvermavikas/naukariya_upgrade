$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search); // get query parameters.

    $.ajax({
        url : '/employer/consolidate/getUniqueSource1',
        type : 'GET',
        dataType: 'json',
        success : function(data) {
            var select = $('#source');
            var html = '<option value="">Select Source</option>';
            $.each(data.data, function(key, value) {
            if(urlParams.get('source') == value){
                html += '<option selected value="' + value + '">' + value + '</option>';
            }else{
                html += '<option value="' + value + '">' + value + '</option>';
            }
            });
            select.html(html);
        }
    });
});