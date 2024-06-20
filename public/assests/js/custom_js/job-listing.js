$(document).ready(function() {
    $.ajax({
        url: '/get-industry',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var html = '<option value="">Select Category</option>';
            $.each(data.data, function(key, value) {
                html += '<option value="' + value.id + '">' + value.category_name +
                    '</option>';
            });
            $('#industries').html(html);
        }
    });
});