$(document).ready(function() {
    const token = $("meta[name=csrf-token]").attr("content");

    function get_functional_roles(){
        var functional_roles = '<option value="">Select Functional Role</option>';
        $.ajax({
            url: SITE_URL+'/employer/get-functional-role',
            type: 'GET',
            success: function(data){
                data.data.forEach(function(role){
                    functional_roles += '<option value="'+role.id+'">'+role.subcategory_name+'</option>';
                });
                $('#functionalrole_name').html(functional_roles);
                $('#yes_no_functional').html(functional_roles);
                $('#descriptive_functional').html(functional_roles);
            }
        });
    }

    

    function get_industries(){
        var industries = '<option value="">Select Industry</option>';
        $.ajax({
            url: SITE_URL+'/get-industry',
            type: 'GET',
            success: function(data){
                data.data.forEach(function(role){
                    industries += '<option value="'+role.id+'">'+role.category_name+'</option>';
                });
                $('#industry_name').html(industries);
                $('#yes_no_industry_name').html(industries);
                $('#descriptive_industry_name').html(industries);
            }
        });
    }

    get_industries();
    get_functional_roles();

    // Set answer for mcq.
    $("#answer").focus(function(){
        var options1 = $("#options1").val();
        var options2 = $("#options2").val();
        var options3 = $("#options3").val();
        var options4 = $("#options4").val();
        if (options1 || options2 || options3 || options4) {
            var selectoptions = '<option value="">Select</option>';
            selectoptions += '<option value="'+options1+'">'+options1+'</option>';
            selectoptions += '<option value="'+options2+'">'+options2+'</option>';
            selectoptions += '<option value="'+options3+'">'+options3+'</option>';
            selectoptions += '<option value="'+options4+'">'+options4+'</option>';
            $("#answer").html(selectoptions);
        }
    });

});