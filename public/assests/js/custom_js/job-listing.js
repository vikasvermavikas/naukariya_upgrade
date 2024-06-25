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



$(document).ready(function() {
    function fetchJobListings() {
        var industry = $('#industries').val();
        var jobTypes = [];
        $('.jobtype:checked').each(function() {
            jobTypes.push($(this).val());
        });
        var experiences = [];
        $('.experience:checked').each(function() {
            experiences.push($(this).val());
        });
        var postedWithin = [];
        $('.postedWithin:checked').each(function() {
            postedWithin.push($(this).val());
        });
        // var queryString = `industry=${industry}`;
        var queryString = `industry=${industry}&jobTypes=${jobTypes.join(',')}&experiences=${experiences.join(',')}&postedWithin=${postedWithin.join(',')}`;



        $.ajax({
            url: `/job_listing-data?${queryString}`,
            type: 'GET',
                success: function(data) {
                    $('.joblists').hide();
                                var html = '';
                                var base_url = window.location.origin;
                                var jobCount = data.data.data.length;
                                if(jobCount ){
                                    $("#jobcount").html("Job Found (" + jobCount + ")");
                                }else{
                                    $("#jobcount").html("Job Found (" + 0 + ")");
                                }
                                if(data.data.data.length  > 0){

                                    $.each(data.data.data, function(key, value) {


                                        //  console.log(value.id);
                                        $minsalary = 0;
                                        var exp_required ;
                                        var main_exp = value.main_exp == null ? '' :  value.main_exp;
                    
                                        exp_required = main_exp + 'Yr - ' + value.max_exp + ' Yr';
                                        if (value.offered_sal_min) {
                                            minsalary = value.offered_sal_min;
                                        }
                                        if (value.main_exp === '0' && value.max_exp === '0') {
                                            exp_required = 'Fresher';
                                        }
                                        // let jobdetails = route('job_details', value.id);
                                        var base_url = window.location.origin+ 'job_details/'+ value.id;


                    
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
                                                            class="fas fa-map-marker-alt"></i>${value.location ? value.location : 'Not Defined' }
                                                    </li>
                                                    <li>${value.sal_disclosed == 'Yes' ? 'INR ' + $minsalary + ' - ' + value.offered_sal_max : 'Not Disclosed' }
                                                    </li>

                                                </ul>
                                                <span class="text-muted">Experience Required : ${exp_required }</span>
                                            </div>
                                        </div>
                                        </div>`;
                                   
                                });
                                $('.joblists1').html(html);
                                }else{
                                    $('.joblists1').html('Record not Found');
                                }
                            },

            error: function(error) {
                console.error('Error fetching job listings:', error);
                $('#jobListings').append('<p>Error fetching job listings. Please try again later.</p>');
            }
        });
    }
    $('#industries').on('change', fetchJobListings);
    $('.jobtype').on('change', fetchJobListings);
    $('.experience').on('change', fetchJobListings);
    $('.postedWithin').on('change', fetchJobListings);

    // $('#postedWithin').click(function(){
    //     if(this.checked) {
    //         fetchJobListings
    //     }
    // } );
});
