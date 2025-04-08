<?php
    session_start();
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
    } else {
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];
    if(isset($_SESSION['user_id'])) {
        // echo "User ID is set!";
        if (isset($_SESSION['is_admin']) &&  $_SESSION['is_admin'] == 1) {
            // echo "IS ADMIN is set!";
            header('Location: '.$uri.'/covid-not-found/AdminPanel/admin.php');
        } else {
            // echo "Plain User";
            header('Location: '.$uri.'/covid-not-found/UserPanel/user.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid Not Found - Log In</title>
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body class="w-50 m-auto">

<!-- Pills navs -->
<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab-login" data-bs-toggle="pill" href="#pills-login" role="tab"
            aria-controls="pills-login" aria-selected="true">Login</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab-register" data-bs-toggle="pill" href="#pills-register" role="tab"
            aria-controls="pills-register" aria-selected="false">Register</a>
    </li>
</ul>

  
    <!-- Pills content -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
            <div class="form-outline mb-4" id="login_alert"></div>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="login-email">Email</label>
                <input type="email" id="login-email" class="form-control login" placeholder="name@example.com"/>          
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="login-pwd">Password</label>
                <input type="password" id="login-pwd" class="form-control login" placeholder="***************"/>          
            </div>

            <!-- Submit button -->
            <button id="login-submit" class="btn btn-primary btn-block mb-4">Sign in</button>
        </div>
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="active">
            <div class="form-outline mb-4" id="register_alert"></div>
            <!-- Name input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="register-name">Name</label>
                <input type="text" id="register-name" placeholder="John" class="form-control register" />
            </div>

            <!-- Username input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="register-surname">Username</label>
                <input type="text" id="register-surname" placeholder="Doe" class="form-control register" />
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="register-email">Email</label>
                <input type="email" id="register-email" placeholder="name@example.com" class="form-control register" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="register-password">Password</label>
                <input type="password" id="register-password" placeholder="***************" class="form-control register" /> 
            </div>

            <!-- Repeat Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="register-password-conf">Repeat password</label>
                <input type="password" id="register-password-conf" placeholder="***************" class="form-control register" />
            </div>

            <!-- Submit button -->
            <button id="register-submit" class="btn btn-primary btn-block mb-3">Register</button>
        </div>
    </div>

    <?php include '../requirements.php'; ?>

</body>
</html>