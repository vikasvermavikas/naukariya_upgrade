$(document).ready(function() {

    $('.js-example-basic-multiple').select2({
        placeholder: "Search"
    });
    $('.location-multiple').select2();
    $('.company-name-basic-single').select2();
    $('.exclude-company-name-basic-single').select2();

    function add_exp_options(){
        var min_exp = '<option value="">Min</option>';
        var max_exp = '<option value="">Max</option>';
        for (let index = 0; index < 20; index++) {
            min_exp += '<option value="'+index+'">'+index+'</option>';
            max_exp += '<option value="'+index+'">'+index+'</option>';
        }
        $('#min_exp').html(min_exp);
        $('#max_exp').html(max_exp);
    }


    function get_functional_roles(){
        var functional_roles = '<option value="">Select Functional Role</option>';
        $.ajax({
            url: 'get-functional-role',
            type: 'GET',
            success: function(data){
                data.data.forEach(function(role){
                    functional_roles += '<option value="'+role.id+'">'+role.subcategory_name+'</option>';
                });
                $('#functionalrole').html(functional_roles);
            }
        });
    }

    

    function get_industries(){
        var industries = '<option value="">Select Industry</option>';
        $.ajax({
            url: '../get-industry',
            type: 'GET',
            success: function(data){
                data.data.forEach(function(role){
                    industries += '<option value="'+role.id+'">'+role.category_name+'</option>';
                });
                $('#industry').html(industries);
            }
        });
    }

    function get_companies_list(){
        var companies = '<option value="">Select Company</option>';
        $.ajax({
            url: 'master/companies/list',
            type: 'GET',
            success: function(data){
                const companiesArray =  Object.values(data.data);
                companiesArray.forEach(function(company, index){
                    companies += '<option value="'+company+'">'+company+'</option>';
                });
                $('#company_name').html(companies);
                $('#exclude_company_name').html(companies);
            }
        });
    }

    function get_degrees(){
        var degrees = '<option value="">Select Degree</option>';
        $.ajax({
            url: 'qualification/name/group',
            type: 'GET',
            success: function(data){
                data.data.forEach(function(role){
                    degrees += '<optgroup label="'+role.group+'">';
                    for (let index = 0; index < role.qualification.length; index++) {
                        degrees += '<option value="'+role.qualification[index].id+'">'+role.qualification[index].qualification+'</option>';
                        
                    }
                    
                    degrees += '</optgroup>';
                });
                $('#qualifications').html(degrees);
            }
        });
    }

    function get_years(){
        const currentYear = new Date().getFullYear();
        var startYears = '<option value="">From</option>';
        var toYears = '<option value="">To</option>';
        for (let index = currentYear-20; index < currentYear + 1; index++) {
            startYears += '<option value="'+index+'">'+index+'</option>';
            toYears += '<option value="'+index+'">'+index+'</option>';
        }
        $('#start_graduation').html(startYears);
        $('#to_graduation').html(toYears);
    }

    $(".collapsebutton").click(function(){
        $(this).find("i").toggleClass("fa-caret-down fa-caret-up");
    });
    
    // Call the functions.
    add_exp_options();
    get_functional_roles();
    get_industries();
    get_companies_list();
    get_degrees();
    get_years();
});