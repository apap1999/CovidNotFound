$(document).ready(function () {
    // List all visits of the current user
    $.ajax( {
        url: "../includes/user.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            my_visits: "NULL"
        }, 
        success: function( response ) { 
            if (response.includes("poi_name")) {
                let element =  document.getElementById('my_visits')
                if(typeof(element) != 'undefined' && element != null){
                    create_visits_table(JSON.parse(response))
                }
            } else if (response.includes("error")) {
                console.log(JSON.parse(response).error)
            } else {
                $('#my_visits').html("<p id='visits_alert'>There are no visits registered!</p>")
                $('#visits_alert').addClass("bg-info text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
            }
        },
        error: function( error ) { console.log(error) }
    });

    // List all covid cases of the current user
    $.ajax( {
        url: "../includes/user.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            my_cases: "NULL"
        }, 
        success: function( response ) { 
            if (response.includes("covid_case")) {
                let element =  document.getElementById('my_cases')
                if(typeof(element) != 'undefined' && element != null){
                    create_cases_table(JSON.parse(response))
                }
            } else if (response.includes("error")) {
                console.log(JSON.parse(response).error)
            } else {
                $('#my_cases').html("<p id='cases_alert'>There are no Covid Cases registered!</p>")
                $('#cases_alert').addClass("bg-info text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
            }
        },
        error: function( error ) { console.log(error) }
    });

    function create_visits_table(data) {
        let table = document.createElement('table');
        let thead = document.createElement('thead');
        let tbody = document.createElement('tbody');

        table.classList.add("table", "table-responsive", "table-bordered");
        thead.classList.add("thead-info");

        table.appendChild(thead);
        table.appendChild(tbody);

        // Adding the entire table to the card
        document.getElementById('my_visits').appendChild(table);

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

    function create_cases_table(data) {
        let table = document.createElement('table');
        let thead = document.createElement('thead');
        let tbody = document.createElement('tbody');

        table.classList.add("table", "table-responsive", "table-bordered");
        thead.classList.add("thead-info");

        table.appendChild(thead);
        table.appendChild(tbody);

        // Adding the entire table to the card
        document.getElementById('my_cases').appendChild(table);

        // Creating and adding data to first row of the table
        let row_1 = document.createElement('tr');
        let heading_1 = document.createElement('th');
        heading_1.innerHTML = "Covid Case NO:";
        let heading_2 = document.createElement('th');
        heading_2.innerHTML = "Date:";

        row_1.appendChild(heading_1);
        row_1.appendChild(heading_2);
        thead.appendChild(row_1);

        data.forEach(covid => {
            let row = document.createElement('tr');
            let row_data_1 = document.createElement('td');
            row_data_1.innerHTML = covid.covid_case;
            let row_data_2 = document.createElement('td');
            let date = new Date(covid.covid_time).toDateString();
            row_data_2.innerHTML = date;

            row.appendChild(row_data_1);
            row.appendChild(row_data_2);
            tbody.appendChild(row);
        });
    };
})