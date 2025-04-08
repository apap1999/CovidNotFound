// Confirm Covid Case Button
$(document).ready(function () {

    // Show / Hide the option to log in as Admin
    $.ajax( {
        url: "../includes/user.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            is_admin: "NULL"
        }, 
        success: function( response ) { 
            if (response.includes("user_id")) {
                if (JSON.parse(response).is_admin == 1) {
                    $('#log_admin').css("display","block")
                }
                else if (JSON.parse(response).is_admin == 0) {
                    $('#log_admin').css("display","none")
                }
            }
            else if (response.includes("No session running!")) {
                $('#log_admin').css("display","none")
                console.log(response)
            }
        },
        error: function( error ) { console.log(error) }
    });

    $('#confcase-submit').click(function () {
        
        var date = document.getElementById("confcase-date").value;

        $.ajax( {
            url: "../includes/user.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                confcase: JSON.stringify({ 
                    date: date
                })
            }, 
            success: function( response ) { 
                if (response.includes("[SQL Success]")) {
                    $('#confcase-submit').removeClass("btn-danger");
                    $('#confcase-submit').addClass("btn-dark disabled");
                }
                else if (response.includes("[Recent case exists]")) {
                    $('#recent_case').html("<p id='recent_alert'>There is already a recent case!</p>")
                    $('#recent_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#confcase-submit').removeClass("btn-danger");
                    $('#confcase-submit').addClass("btn-dark disabled");
                }
                else if (response.includes("[SQL Failed]")) {
                    alert("Database error!");
                }
            },
            error: function( error ) { console.log(error) }
        });
    });

    $.ajax( {
        url: "../includes/user.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            possible_contact: "NULL"
        }, 
        success: function( response ) { 
            if (response.includes("poi_name")){
                $('#covid_alert').html("<a class='link-danger' href='possible_contact.php'><p id='possible_covid_alert'>You are a possible Covid Case!</p></a>")
                $('#possible_covid_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
            } else {
                has_covid();
            }
            let element =  document.getElementById('possible_contact')
            if(typeof(element) != 'undefined' && element != null){
                if (response.includes("poi_name")) {
                    create_possible_case_table(JSON.parse(response))
                } else if (response.includes("error")) {
                    console.log(response.error)
                } else {
                    $('#possible_contact').html("<p id='possible_case_alert'>You haven't been in contact with a Confirmed Case lately!</p>")
                    $('#possible_case_alert').addClass("bg-info text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                }
            }   
        },
        error: function( error ) { console.log(error) }
    });

    
    
});

function create_possible_case_table(data) {
    let table = document.createElement('table');
    let thead = document.createElement('thead');
    let tbody = document.createElement('tbody');

    table.classList.add("table", "table-responsive", "table-bordered");
    thead.classList.add("thead-info");

    table.appendChild(thead);
    table.appendChild(tbody);

    // Adding the entire table to the card
    document.getElementById('possible_contact').appendChild(table);

    // Creating and adding data to first row of the table
    let row_1 = document.createElement('tr');
    let heading_1 = document.createElement('th');
    heading_1.innerHTML = "POI Name:";
    let heading_2 = document.createElement('th');
    heading_2.innerHTML = "Visit At:";

    row_1.appendChild(heading_1);
    row_1.appendChild(heading_2);
    thead.appendChild(row_1);

    data.forEach(visit => {
        let row = document.createElement('tr');
        let row_data_1 = document.createElement('td');
        row_data_1.innerHTML = visit.poi_name;
        let row_data_2 = document.createElement('td');
        let date = new Date(visit.visit_time).toString();
        row_data_2.innerHTML = date;

        row.appendChild(row_data_1);
        row.appendChild(row_data_2);
        tbody.appendChild(row);
    });
};

function has_covid() {
    $.ajax( {
        url: "../includes/user.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            has_covid: "NULL"
        }, 
        success: function( response ) { 
            if (response.includes("has_covid")){
                $('#covid_alert').html("<a class='link-danger' href='covid_case.php'><p id='possible_covid_alert'>"+ JSON.parse(response).has_covid +"</p></a>")
                $('#possible_covid_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
            } else if (response.includes("not_covid")){
                $('#covid_alert').html("<a class='link-info' href='possible_contact.php'><p id='possible_covid_alert'>"+ JSON.parse(response).not_covid +"</p></a>")
                $('#possible_covid_alert').addClass("bg-info text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
            }   
        },
        error: function( error ) { console.log(error) }
    });
}