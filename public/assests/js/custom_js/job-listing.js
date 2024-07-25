$(document).ready(function () {
    $.ajax({
        url: SITE_URL+'/get-industry',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var html = '<option value="">Select Category</option>';
            $.each(data.data, function (key, value) {
                html += '<option value="' + value.id + '">' + value.category_name +
                    '</option>';
            });
            $('#industries').html(html);
        }
    });
});

$(document).ready(function () {
    $.ajax({
        url: SITE_URL+'/get-skill',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            var html = '<option value="">Select Skill</option>';
            $.each(data.data, function (key, value) {
                html += '<option value="' + value.skill + '">' + value.skill +
                    '</option>';
            });
            $('#skill').html(html);
        }
    });
});

   



$(document).ready(function () {

    function fetchJobListings(pageno = 1) {
        $('.joblists1').show();
        var industry = $('#industries').val();
        var searchkeyword = $('#searchkeyword').val();

        // var skill = [];


        var skill = $('#skill').val(); // Get and trim the value of the input field

     
        if(skill){
            skill =  skill;
        }else{
            skill = '';
        }
        // var skill = $('#skill').val();
        // if()

        // console.log(skill);


        var jobTypes = [];
        $('.jobtype:checked').each(function () {
            jobTypes.push($(this).val());
        });
        var experiences = [];
        $('.experience:checked').each(function () {
            experiences.push($(this).val());
        });
        var postedWithin = [];
        $('.postedWithin:checked').each(function () {
            postedWithin.push($(this).val());
        });

        // var queryString = `industry=${industry}`;
        var queryString = `industry=${industry}&jobTypes=${jobTypes.join(',')}&experiences=${experiences.join(',')}&postedWithin=${postedWithin.join(',')}&searchkeyword=${searchkeyword}&skill=${skill}&page=${pageno}`;

        // If all filters are removed then show default data.
        if (industry == '' && jobTypes.join(',') == '' && experiences.join(',') == '' && postedWithin.join(',') == '' && searchkeyword == '' && skill=='') {
            fetchDefaultData();
            console.log('hi');
            return false;
        }
        $.ajax({
            url: SITE_URL+`/job_listing-data?${queryString}`,
            type: 'GET',
            success: function (data) {

                // var data = JSON.parse(data);
                $('.joblists').hide();
                $(".default_pagination").hide();

                var html = '';
                var base_url = window.location.origin;
                var jobCount = data.data.data.length;
                if (jobCount) {
                    $("#jobcount").html("Job Found (" + jobCount + ")");
                } else {
                    $("#jobcount").html("Job Found (" + 0 + ")");
                }
                if (data.data.data.length > 0) {

                    $.each(data.data.data, function (key, value) {


                        //  console.log(value.id);
                        $minsalary = 0;
                        var exp_required;
                        var main_exp = value.main_exp == null ? '' : value.main_exp;

                        exp_required = main_exp + 'Yr - ' + value.max_exp + ' Yr';
                        if (value.offered_sal_min) {
                            minsalary = value.offered_sal_min;
                        }
                        if (value.main_exp === '0' && value.max_exp === '0') {
                            exp_required = 'Fresher';
                        }
                        // let jobdetails = route('job_details', value.id);
                        // var base_url = window.location.origin + 'job_details/' + value.id;
                        var base_url = SITE_URL + '/job_details/' + value.id;



                        html += `<div class="single-job-items mb-30">
                                                <div class="job-items mb-30">
                                            <div class="company-img">
                                                <a href="${base_url}"><img
                                                        src="${PUBLIC_PATH}/assets/img/icon/job-list1.png" alt=""></a>
                                            </div>
                                            <div class="job-tittle job-tittle2">
                                                <a href="${base_url}">
                                                    <h4>${value.title}</h4>
                                                </a>
                                                <ul>
                                                    <li>${value.company_name}</li>
                                                    <li><i
                                                            class="fas fa-map-marker-alt"></i>${value.location ? value.location : 'Not Defined'}
                                                    </li>
                                                    <li>${value.sal_disclosed == 'Yes' ? 'INR ' + $minsalary + ' - ' + value.offered_sal_max : 'Not Disclosed'}
                                                    </li>

                                                </ul>
                                                <span class="text-muted">Experience Required : ${exp_required}</span>
                                            </div>
                                        </div>
                                        </div>`;

                    });
                    $('.joblists1').html(html);
                    //         // start pagination
                    var pagination = '<nav><ul class="pagination">';
                    $.each(data.data.links, function (key, value) {
                        if (value.url == null) {
                            pagination += ' <li class="page-item disabled" ><span class="page-link" aria-hidden="true">' + value.label + '</span></li>';
                        }
                        else {
                            pagination += ' <li class="page-item';
                            if (value.active) {
                                pagination += ' active';
                            }

                            pagination += '"><button class="page-link customlink" onclick="getFilterdata(' + value.label + ')" href="' + value.url + '">' + value.label + '</button></li>';
                        }

                    });
                    pagination += '</ul></nav>';
                    $(".filter_pagination").html(pagination);
                    $(".filter_pagination").show();
                } else {
                    $('.joblists1').html('Record not Found');
                }
            },

            error: function (error) {
                console.error('Error fetching job listings:', error);
                $('#jobListings').append('<p>Error fetching job listings. Please try again later.</p>');
            }
        });
    }


    function fetchDefaultData() {
        $('.joblists1').hide();
        $('.filter_pagination').hide();
        $('.joblists').show();
        $(".default_pagination").show();
    }

    $('#industries').on('change', fetchJobListings);
    $('.jobtype').on('change', fetchJobListings);
    $('.experience').on('change', fetchJobListings);
    $('.postedWithin').on('change', fetchJobListings);
    $('#searchkeyword').on('change', fetchJobListings);
    $('.skill').on('change', fetchJobListings);

});

function getFilterdata(pageno = 1) {
    $('.joblists1').show();
    var skill = $('#skill').val();
    var industry = $('#industries').val();
    var searchkeyword = $('#searchkeyword').val();
    var jobTypes = [];
    $('.jobtype:checked').each(function () {
        jobTypes.push($(this).val());
    });
    var experiences = [];
    $('.experience:checked').each(function () {
        experiences.push($(this).val());
    });
    var postedWithin = [];
    $('.postedWithin:checked').each(function () {
        postedWithin.push($(this).val());
    });

    // var queryString = `industry=${industry}`;
    var queryString = `industry=${industry}&jobTypes=${jobTypes.join(',')}&experiences=${experiences.join(',')}&postedWithin=${postedWithin.join(',')}searchkeyword=${searchkeyword}&skill=${skill}&page=${pageno}`;

    // If all filters are removed then show default data.
    if (industry == '' && jobTypes.join(',') == '' && experiences.join(',') == '' && postedWithin.join(',') == '' && searchkeyword == '' && skill == '') {
        fetchDefaultData();
        return false;
    }
    $.ajax({
        url: SITE_URL+`/job_listing-data?${queryString}`,
        type: 'GET',
        success: function (data) {
            $('.joblists').hide();
            $(".default_pagination").hide();

            var html = '';
            var base_url = window.location.origin;
            var jobCount = data.data.data.length;
            if (jobCount) {
                $("#jobcount").html("Job Found (" + jobCount + ")");
            } else {
                $("#jobcount").html("Job Found (" + 0 + ")");
            }
            if (data.data.data.length > 0) {

                $.each(data.data.data, function (key, value) {


                    //  console.log(value.id);
                    $minsalary = 0;
                    var exp_required;
                    var main_exp = value.main_exp == null ? '' : value.main_exp;

                    exp_required = main_exp + 'Yr - ' + value.max_exp + ' Yr';
                    if (value.offered_sal_min) {
                        minsalary = value.offered_sal_min;
                    }
                    if (value.main_exp === '0' && value.max_exp === '0') {
                        exp_required = 'Fresher';
                    }
                    // let jobdetails = route('job_details', value.id);
                    var base_url = window.location.origin + 'job_details/' + value.id;



                    html += `<div class="single-job-items mb-30">
                                           <div class="job-items mb-30">
                                       <div class="company-img">
                                           <a href="${base_url}"><img
                                                   src="assets/img/icon/job-list1.png" alt=""></a>
                                       </div>
                                       <div class="job-tittle job-tittle2">
                                           <a href="${base_url}">
                                               <h4>${value.title}</h4>
                                           </a>
                                           <ul>
                                               <li>${value.company_name}</li>
                                               <li><i
                                                       class="fas fa-map-marker-alt"></i>${value.location ? value.location : 'Not Defined'}
                                               </li>
                                               <li>${value.sal_disclosed == 'Yes' ? 'INR ' + $minsalary + ' - ' + value.offered_sal_max : 'Not Disclosed'}
                                               </li>

                                           </ul>
                                           <span class="text-muted">Experience Required : ${exp_required}</span>
                                       </div>
                                   </div>
                                   </div>`;

                });
                $('.joblists1').html(html);

                //         // start pagination
                var pagination = '<nav><ul class="pagination">';
                $.each(data.data.links, function (key, value) {
                    if (value.url == null) {
                        pagination += ' <li class="page-item disabled" ><span class="page-link" aria-hidden="true">' + value.label + '</span></li>';
                    }
                    else {
                        pagination += ' <li class="page-item';
                        if (value.active) {
                            pagination += ' active';
                        }

                        pagination += '"><button class="page-link customlink" onclick="getFilterdata(' + value.label + ')" href="' + value.url + '">' + value.label + '</button></li>';
                    }

                });
                pagination += '</ul></nav>';
                $(".filter_pagination").html(pagination);
                $(".filter_pagination").show();
            } else {
                $('.joblists1').html('Record not Found');
            }
        },

        error: function (error) {
            console.error('Error fetching job listings:', error);
            $('#jobListings').append('<p>Error fetching job listings. Please try again later.</p>');
        }
    });

}


$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});

