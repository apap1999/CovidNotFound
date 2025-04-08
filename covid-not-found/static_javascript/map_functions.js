// Initialize color markers
var blueMarker = L.AwesomeMarkers.icon({
    markerColor: 'blue'
});
var greenMarker = L.AwesomeMarkers.icon({
    markerColor: 'green'
});
var orangeMarker = L.AwesomeMarkers.icon({
    markerColor: 'orange'
});
var redMarker = L.AwesomeMarkers.icon({
    markerColor: 'red'
});

// Map initialization 
var map = L.map('map').setView([38.29037783868629, 21.79569292607424], 12);
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
osm.addTo(map);

// Request access to geolocation
if(!navigator.geolocation) { console.log("Your browser doesn't support geolocation feature!")
} else { navigator.geolocation.getCurrentPosition(getPosition); }

// Get user's position
var coords, marker, circle;

function getPosition( position ){
    var lat = position.coords.latitude
    var lng = position.coords.longitudevar 
    // var lat = 38.2475
    // var lng = 21.7311

    if(mylocation) { map.removeLayer(mylocation) }

    mycoords = L.marker([lat, lng], {icon: blueMarker}).bindPopup("My Location")
    bigcircle = L.circle([lat, lng], { radius: 5000 });
    smallcircle = L.circle([lat, lng], { radius: 300 });

    var mylocation = L.featureGroup([mycoords]).addTo(map)
    var circles = L.featureGroup([bigcircle, smallcircle]).addTo(map)
    circles.setStyle({color: 'rgba(0,0,0,0)'})

    map.fitBounds(bigcircle.getBounds())
}

// Search for POIs nearby
var pois;

$(document).ready(function () {

    var name = document.getElementById("searchbyname");
    var type = document.getElementById("searchbytype");

    name.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {

            type.value = '';
            if (pois) { map.removeLayer(pois); }
            var bounds = bigcircle.getBounds(); 
            getPOIs(bounds, "name", name.value);
        }
    });

    type.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            name.value = '';
            if (pois) { map.removeLayer(pois); }
            var bounds = bigcircle.getBounds(); 
            getPOIs(bounds, "type", type.value);
        }
    });
})

// Fetch POIs
function getPOIs( bounds, search_by, value ) {
    var search = {
        northEast: {
            lat: bounds._northEast.lat,
            lng: bounds._northEast.lng
        },
        southWest: {
            lat: bounds._southWest.lat,
            lng: bounds._southWest.lng
        },
        search_by: search_by,
        search_value: value
    }

    $.ajax( {
        url: "../includes/map.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            search: JSON.stringify({
                search
            })
        }, 
        success: function( response ) {
            if (response.includes("error")) {
                var error = JSON.parse(response);
                console.log(error.error);
            }
            else {
                display_pois(JSON.parse(response));
            }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
        }
    });
}

// Display POIs on the map
function display_pois( poi_res ) {
    let markers = [];
    Object.entries(poi_res).forEach(([key, value]) => {
        let poi_id = value.poi_id;
        let name = value.name;
        let address = value.address;
        let lat = value.lat;
        let lng = value.lng;
        let rating = value.rating;
        let populartimes = value.populartimes;

        let pred = crowd_prediction(JSON.parse(populartimes));
        let marker_color;
        if (pred.first_hour < 33) { marker_color = greenMarker; }
        else if (pred.first_hour > 32 && pred.first_hour < 66) { marker_color = orangeMarker; }
        else { marker_color = redMarker; }
        let estim = get_estimation(poi_id);            

        let popupText = name + "<br>" + address + "<br>Rating: " + rating + 
                    "<br>Crowd Prediction: " + pred.first_hour + " " + pred.second_hour +
                    "<br>Crowd Estimation: " + estim ;
        
        var bounds = smallcircle.getBounds()
        if  (  lat > bounds._southWest.lat && lat < bounds._northEast.lat
            && lng > bounds._southWest.lng && lng < bounds._northEast.lng ) {
            popupText +=  '<br>Your crowd estimation: <input type="number" id="estimation_'+ poi_id +'">' +
            '<br><input type="button" id="'+ poi_id +'" class="mybuttons" value="Register Visit"></input>'
        }
        
        markers[key] = new L.marker([lat, lng], {icon: marker_color})
                            .bindPopup(popupText)
                            .on("popupopen", function() {
                                $('.mybuttons').click(function () {
                                    var estimation = $('#estimation_' + this.id).val();
                                    register_visit(this.id, estimation);
                                });
                            });
    })

    pois = L.layerGroup(markers);
    map.addLayer(pois);
}

// Get current crowd prediction
function crowd_prediction( populartimes ) {
    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    var current_day = today.getDay();
    if (current_day == 0) { current_day = 6; }  // Our JSON starts the week from Monday
        else { current_day--; }                 // but .getDay() function starts from Sunday
    const current_time = today.getHours();
    let weekday, hours;
    Object.entries(populartimes).forEach(([key, value]) => {
        if (current_day == key) {
            weekday = value.name;
            hours = value.data;                
        } 
    })

    return {
        "first_hour":hours[current_time+1], 
        "second_hour":hours[current_time+2]
    };         
}

// Get User's estimation
function get_estimation( poi_id ) {
    $.ajax({
        url:"../includes/map.inc.php",
        method:"POST",
        data:{ estimation: poi_id },
        dataType:"text",
        async: false,

        success: function( response ) {
            if (response.includes("error")) {
                result = JSON.parse(response).error;
            }
            else if (response.includes("estimation")) {
                result = JSON.parse(response).estimation;
            }
        },
        error: function( xhr, ajaxOptions, thrownError ) {
            console.log("AJAX Error:" + xhr.status)
            console.log("Thrown Error:" + thrownError)
            result = "Error!";
        }
    });
    return result;
}

// Register visit to the DB
function register_visit( poi_id, estimation ) {
    $.ajax( {
        url: "../includes/map.inc.php",
        dataType: "text",
        type: "POST",
        data: {
            visits: JSON.stringify({ 
                poi_id: poi_id,
                estimation: estimation
            })
        }, 
        success: function( response ) {
            if (response.includes("[SQL Success]")) {
                console.log("Your visit has been registered successfully!");
                $('#' + poi_id).addClass("btn-success disabled");
            } else { console.log(response) }
        },
        error: function( error ) {
            console.log(error)
        }
    });
}