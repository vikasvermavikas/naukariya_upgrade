$(document).ready(function() {
    $("#logout").click(function() {
        Swal.fire({
            title: "Are you sure you want to logout?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, logout it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#logout-form").submit();
            }
        });
    });

// Draw Chart.
let totalSubusers = $("#data-total-subusers").val();
let totalClients = $("#data-total-clients").val();
let totalJobseekers = $("#data-total-jobseekers").val();
let totalFollowers = $("#data-total-followers").val();

function getAtsData(){
    $.ajax({
        url : SITE_URL+'/employer/get_ats_data',
        type : 'get',
        dataType : 'json',
        success : function(res){
            console.log(res);
            drawChart(res.jobs, res.applications);
        }
    });
}

function drawChart(xvalues, yvalues){
    var xValues = xvalues;
    var yValues = yvalues;
    var barColors = ["red", "green","blue","orange","brown"];

      var ctx = $("#chart-line");

      // Bar chart.
      new Chart(ctx, {
                 type: "bar",
                 data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                 options: {
                     scales: {
                         xAxes: [{
                            ticks: {
                               callback: function(t) {
                                  var maxLabelLength = 6;
                                  if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                                  else return t;
                               }
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Jobs' // Name of x-axis
                            }
                         }],
                         yAxes: [{
                            ticks: {
                               beginAtZero: true,
                               // stepSize: 1
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Applications' // Name of x-axis
                            }
                         }]
                    },
                    legend: {display: false},
                    title: {
                      display: true,
                      text: "Top 5 Resumes Wise Jobs"
                    },
                    tooltips: {
                         callbacks: {
                            title: function(t, d) {
                               return d.labels[t[0].index];
                            }
                         }
                    }
                }
        });

      // Pie chart
        // var myLineChart = new Chart(ctx, {
        //     type: 'pie',
        //     data: {
        //         labels: ["SubUsers", "Clients", "Jobseekers", "Followers"],
        //         datasets: [{
        //             data: [totalSubusers, totalClients, totalJobseekers, totalFollowers],
        //             backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)", "rgba(200, 50, 255, 0.5)", "rgba(0, 100, 255, 0.5)"]
        //         }]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'System Tracker'
        //         }
        //     }
        // });
}
getAtsData();
drawChart();

});