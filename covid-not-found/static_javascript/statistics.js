function update_chart_1() {
    $.ajax({
        url:"../includes/admincharts.inc.php",
        method:"POST",
        data:{ chart1: null },
        dataType:"text",

        success: function( response ) {
            if (response.includes("error")) {
                let error = JSON.parse(response);
                console.log(error.error);
            }
            else if (response.includes("total_visits")) {
                let value = JSON.parse(response).total_visits;
                document.getElementById("chart-1").innerHTML = value;
            }
            else { console.log("Wrong response!"); }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }
    });
}

function update_chart_2() {
    $.ajax({
        url:"../includes/admincharts.inc.php",
        method:"POST",
        data:{ chart2: null },
        dataType:"text",

        success: function( response ) {
            if (response.includes("error")) {
                let error = JSON.parse(response);
                console.log(error.error);
            }
            else if (response.includes("covid_cases")) {
                let value = JSON.parse(response).covid_cases;
                document.getElementById("chart-2").innerHTML = value;
            }
            else { console.log("Wrong response!"); }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }
    });
}

function update_chart_3() {
    $.ajax({
        url:"../includes/admincharts.inc.php",
        method:"POST",
        data:{ chart3: null },
        dataType:"text",

        success: function( response ) {
            if (response.includes("error")) {
                let error = JSON.parse(response);
                console.log(error.error);
            }
            else if (response.includes("covid_visits")) {
                let value = JSON.parse(response).covid_visits;
                document.getElementById("chart-3").innerHTML = value;
            }
            else { console.log("Wrong response!"); }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }
    });
}

function update_chart_4() {
    $.ajax({
        url:"../includes/admincharts.inc.php",
        method:"POST",
        data:{ chart4: null },
        dataType:"text",
        
        success: function( response ) {
            if (response.includes("error")) {
                let error = JSON.parse(response);
                console.log(error.error);
            }
            else if (response.includes("visits")) {
                create_pie_chart('#chart-4', JSON.parse(response));
            }
            else { console.log("Wrong response!"); }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }					
    })
}

function update_chart_5() {
    $.ajax({
        url:"../includes/admincharts.inc.php",
        method:"POST",
        data:{ chart5: null },
        dataType:"text",
        
        success:function( response ) {
            if (response.includes("error")) {
                let error = JSON.parse(response);
                console.log(error.error);
            }
            else if (response.includes("visits")) {
                create_pie_chart('#chart-5', JSON.parse(response));
            }
            else { console.log("Wrong response!"); }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }					
    })
}

function update_chart_6(minDate, maxDate, visits, confcases) {
    if (visits || confcases) {
        $.ajax({
            url:"../includes/admincharts.inc.php",
            method:"POST",
            data:{ chart6: JSON.stringify({
                    minDate, 
                    maxDate,
                    visits,
                    confcases
                }) 
            },
            dataType:"text",
            
            success:function( response ) {
                if (response.includes("error")) {
                    let error = JSON.parse(response);
                    console.log(error.error);
                }
                else if (response.includes("dateArray")) {
                    create_board_chart6(chart_6, JSON.parse(response));
                }
                else { console.log("Wrong response!"); }
            },
            error: function( xhr, ajaxOptions, thrownError ) {
                console.log("AJAX Error:" + xhr.status)
                console.log("Thrown Error:" + thrownError)
            }					
        })
    } else {
        console.log("Choose a filter!");
    }
}

function update_chart_7(myDate, visits, confcases) {
    if (visits || confcases) {
        $.ajax({
            url:"../includes/admincharts.inc.php",
            method:"POST",
            data:{ chart7: JSON.stringify({
                    myDate,
                    visits, 
                    confcases
                }) 
            },
            dataType:"text",
            
            success:function( response ) {
                if (response.includes("error")) {
                    let error = JSON.parse(response);
                    console.log(error.error);
                }
                else if (response.includes("date_visits")) {
                    create_board_chart7(chart_7, JSON.parse(response));
                }
                else { console.log("Wrong response!"); }
            },
            error: function( xhr, ajaxOptions, thrownError ) {
                console.log("AJAX Error:" + xhr.status)
                console.log("Thrown Error:" + thrownError)
            }					
        })
    } else {
        console.log("Choose a filter!");
    }    
}

function create_pie_chart(chart_id, data) {

    var chart_data = {
        labels: data.type,
        datasets:[{
            label:'Vote',
            backgroundColor: data.color,
            color:'#fff',
            data: data.visits
        }]
    };

    new Chart( $(chart_id), {
        type: "pie",
        data: chart_data
    });
}

function create_board_chart6(chart_id, dataSets) {

    var label_dates = [];
    var dates = []
    var countVisits = [];
    var countCaseVisits = [];
    var bg_color = [];
    var border_color = [];
    var index = -1;
    dataSets.dateArray.forEach(date => {
        this_date = new Date(date).getDate();
        if (this_date == dates[index]) { countVisits[index]++; }
        else { index++; 
            dates[index] = this_date;
            label_dates[index] = new Date(date).toDateString(); 
            countVisits[index] = 1; 
            let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
            bg_color[index] = color + '0.4)'
            border_color[index] = color + '1)'
        }
    })  

    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
    let chart_datasets = [{
            label: 'Visits',
            data: countVisits,
            backgroundColor: color + '0.4)',
            borderColor: color + '1)',
            borderWidth: 1
        }];

    if (dataSets.hasOwnProperty('caseArray')) {
        var index = -1;
        dataSets.caseArray.forEach(date => {
            this_date = new Date(date).getDate();
            if (this_date == dates[index]) { countCaseVisits[index]++; }
            else { index++; 
                if (this_date == dates[index]) {
                    countCaseVisits[index] = 1;
                }                 
            }
        })  
        let covid_color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
        chart_datasets.push({
            label: 'Covid Visits',
            data: countCaseVisits,
            backgroundColor: covid_color + '0.4)',
            borderColor: covid_color + '1)',
            borderWidth: 1
        })        
    }
    
    removeData(chart_id);
    addData(chart_id, label_dates, chart_datasets);
}

function create_board_chart7(chart_id, dataSets) {
    const label_hours = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00',
                         '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', 
                         '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', 
                         '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];

    // Count the visits per hour
    var hours = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var covid_hours = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    dataSets.date_visits.forEach( hour => {
        let i = new Date(hour).getHours()
        hours[i]++;
    })

    // // Create random colors for the bars 
    // var bg_color = []
    // var border_color = []
    // for (var n=0; n<24; n++){
    //     let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
    //     bg_color[n] = color + '0.4)'
    //     border_color[n] = color + '1)'
    // }

    // Create the first dataset
    let color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
    var hour_datasets = [{
        label: 'Visits',
        data: hours,
        backgroundColor: color + '0.4)',
        borderColor: color + '1)',
        borderWidth: 1
    }];

    // Push second dataset if exist
    if (dataSets.hasOwnProperty('caseArray')) {
        dataSets.caseArray.forEach( hour => {
            let i = new Date(hour).getHours()
            covid_hours[i]++;
        })
        let covid_color = 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', '
        hour_datasets.push({
            label: 'Covid Visits',
            data: covid_hours,
            backgroundColor: covid_color + '0.4)',
            borderColor: covid_color + '1)',
            borderWidth: 1
        })
    }

    removeData(chart_id);
    addData(chart_id, label_hours, hour_datasets);
}

function addData(chart, label, data) {
    chart.data.labels = label;
    chart.data.datasets = data;
    chart.update();
}

function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

// Create charts
var chart_6 = new Chart( $('#chart-6'),
        {
            type: 'bar',
            data: [],
            options: {
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        }
    );
var chart_7 = new Chart( $('#chart-7'),
{
    type: 'bar',
    data: [],
    options: {
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                }
            }]
        }
    }
}
);

$(document).ready(function() {
    // populate charts
    update_chart_1();
    update_chart_2();
    update_chart_3();
    update_chart_4();
    update_chart_5();
    update_chart_6('2022-07-31', '2022-09-30', true, false);
    update_chart_7('2022-09-02', true, false);

    // create resfresh buttons
    $('#refresh-chart-1').click(function() {
        update_chart_1();
    });
    $('#refresh-chart-2').click(function() {
        update_chart_2();
    });
    $('#refresh-chart-3').click(function() {
        update_chart_3();
    });
    $('#refresh-chart-4').click(function() {
        update_chart_4();
    });
    $('#refresh-chart-5').click(function() {
        update_chart_5();
    });
    $('#filter-chart-6').click(function() {
        let minDate = $('#chart6-minDate').val()
        let maxDate = $('#chart6-maxDate').val()
        let visits = $('#chart-6-visits').is(":checked")
        let confcases = $('#chart-6-confcases').is(":checked")
        update_chart_6(minDate, maxDate, visits, confcases);
    });
    $('#filter-chart-7').click(function() {
        let myDate = $('#chart7-myDate').val()
        let visits = $('#chart-7-visits').is(":checked")
        let confcases = $('#chart-7-confcases').is(":checked")
        update_chart_7(myDate, visits, confcases);
    });			
})