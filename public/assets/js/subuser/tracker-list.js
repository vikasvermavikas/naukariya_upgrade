$(document).ready(function() {
const urlParams = new URLSearchParams(window.location.search);
const referenceparam = urlParams.get('source');
    function get_references() {
            $.ajax({
                url: SITE_URL + '/subuser/reference-list',
                type: 'GET',
                success: function (data) {
                    var html = '<option value="">Select Source</option>';
                    $.each(data.data, function (key, value) {
                        if (referenceparam && (value.name == referenceparam)) {
                            html += '<option value="' + value.name + '" selected>' + value.name + '</option>';
                        }
                        else {
                            html += '<option value="' + value.name + '">' + value.name + '</option>';
                        }
    
                    });
                    $('#source').html(html);
                }
            });
   
    }
    get_references();
});