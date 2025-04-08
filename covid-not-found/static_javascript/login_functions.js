$(document).ready(function () {

    $('#login-submit').click(function () {
        var email = document.getElementById("login-email").value;
        var password = document.getElementById("login-pwd").value;

        $.ajax( {
            url: "../includes/login.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                login: JSON.stringify({ 
                    email: email,
                    password: password
                }) 
            }, 
            success: function( response ) { 
                $('.login').removeClass("border-danger")
                if (response.includes("[DONE] Logged In Successfully!")) {
                    window.location.replace("/covid-not-found/UserPanel/user.php")
                } else if (response.includes("[ADMIN] Logged In Successfully!")) {
                    window.location.replace("/covid-not-found/AdminPanel/admin.php")
                } else if (response.includes("[ERROR] stmt_failed")) {
                    $('#login_alert').html("<p id='log_alert'>Registration Failed!</p>")
                    $('#log_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                } else if (response.includes("[ERROR] empty_input")) {
                    $('#login_alert').html("<p id='log_alert'>Empty input!</p>")
                    $('#log_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('.login').addClass("border-danger") 
                } else if (response.includes("[ERROR] Wrong Email")) {
                    $('#login_alert').html("<p id='log_alert'>Wrong Email!</p>")
                    $('#log_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#login-email').addClass("border-danger") 
                } else if (response.includes("[ERROR] Wrong Password")) {
                    $('#login_alert').html("<p id='log_alert'>Wrong Password!</p>")
                    $('#log_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#login-pwd').addClass("border-danger") 
                }                    
            },
            error: function( error ) { console.log(error) }
        });
    });

    $('#register-submit').click(function () {
        var name = document.getElementById("register-name").value;
        var surname = document.getElementById("register-surname").value;
        var email = document.getElementById("register-email").value;
        var password = document.getElementById("register-password").value;
        var password_conf = document.getElementById("register-password-conf").value;

        $.ajax( {
            url: "../includes/login.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                register: JSON.stringify({ 
                    name: name,
                    surname: surname,
                    email: email,
                    password: password,
                    password_conf: password_conf
                })
            }, 
            success: function( response ) { 
                $('.register').removeClass("border-danger")
                if (response.includes("[DONE] Insert Completed!")) {
                    $('#register_alert').html("<p id='reg_alert'>Registered Successfully! Log in with your credentials!</p>")
                    $('#reg_alert').addClass("bg-success text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                } else if (response.includes("[ERROR] stmt_failed")) {
                    $('#register_alert').html("<p id='reg_alert'>Registration Failed!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                } else if (response.includes("[ERROR] empty_input")) {
                    $('#register_alert').html("<p id='reg_alert'>Empty input!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('.register').addClass("border-danger")
                } else if (response.includes("[ERROR] invalid_email")) {
                    $('#register_alert').html("<p id='reg_alert'>Invalid Email!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-email').addClass("border-danger")
                } else if (response.includes("[ERROR] password_dont_match")) {
                    $('#register_alert').html("<p id='reg_alert'>Passwords do not match!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-password').addClass("border-danger")
                    $('#register-password-conf').addClass("border-danger")
                } else if (response.includes("[ERROR] email_already_exists")) {
                    $('#register_alert').html("<p id='reg_alert'>Email already exists!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-email').addClass("border-danger")
                } else if (response.includes("[ERROR] password_strength")) {
                    $('#register_alert').html("<p id='reg_alert'>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-password').addClass("border-danger")
                    $('#register-password-conf').addClass("border-danger")
                }

            },
            error: function( error ) { console.log(error) }
        });
    });

    $('#register-admin').click(function () {
        var name = document.getElementById("register-name").value;
        var surname = document.getElementById("register-surname").value;
        var email = document.getElementById("register-email").value;
        var password = document.getElementById("register-password").value;
        var password_conf = document.getElementById("register-password-conf").value;

        $.ajax( {
            url: "../includes/login.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                admin: JSON.stringify({ 
                    name: name,
                    surname: surname,
                    email: email,
                    password: password,
                    password_conf: password_conf
                })
            }, 
            success: function( response ) { 
                $('.register').removeClass("border-danger")
                if (response.includes("[ADMIN] Insert Completed!")) {
                    $('#register_alert').html("<p id='reg_alert'>Registered Successfully! Log in with your credentials!</p>")
                    $('#reg_alert').addClass("bg-success text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                } else if (response.includes("[ERROR] stmt_failed")) {
                    $('#register_alert').html("<p id='reg_alert'>Registration Failed!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                } else if (response.includes("[ERROR] empty_input")) {
                    $('#register_alert').html("<p id='reg_alert'>Empty input!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('.register').addClass("border-danger")
                } else if (response.includes("[ERROR] invalid_email")) {
                    $('#register_alert').html("<p id='reg_alert'>Invalid Email!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-email').addClass("border-danger")
                } else if (response.includes("[ERROR] password_dont_match")) {
                    $('#register_alert').html("<p id='reg_alert'>Passwords do not match!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-password').addClass("border-danger")
                    $('#register-password-conf').addClass("border-danger")
                } else if (response.includes("[ERROR] email_already_exists")) {
                    $('#register_alert').html("<p id='reg_alert'>Email already exists!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-email').addClass("border-danger")
                } else if (response.includes("[ERROR] password_strength")) {
                    $('#register_alert').html("<p id='reg_alert'>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character!</p>")
                    $('#reg_alert').addClass("bg-danger text-white text-center font-weight-bold rounded d-flex align-middle mb-1 py-2 px-3")
                    $('#register-password').addClass("border-danger")
                    $('#register-password-conf').addClass("border-danger")
                }
             },
            error: function( error ) { console.log(error) }
        });
    });

    $('#logout').click(function () {
        $.ajax( {
            url: "../includes/login.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                logout: null
            }, 
            success: function( response ) { 
                console.log(response) 
                window.location.replace('../login/login.php')
            },
            error: function( error ) { console.log(error) }
        });
    });

    $('#user_menu').click(function (e) {
        if (e.target.id == "logout") {
            $.ajax( {
                url: "../includes/login.inc.php",
                dataType: "text",
                type: "POST",
                data: {
                    logout: null
                }, 
                success: function( response ) { 
                    $('#test').html(response) 
                    window.location.replace('../login/login.php')
                },
                error: function( error ) { console.log(error) }
            });
        }
    });

    $('#submit-changes').click(function () {
        var name = document.getElementById("change-name").value;
        var surname = document.getElementById("change-surname").value;
        var email = document.getElementById("change-email").value;
        var password = document.getElementById("change-password").value;
        var password_conf = document.getElementById("change-password-conf").value;

        $.ajax( {
            url: "../includes/login.inc.php",
            dataType: "text",
            type: "POST",
            data: {
                change_user: JSON.stringify({ 
                    name: name,
                    surname: surname,
                    email: email,
                    password: password,
                    password_conf: password_conf
                })
            }, 
            success: function( response ) { alert(response) },
            error: function( error ) { console.log(error) }
        });
    });
})       