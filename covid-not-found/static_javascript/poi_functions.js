$(document).ready(function () {
    $('#save').click(function () {
        var file_to_read = document.getElementById("jsonfileinput").files[0];
        var fileread = new FileReader();
        var myJSON;

        fileread.readAsText(file_to_read);
        fileread.onload = function() {
            myJSON = JSON.parse(fileread.result);                        
        }

        fileread.onloadend = function() {
            var sendfile = JSON.stringify(myJSON);

            $.ajax( {
                url: "../includes/insert_pois.inc.php",
                dataType: "text",
                type: "POST",
                data: {
                    pois: sendfile 
                }, 
                success: function( response ) { alert(response) },
                error: function( error ) { console.log(error) }
            });
        }
        fileread.onerror = function() {
            console.log(fileread.error);
        }

    });

    $('#delete').click(function () {
            
        $.ajax( {
            url: "../includes/insert_pois.inc.php",
            dataType: "text",
            type: "POST",
            data: { delete: null }, 
            success: function( response ) { alert(response) },
            error: function( error ) { console.log(error) }
        });
          

    });

})